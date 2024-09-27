<?php

declare(strict_types=1);

namespace App\Quote\Application\Calculator;

use App\Quote\Application\DTO\ProposalQuotesDTO;
use App\Quote\Application\DTO\QuoteDTO;
use App\Quote\Domain\Enum\QuoteTypeEnum;

// This will be strategy in future to calculate cheapest/fastest quotes
final class QuoteCalculator
{
    public function calculate(array $quotes, array $typePriceTable): ProposalQuotesDTO
    {
        if (empty($quotes)) {
            return ProposalQuotesDTO::ofNoAvailableRates();
        }

        $this->sortQuotes($quotes);

        return new ProposalQuotesDTO(
            $this->getTodayCheapest($quotes, $typePriceTable),
            $this->getTodayEvening($quotes, $typePriceTable),
            $this->getLatest($quotes, $typePriceTable)
        );
    }

    private function sortQuotes(array &$quotes): void
    {
        usort($quotes, function (QuoteDTO $a, QuoteDTO $b) {
            return $a->getDeliveryDateTo()->getTimestamp() - $b->getDeliveryDateTo()->getTimestamp();
        });
    }

    /** @param QuoteDTO[] $quotes */
    private function getTodayCheapest(array $quotes, array $typePriceTable): ?QuoteDTO
    {
        if (!isset($quotes[0]) || !array_key_exists(QuoteTypeEnum::EVERMILE_TODAY->value, $typePriceTable)) {
            return null;
        }

        $today = new \DateTimeImmutable();
        $cheapestQuote = null;

        foreach ($quotes as $quote) {
            if ($quote->getDeliveryDateTo()->format('Ymd') == $today->format('Ymd') && $quote->getName() != 'evening') {
                if (is_null($cheapestQuote) || $quote->getPrice() < $cheapestQuote->getPrice()) {
                    $cheapestQuote = $quote;
                }
            }
        }

        if (!is_null($cheapestQuote)) {
            $cheapestQuote->setType(QuoteTypeEnum::EVERMILE_TODAY);
            $cheapestQuote->setCustomerPrice($typePriceTable[QuoteTypeEnum::EVERMILE_TODAY->value]);
        }

        return $cheapestQuote;
    }

    /** @param QuoteDTO[] $quotes */
    private function getTodayEvening(array $quotes, array $typePriceTable): ?QuoteDTO
    {
        if (!array_key_exists(QuoteTypeEnum::EVERMILE_TONIGHT->value, $typePriceTable)) {
            return null;
        }

        foreach ($quotes as $quote) {
            if ($quote->getName() === 'evening') {
                $quote->setType(QuoteTypeEnum::EVERMILE_TONIGHT);
                $quote->setCustomerPrice($typePriceTable[QuoteTypeEnum::EVERMILE_TONIGHT->value]);
                return $quote;
            }
        }

        return null;
    }

    /** @param QuoteDTO[] $quotes */
    private function getLatest(array $quotes, array $typePriceTable): ?QuoteDTO
    {
        if (!array_key_exists(QuoteTypeEnum::EVERMILE_TOMORROW->value, $typePriceTable)) {
            return null;
        }

        $today = new \DateTimeImmutable();
        $cheapestQuote = null;
        $chosenDate = null;

        // todo change for cheapest available
        foreach ($quotes as $quote) {
            if ($quote->getDeliveryDateTo()->format('Ymd') != $today->format('Ymd')) {
                if (is_null($cheapestQuote) || $quote->getPrice() < $cheapestQuote->getPrice()) {
                    if (is_null($chosenDate) || $quote->getDeliveryDateTo()->format('Ymd') === $chosenDate) {
                        $cheapestQuote = $quote;
                        $chosenDate = $quote->getDeliveryDateTo()->format('Ymd');
                    }
                }
            }
        }

        if (!is_null($cheapestQuote)) {
            $cheapestQuote->setType(QuoteTypeEnum::EVERMILE_TOMORROW);
            $cheapestQuote->setCustomerPrice($typePriceTable[QuoteTypeEnum::EVERMILE_TOMORROW->value]);
        }

        return $cheapestQuote;
    }
}
