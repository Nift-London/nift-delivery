<?php

declare(strict_types=1);

namespace App\Store\Application\Exception;

final class StoreValidationException extends \Exception
{
    public static function storeNotFoundException(): self
    {
        return new self('Store not found');
    }
}
