<?php

declare(strict_types=1);

namespace App\Store\Application\Validator;

use App\Store\Domain\Entity\Store;

final class StoreValidator
{
    public function isStoreValid(?Store $store): bool
    {
        return !is_null($store) && $store->isEnabled();
    }
}
