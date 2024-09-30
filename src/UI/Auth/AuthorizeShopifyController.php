<?php

declare(strict_types=1);

namespace App\UI\Auth;

use App\Common\Util\RequestResponseLogger;
use App\Store\Domain\Repository\StoreRepository;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class AuthorizeShopifyController extends AbstractController
{
    private RequestResponseLogger $logger;
    private StoreRepository $storeRepository;

    public function __construct(RequestResponseLogger $logger, StoreRepository $storeRepository)
    {
        $this->logger = $logger;
        $this->storeRepository = $storeRepository;
    }

    #[Route(path: '/shopify', name: 'shopify', methods: ['GET'])]
    public function shopify(
        Request $request,
    ): Response {
//        $requestArray = $request->get();
//        $this->logger->logRequest($request->headers->all(), $requestArray);

        // todo validate hmac
        $hmac = $request->query->get('hmac');
        $host = $request->query->get('host');
        $shop = $request->query->get('shop');
        $timestamp = $request->query->get('timestamp');

        $store = $this->storeRepository->findByShopifyDomain($shop);
        if (!$store) {
            return $this->json(['error' => 'Store not found'], 404);
        }

        return $this->redirect(
            'https://' . $shop . '/admin/oauth/authorize?client_id=' . $store->getShopifyClientId()
            . '&scope=' . 'read_checkouts,read_customers,write_shipping,read_shipping,write_returns,read_returns,write_delivery_customizations,write_delivery_option_generators,read_delivery_option_generators,write_delivery_customizations,read_delivery_customizations'
            . '&redirect_uri=' . 'https://b717-83-8-251-107.ngrok-free.app/shopify/auth'
            . '&state=' . $store->getId()->jsonSerialize()
        );
    }

    #[Route(path: '/shopify/auth', name: 'auth_shopify', methods: ['GET'])]
    public function authShopify(
        Request $request,
    ): Response {
//        $this->logger->logRequest($request->headers->all(), $request->toArray());
        $code = $request->query->get('code');
        $shop = $request->query->get('shop');
        $state = $request->query->get('state');

        $store = $this->storeRepository->findByShopifyDomain($shop);
        if (!$store) {
            return $this->json(['error' => 'Store not found'], 404);
        }

        if ($state !== $store->getId()->jsonSerialize()) {
            // todo throw
        }

        $store->setShopifyAuthCode($code);

        try {

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://' . $store->getShopifyDomain() . '/admin/oauth/access_token', [
                'form_params' => [
                    'client_id' => $store->getShopifyClientId(),
                    'client_secret' => $store->getShopifyClientSecret(),
                    'code' => $code
                ]
            ]);

            $store->setShopifyToken(json_decode($response->getBody()->getContents(), true)['access_token']);
        } catch (ClientException $e) {
            echo($e->getResponse()->getBody()->getContents());die;
        }


        $this->storeRepository->save($store);

        return $this->json(['ok']);
    }
}
