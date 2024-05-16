<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Email language settings
return [
    'mustBeArray'          => 'El método de validación de correo electrónico debe recibir un array.',
    'invalidAddress'       => 'Dirección de correo electrónico no válida: "{0}"',
    'attachmentMissing'    => 'No se puede encontrar el siguiente adjunto de correo electrónico: "{0}"',
    'attachmentUnreadable' => 'No se puede abrir este adjunto: "{0}"',
    'noFrom'               => 'No se puede enviar correo sin encabezado "From".',
    'noRecipients'         => 'Debes incluir destinatarios: Para, Cc o Bcc',
    'sendFailurePHPMail'   => 'No se puede enviar correo usando mail() de PHP. Es posible que tu servidor no esté configurado para enviar correo usando este método.',
    'sendFailureSendmail'  => 'No se puede enviar correo usando Sendmail. Es posible que tu servidor no esté configurado para enviar correo usando este método.',
    'sendFailureSmtp'      => 'No se puede enviar correo usando SMTP. Es posible que tu servidor no esté configurado para enviar correo usando este método.',
    'sent'                 => 'Tu mensaje se ha enviado correctamente utilizando el siguiente protocolo: {0}',
    'noSocket'             => 'No se puede abrir un socket para Sendmail. Por favor, verifica la configuración.',
    'noHostname'           => 'No especificaste un nombre de host SMTP.',
    'SMTPError'            => 'Se encontró el siguiente error SMTP: {0}',
    'noSMTPAuth'           => 'Error: Debes asignar un nombre de usuario y una contraseña SMTP.',
    'failedSMTPLogin'      => 'Error al enviar el comando AUTH LOGIN. Error: {0}',
    'SMTPAuthUsername'     => 'Error al autenticar el nombre de usuario. Error: {0}',
    'SMTPAuthPassword'     => 'Error al autenticar la contraseña. Error: {0}',
    'SMTPDataFailure'      => 'No se puede enviar datos: {0}',
    'exitStatus'           => 'Código de estado de salida: {0}',
    
];
