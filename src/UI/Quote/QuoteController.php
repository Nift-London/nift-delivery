<?php

declare(strict_types=1);

namespace App\UI\Quote;

use App\Quote\Application\Calculator\QuoteCalculator;
use App\Quote\Domain\DTO\AddressDTO;
use App\UI\Quote\Builder\QuoteResponseDTOBuilder;
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
    private QuoteCalculator $quoteCalculator;
    private QuoteResponseDTOBuilder $quoteResponseDTOBuilder;

    public function __construct(QuoteCalculator $quoteCalculator, QuoteResponseDTOBuilder $quoteResponseDTOBuilder)
    {
        $this->quoteCalculator = $quoteCalculator;
        $this->quoteResponseDTOBuilder = $quoteResponseDTOBuilder;
    }

    #[Route('/api/v1/quote/shopify', name: 'quote')]
    public function quoteForShopify(Request $request): Response
    {
        //todo from request
        $addressDto = new AddressDTO("145 Queen Victoria St", "EC4V 4AA", "London");

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter())];
        $serializer = new Serializer($normalizers, $encoders);

        return new Response($serializer->serialize(
            ['rates' => $this->quoteResponseDTOBuilder->build($this->quoteCalculator->calculate($addressDto))],
            'json'
        ));
    }
}
