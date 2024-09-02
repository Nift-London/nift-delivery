<?php

declare(strict_types=1);

namespace App\Quote\Application\Saver;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ProposalQuotesDTO;
use App\Quote\Application\DTO\QuoteDTO;
use App\Quote\Domain\Entity\Quote;
use App\Quote\Domain\Repository\QuoteRepository;
use App\Store\Domain\Entity\Store;
use App\Store\Infrastructure\Query\StoreQuery;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV6;

final class QuoteSaver
{
    private QuoteRepository $quoteRepository;
    private StoreQuery $storeQuery;

    public function __construct(QuoteRepository $quoteRepository, StoreQuery $storeQuery)
    {
        $this->quoteRepository = $quoteRepository;
        $this->storeQuery = $storeQuery;
    }

    public function save(ProposalQuotesDTO $proposalQuotesDTO, Uuid $storeId, AddressDTO $addressTo): void
    {
        $store = $this->storeQuery->queryEntityById($storeId);
        $groupId = Uuid::v6();

        $this->saveQuote($proposalQuotesDTO->getFastestToday(), $store, $addressTo, $groupId);
        $this->saveQuote($proposalQuotesDTO->getToday(), $store, $addressTo, $groupId);
        $this->saveQuote($proposalQuotesDTO->getLatest(), $store, $addressTo, $groupId);
    }

    private function saveQuote(?QuoteDTO $quoteDTO, Store $store, AddressDTO $addressTo, Uuid $groupId)
    {
        if (!is_null($quoteDTO)) {
            $quote = new Quote();
            $quote->setGroupId($groupId);
            $quote->setExternalId($quoteDTO->getExternalId());
            $quote->setPrice($quoteDTO->getPrice());
            $quote->setCurrency($quoteDTO->getCurrency());
            $quote->setPickupDateFrom($quoteDTO->getPickupDateFrom());
            $quote->setPickupDateTo($quoteDTO->getPickupDateTo());
            $quote->setDeliveryDateFrom($quoteDTO->getDeliveryDateFrom());
            $quote->setDeliveryDateTo($quoteDTO->getDeliveryDateTo());
            $quote->setType($quoteDTO->getType());
            $quote->setDeliveryStreet($addressTo->getStreet());
            $quote->setDeliveryPostalCode($addressTo->getPostalCode());
            $quote->setDeliveryCity($addressTo->getCity());
            $quote->setStore($store);

            $this->quoteRepository->save($quote);
        }
    }
}
