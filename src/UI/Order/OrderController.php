<?php

declare(strict_types=1);

namespace App\UI\Order;

use App\Common\Util\RequestResponseLogger;
use App\Order\Application\Exception\OrderAlreadyCompletedException;
use App\Order\Infrastructure\Command\DTO\OrderCommandDTO;
use App\Order\Infrastructure\Command\OrderCommand;
use App\Quote\Application\Exception\QuoteNotFoundException;
use App\UI\Order\Builder\Command\OrderCommandBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class OrderController extends AbstractController
{
    private OrderCommand $orderCommand;
    private OrderCommandBuilder $orderCommandBuilder;
    private RequestResponseLogger $requestResponseLogger;
    private LoggerInterface $logger;

    public function __construct(
        OrderCommand $orderCommand,
        OrderCommandBuilder $orderCommandBuilder,
        RequestResponseLogger $requestResponseLogger,
        LoggerInterface $logger
    ) {
        $this->orderCommand = $orderCommand;
        $this->orderCommandBuilder = $orderCommandBuilder;
        $this->requestResponseLogger = $requestResponseLogger;
        $this->logger = $logger;
    }

    #[Route('/api/v1/order/shopify', name: 'order', methods: ['POST'])]
    public function orderForShopify(Request $request): Response {
        $this->requestResponseLogger->logRequest($request->headers->all(), $request->toArray());

        $orderCommand = $this->orderCommandBuilder->build(json_decode($request->getContent(), true));

        try {
            $this->orderCommand->order($orderCommand);
        } catch (QuoteNotFoundException $e) {
            $this->logger->warning($e->getMessage());
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (OrderAlreadyCompletedException $e) {
            $this->logger->warning($e->getMessage());
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([]);
    }

    // todo remove
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response {
        return $this->json([]);
    }
}
