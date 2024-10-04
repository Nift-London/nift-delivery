<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Query\DTO;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ItemDTO;
use App\Quote\Application\DTO\LocationDTO;

final class QuoteQueryDTO
{
    private AddressDTO $addressTo;
    private LocationDTO $locationDTO;
    /** @var ItemDTO[] */
    private array $items;

    public function __construct(
        AddressDTO $addressTo,
        LocationDTO $locationDTO,
        array $items
    ) {
        $this->addressTo = $addressTo;
        $this->locationDTO = $locationDTO;
        $this->items = $items;
    }

    public function getAddressTo(): AddressDTO
    {
        return $this->addressTo;
    }

    public function getLocationDTO(): LocationDTO
    {
        return $this->locationDTO;
    }

    /** @return ItemDTO[] */
    public function getItems(): array
    {
        return $this->items;
    }
}
