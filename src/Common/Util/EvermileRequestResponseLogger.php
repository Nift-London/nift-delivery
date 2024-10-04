<?php

declare(strict_types=1);

namespace App\Common\Util;

use OpenAPI\Client\Model\ModelInterface;
use Psr\Log\LoggerInterface;

class EvermileRequestResponseLogger
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(ModelInterface $request, ModelInterface $response): void
    {
        $this->logger->info(
            '[EVERMILE] Request: ' . json_encode($request) . ' | ' . 'Response: ' . json_encode($response)
        );
    }
}
