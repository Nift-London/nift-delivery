<?php

declare(strict_types=1);

namespace App\UI\Quote\DTO\Request;

use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyAddress;
use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyItem;

final class QuoteForShopifyRequest
{
    private string $shopifyDomain;
    private QuoteForShopifyAddress $origin;
    private QuoteForShopifyAddress $destination;
    /** @var QuoteForShopifyItem[]  */
    private array $items;

    public function getShopifyDomain(): string
    {
        return $this->shopifyDomain;
    }

    public function setShopifyDomain(string $shopifyDomain): self
    {
        $this->shopifyDomain = $shopifyDomain;
        return $this;
    }

    public function getOrigin(): QuoteForShopifyAddress
    {
        return $this->origin;
    }

    public function setOrigin(QuoteForShopifyAddress $origin): self
    {
        $this->origin = $origin;
        return $this;
    }

    public function getDestination(): QuoteForShopifyAddress
    {
        return $this->destination;
    }

    public function setDestination(QuoteForShopifyAddress $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /** @param QuoteForShopifyItem[] $items */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }
}
