<?php

declare(strict_types=1);

namespace App\Quote\Application\Exception;

use Symfony\Component\Uid\Uuid;

final class QuoteNotFoundException extends \Exception
{
    public static function storeNotFoundException(Uuid $id): self
    {
        return new self('Quote not found: ' . $id->jsonSerialize());
    }
}
