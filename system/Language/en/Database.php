<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Database language settings
return [
    'invalidEvent'                     => '"{0}" no es una devolución de llamada de Evento de Modelo válida.',
    'invalidArgument'                  => 'Debes proporcionar un "{0}" válido.',
    'invalidAllowedFields'             => 'Los campos permitidos deben ser especificados para el modelo: "{0}"',
    'emptyDataset'                     => 'No hay datos para {0}.',
    'emptyPrimaryKey'                  => 'No se ha definido una clave primaria al intentar crear {0}.',
    'failGetFieldData'                 => 'Error al obtener los datos del campo desde la base de datos.',
    'failGetIndexData'                 => 'Error al obtener los datos del índice desde la base de datos.',
    'failGetForeignKeyData'            => 'Error al obtener los datos de la clave externa desde la base de datos.',
    'parseStringFail'                  => 'Error al analizar la cadena de clave.',
    'featureUnavailable'               => 'Esta función no está disponible para la base de datos que estás utilizando.',
    'tableNotFound'                    => 'La tabla "{0}" no se encontró en la base de datos actual.',
    'noPrimaryKey'                     => 'La clase de modelo "{0}" no especifica una Clave Primaria.',
    'noDateFormat'                     => 'La clase de modelo "{0}" no tiene un formato de fecha válido.',
    'fieldNotExists'                   => 'Campo "{0}" no encontrado.',
    'forEmptyInputGiven'               => 'Se proporciona una declaración vacía para el campo "{0}"',
    'forFindColumnHaveMultipleColumns' => 'Solo se permite una columna en el nombre de la columna.',
    'methodNotAvailable'               => 'No puedes usar "{1}" en "{0}". Este es un método de la Clase Constructora de Consultas.',    
];
