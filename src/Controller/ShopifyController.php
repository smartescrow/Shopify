<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopifyController extends AbstractController
{
    /**
     * @Route("/shopify", name="shopify")
     */
    public function authorizeShopify(): RedirectResponse
    {
        // Configuración para Shopify
        $config = array(
            'ShopUrl' => 'tiendapruebala.myshopify.com',
            'ApiKey' => '5d3752ee6d2b47e8836ee3c7de699f0b',
            'SharedSecret' => 'e3a80914f1b52bcd4786d82f370759fb',
        );

        // Configurar SDK de Shopify
        \PHPShopify\ShopifySDK::config($config);

        // Definir los permisos que necesitas
        $scopes = 'read_products,write_products,read_script_tags,write_script_tags';

        // URL de redireccionamiento
        $redirectUrl = $this->generateUrl('shopify_redirect_url', [], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);

        // Crear la solicitud de autenticación
        \PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl);

        // Redirigir automáticamente al usuario a la página de autorización de Shopify
        return $this->redirectToRoute('shopify_redirect_url');
    }

    /**
     * @Route("/shopify/redirect-url", name="shopify_redirect_url")
     */
    public function handleRedirect(Request $request): Response
    {
        // Configuración para Shopify
        $config = array(
            'ShopUrl' => 'tiendapruebala.myshopify.com',
            'ApiKey' => '5d3752ee6d2b47e8836ee3c7de699f0b',
            'SharedSecret' => 'e3a80914f1b52bcd4786d82f370759fb',
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
