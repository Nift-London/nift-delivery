<?php

declare(strict_types=1);

namespace App\Quote\Domain\DTO;

final class ProposalQuotesDTO
{
    private ?QuoteDTO $fastestToday;
    private ?QuoteDTO $today;
    private ?QuoteDTO $latest;

    public function __construct(?QuoteDTO $fastestToday, ?QuoteDTO $today, ?QuoteDTO $latest)
    {
        $this->fastestToday = $fastestToday;
        $this->today = $today;
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

    public function getToday(): ?QuoteDTO
    {
        return $this->today;
    }

    public function getLatest(): ?QuoteDTO
    {
        return $this->latest;
    }
}
