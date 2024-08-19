<?php

declare(strict_types=1);

namespace App\UI\Quote;

use App\Quote\Infrastructure\Query\QuoteQuery;
use App\Store\Application\Exception\StoreValidationException;
use App\UI\Quote\Builder\Request\QuoteForShopifyRequestBuilder;
use App\UI\Quote\Builder\Query\QuoteQueryBuilder;
use App\UI\Quote\Builder\Response\QuoteResponseBuilder;
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
    private QuoteResponseBuilder $quoteResponseBuilder;

    public function __construct(QuoteQuery $quoteQuery, QuoteResponseBuilder $quoteResponseBuilder)
    {
        $this->quoteQuery = $quoteQuery;
        $this->quoteResponseBuilder = $quoteResponseBuilder;
    }

    #[Route('/api/v1/quote/shopify', name: 'quote', methods: ['POST'])]
    public function quoteForShopify(Request $request,
        QuoteForShopifyRequestBuilder $quoteForShopifyRequestBuilder,
        QuoteQueryBuilder $quoteQueryBuilder
    ): Response {
        // todo make pretty request validator
        $shopifyDomain = $request->headers->get('X-Shopify-Shop-Domain');

        if (!$shopifyDomain) {
            return $this->json(['error' => 'Invalid shopify domain'], Response::HTTP_BAD_REQUEST);
        }

        $quoteForShopifyRequest = $quoteForShopifyRequestBuilder->build($request);

        try {
            $quoteQuery = $quoteQueryBuilder->build($quoteForShopifyRequest);
        } catch (StoreValidationException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $quote = $this->quoteQuery->query($quoteQuery);

        return new Response($this->getSerializer()->serialize(
            ['rates' => $this->quoteResponseBuilder->build($quote)],
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
