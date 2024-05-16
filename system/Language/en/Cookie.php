<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Cookie language settings
return [
    'invalidExpiresTime'    => 'Tipo de "{0}" no válido para el atributo "Expira". Se esperaba: cadena, entero, objeto DateTimeInterface.',
    'invalidExpiresValue'   => 'El tiempo de expiración de la cookie no es válido.',
    'invalidCookieName'     => 'El nombre de la cookie "{0}" contiene caracteres no válidos.',
    'emptyCookieName'       => 'El nombre de la cookie no puede estar vacío.',
    'invalidSecurePrefix'   => 'El uso del prefijo "__Secure-" requiere establecer el atributo "Seguro" (Secure).',
    'invalidHostPrefix'     => 'El uso del prefijo "__Host-" debe establecerse con la bandera "Seguro" (Secure), no debe tener un atributo "Dominio" (Domain) y la "Ruta" (Path) debe establecerse en "/".',
    'invalidSameSite'       => 'El valor SameSite debe ser Ninguno (None), Lax, Strict o una cadena vacía, se proporcionó {0}.',
    'invalidSameSiteNone'   => 'El uso del atributo "SameSite=None" requiere establecer el atributo "Seguro" (Secure).',
    'invalidCookieInstance' => 'Se esperaba que la clase "{0}" recibiera una matriz de cookies como instancias de "{1}" pero se obtuvo "{2}" en el índice {3}.',
    'unknownCookieInstance' => 'No se encontró el objeto de cookie con nombre "{0}" y prefijo "{1}" en la colección.',    
];
