# facturaselectronicas.biz - PHP

Librería de acceso a la API de [facturaselectronicas.biz](https://facturaselectronicas.biz/) para PHP.

## Instalación

La instalación se realiza via [Composer](https://packagist.org/packages/paperclip/facturas-electronicas):

```
composer require paperclip/facturas-electrónicas
```

## Uso

El constructor de la clase `Paperclip\FacturasElectrónicas\Facturador` acepta dos parámetros:

* `$token`, el token recibido cuando creas el acceso a la API de facturación de Paperclip.
* `$url`, la URL para acceder a la API de facturación de Paperclip, también recibida cuando creas el acceso.

Al instanciar un objecto `Paperclip\FacturasElectrónicas\Facturador`, puedes ejecutar un [comando de la API](https://docs.paperclip.com.pe/api-facturación/#comandos ) como método del objeto:

* [`Paperclip\FacturasElectrónicas\Facturador::hola(array $parámetros):array`](https://docs.paperclip.com.pe/api-facturación/comando-hola/): Comando para realizar pruebas de comunicación.[`Paperclip\FacturasElectrónicas\Facturador::emitir(array $parámetros):array`](https://docs.paperclip.com.pe/api-facturación/comando-emitir/): Genera un nuevo comprobante, ya sea factura, boleta, o sus notas correspondientes.  
* [`Paperclip\FacturasElectrónicas\Facturador::baja(array $parámetros): array`](https://docs.paperclip.com.pe/api-facturación/comando-baja/): Solicita la baja (anulación) un comprobante.
* [`Paperclip\FacturasElectrónicas\Facturador::correo(array $parámetros):array`](https://docs.paperclip.com.pe/api-facturación/comando-correo/):  Envia el PDF y el XML por correo electrónico a los destinatarios especificados.
* [`Paperclip\FacturasElectrónicas\Facturador::consultar_ruc(array $parámetros):array`](https://docs.paperclip.com.pe/api-facturación/comando-consultarruc/):  Obtiene información sobre un RUC, o un DNI con empresa.
* [`Paperclip\FacturasElectrónicas\Facturador::consultar_ticket(array $parámetros):array`](https://docs.paperclip.com.pe/api-facturación/comando-consultarticket/):  Consulta el estado de un ticket de una transacción diferida de la SUNAT.

`$parámetros` es el array de parámtros requerido por cada comando de la API.
