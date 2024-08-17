<?php

declare(strict_types=1);

namespace App\Quote\Domain\DTO;

final class AddressDTO
{
    private string $street;
    private string $postalCode;
    private string $city;

    public function __construct(string $street, string $postalCode, string $city)
    {
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
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
}
