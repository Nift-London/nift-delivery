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
    private Uuid $id;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyClientId;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyClientSecret;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyAuthCode;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyToken;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyName;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyDomain;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $enabled = false;

    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'store')]
    /** @var Location[]|Collection */
    private Collection $locations;

    public function __construct()
    {
        $this->id = Uuid::v6();
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

    public function getShopifyClientId(): ?string
    {
        return $this->shopifyClientId;
    }

    public function setShopifyClientId(?string $shopifyClientId): self
    {
        $this->shopifyClientId = $shopifyClientId;
        return $this;
    }

    public function getShopifyClientSecret(): ?string
    {
        return $this->shopifyClientSecret;
    }

    public function setShopifyClientSecret(?string $shopifyClientSecret): self
    {
        $this->shopifyClientSecret = $shopifyClientSecret;
        return $this;
    }

    public function getShopifyAuthCode(): ?string
    {
        return $this->shopifyAuthCode;
    }

    public function setShopifyAuthCode(?string $shopifyAuthCode): self
    {
        $this->shopifyAuthCode = $shopifyAuthCode;
        return $this;
    }

    public function getShopifyToken(): ?string
    {
        return $this->shopifyToken;
    }

    public function setShopifyToken(?string $shopifyToken): self
    {
        $this->shopifyToken = $shopifyToken;
        return $this;
    }

    public function getShopifyName(): ?string
    {
        return $this->shopifyName;
    }

    public function setShopifyName(?string $shopifyName): self
    {
        $this->shopifyName = $shopifyName;
        return $this;
    }

    public function getShopifyDomain(): ?string
    {
        return $this->shopifyDomain;
    }

    public function setShopifyDomain(?string $shopifyDomain): self
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
