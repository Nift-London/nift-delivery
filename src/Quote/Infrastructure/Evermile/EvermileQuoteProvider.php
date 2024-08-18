<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile;

use App\Common\Evermile\EvermileClient;
use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\QuoteDTO;
use App\Quote\Domain\DTO\StoreDTO;
use App\Quote\Infrastructure\Evermile\Builder\EvermileQuoteRequestBuilder;

final class EvermileQuoteProvider
{
    private EvermileClient $evermileClient;
    private EvermileQuoteRequestBuilder $evermileQuoteRequestBuilder;

    public function __construct(EvermileClient $evermileClient, EvermileQuoteRequestBuilder $evermileQuoteRequestBuilder)
    {
        $this->evermileClient = $evermileClient;
        $this->evermileQuoteRequestBuilder = $evermileQuoteRequestBuilder;
    }

    /** @return QuoteDTO[] */
    public function provide(AddressDTO $addressFrom, AddressDTO $addressTo, StoreDTO $store): array
    {
        $quotes = [];

        $response = $this->evermileClient->getQuote($this->evermileQuoteRequestBuilder->build($addressTo, $store));

        foreach($response->getDateProposals() as $dateProposal) {
            foreach($dateProposal->getProposals() as $proposalOptional) {
                if (is_null($proposalOptional->getProposal())) {
                    continue;
                }

                $proposal = $proposalOptional->getProposal();

                $quotes[] = new QuoteDTO(
                    $proposal->getId(),
                    $proposal->getModelName(),
                    $proposal->getModelName(),
                    $proposal->getModelName(),
                    $proposal->getPriceVat()->getValue(),
                    $proposal->getPriceVat()->getCurrency(),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedPickup()->getStart()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedPickup()->getEnd()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getStart()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getStart()),
                );
            }

        }
        return $quotes;
    }
}
