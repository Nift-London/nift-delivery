<?php

declare(strict_types=1);

namespace App\Quote\Application\Exception;

final class QuoteNotFoundException extends \Exception
{
    public static function quoteNotFoundException(string $street, string $postalCode, string $city): self
    {
        return new self(sprintf('Quote not found for % % % ', $street, $postalCode, $city));
    }
}
