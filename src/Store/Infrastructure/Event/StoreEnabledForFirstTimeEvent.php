<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Event;

use App\Store\Domain\Entity\Store;
use App\Store\Domain\Repository\StoreRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class StoreEnabledForFirstTimeEvent implements EventSubscriberInterface
{
    private StoreRepository $storeRepository;
    private string $appUrl;

    public function __construct(StoreRepository $storeRepository, string $appUrl)
    {
        $this->storeRepository = $storeRepository;
        $this->appUrl = $appUrl;
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterEntityUpdatedEvent::class => ['setUpStore'],
        ];
    }

    public function setUpStore(AfterEntityUpdatedEvent $event)
    {
        $store = $event->getEntityInstance();

        if (!($store instanceof Store)) {
            return;
        }

        $client = new \GuzzleHttp\Client();

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
            echo($e->getResponse()->getBody()->getContents());
            return;
        }

        // todo add to shopify carrier service
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
            echo($e->getResponse()->getBody()->getContents());
            die;
        }

        $this->storeRepository->save($store);
    }
}
