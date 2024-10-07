<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Event;

use App\Store\Domain\Entity\Store;
use App\Store\Domain\Repository\StoreRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class StoreEnabledForFirstTimeEvent implements EventSubscriberInterface
{
    private StoreRepository $storeRepository;
    private string $appUrl;
    private LoggerInterface $logger;

    public function __construct(StoreRepository $storeRepository, string $appUrl, LoggerInterface $logger)
    {
        $this->storeRepository = $storeRepository;
        $this->appUrl = $appUrl;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterEntityUpdatedEvent::class => ['setUpStore'],
        ];
    }

    public function setUpStore(AfterEntityUpdatedEvent $event)
    {
        /** @var Store $store */
        $store = $event->getEntityInstance();

        if (!($store instanceof Store) || !$store->isEnabled()) {
            return;
        }

        $client = new \GuzzleHttp\Client();

        if (!$store->isShopifyWebhooksConfigured()) {
            $this->logger->info('Setting up Shopify webhooks for store ' . $store->getShopifyDomain());
            try {
                $client->request('POST', 'https://' . $store->getShopifyDomain() . '/admin/api/2024-04/webhooks.json', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Shopify-Access-Token' => $store->getShopifyToken()
                    ],
                    'json' => [
                        'webhook' => [
                            'topic' => 'orders/create',
                            'address' => $this->appUrl . '/api/v1/order/shopify',
                            'format' => 'json'
                        ]
                    ]
                ]);

                $store->setShopifyWebhooksConfigured(true);
            } catch (ClientException $e) {
                $this->logger->error('Shopify response error: ' . $e->getResponse()->getBody()->getContents());
            }
        }

        if (!$store->isShopifyCarrierServiceConfigured()) {
            $this->logger->info('Setting up Shopify carrier service for store ' . $store->getShopifyDomain());
            try {
                $client->request('POST', 'https://' . $store->getShopifyDomain() . '/admin/api/2023-10/carrier_services.json', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Shopify-Access-Token' => $store->getShopifyToken()
                    ],
                    'json' => [
                        'carrier_service' => [
                            'name' => 'NIFT',
                            'callback_url' => $this->appUrl . '/api/v1/quote/shopify',
                            'service_discovery' => true
                        ]
                    ]
                ]);

                $store->setShopifyCarrierServiceConfigured(true);
            } catch (ClientException $e) {
                $this->logger->error('Shopify response error: ' . $e->getResponse()->getBody()->getContents());
            }
        }

        $this->storeRepository->save($store);
    }
}
