<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Session language settings
return [   
    'missingDatabaseTable' => '"sessionSavePath" debe tener el nombre de la tabla para que funcione el Controlador de Sesiones de Base de Datos.',
    'invalidSavePath' => 'Sesión: La ruta de guardado configurada "{0}" no es un directorio, no existe o no se puede crear.',
    'writeProtectedSavePath' => 'Sesión: La ruta de guardado configurada "{0}" no es escribible por el proceso PHP.',
    'emptySavePath' => 'Sesión: No se ha configurado una ruta de guardado.',
    'invalidSavePathFormat' => 'Sesión: Formato de ruta de guardado de Redis no válido: "{0}"',

    // @deprecated
    'invalidSameSiteSetting' => 'Sesión: La configuración SameSite debe ser None, Lax, Strict o una cadena vacía. Se proporcionó: "{0}"',
];
