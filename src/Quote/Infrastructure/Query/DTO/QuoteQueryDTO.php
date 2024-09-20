<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Query\DTO;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ItemDTO;
use App\Quote\Application\DTO\StoreDTO;

final class QuoteQueryDTO
{
    private ?AddressDTO $addressFrom;
    private AddressDTO $addressTo;
    private StoreDTO $storeDTO;
    /** @var ItemDTO[] */
    private array $items;

    public function __construct(
        ?AddressDTO $addressFrom,
        AddressDTO $addressTo,
        StoreDTO $storeDTO,
        array $items
    ) {
        $this->addressFrom = $addressFrom;
        $this->addressTo = $addressTo;
        $this->storeDTO = $storeDTO;
        $this->items = $items;
    }

    public function getAddressFrom(): ?AddressDTO
    {
        return $this->addressFrom;
    }

    public function getAddressTo(): AddressDTO
    {
        return $this->addressTo;
    }

    public function getStoreDTO(): StoreDTO
    {
        return $this->storeDTO;
    }

    /** @return ItemDTO[] */
    public function getItems(): array
    {
        return $this->items;
    }
}
