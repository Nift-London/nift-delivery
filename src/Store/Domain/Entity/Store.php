<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity;

final class Store
{
    private int $id; // todo uuid
    private string $name;
    private string $street;
    private string $postalCode;
    private string $city;
    private StoreExternalData $externalData;

    public function __construct()
    {
        $this->externalData = new StoreExternalData();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getExternalData(): StoreExternalData
    {
        return $this->externalData;
    }
}
