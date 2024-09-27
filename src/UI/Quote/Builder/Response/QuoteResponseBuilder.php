<?php

declare(strict_types=1);

namespace App\UI\Quote\Builder\Response;

use App\Quote\Application\DTO\ProposalQuotesDTO;
use App\Quote\Application\DTO\QuoteDTO;
use App\UI\Quote\DTO\Response\ShopifyQuoteResponse;

final class QuoteResponseBuilder
{
    /**
     * @param QuoteDTO[] $quoteDTOs
     * @return ShopifyQuoteResponse[]
     */
    public function build(ProposalQuotesDTO $proposalQuotesDTO): array
    {
        $proposals = [];

        if (!is_null($proposalQuotesDTO->getEveningToday())) {
            $proposals[] = new ShopifyQuoteResponse(
                'Need it for Tonight',
                $proposalQuotesDTO->getEveningToday()->getType()->value,
                $proposalQuotesDTO->getEveningToday()->getCustomerPrice(),
                'Evening delivery option. Estimated today delivery time: ' . $proposalQuotesDTO->getEveningToday()->getDeliveryDateTo()->format('H:i'),
                $proposalQuotesDTO->getEveningToday()->getCurrency()
            );
        }

        if (!is_null($proposalQuotesDTO->getFastestToday())) {
            $proposals[] = new ShopifyQuoteResponse(
                'Need it for Today',
                $proposalQuotesDTO->getFastestToday()->getType()->value,
                $proposalQuotesDTO->getFastestToday()->getCustomerPrice(),
                'Today delivery option. Estimated today delivery time: ' . $proposalQuotesDTO->getFastestToday()->getDeliveryDateTo()->format('H:i'),
                $proposalQuotesDTO->getFastestToday()->getCurrency()
            );
        }

        if (!is_null($proposalQuotesDTO->getLatest())) {
            $proposals[] = new ShopifyQuoteResponse(
                'Need it for Tomorrow',
                $proposalQuotesDTO->getLatest()->getType()->value,
                $proposalQuotesDTO->getLatest()->getCustomerPrice(),
                'Normal delivery option. Estimated delivery time: ' . $proposalQuotesDTO->getLatest()->getDeliveryDateTo()->format('Y/m/d H:i'),
                $proposalQuotesDTO->getLatest()->getCurrency()
            );
        }

        return $proposals;
    }
}
