<?php

declare(strict_types=1);

namespace App\Quote\Application\Calculator\Provider;

use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\QuoteDTO;

interface QuoteProviderInterface
{
    /** @return QuoteDTO[] */
    public function provide(AddressDTO $addressDTO): array;
}
