<?php
namespace Paperclip\FacturasElectrónicas;

use InvalidArgumentException;
use RuntimeException;

/**
 * Clase para enviar la información de los comprobantes de pago via la API de
 * https://facturaselectronicas.biz/
 *
 * @author Oliver Etchebarne
 */
class Facturador
{
    private $token = '';
    private $url = '';

    private $parámetros = [];
    private $items = [];

    /**
     * Constructor
     */
    public function __construct($token, $url)
    {
        // Validamos el token
        if (!preg_match('/^[0-9a-f]{64}$/', $token)) {
            throw new InvalidArgumentException("Formato de token inválido.");
        }

        $re = '/^https?\:\/\/.+[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/';
        if (!preg_match($re, $url)) {
            throw new InvalidArgumentException('URL de facturador mal formado.');
        }

        $this->token = $token;
        $this->url = $url;
    }

    /**
     * Asigna parámetros a esta petición.
     * @param array $parámetros Parámetros a añadir
     * @return self
     */
    public function parámetros($parámetros)
    {
        $this->parámetros = $parámetros;
        return $this;
    }

    /**
     * Ejecuta un comando de la API.
     * @param string $comando Comando a ejecutar.
     */
    public function ejecutar($comando)
    {

        $payload = json_encode($this->parámetros);

        $url = $this->url . '/' . $comando;

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_HTTPHEADER, [
            'X-Token: ' . $this->token,
            'X-Formato: json'
        ]);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($c);

        if ($result === false) {
            throw new RuntimeException(curl_error($c));
        } else {
            $status = json_decode($result, true);
            // Esto _nunca_ debe pasar...
            if (is_null($status)) {
                throw new RuntimeException("Error interno de la API. Por favor, comuníquese con el administrador.");
            }

            if ($status['estado'] != 'ok') {
                throw new RuntimeException($status['descripcion_error'] . ": "
                    . $status['descripcion_extra']);

            }
        }

        curl_close($c);

        return $status;
    }

    /**
     * Ejecuta el comando "emitir"
     */
    public function emitir($parámetros)
    {
        return $this->parámetros($parámetros)->ejecutar('emitir');
    }

    /**
     * Ejecuta el comando "baja"
     */
    public function baja(array $parámetros): array
    {
        return $this->parámetros($parámetros)->ejecutar('baja');
    }

    /**
     * Ejecuta el comando "correo"
     */
    public function correo(array $parámetros): array
    {
        return $this->parámetros($parámetros)->ejecutar('correo');
    }

    /**
     * Ejecuta el comando "consultar_ruc"
     */
    public function consultarRuc(array $parámetros): array
    {
        return $this->parámetros($parámetros)->ejecutar('consultar_ruc');
    }

    /**
     * Ejecuta el comando "consultar_ticket"
     */
    public function consultarTicket(array $parámetros): array
    {
        return $this->parámetros($parámetros)->ejecutar('consultar_ticket');
    }

    /**
     * Ejecuta el comando "hola"
     */
    public function hola(array $parámetros): array
    {
        return $this->parámetros($parámetros)->ejecutar('hola');
    }
}
