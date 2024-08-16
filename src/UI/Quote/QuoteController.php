<?php

declare(strict_types=1);

namespace App\UI\Quote;

use App\Quote\Infrastructure\Evermile\QuoteCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class QuoteController extends AbstractController
{
    private QuoteCalculator $quoteCalculator;

    public function __construct(QuoteCalculator $quoteCalculator)
    {
        $this->quoteCalculator = $quoteCalculator;
    }

    #[Route('/quote', name: 'quote')]
    public function quote(Request $request): Response
    {
        $this->quoteCalculator->calculate();
        return $this->json(['ok']);
    }
}
