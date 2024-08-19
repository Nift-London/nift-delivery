<?php

declare(strict_types=1);

namespace App\Store\Application\Provider;

use App\Store\Application\Exception\StoreValidationException;
use App\Store\Application\Validator\StoreValidator;
use App\Store\Domain\Entity\Store;
use App\Store\Domain\Repository\StoreRepository;

final class StoreProvider
{
    private StoreRepository $storeRepository;
    private StoreValidator $storeValidator;

    public function __construct(StoreRepository $storeRepository, StoreValidator $storeValidator)
    {
        $this->storeRepository = $storeRepository;
        $this->storeValidator = $storeValidator;
    }

    /**
     * @throws StoreValidationException
     */
    public function provideStoreByShopifyDomain(string $shopifyDomain): Store
    {
        $store = $this->storeRepository->findByShopifyDomain($shopifyDomain);

        if (!$this->storeValidator->isStoreValid($store)) {
            throw StoreValidationException::storeNotFoundException();
        }

        return $store;
    }
}
