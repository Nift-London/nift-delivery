<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity;

use App\Quote\Domain\Entity\Quote;
use App\Quote\Domain\Enum\QuoteTypeEnum;
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

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $todayEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tonightEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tomorrowEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayPrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightPrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tomorrowPrice;

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

        $this->todayPrice = 1499;
        $this->tonightPrice = 1499;
        $this->tomorrowPrice = 999;
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

    public function isTodayEnabled(): bool
    {
        return $this->todayEnabled;
    }

    public function setTodayEnabled(bool $todayEnabled): self
    {
        $this->todayEnabled = $todayEnabled;
        return $this;
    }

    public function isTonightEnabled(): bool
    {
        return $this->tonightEnabled;
    }

    public function setTonightEnabled(bool $tonightEnabled): self
    {
        $this->tonightEnabled = $tonightEnabled;
        return $this;
    }

    public function isTomorrowEnabled(): bool
    {
        return $this->tomorrowEnabled;
    }

    public function setTomorrowEnabled(bool $tomorrowEnabled): self
    {
        $this->tomorrowEnabled = $tomorrowEnabled;
        return $this;
    }

    public function getTodayPrice(): int
    {
        return $this->todayPrice;
    }

    public function setTodayPrice(int $todayPrice): self
    {
        $this->todayPrice = $todayPrice;
        return $this;
    }

    public function getTonightPrice(): int
    {
        return $this->tonightPrice;
    }

    public function setTonightPrice(int $tonightPrice): self
    {
        $this->tonightPrice = $tonightPrice;
        return $this;
    }

    public function getTomorrowPrice(): int
    {
        return $this->tomorrowPrice;
    }

    public function setTomorrowPrice(int $tomorrowPrice): self
    {
        $this->tomorrowPrice = $tomorrowPrice;
        return $this;
    }

    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function setQuotes(Collection $quotes): self
    {
        $this->quotes = $quotes;
        return $this;
    }

    /** @return QuoteTypeEnum[] */
    public function getEnabledTypesWithPrices(): array
    {
        $types = [];

        if ($this->isTodayEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TODAY->value] = $this->getTodayPrice();
        }

        if ($this->isTonightEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TONIGHT->value] = $this->getTonightPrice();
        }

        if ($this->isTomorrowEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TOMORROW->value] = $this->getTomorrowPrice();
        }

        return $types;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
