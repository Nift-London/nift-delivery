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
use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyAddress;
use App\UI\Quote\DTO\Request\QuoteForShopifyRequest;

final class QuoteQueryBuilder
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
    public function build(QuoteForShopifyRequest $quoteForShopifyRequest): QuoteQueryDTO
    {
        $originAddress = $quoteForShopifyRequest->getOrigin();
        $destinationAddress = $quoteForShopifyRequest->getDestination();
        $location = $this->getLocation($quoteForShopifyRequest, $originAddress);

        $addressTo = $this->getAddress($destinationAddress);
        $locationDTO = new LocationDTO(
            $location->getId(),
            $location->getEvermileLocationId(),
            $location->getEnabledTypesWithPrices()
        );
        $items = $this->getItems($quoteForShopifyRequest);

        return new QuoteQueryDTO($addressTo, $locationDTO, $items);
    }

    private function getAddress(QuoteForShopifyAddress $destinationAddress): AddressDTO
    {
        return new AddressDTO(
            $this->getTrimmedAddress($destinationAddress),
            $destinationAddress->getPostalCode(),
            $destinationAddress->getCity()
        );
    }

    /** @return ItemDTO[] */
    private function getItems(QuoteForShopifyRequest $quoteForShopifyRequest): array
    {
        $items = [];

        foreach ($quoteForShopifyRequest->getItems() as $item) {
            $items[] = new ItemDTO(
                $item->getName(),
                $item->getSku(),
                $item->getQuantity(),
                $item->getPrice(),
                $item->getGrams());
        }
        return $items;
    }

    private function getLocation(QuoteForShopifyRequest $quoteForShopifyRequest, QuoteForShopifyAddress $originAddress): Location
    {
        try {
            return $this->storeQuery->query(
                $quoteForShopifyRequest->getShopifyDomain(),
                $this->getTrimmedAddress($originAddress),
                $originAddress->getPostalCode(),
                $originAddress->getCity()
            );
        } catch (LocationNotFoundException $e) {
            return $this->locationCommand->create(
                $quoteForShopifyRequest->getShopifyDomain(),
                $this->getTrimmedAddress($originAddress),
                $originAddress->getPostalCode(),
                $originAddress->getCity()
            );
        }
    }

    private function getTrimmedAddress(QuoteForShopifyAddress $destinationAddress): string
    {
        return trim($destinationAddress->getAddress1() . ' ' . $destinationAddress->getAddress2() . ' ' . $destinationAddress->getAddress3());
    }
}
