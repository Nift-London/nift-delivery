<?php

declare(strict_types=1);

namespace App\UI\Quote\DTO\Request\Partial;

final class QuoteForShopifyItem
{
    private ?string $name;
    private ?string $sku;
    private ?int $quantity;
    private ?int $grams;
    private ?int $price;
    private ?string $vendor;
    private ?bool $requiresShipping;
    private ?bool $taxable;
    private ?string $fulfillmentService;
    private ?array $properties;
    private ?int $productId;
    private ?int $variantId;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getGrams(): ?int
    {
        return $this->grams;
    }

    public function setGrams(?int $grams): self
    {
        $this->grams = $grams;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(?string $vendor): self
    {
        $this->vendor = $vendor;
        return $this;
    }

    public function getRequiresShipping(): ?bool
    {
        return $this->requiresShipping;
    }

    public function setRequiresShipping(?bool $requiresShipping): self
    {
        $this->requiresShipping = $requiresShipping;
        return $this;
    }

    public function getTaxable(): ?bool
    {
        return $this->taxable;
    }

    public function setTaxable(?bool $taxable): self
    {
        $this->taxable = $taxable;
        return $this;
    }

    public function getFulfillmentService(): ?string
    {
        return $this->fulfillmentService;
    }

    public function setFulfillmentService(?string $fulfillmentService): self
    {
        $this->fulfillmentService = $fulfillmentService;
        return $this;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function setProperties(?array $properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getVariantId(): ?int
    {
        return $this->variantId;
    }

    public function setVariantId(?int $variantId): self
    {
        $this->variantId = $variantId;
        return $this;
    }

}
