<?php

namespace App\Controller;

use PHPShopify\AuthHelper;
use PHPShopify\ShopifySDK;
use App\Service\ShopifyAuthorizationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function authorizeAndRedirect(ShopifyAuthorizationService $shopifyService): Response
    {
        // Llamar al servicio para autorizar y redirigir
        $shopifyService->authorizeAndRedirect();

        // No hay un valor de retorno explícito aquí porque la redirección ya ha ocurrido
        return new Response('Redirigiendo al usuario...');
    }

    #[Route('/shopify/redirect-url', name: 'shopify_redirect_url')]
    public function handleRedirect(): Response
    {
        // Configuración para Shopify (debe ser la misma que usaste en authorizeAndRedirect)
        $config = array(
            'ShopUrl' => 'tiendapruebala.myshopify.com',
            'ApiKey' => '5d3752ee6d2b47e8836ee3c7de699f0b',
            'SharedSecret' => 'e3a80914f1b52bcd4786d82f370759fb',
        );

        // Configurar SDK de Shopify
        \PHPShopify\ShopifySDK::config($config);

        // Obtener el token de acceso cuando se redirige de nuevo a la autorización posterior a la aplicación
        $accessToken = \PHPShopify\AuthHelper::getAccessToken();

        // Puedes hacer lo que quieras con el token de acceso, por ejemplo, imprimir en la respuesta
        return new Response('Token de acceso obtenido con éxito: ' . $accessToken);
    }
}
