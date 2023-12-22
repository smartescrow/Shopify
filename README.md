# Servicio de Autorización de Shopify

*Nota importante para Braian*<br>
Este servicio utiliza OAuth2 para autenticar y autorizar el acceso a la API de Shopify. Es necesario proporcionar una URL pública para<br>
el proceso de redireccionamiento durante la autenticación, obyener el accessToken y configurar el SDK. Esta realizado en el service pero <br>
hay que modificarlo para que funcione con el partner<br>
Estos son los datos de la cuenta partner 	<br>		
web	https://www.shopify.com/partners/blog?logout=true&signup_intent=developer	<br>		
usuario	soledad@smartescrow.es			<br>
contraseña	0soleSmartEscrow!	<br>		


## Configuración y Uso
Por lo tanto cree un controlador con auth basica y llamar al endpoint para obtener la lista de pedidos. <br>
Hay que tener en cuenta que la API es modificada trimestralmente por lo que hay que revisar los cambios, esto fue realizado con la version <br>2023-10, la nueva esta en desarrollo para lanzarla en enero 2024<br>

Lo que hay qeu completar para obtener los pedidos es:<br>

* $apiKey = 'Nos la da el usuario de la tienda';<br>
* $apiSecret = 'Nos la da el usuario de la tienda';<br>
* $accessToken = 'Nos la da el usuario de la tienda '; ESTO LO DA SHOPIFY UNA SOLA VEZ AL CREAR LA TIENDA, POR ESO HAY QUE USAR LA OAUTH2<br>        

* $shopName = 'Nombre de la tienda';<br>
* $apiVersion = '2023-10'; Ultima version estable<br>
* $resource = 'orders';<br>

Para obtener los endpoints disponibles y resources de la API de Shopify => [REST Admin API Reference](https://shopify.dev/docs/api/admin-rest#endpoints).<br>

Para mas detalles ver el archivo excel en la raiz del proyecto<br>