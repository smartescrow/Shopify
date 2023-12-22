<?php
namespace App\Service;

use PHPShopify\AuthHelper;
use PHPShopify\ShopifySDK;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ShopifyAuthorizationService
{
    public function authorizeShopify(): RedirectResponse
    {
        // Configuración para Shopify
        $config = array(
            'ShopUrl' => 'probando2023.myshopify.com',
            'ApiKey' => '9b09ce6489ba709cd9894bf9287039f0',
            'SharedSecret' => '0726d6ed5d891b5b14f1b711a83a7ecf',
        );

        // Configurar SDK de Shopify
        \PHPShopify\ShopifySDK::config($config);

        // Definir los permisos que necesitas
        $scopes = 'read_products,write_products,read_script_tags,write_script_tags';

        // URL de redireccionamiento
        $redirectUrl = 'https://d6r6nb2p-62558.uks1.devtunnels.ms/';

        // Crear la solicitud de autenticación
        \PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl);

        // Redirigir automáticamente al usuario a la página de autorización de Shopify
        return new RedirectResponse('/shopify/redirect-url');
    }

    /**
     * @Route("/shopify/redirect-url", name="shopify_redirect_url")
     */
    public function handleRedirect(): Response
    {
        // Configuración para Shopify
        $config = array(
            'ShopUrl' => 'probando2023.myshopify.com',
            'ApiKey' => '9b09ce6489ba709cd9894bf9287039f0',
            'SharedSecret' => '0726d6ed5d891b5b14f1b711a83a7ecf',
        );

        // Configurar SDK de Shopify
        \PHPShopify\ShopifySDK::config($config);

        // Obtener el token de acceso cuando se redirige de nuevo a la autorización posterior a la aplicación
        $accessToken = \PHPShopify\AuthHelper::getAccessToken();

        // Almacenar el token de acceso en la base de datos o en algún otro lugar seguro
        // ... Puedes implementar la lógica de almacenamiento aquí

        return new Response('Token de acceso obtenido con éxito. Almacenado en la base de datos.');
    }
}

