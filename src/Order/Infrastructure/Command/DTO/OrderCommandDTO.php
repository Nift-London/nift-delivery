<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Command\DTO;

final class OrderCommandDTO
{
    private string $shippingId;
    private string $contactName;

    public function __construct(string $shippingId, string $contactName)
    {
        $this->shippingId = $shippingId;
        $this->contactName = $contactName;
    }

    public function getShippingId(): string
    {
        return $this->shippingId;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }
}
