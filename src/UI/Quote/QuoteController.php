<?php

declare(strict_types=1);

namespace App\UI\Quote;

use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\StoreDTO;
use App\Quote\Infrastructure\Query\QuoteQuery;
use App\Store\Infrastructure\Query\StoreQuery;
use App\UI\Quote\Builder\Response\QuoteResponseDTOBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsController]
final class QuoteController extends AbstractController
{
    private QuoteQuery $quoteQuery;
    private QuoteResponseDTOBuilder $quoteResponseDTOBuilder;
    private StoreQuery $storeQuery;

    public function __construct(QuoteQuery $quoteQuery, QuoteResponseDTOBuilder $quoteResponseDTOBuilder, StoreQuery $storeQuery)
    {
        $this->quoteQuery = $quoteQuery;
        $this->quoteResponseDTOBuilder = $quoteResponseDTOBuilder;
        $this->storeQuery = $storeQuery;
    }

    #[Route('/api/v1/quote/shopify', name: 'quote', methods: ['POST'])]
    public function quoteForShopify(Request $request): Response
    {
        //todo from request
        $addressFrom = new AddressDTO("145 Queen Victoria St", "EC4V 4AA", "London");
        $addressTo = new AddressDTO("145 Queen Victoria St", "EC4V 4AA", "London");
        $storeDto = new StoreDTO($this->storeQuery->findStoreByShopifyName('s')->getEvermileLocationId());
        $quote = $this->quoteQuery->query($addressFrom, $addressTo, $storeDto);

        return new Response($this->getSerializer()->serialize(
            ['rates' => $this->quoteResponseDTOBuilder->build($quote)],
            'json'
        ));
    }

    // todo setup default for all
    private function getSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter())];
        return new Serializer($normalizers, $encoders);
    }
}
