<?php

declare(strict_types=1);

namespace App\UI\Quote\Builder\Query;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ItemDTO;
use App\Quote\Application\DTO\LocationDTO;
use App\Quote\Infrastructure\Query\DTO\QuoteQueryDTO;
use App\Store\Application\Exception\LocationNotFoundException;
use App\Store\Application\Exception\StoreValidationException;
use App\Store\Domain\Entity\Location;
use App\Store\Infrastructure\Command\LocationCommand;
use App\Store\Infrastructure\Query\LocationQuery;
use App\UI\Quote\DTO\Request\Partial\QuoteAddress;
use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyAddress;
use App\UI\Quote\DTO\Request\QuoteForShopifyRequest;
use App\UI\Quote\DTO\Request\QuoteRequest;

final class QuoteQueryRequestBuilder
{
    private LocationQuery $storeQuery;
    private LocationCommand $locationCommand;

    public function __construct(LocationQuery $storeQuery, LocationCommand $locationCommand)
    {
        $this->storeQuery = $storeQuery;
        $this->locationCommand = $locationCommand;
    }

    /**
     * @throws StoreValidationException
     */
    public function build(QuoteRequest $quoteRequest): QuoteQueryDTO
    {
        $destinationAddress = $quoteRequest->getDestination();
        $location = $this->getLocation($quoteRequest);

        $addressTo = $this->getAddress($destinationAddress);
        $locationDTO = new LocationDTO(
            $location->getId(),
            $location->getEvermileLocationId(),
            $location->getEnabledTypesWithDistanceAndPrices()
        );
        $items = $this->getItems($quoteRequest);

        return new QuoteQueryDTO($addressTo, $locationDTO, $items);
    }

    private function getAddress(QuoteAddress $destinationAddress): AddressDTO
    {
        return new AddressDTO(
            $this->getTrimmedAddress($destinationAddress),
            $destinationAddress->getPostalCode(),
            $destinationAddress->getCity()
        );
    }

    /** @return ItemDTO[] */
    private function getItems(QuoteRequest $quoteForShopifyRequest): array
    {
        $items = [];

        foreach ($quoteForShopifyRequest->getItems() as $item) {
            $items[] = new ItemDTO(
                $item->getName(),
                null,
                $item->getQuantity(),
                $item->getPrice(),
                $item->getGrams()
            );
        }
        return $items;
    }

    private function getLocation(QuoteRequest $quoteForShopifyRequest): Location
    {
        $originAddress = $quoteForShopifyRequest->getOrigin();
        try {
            return $this->storeQuery->queryByStoreName(
                $originAddress->getName(),
                $this->getTrimmedAddress($originAddress),
                $originAddress->getPostalCode(),
                $originAddress->getCity()
            );
        } catch (LocationNotFoundException $e) {
            return $this->locationCommand->createWithStoreName(
                $originAddress->getName(),
                $this->getTrimmedAddress($originAddress),
                $originAddress->getPostalCode(),
                $originAddress->getCity()
            );
        }
    }

    private function getTrimmedAddress(QuoteAddress $destinationAddress): string
    {
        return trim($destinationAddress->getAddress());
    }
}
