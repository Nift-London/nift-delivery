<?php

declare(strict_types=1);

namespace App\UI\Quote\DTO\Response;

final class QuoteResponse
{
    private string $id;
    private string $name;
    private string $code;
    private int $price;
    private string $description;
    private string $currency;

    public function __construct(string $id, string $name, string $code, int $price, string $description, string $currency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->price = $price;
        $this->description = $description;
        $this->currency = $currency;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPrice(): int
    {
        return $this->price;
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
