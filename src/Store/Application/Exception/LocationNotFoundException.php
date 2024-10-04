<?php

declare(strict_types=1);

namespace App\Store\Application\Exception;

use Symfony\Component\Uid\Uuid;

final class LocationNotFoundException extends \Exception
{
    public static function locationNotFoundException(Uuid $storeId): self
    {
        return new self(sprintf('Location not found for store %s, creating new', $storeId->jsonSerialize()));
    }
}
