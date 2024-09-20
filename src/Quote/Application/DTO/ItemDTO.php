<?php

declare(strict_types=1);

namespace App\Quote\Application\DTO;

final class ItemDTO
{
    private string $name;
    private string $sku;
    private int $quantity;
    private int $price;
    private int $weightInGrams;

    public function __construct(string $name, string $sku, int $quantity, int $price, int $weightInGrams)
    {
        $this->name = $name;
        $this->sku = $sku;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->weightInGrams = $weightInGrams;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getWeightInGrams(): int
    {
        return $this->weightInGrams;
    }
}
