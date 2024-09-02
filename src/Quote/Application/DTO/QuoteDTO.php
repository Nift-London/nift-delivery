<?php

declare(strict_types=1);

namespace App\Quote\Application\DTO;

use App\Quote\Domain\Enum\QuoteTypeEnum;

final class QuoteDTO
{
    private string $externalId;
    private string $name;
    private string $code;
    private string $description;
    private int $price;
    private string $currency;
    private \DateTimeImmutable $pickupDateFrom;
    private \DateTimeImmutable $pickupDateTo;
    private \DateTimeImmutable $deliveryDateFrom;
    private \DateTimeImmutable $deliveryDateTo;
    private QuoteTypeEnum $type;

    public function __construct(
        string $externalId,
        string $name,
        string $code,
        string $description,
        int $price,
        string $currency,
        \DateTimeImmutable $pickupDateFrom,
        \DateTimeImmutable $pickupDateTo,
        \DateTimeImmutable $deliveryDateFrom,
        \DateTimeImmutable $deliveryDateTo,
        QuoteTypeEnum $type
    ) {
        $this->externalId = $externalId;
        $this->name = $name;
        $this->code = $code;
        $this->description = $description;
        $this->price = $price;
        $this->currency = $currency;
        $this->pickupDateFrom = $pickupDateFrom;
        $this->pickupDateTo = $pickupDateTo;
        $this->deliveryDateFrom = $deliveryDateFrom;
        $this->deliveryDateTo = $deliveryDateTo;
        $this->type = $type;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPickupDateFrom(): \DateTimeImmutable
    {
        return $this->pickupDateFrom;
    }

    public function getPickupDateTo(): \DateTimeImmutable
    {
        return $this->pickupDateTo;
    }

    public function getDeliveryDateFrom(): \DateTimeImmutable
    {
        return $this->deliveryDateFrom;
    }

    public function getDeliveryDateTo(): \DateTimeImmutable
    {
        return $this->deliveryDateTo;
    }

    public function getType(): QuoteTypeEnum
    {
        return $this->type;
    }
}
