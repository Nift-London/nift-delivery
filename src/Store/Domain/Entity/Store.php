<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Store implements \Stringable
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $shopifyToken;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $shopifyName;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $shopifyDomain;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $enabled = false;

    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'store')]
    /** @var Location[]|Collection */
    private Collection $locations;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->locations = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getStreet(): ?string
    {
        return null;
        return $this->locations->first()->getStreet();
    }

    public function getPostalCode(): ?string
    {
        return null;
        return $this->locations->first()->getPostalCode();
    }

    public function getCity(): ?string
    {
        return null;
        return $this->locations->first()->getCity();
    }

    public function getEvermileLocationId(): ?string
    {
        return null;
        return $this->locations->first()->getEvermileLocationId();
    }

    public function getShopifyToken(): string
    {
        return $this->shopifyToken;
    }

    public function setShopifyToken(string $shopifyToken): self
    {
        $this->shopifyToken = $shopifyToken;
        return $this;
    }

    public function getShopifyName(): string
    {
        return $this->shopifyName;
    }

    public function setShopifyName(string $shopifyName): self
    {
        $this->shopifyName = $shopifyName;
        return $this;
    }

    public function getShopifyDomain(): string
    {
        return $this->shopifyDomain;
    }

    public function setShopifyDomain(string $shopifyDomain): self
    {
        $this->shopifyDomain = $shopifyDomain;
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

    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
