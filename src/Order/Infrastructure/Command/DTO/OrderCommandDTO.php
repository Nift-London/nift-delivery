<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Command\DTO;

final class OrderCommandDTO
{
    private string $shippingId;
    private string $contactName;
    private ?string $contactPhone;
    private ?string $contactEmail;

    public function __construct(string $shippingId, string $contactName, ?string $contactPhone, ?string $contactEmail)
    {
        $this->shippingId = $shippingId;
        $this->contactName = $contactName;
        $this->contactPhone = $contactPhone;
        $this->contactEmail = $contactEmail;
    }

    public function getShippingId(): string
    {
        return $this->shippingId;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }
}
