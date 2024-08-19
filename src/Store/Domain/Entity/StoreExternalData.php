<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity;

final class StoreExternalData
{
    private string $evermileLocationId = 'f9e4c4e4-e05e-4020-970c-d71f961fdda0';
    private string $shopifyToken;

    public function getEvermileLocationId(): string
    {
        return $this->evermileLocationId;
    }

    public function getShopifyToken(): string
    {
        return $this->shopifyToken;
    }

    public function setEvermileLocationId(string $evermileLocationId): self
    {
        $this->evermileLocationId = $evermileLocationId;
        return $this;
    }

    public function setShopifyToken(string $shopifyToken): self
    {
        $this->shopifyToken = $shopifyToken;
        return $this;
    }
}
