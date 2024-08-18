<?php

declare(strict_types=1);

namespace App\Store\Application\Provider;

use App\Store\Domain\Entity\Store;

final class StoreProvider
{
    public function provideStoreByShopifyName(): Store
    {
        return new Store();
    }
}
