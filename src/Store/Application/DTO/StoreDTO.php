<?php

declare(strict_types=1);

namespace App\Store\Application\DTO;

use Symfony\Component\Uid\Uuid;

final class StoreDTO
{
    private Uuid $id;
    private string $street;
    private string $postalCode;
    private string $city;
    private string $evermileLocationId;

    public function __construct(Uuid $id, string $street, string $postalCode, string $city, string $evermileLocationId)
    {
        $this->id = $id;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->evermileLocationId = $evermileLocationId;
    }

    public function getId(): Uuid
    {
        return $this->id;
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

    public function getEvermileLocationId(): string
    {
        return $this->evermileLocationId;
    }
}
