<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Command\DTO;

use App\Quote\Domain\Enum\QuoteTypeEnum;

final class OrderCommandDTO
{
    private string $contactName;
    private string $street;
    private string $postalCode;
    private string $city;
    private ?string $contactPhone;
    private ?string $contactEmail;
    private QuoteTypeEnum $quoteTypeEnum;
    private string $externalPurchaseId;

    public function __construct(
        string $contactName,
        string $street,
        string $postalCode,
        string $city,
        ?string $contactPhone,
        ?string $contactEmail,
        QuoteTypeEnum $quoteTypeEnum,
        string $externalPurchaseId
    ) {
        $this->contactName = $contactName;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->contactPhone = $contactPhone;
        $this->contactEmail = $contactEmail;
        $this->quoteTypeEnum = $quoteTypeEnum;
        $this->externalPurchaseId = $externalPurchaseId;
    }

    public function getContactName(): string
    {
        return $this->contactName;
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

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function getQuoteTypeEnum(): QuoteTypeEnum
    {
        return $this->quoteTypeEnum;
    }

    public function getExternalPurchaseId(): string
    {
        return $this->externalPurchaseId;
    }
}
