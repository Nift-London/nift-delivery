<?php

declare(strict_types=1);

namespace App\UI\Quote\DTO\Request;

use App\UI\Quote\DTO\Request\Partial\QuoteAddress;
use App\UI\Quote\DTO\Request\Partial\QuoteItem;

final class QuoteRequest
{
    private QuoteAddress $origin;
    private QuoteAddress $destination;
    /** @var QuoteItem[]  */
    private array $items;

    public function getOrigin(): QuoteAddress
    {
        return $this->origin;
    }

    public function setOrigin(QuoteAddress $origin): self
    {
        $this->origin = $origin;
        return $this;
    }

    public function getDestination(): QuoteAddress
    {
        return $this->destination;
    }

    public function setDestination(QuoteAddress $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    /** @return QuoteItem[] */
    public function getItems(): array
    {
        return $this->items;
    }

    /** @param QuoteItem[] $items */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }
}
