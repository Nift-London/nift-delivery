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

// todo Distances as onetomany (we need first custom UI for it, easy may be bad for it)
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

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shopifyId;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $enabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tomorrowEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tomorrowPrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tomorrowMaxPrice = 0;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayMaxPrice = 0;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightMaxPrice = 0;

    /** First Distance */

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFirstDistanceFrom = 0;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFirstDistanceTo = 7000;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFirstDistanceFrom = 0;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFirstDistanceTo = 7000;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $todayFirstDistanceEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tonightFirstDistanceEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFirstDistancePrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFirstDistancePrice;

    /** Second Distance */

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todaySecondDistanceFrom = 7001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todaySecondDistanceTo = 7001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightSecondDistanceFrom = 10000;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightSecondDistanceTo = 10000;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $todaySecondDistanceEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tonightSecondDistanceEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todaySecondDistancePrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightSecondDistancePrice;

    /** Third Distance */

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayThirdDistanceFrom = 10001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightThirdDistanceTo = 15000;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayThirdDistanceTo = 10001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightThirdDistanceFrom = 15000;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $todayThirdDistanceEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tonightThirdDistanceEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayThirdDistancePrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightThirdDistancePrice;

    /** Fourth Distance */

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFourthDistanceFrom = 15001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFourthDistanceTo = 15001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFourthDistanceFrom = 50000;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFourthDistanceTo = 50000;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $todayFourthDistanceEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tonightFourthDistanceEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFourthDistancePrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFourthDistancePrice;

    /** Fifth Distance */

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFifthDistanceFrom = 50001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFifthDistanceTo = 50001;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFifthDistanceFrom = 80000;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFifthDistanceTo = 80000;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $todayFifthDistanceEnabled = false;

    #[ORM\Column(type: 'boolean', nullable: false, columnDefinition: 'BOOLEAN DEFAULT false')]
    private bool $tonightFifthDistanceEnabled = false;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $todayFifthDistancePrice;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $tonightFifthDistancePrice;

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

    public function getShopifyId(): ?string
    {
        return $this->shopifyId;
    }

    public function setShopifyId(string $shopifyId): self
    {
        $this->shopifyId = $shopifyId;
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

    public function isTomorrowEnabled(): bool
    {
        return $this->tomorrowEnabled;
    }

    public function setTomorrowEnabled(bool $tomorrowEnabled): self
    {
        $this->tomorrowEnabled = $tomorrowEnabled;
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
    public function getEnabledTypesWithDistanceAndPrices(): array
    {
        $types = [];

        if ($this->isTodayFirstDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TODAY->value][] = [
                'price' => $this->getTodayFirstDistancePrice(),
                'maxPrice' => $this->getTodayMaxPrice(),
                'distanceFrom' => $this->getTodayFirstDistanceFrom(),
                'distanceTo' => $this->getTodayFirstDistanceTo(),
            ];
        }

        if ($this->isTonightFirstDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TONIGHT->value][] = [
                'price' => $this->getTonightFirstDistancePrice(),
                'maxPrice' => $this->getTonightMaxPrice(),
                'distanceFrom' => $this->getTonightFirstDistanceFrom(),
                'distanceTo' => $this->getTonightFirstDistanceTo(),
            ];
        }

        if ($this->isTodaySecondDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TODAY->value][] = [
                'price' => $this->getTodaySecondDistancePrice(),
                'maxPrice' => $this->getTodayMaxPrice(),
                'distanceFrom' => $this->getTodaySecondDistanceFrom(),
                'distanceTo' => $this->getTodaySecondDistanceTo(),
            ];
        }

        if ($this->isTonightSecondDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TONIGHT->value][] = [
                'price' => $this->getTonightSecondDistancePrice(),
                'maxPrice' => $this->getTonightMaxPrice(),
                'distanceFrom' => $this->getTonightSecondDistanceFrom(),
                'distanceTo' => $this->getTonightSecondDistanceTo(),
            ];
        }

        if ($this->isTodayThirdDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TODAY->value][] = [
                'price' => $this->getTodayThirdDistancePrice(),
                'maxPrice' => $this->getTodayMaxPrice(),
                'distanceFrom' => $this->getTodayThirdDistanceFrom(),
                'distanceTo' => $this->getTodayThirdDistanceTo(),
            ];
        }

        if ($this->isTonightThirdDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TONIGHT->value][] = [
                'price' => $this->getTonightThirdDistancePrice(),
                'maxPrice' => $this->getTonightMaxPrice(),
                'distanceFrom' => $this->getTonightThirdDistanceFrom(),
                'distanceTo' => $this->getTonightThirdDistanceTo(),
            ];
        }

        if ($this->isTodayFourthDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TODAY->value][] = [
                'price' => $this->getTodayFourthDistancePrice(),
                'maxPrice' => $this->getTodayMaxPrice(),
                'distanceFrom' => $this->getTodayFourthDistanceFrom(),
                'distanceTo' => $this->getTodayFourthDistanceTo(),
            ];
        }

        if ($this->isTonightFourthDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TONIGHT->value][] = [
                'price' => $this->getTonightFourthDistancePrice(),
                'maxPrice' => $this->getTonightMaxPrice(),
                'distanceFrom' => $this->getTonightFourthDistanceFrom(),
                'distanceTo' => $this->getTonightFourthDistanceTo(),
            ];
        }

        if ($this->isTodayFifthDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TODAY->value][] = [
                'price' => $this->getTodayFifthDistancePrice(),
                'maxPrice' => $this->getTodayMaxPrice(),
                'distanceFrom' => $this->getTodayFifthDistanceFrom(),
                'distanceTo' => $this->getTodayFifthDistanceTo(),
            ];
        }

        if ($this->isTonightFifthDistanceEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TONIGHT->value][] = [
                'price' => $this->getTonightFifthDistancePrice(),
                'maxPrice' => $this->getTonightMaxPrice(),
                'distanceFrom' => $this->getTonightFifthDistanceFrom(),
                'distanceTo' => $this->getTonightFifthDistanceTo(),
            ];
        }

        if ($this->isTomorrowEnabled()) {
            $types[QuoteTypeEnum::EVERMILE_TOMORROW->value] = $this->getTomorrowPrice();
        }

        return $types;
    }

    /**
     * @return int
     */
    public function getTodayFirstDistanceFrom(): int
    {
        return $this->todayFirstDistanceFrom;
    }

    /**
     * @param int $todayFirstDistanceFrom
     * @return Location
     */
    public function setTodayFirstDistanceFrom(int $todayFirstDistanceFrom): Location
    {
        $this->todayFirstDistanceFrom = $todayFirstDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFirstDistanceTo(): int
    {
        return $this->tonightFirstDistanceTo;
    }

    /**
     * @param int $tonightFirstDistanceTo
     * @return Location
     */
    public function setTonightFirstDistanceTo(int $tonightFirstDistanceTo): Location
    {
        $this->tonightFirstDistanceTo = $tonightFirstDistanceTo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTodayFirstDistanceEnabled(): bool
    {
        return $this->todayFirstDistanceEnabled;
    }

    /**
     * @param bool $todayFirstDistanceEnabled
     * @return Location
     */
    public function setTodayFirstDistanceEnabled(bool $todayFirstDistanceEnabled): Location
    {
        $this->todayFirstDistanceEnabled = $todayFirstDistanceEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTonightFirstDistanceEnabled(): bool
    {
        return $this->tonightFirstDistanceEnabled;
    }

    /**
     * @param bool $tonightFirstDistanceEnabled
     * @return Location
     */
    public function setTonightFirstDistanceEnabled(bool $tonightFirstDistanceEnabled): Location
    {
        $this->tonightFirstDistanceEnabled = $tonightFirstDistanceEnabled;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFirstDistancePrice(): int
    {
        return $this->todayFirstDistancePrice;
    }

    /**
     * @param int $todayFirstDistancePrice
     * @return Location
     */
    public function setTodayFirstDistancePrice(int $todayFirstDistancePrice): Location
    {
        $this->todayFirstDistancePrice = $todayFirstDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFirstDistancePrice(): int
    {
        return $this->tonightFirstDistancePrice;
    }

    /**
     * @param int $tonightFirstDistancePrice
     * @return Location
     */
    public function setTonightFirstDistancePrice(int $tonightFirstDistancePrice): Location
    {
        $this->tonightFirstDistancePrice = $tonightFirstDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodaySecondDistanceFrom(): int
    {
        return $this->todaySecondDistanceFrom;
    }

    /**
     * @param int $todaySecondDistanceFrom
     * @return Location
     */
    public function setTodaySecondDistanceFrom(int $todaySecondDistanceFrom): Location
    {
        $this->todaySecondDistanceFrom = $todaySecondDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightSecondDistanceTo(): int
    {
        return $this->tonightSecondDistanceTo;
    }

    /**
     * @param int $tonightSecondDistanceTo
     * @return Location
     */
    public function setTonightSecondDistanceTo(int $tonightSecondDistanceTo): Location
    {
        $this->tonightSecondDistanceTo = $tonightSecondDistanceTo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTodaySecondDistanceEnabled(): bool
    {
        return $this->todaySecondDistanceEnabled;
    }

    /**
     * @param bool $todaySecondDistanceEnabled
     * @return Location
     */
    public function setTodaySecondDistanceEnabled(bool $todaySecondDistanceEnabled): Location
    {
        $this->todaySecondDistanceEnabled = $todaySecondDistanceEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTonightSecondDistanceEnabled(): bool
    {
        return $this->tonightSecondDistanceEnabled;
    }

    /**
     * @param bool $tonightSecondDistanceEnabled
     * @return Location
     */
    public function setTonightSecondDistanceEnabled(bool $tonightSecondDistanceEnabled): Location
    {
        $this->tonightSecondDistanceEnabled = $tonightSecondDistanceEnabled;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodaySecondDistancePrice(): int
    {
        return $this->todaySecondDistancePrice;
    }

    /**
     * @param int $todaySecondDistancePrice
     * @return Location
     */
    public function setTodaySecondDistancePrice(int $todaySecondDistancePrice): Location
    {
        $this->todaySecondDistancePrice = $todaySecondDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightSecondDistancePrice(): int
    {
        return $this->tonightSecondDistancePrice;
    }

    /**
     * @param int $tonightSecondDistancePrice
     * @return Location
     */
    public function setTonightSecondDistancePrice(int $tonightSecondDistancePrice): Location
    {
        $this->tonightSecondDistancePrice = $tonightSecondDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayThirdDistanceFrom(): int
    {
        return $this->todayThirdDistanceFrom;
    }

    /**
     * @param int $todayThirdDistanceFrom
     * @return Location
     */
    public function setTodayThirdDistanceFrom(int $todayThirdDistanceFrom): Location
    {
        $this->todayThirdDistanceFrom = $todayThirdDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightThirdDistanceTo(): int
    {
        return $this->tonightThirdDistanceTo;
    }

    /**
     * @param int $tonightThirdDistanceTo
     * @return Location
     */
    public function setTonightThirdDistanceTo(int $tonightThirdDistanceTo): Location
    {
        $this->tonightThirdDistanceTo = $tonightThirdDistanceTo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTodayThirdDistanceEnabled(): bool
    {
        return $this->todayThirdDistanceEnabled;
    }

    /**
     * @param bool $todayThirdDistanceEnabled
     * @return Location
     */
    public function setTodayThirdDistanceEnabled(bool $todayThirdDistanceEnabled): Location
    {
        $this->todayThirdDistanceEnabled = $todayThirdDistanceEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTonightThirdDistanceEnabled(): bool
    {
        return $this->tonightThirdDistanceEnabled;
    }

    /**
     * @param bool $tonightThirdDistanceEnabled
     * @return Location
     */
    public function setTonightThirdDistanceEnabled(bool $tonightThirdDistanceEnabled): Location
    {
        $this->tonightThirdDistanceEnabled = $tonightThirdDistanceEnabled;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayThirdDistancePrice(): int
    {
        return $this->todayThirdDistancePrice;
    }

    /**
     * @param int $todayThirdDistancePrice
     * @return Location
     */
    public function setTodayThirdDistancePrice(int $todayThirdDistancePrice): Location
    {
        $this->todayThirdDistancePrice = $todayThirdDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightThirdDistancePrice(): int
    {
        return $this->tonightThirdDistancePrice;
    }

    /**
     * @param int $tonightThirdDistancePrice
     * @return Location
     */
    public function setTonightThirdDistancePrice(int $tonightThirdDistancePrice): Location
    {
        $this->tonightThirdDistancePrice = $tonightThirdDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFourthDistanceFrom(): int
    {
        return $this->todayFourthDistanceFrom;
    }

    /**
     * @param int $todayFourthDistanceFrom
     * @return Location
     */
    public function setTodayFourthDistanceFrom(int $todayFourthDistanceFrom): Location
    {
        $this->todayFourthDistanceFrom = $todayFourthDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFourthDistanceTo(): int
    {
        return $this->tonightFourthDistanceTo;
    }

    /**
     * @param int $tonightFourthDistanceTo
     * @return Location
     */
    public function setTonightFourthDistanceTo(int $tonightFourthDistanceTo): Location
    {
        $this->tonightFourthDistanceTo = $tonightFourthDistanceTo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTodayFourthDistanceEnabled(): bool
    {
        return $this->todayFourthDistanceEnabled;
    }

    /**
     * @param bool $todayFourthDistanceEnabled
     * @return Location
     */
    public function setTodayFourthDistanceEnabled(bool $todayFourthDistanceEnabled): Location
    {
        $this->todayFourthDistanceEnabled = $todayFourthDistanceEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTonightFourthDistanceEnabled(): bool
    {
        return $this->tonightFourthDistanceEnabled;
    }

    /**
     * @param bool $tonightFourthDistanceEnabled
     * @return Location
     */
    public function setTonightFourthDistanceEnabled(bool $tonightFourthDistanceEnabled): Location
    {
        $this->tonightFourthDistanceEnabled = $tonightFourthDistanceEnabled;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFourthDistancePrice(): int
    {
        return $this->todayFourthDistancePrice;
    }

    /**
     * @param int $todayFourthDistancePrice
     * @return Location
     */
    public function setTodayFourthDistancePrice(int $todayFourthDistancePrice): Location
    {
        $this->todayFourthDistancePrice = $todayFourthDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFourthDistancePrice(): int
    {
        return $this->tonightFourthDistancePrice;
    }

    /**
     * @param int $tonightFourthDistancePrice
     * @return Location
     */
    public function setTonightFourthDistancePrice(int $tonightFourthDistancePrice): Location
    {
        $this->tonightFourthDistancePrice = $tonightFourthDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFifthDistanceFrom(): int
    {
        return $this->todayFifthDistanceFrom;
    }

    /**
     * @param int $todayFifthDistanceFrom
     * @return Location
     */
    public function setTodayFifthDistanceFrom(int $todayFifthDistanceFrom): Location
    {
        $this->todayFifthDistanceFrom = $todayFifthDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFifthDistanceTo(): int
    {
        return $this->tonightFifthDistanceTo;
    }

    /**
     * @param int $tonightFifthDistanceTo
     * @return Location
     */
    public function setTonightFifthDistanceTo(int $tonightFifthDistanceTo): Location
    {
        $this->tonightFifthDistanceTo = $tonightFifthDistanceTo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTodayFifthDistanceEnabled(): bool
    {
        return $this->todayFifthDistanceEnabled;
    }

    /**
     * @param bool $todayFifthDistanceEnabled
     * @return Location
     */
    public function setTodayFifthDistanceEnabled(bool $todayFifthDistanceEnabled): Location
    {
        $this->todayFifthDistanceEnabled = $todayFifthDistanceEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTonightFifthDistanceEnabled(): bool
    {
        return $this->tonightFifthDistanceEnabled;
    }

    /**
     * @param bool $tonightFifthDistanceEnabled
     * @return Location
     */
    public function setTonightFifthDistanceEnabled(bool $tonightFifthDistanceEnabled): Location
    {
        $this->tonightFifthDistanceEnabled = $tonightFifthDistanceEnabled;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFifthDistancePrice(): int
    {
        return $this->todayFifthDistancePrice;
    }

    /**
     * @param int $todayFifthDistancePrice
     * @return Location
     */
    public function setTodayFifthDistancePrice(int $todayFifthDistancePrice): Location
    {
        $this->todayFifthDistancePrice = $todayFifthDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFifthDistancePrice(): int
    {
        return $this->tonightFifthDistancePrice;
    }

    /**
     * @param int $tonightFifthDistancePrice
     * @return Location
     */
    public function setTonightFifthDistancePrice(int $tonightFifthDistancePrice): Location
    {
        $this->tonightFifthDistancePrice = $tonightFifthDistancePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTomorrowMaxPrice(): int
    {
        return $this->tomorrowMaxPrice;
    }

    /**
     * @param int $tomorrowMaxPrice
     * @return Location
     */
    public function setTomorrowMaxPrice(int $tomorrowMaxPrice): Location
    {
        $this->tomorrowMaxPrice = $tomorrowMaxPrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayMaxPrice(): int
    {
        return $this->todayMaxPrice;
    }

    /**
     * @param int $todayMaxPrice
     * @return Location
     */
    public function setTodayMaxPrice(int $todayMaxPrice): Location
    {
        $this->todayMaxPrice = $todayMaxPrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightMaxPrice(): int
    {
        return $this->tonightMaxPrice;
    }

    /**
     * @param int $tonightMaxPrice
     * @return Location
     */
    public function setTonightMaxPrice(int $tonightMaxPrice): Location
    {
        $this->tonightMaxPrice = $tonightMaxPrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFirstDistanceTo(): int
    {
        return $this->todayFirstDistanceTo;
    }

    /**
     * @param int $todayFirstDistanceTo
     * @return Location
     */
    public function setTodayFirstDistanceTo(int $todayFirstDistanceTo): Location
    {
        $this->todayFirstDistanceTo = $todayFirstDistanceTo;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFirstDistanceFrom(): int
    {
        return $this->tonightFirstDistanceFrom;
    }

    /**
     * @param int $tonightFirstDistanceFrom
     * @return Location
     */
    public function setTonightFirstDistanceFrom(int $tonightFirstDistanceFrom): Location
    {
        $this->tonightFirstDistanceFrom = $tonightFirstDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodaySecondDistanceTo(): int
    {
        return $this->todaySecondDistanceTo;
    }

    /**
     * @param int $todaySecondDistanceTo
     * @return Location
     */
    public function setTodaySecondDistanceTo(int $todaySecondDistanceTo): Location
    {
        $this->todaySecondDistanceTo = $todaySecondDistanceTo;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightSecondDistanceFrom(): int
    {
        return $this->tonightSecondDistanceFrom;
    }

    /**
     * @param int $tonightSecondDistanceFrom
     * @return Location
     */
    public function setTonightSecondDistanceFrom(int $tonightSecondDistanceFrom): Location
    {
        $this->tonightSecondDistanceFrom = $tonightSecondDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayThirdDistanceTo(): int
    {
        return $this->todayThirdDistanceTo;
    }

    /**
     * @param int $todayThirdDistanceTo
     * @return Location
     */
    public function setTodayThirdDistanceTo(int $todayThirdDistanceTo): Location
    {
        $this->todayThirdDistanceTo = $todayThirdDistanceTo;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightThirdDistanceFrom(): int
    {
        return $this->tonightThirdDistanceFrom;
    }

    /**
     * @param int $tonightThirdDistanceFrom
     * @return Location
     */
    public function setTonightThirdDistanceFrom(int $tonightThirdDistanceFrom): Location
    {
        $this->tonightThirdDistanceFrom = $tonightThirdDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFourthDistanceTo(): int
    {
        return $this->todayFourthDistanceTo;
    }

    /**
     * @param int $todayFourthDistanceTo
     * @return Location
     */
    public function setTodayFourthDistanceTo(int $todayFourthDistanceTo): Location
    {
        $this->todayFourthDistanceTo = $todayFourthDistanceTo;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFourthDistanceFrom(): int
    {
        return $this->tonightFourthDistanceFrom;
    }

    /**
     * @param int $tonightFourthDistanceFrom
     * @return Location
     */
    public function setTonightFourthDistanceFrom(int $tonightFourthDistanceFrom): Location
    {
        $this->tonightFourthDistanceFrom = $tonightFourthDistanceFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getTodayFifthDistanceTo(): int
    {
        return $this->todayFifthDistanceTo;
    }

    /**
     * @param int $todayFifthDistanceTo
     * @return Location
     */
    public function setTodayFifthDistanceTo(int $todayFifthDistanceTo): Location
    {
        $this->todayFifthDistanceTo = $todayFifthDistanceTo;
        return $this;
    }

    /**
     * @return int
     */
    public function getTonightFifthDistanceFrom(): int
    {
        return $this->tonightFifthDistanceFrom;
    }

    /**
     * @param int $tonightFifthDistanceFrom
     * @return Location
     */
    public function setTonightFifthDistanceFrom(int $tonightFifthDistanceFrom): Location
    {
        $this->tonightFifthDistanceFrom = $tonightFifthDistanceFrom;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
