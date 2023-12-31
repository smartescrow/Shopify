<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShopifyController extends AbstractController
{
    #[Route('/shopify', name: 'app_shopify')]
    public function getProducts(): Response
    {
        $apiKey = '9b09ce6489ba709cd9894bf9287039f0';
        $apiSecret = '0726d6ed5d891b5b14f1b711a83a7ecf';
        $accessToken = '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';

        // Combinar las credenciales y codificarlas en Base64 para la autenticación básica
        $credentials = base64_encode("$apiKey:$apiSecret");

        // Crear un cliente Guzzle
        $client = new Client();

        // Definir las cabeceras para la solicitud
        $headers = [
            'Authorization' => 'Basic ' . $credentials,
            'X-Shopify-Access-Token' => $accessToken
        ];

        $shopName = 'probando2023';
        $apiVersion = '2023-10';
        $resource = 'orders';

        // Realizar la solicitud GET a la API de Shopify
        $response = $client->request('GET', 'https://' . $shopName . '.myshopify.com/admin/api/' . $apiVersion . '/' . $resource . '.json?status=any', [
            'headers' => $headers
        ]);

        // Convertir la respuesta JSON en un objeto PHP
        $data = json_decode($response->getBody(), true);

        $orders = $data['orders'];
        $ordersTraducidos = [];

        foreach ($orders as $order) {
            $lineItemsTraducidos = [];
            //Itero sobre los detalles de cada uno de los productos del pedido
            foreach ($order['line_items'] as $lineItem) {
                $lineItemTraducido = [
                    'ID' => $lineItem['id'],
                    'Gramos' => $lineItem['grams'],
                    'Nombre' => $lineItem['name'],
                    'Precio' => number_format($lineItem['price'], 2, ',', '.'),
                    'ID Producto' => $lineItem['product_id'],
                    'Cantidad' => $lineItem['quantity'],
                    'SKU' => $lineItem['sku'],
                    'Título' => $lineItem['title'],
                    'Descuento Total' => number_format($lineItem['total_discount'], 2, ',', '.'),
                ];
                array_push($lineItemsTraducidos, $lineItemTraducido);
            }

            //Hay 2 pero no lo itero y lo tomo directo porque es el mismo que se repite
            $totalShipping = null;
            if (isset($order['total_shipping_price_set']['shop_money'])) {
                $totalShipping = [
                    'Importe' => number_format($order['total_shipping_price_set']['shop_money']['amount'], 2, ',', '.'),
                    'Moneda' => $order['total_shipping_price_set']['shop_money']['currency_code'],
                ];
            }

            $clienteTraducido = null;
            if (isset($order['customer'])) {
                $cliente = $order['customer'];
                $direccionPredeterminadaTraducida = [];

                // Verificar si 'default_address' existe en 'customer'
                if (isset($cliente['default_address'])) {
                    $direccionPredeterminada = $cliente['default_address'];
                    $direccionPredeterminadaTraducida = [
                        'ID' => $direccionPredeterminada['id'],
                        'Nombre_Completo' => $direccionPredeterminada['name'],
                        'Empresa' => $direccionPredeterminada['company'],
                        'Dirección' => $direccionPredeterminada['address1'],
                        'Ciudad' => $direccionPredeterminada['city'],
                        'Provincia' => $direccionPredeterminada['province'],
                        'País' => $direccionPredeterminada['country'],
                        'Código Postal' => $direccionPredeterminada['zip'],
                    ];
                }
                $clienteTraducido = [
                    'ID' => $cliente['id'],
                    'Correo_Electrónico' => $cliente['email'],
                    'Nombre' => $cliente['first_name'],
                    'Apellido' => $cliente['last_name'],
                    'Estado' => $cliente['state'],
                    'Exento_Impuestos' => $cliente['tax_exempt'],
                    'Teléfono' => $cliente['phone'],
                    'Moneda' => $cliente['currency'],
                    'Exenciones Impuestos' => $cliente['tax_exemptions'],
                    'Dirección Predeterminada' => $direccionPredeterminadaTraducida,

                ];
            }
            // Devuelve todos los pedidos
            $orderTraducido = [
                'ID' => $order['id'],
                'ID Pago' => $order['checkout_id'],
                'Confirmado' => $order['confirmed'],
                'Fecha Pedido' => $order['created_at'],
                'Moneda' => $order['currency'],
                'Subtotal Actual' => number_format($order['current_subtotal_price'], 2, ',', '.'),
                'Descuentos Totales Actuales' => number_format($order['current_total_discounts'], 2, ',', '.'),
                'Precio Total Actual' => number_format($order['current_total_price'], 2, ',', '.'),
                'Impuesto Total Actual' => number_format($order['current_total_tax'], 2, ',', '.'),
                'Estado Financiero del Pedido' => $order['financial_status'],
                'Número Pedido' => $order['order_number'],
                'URL Estado Pedido' => $order['order_status_url'],
                'Moneda Presentación' => $order['presentment_currency'],
                'Precio Subtotal' => number_format($order['subtotal_price'], 2, ',', '.'),
                'Etiquetas' => $order['tags'],
                'Impuestos Incluidos' => $order['taxes_included'],
                'Descuentos_Totales' => number_format($order['total_discounts'], 2, ',', '.'),
                'Precio Total Artículos' => number_format($order['total_line_items_price'], 2, ',', '.'),
                'Total Pendiente' => number_format($order['total_outstanding'], 2, ',', '.'),
                'Precio Total' => number_format($order['total_price'], 2, ',', '.'),
                'Impuesto Total' => $order['total_tax'],
                'Peso Total' => $order['total_weight'],
                'Cliente' => $clienteTraducido,
                'Artículos' => $lineItemsTraducidos,
                'Precio Envío Total' => $totalShipping,
            ];

            array_push($ordersTraducidos, $orderTraducido);
        }

        return new Response(json_encode($ordersTraducidos, JSON_PRETTY_PRINT), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
