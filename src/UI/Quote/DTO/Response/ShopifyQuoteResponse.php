<?php

declare(strict_types=1);

namespace App\UI\Quote\DTO\Response;

final class ShopifyQuoteResponse
{
    private string $serviceName;
    private string $serviceCode;
    private int $totalPrice;
    private string $description;
    private string $currency;

    public function __construct(string $serviceName, string $serviceCode, int $totalPrice, string $description, string $currency)
    {
        $this->serviceName = $serviceName;
        $this->serviceCode = $serviceCode;
        $this->totalPrice = $totalPrice;
        $this->description = $description;
        $this->currency = $currency;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
