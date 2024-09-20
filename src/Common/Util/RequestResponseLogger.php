<?php

declare(strict_types=1);

namespace App\Common\Util;

use OpenAPI\Client\Model\ModelInterface;
use Psr\Log\LoggerInterface;

class RequestResponseLogger
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(array $requestHeaders, array $request, string $responseJson): void
    {
        $this->logger->info(
            '[DELIVERY_APP] Request headers: ' . json_encode($requestHeaders) . ' Request: ' . json_encode($request) . ' | ' . 'Response: ' . $responseJson
        );
    }
}
