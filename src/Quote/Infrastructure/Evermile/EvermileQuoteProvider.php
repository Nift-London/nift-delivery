<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile;

use App\Common\Evermile\Client\EvermileClient;
use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ItemDTO;
use App\Quote\Application\DTO\QuoteDTO;
use App\Quote\Application\DTO\LocationDTO;
use App\Quote\Domain\Enum\QuoteTypeEnum;
use App\Quote\Infrastructure\Evermile\Builder\EvermileQuoteRequestBuilder;
use Psr\Log\LoggerInterface;

final class EvermileQuoteProvider
{
    private EvermileClient $evermileClient;
    private EvermileQuoteRequestBuilder $evermileQuoteRequestBuilder;
    private LoggerInterface $logger;

    public function __construct(
        EvermileClient $evermileClient,
        EvermileQuoteRequestBuilder $evermileQuoteRequestBuilder,
        LoggerInterface $logger
    ) {
        $this->evermileClient = $evermileClient;
        $this->evermileQuoteRequestBuilder = $evermileQuoteRequestBuilder;
        $this->logger = $logger;
    }

    /**
     * @param ItemDTO[] $items
     * @return QuoteDTO[]
     */
    public function provide(AddressDTO $addressTo, LocationDTO $store, array $items): array
    {
        $quotes = [];

        try {
            $response = $this->evermileClient->getQuote($this->evermileQuoteRequestBuilder->build($addressTo, $store, $items));
        } catch (\Exception $e) {
            $this->logger->error('Error while getting quotes from Evermile', ['error' => $e->getMessage()]);
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
                    $proposalOptional->getLabel(),
                    $proposal->getModelName(),
                    $proposal->getModelName(),
                    $proposal->getPriceVat()->getValue(),
                    $proposal->getPriceVat()->getCurrency(),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedPickup()->getStart()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedPickup()->getEnd()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getStart()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getEnd())
                );
            }

        }
        return $quotes;
    }
}
