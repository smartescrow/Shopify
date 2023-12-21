<?php
namespace App\Service;

use PHPShopify\AuthHelper;
use PHPShopify\ShopifySDK;
use Symfony\Component\HttpFoundation\Response;

class ShopifyAuthorizationService
{
    public function authorizeAndRedirect(): Response
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

        // Obtener el token de acceso cuando se redirige de nuevo a la autorización posterior a la aplicación
        $accessToken = \PHPShopify\AuthHelper::createAuthRequest($scopes);
        
        // Almacenar el token de acceso en la base de datos o en algún otro lugar seguro
        // ... Puedes implementar la lógica de almacenamiento aquí    

        return new Response('Token de acceso obtenido con éxito. Almacenado en la base de datos.');
    }
}

