<?php

declare(strict_types=1);

namespace App\Quote\Application\DTO;

final class ProposalQuotesDTO
{
    private ?QuoteDTO $fastestToday;
    private ?QuoteDTO $eveningToday;
    private ?QuoteDTO $latest;

    public function __construct(?QuoteDTO $fastestToday, ?QuoteDTO $eveningToday, ?QuoteDTO $latest)
    {
        $this->fastestToday = $fastestToday;
        $this->eveningToday = $eveningToday;
        $this->latest = $latest;
    }

    public static function ofNoAvailableRates(): self
    {
        return new self(null, null, null);
    }

    public function getFastestToday(): ?QuoteDTO
    {
        return $this->fastestToday;
    }

    public function getEveningToday(): ?QuoteDTO
    {
        return $this->eveningToday;
    }

    public function getLatest(): ?QuoteDTO
    {
        return $this->latest;
    }
}
