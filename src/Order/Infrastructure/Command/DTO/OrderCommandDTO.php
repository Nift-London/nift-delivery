<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Command\DTO;

final class OrderCommandDTO
{
    private string $contactName;
    private string $street;
    private string $postalCode;
    private string $city;
    private ?string $contactPhone;
    private ?string $contactEmail;

    public function __construct(
        string $contactName,
        string $street,
        string $postalCode,
        string $city,
        ?string $contactPhone,
        ?string $contactEmail
    ) {
        $this->contactName = $contactName;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->contactPhone = $contactPhone;
        $this->contactEmail = $contactEmail;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
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
