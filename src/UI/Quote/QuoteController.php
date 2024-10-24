<?php

declare(strict_types=1);

namespace App\UI\Quote;

use App\Common\Util\RequestResponseLogger;
use App\Quote\Infrastructure\Query\ProposalQuoteQuery;
use App\Store\Application\Exception\StoreValidationException;
use App\UI\Quote\Builder\Query\QuoteQueryRequestBuilder;
use App\UI\Quote\Builder\Request\QuoteForShopifyRequestBuilder;
use App\UI\Quote\Builder\Query\QuoteQueryByShopifyRequestBuilder;
use App\UI\Quote\Builder\Request\QuoteRequestBuilder;
use App\UI\Quote\Builder\Response\QuoteResponseBuilder;
use App\UI\Quote\Builder\Response\ShopifyQuoteResponseBuilder;
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
    private ProposalQuoteQuery $quoteQuery;
    private QuoteQueryByShopifyRequestBuilder $quoteQueryByShopifyRequestBuilder;
    private QuoteQueryRequestBuilder $quoteQueryRequestBuilder;
    private RequestResponseLogger $logger;

    public function __construct(
        ProposalQuoteQuery $quoteQuery,
        QuoteQueryByShopifyRequestBuilder $quoteQueryByShopifyRequestBuilder,
        QuoteQueryRequestBuilder $quoteQueryRequestBuilder,
        RequestResponseLogger $logger
    )
    {
        $this->quoteQuery = $quoteQuery;
        $this->quoteQueryByShopifyRequestBuilder = $quoteQueryByShopifyRequestBuilder;
        $this->quoteQueryRequestBuilder = $quoteQueryRequestBuilder;
        $this->logger = $logger;
    }

    #[Route('/api/v1/quote/shopify', name: 'quoteShopify', methods: ['POST'])]
    public function quoteForShopify(
        Request $request,
        QuoteForShopifyRequestBuilder $requestBuilder,
        ShopifyQuoteResponseBuilder $responseBuilder
    ): Response {
        $this->logger->logRequest($request->headers->all(), $request->toArray());

        // todo make pretty request validator
        $shopifyDomain = $request->headers->get('X-Shopify-Shop-Domain');

        if (!$shopifyDomain) {
            return $this->json(['error' => 'Invalid shopify domain'], Response::HTTP_BAD_REQUEST);
        }

        $quoteForShopifyRequest = $requestBuilder->build($request);

        if ($quoteForShopifyRequest->getOrigin()->getAddress1() === null) {
            return $this->json(['error' => 'Invalid origin address'], Response::HTTP_BAD_REQUEST);
        }

        if ($quoteForShopifyRequest->getOrigin()->getCity() === null) {
            return $this->json(['error' => 'Invalid origin city'], Response::HTTP_BAD_REQUEST);
        }

        if ($quoteForShopifyRequest->getOrigin()->getPostalCode() === null) {
            return $this->json(['error' => 'Invalid origin postal code'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $quoteQuery = $this->quoteQueryByShopifyRequestBuilder->build($quoteForShopifyRequest);
        } catch (StoreValidationException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $quote = $this->quoteQuery->query($quoteQuery);

        $response = $this->getSerializer()->serialize(
            ['rates' => $responseBuilder->build($quote)],
            'json'
        );

        $this->logger->log($request->headers->all(), $request->toArray(), $response);

        return new Response($response);
    }

    #[Route('/api/v1/quote', name: 'quote', methods: ['POST'])]
    public function quote(
        Request $request,
        QuoteRequestBuilder $requestBuilder,
        QuoteResponseBuilder $responseBuilder
    ): Response {
        $this->logger->logRequest($request->headers->all(), $request->toArray());

        $quoteRequest = $requestBuilder->build($request);

        if ($quoteRequest->getOrigin()->getName() === null) {
            return $this->json(['error' => 'Invalid origin name'], Response::HTTP_BAD_REQUEST);
        }

        if ($quoteRequest->getOrigin()->getAddress() === null) {
            return $this->json(['error' => 'Invalid origin address'], Response::HTTP_BAD_REQUEST);
        }

        if ($quoteRequest->getOrigin()->getCity() === null) {
            return $this->json(['error' => 'Invalid origin city'], Response::HTTP_BAD_REQUEST);
        }

        if ($quoteRequest->getOrigin()->getPostalCode() === null) {
            return $this->json(['error' => 'Invalid origin postal code'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $quoteQuery = $this->quoteQueryRequestBuilder->build($quoteRequest);
        } catch (StoreValidationException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $quote = $this->quoteQuery->query($quoteQuery);

        $response = $this->getSerializer()->serialize(
            $responseBuilder->build($quote),
            'json'
        );

        $this->logger->log($request->headers->all(), $request->toArray(), $response);

        return new Response($response);
    }

    // todo setup default for all
    private function getSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter())];
        return new Serializer($normalizers, $encoders);
    }
}
