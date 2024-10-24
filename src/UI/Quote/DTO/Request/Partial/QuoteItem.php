<?php

declare(strict_types=1);

namespace App\UI\Quote\DTO\Request\Partial;

final class QuoteItem
{
    private string $name;
    private int $quantity;
    private int $grams;
    private int $price;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getGrams(): int
    {
        return $this->grams;
    }

    public function setGrams(int $grams): self
    {
        $this->grams = $grams;
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
}
