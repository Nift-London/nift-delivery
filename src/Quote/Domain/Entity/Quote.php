<?php

declare(strict_types=1);

namespace App\Quote\Domain\Entity;

use App\Order\Domain\Entity\DeliveryOrder;
use App\Quote\Domain\Enum\QuoteTypeEnum;
use App\Store\Domain\Entity\Store;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Quote
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $groupId;

    #[ORM\Column(type: 'text')]
    private string $externalId;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'integer')]
    private int $price;

    #[ORM\Column(type: 'text')]
    private string $currency;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $pickupStreet;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $pickupPostalCode;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $pickupCity;

    #[ORM\Column(type: 'text')]
    private string $deliveryStreet;

    #[ORM\Column(type: 'text')]
    private string $deliveryPostalCode;

    #[ORM\Column(type: 'text')]
    private string $deliveryCity;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $pickupDateFrom;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $pickupDateTo;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $deliveryDateFrom;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $deliveryDateTo;

    #[ORM\Column(type: 'string', enumType: QuoteTypeEnum::class)]
    private QuoteTypeEnum $type;

    #[ORM\ManyToOne(targetEntity: Store::class, inversedBy: 'quotes')]
    #[ORM\JoinColumn(nullable: false)]
    private Store $store;

    #[ORM\OneToOne(targetEntity: DeliveryOrder::class, inversedBy: 'quote')]
    private ?DeliveryOrder $deliveryOrder;

    public function __construct()
    {
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

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getPickupDateFrom(): \DateTimeImmutable
    {
        return $this->pickupDateFrom;
    }

    public function setPickupDateFrom(\DateTimeImmutable $pickupDateFrom): self
    {
        $this->pickupDateFrom = $pickupDateFrom;
        return $this;
    }

    public function getPickupDateTo(): \DateTimeImmutable
    {
        return $this->pickupDateTo;
    }

    public function setPickupDateTo(\DateTimeImmutable $pickupDateTo): self
    {
        $this->pickupDateTo = $pickupDateTo;
        return $this;
    }

    public function getDeliveryDateFrom(): \DateTimeImmutable
    {
        return $this->deliveryDateFrom;
    }

    public function setDeliveryDateFrom(\DateTimeImmutable $deliveryDateFrom): self
    {
        $this->deliveryDateFrom = $deliveryDateFrom;
        return $this;
    }

    public function getDeliveryDateTo(): \DateTimeImmutable
    {
        return $this->deliveryDateTo;
    }

    public function setDeliveryDateTo(\DateTimeImmutable $deliveryDateTo): self
    {
        $this->deliveryDateTo = $deliveryDateTo;
        return $this;
    }

    public function getType(): QuoteTypeEnum
    {
        return $this->type;
    }

    public function setType(QuoteTypeEnum $type): self
    {
        $this->type = $type;
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

    public function getPickupStreet(): ?string
    {
        return $this->pickupStreet;
    }

    public function setPickupStreet(?string $pickupStreet): self
    {
        $this->pickupStreet = $pickupStreet;
        return $this;
    }

    public function getPickupPostalCode(): ?string
    {
        return $this->pickupPostalCode;
    }

    public function setPickupPostalCode(?string $pickupPostalCode): self
    {
        $this->pickupPostalCode = $pickupPostalCode;
        return $this;
    }

    public function getPickupCity(): ?string
    {
        return $this->pickupCity;
    }

    public function setPickupCity(?string $pickupCity): self
    {
        $this->pickupCity = $pickupCity;
        return $this;
    }

    public function getDeliveryStreet(): string
    {
        return $this->deliveryStreet;
    }

    public function setDeliveryStreet(string $deliveryStreet): self
    {
        $this->deliveryStreet = $deliveryStreet;
        return $this;
    }

    public function getDeliveryPostalCode(): string
    {
        return $this->deliveryPostalCode;
    }

    public function setDeliveryPostalCode(string $deliveryPostalCode): self
    {
        $this->deliveryPostalCode = $deliveryPostalCode;
        return $this;
    }

    public function getDeliveryCity(): string
    {
        return $this->deliveryCity;
    }

    public function setDeliveryCity(string $deliveryCity): self
    {
        $this->deliveryCity = $deliveryCity;
        return $this;
    }

    public function getGroupId(): Uuid
    {
        return $this->groupId;
    }

    public function setGroupId(Uuid $groupId): self
    {
        $this->groupId = $groupId;
        return $this;
    }

    public function getDeliveryOrder(): ?DeliveryOrder
    {
        return $this->deliveryOrder;
    }

    public function setDeliveryOrder(DeliveryOrder $deliveryOrder): self
    {
        $this->deliveryOrder = $deliveryOrder;
        return $this;
    }
}
