<?php

declare(strict_types=1);

namespace App\Store\Application\Exception;

use Symfony\Component\Uid\Uuid;

final class LocationDisabledException extends \Exception
{
    public static function locationDisabledException(Uuid $locationId): self
    {
        return new self(sprintf('Location %s is disabled', $locationId->jsonSerialize()));
    }
}
