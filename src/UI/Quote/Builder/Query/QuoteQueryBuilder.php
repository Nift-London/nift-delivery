<?php

declare(strict_types=1);

namespace App\UI\Quote\Builder\Query;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ItemDTO;
use App\Quote\Application\DTO\StoreDTO;
use App\Quote\Infrastructure\Query\DTO\QuoteQueryDTO;
use App\Store\Application\Exception\StoreValidationException;
use App\Store\Infrastructure\Query\StoreQuery;
use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyAddress;
use App\UI\Quote\DTO\Request\QuoteForShopifyRequest;

final class QuoteQueryBuilder
{
    private StoreQuery $storeQuery;

    public function __construct(StoreQuery $storeQuery)
    {
        $this->storeQuery = $storeQuery;
    }

    /**
     * @throws StoreValidationException
     */
    public function build(QuoteForShopifyRequest $quoteForShopifyRequest): QuoteQueryDTO
    {
        $originAddress = $quoteForShopifyRequest->getOrigin();
        $destinationAddress = $quoteForShopifyRequest->getDestination();
        $store = $this->storeQuery->queryByShopifyDomain($quoteForShopifyRequest->getShopifyDomain());

        $addressFrom = $this->getAddressFrom($originAddress);
        $addressTo = $this->getAddress($destinationAddress);
        $storeDTO = new StoreDTO($store->getId(), $store->getEvermileLocationId());
        $items = $this->getItems($quoteForShopifyRequest);

        return new QuoteQueryDTO($addressFrom, $addressTo, $storeDTO, $items);
    }

    public function getAddressFrom(QuoteForShopifyAddress $originAddress): ?AddressDTO
    {
        if ($originAddress->getAddress1() && $originAddress->getPostalCode() && $originAddress->getCity()) {
            return $this->getAddress($originAddress);
        }

        return null;
    }

    public function getAddress(QuoteForShopifyAddress $destinationAddress): AddressDTO
    {
        return new AddressDTO(
            trim($destinationAddress->getAddress1() . ' ' . $destinationAddress->getAddress2() . ' ' . $destinationAddress->getAddress3()),
            $destinationAddress->getPostalCode(),
            $destinationAddress->getCity()
        );
    }

    /** @return ItemDTO[] */
    public function getItems(QuoteForShopifyRequest $quoteForShopifyRequest): array
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
}
