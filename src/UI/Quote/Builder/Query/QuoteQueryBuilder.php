<?php

declare(strict_types=1);

namespace App\UI\Quote\Builder\Query;

use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\StoreDTO;
use App\Quote\Infrastructure\Query\DTO\QuoteQueryDTO;
use App\Store\Application\Exception\StoreValidationException;
use App\Store\Infrastructure\Query\StoreQuery;
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

        if ($originAddress->getAddress1() && $originAddress->getPostalCode() && $originAddress->getCity()) {
            $addressFrom = new AddressDTO(
                trim($originAddress->getAddress1() . ' ' . $originAddress->getAddress2() . ' ' . $originAddress->getAddress3()),
                $originAddress->getPostalCode(),
                $originAddress->getCity()
            );
        }

        $addressTo = new AddressDTO(
            trim($destinationAddress->getAddress1() . ' ' . $destinationAddress->getAddress2() . ' ' . $destinationAddress->getAddress3()),
            $destinationAddress->getPostalCode(),
            $destinationAddress->getCity()
        );

        $storeDTO = new StoreDTO($store->getEvermileLocationId());

        return new QuoteQueryDTO($addressFrom ?? null, $addressTo, $storeDTO);
    }
}
