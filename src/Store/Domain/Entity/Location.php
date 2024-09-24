<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity;

use App\Quote\Domain\Entity\Quote;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Location implements \Stringable
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

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

    #[ORM\Column(type: 'text', nullable: false)]
    private string $evermileLocationId;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $enabled = false;

    #[ORM\ManyToOne(targetEntity: Store::class, inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private Store $store;

    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'location')]
    private Collection $quotes;

    public function __construct()
    {
        $this->id = Uuid::v6();
        $this->quotes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
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

    public function getEvermileLocationId(): string
    {
        return $this->evermileLocationId;
    }

    public function setEvermileLocationId(string $evermileLocationId): self
    {
        $this->evermileLocationId = $evermileLocationId;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function setStore(Store $store): self
    {
        $this->store = $store;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
