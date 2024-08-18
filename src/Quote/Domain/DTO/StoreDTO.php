<?php

declare(strict_types=1);

namespace App\Quote\Domain\DTO;

final class StoreDTO
{
    private string $evermileLocationId;

    public function __construct(string $evermileLocationId)
    {
        $this->evermileLocationId = $evermileLocationId;
    }

    public function getEvermileLocationId(): string
    {
        return $this->evermileLocationId;
    }
}
