<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity]
final class Store
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private int $id;
    #[ORM\Column(type: 'datetimetz_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;
    #[ORM\Column(type: 'text', nullable: false)]
    private string $name;
    #[ORM\Column(type: 'text', nullable: false)]
    private string $street;
    #[ORM\Column(type: 'text', nullable: false)]
    private string $postalCode;
    #[ORM\Column(type: 'text', nullable: false)]
    private string $city;
    #[ORM\Column(type: 'json', nullable: false)]
    private StoreExternalData $externalData;

    public function __construct()
    {
        $this->externalData = new StoreExternalData();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
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

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function setExternalData(StoreExternalData $externalData): self
    {
        $this->externalData = $externalData;
        return $this;
    }
}
