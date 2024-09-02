<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\QuoteDTO;
use App\Quote\Application\DTO\StoreDTO;
use App\Quote\Domain\Enum\QuoteTypeEnum;
use App\Quote\Infrastructure\Evermile\Builder\EvermileQuoteRequestBuilder;
use App\Quote\Infrastructure\Evermile\Client\EvermileClient;

final class EvermileQuoteProvider
{
    private EvermileClient $evermileClient;
    private EvermileQuoteRequestBuilder $evermileQuoteRequestBuilder;

    public function __construct(EvermileClient $evermileClient, EvermileQuoteRequestBuilder $evermileQuoteRequestBuilder)
    {
        $this->evermileClient = $evermileClient;
        $this->evermileQuoteRequestBuilder = $evermileQuoteRequestBuilder;
    }

    // todo in future handle $addressFrom as priority, for now $store->evermileLocationId is enough
    /** @return QuoteDTO[] */
    public function provide(?AddressDTO $addressFrom, AddressDTO $addressTo, StoreDTO $store): array
    {
        $quotes = [];

        try {
            $response = $this->evermileClient->getQuote($this->evermileQuoteRequestBuilder->build($addressTo, $store));
        } catch (\Exception $e) {
            // todo log exception
            return $quotes;
        }

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
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getEnd()),
                    QuoteTypeEnum::EVERMILE
                );
            }

        }
        return $quotes;
    }
}
