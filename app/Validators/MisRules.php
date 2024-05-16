<?php

namespace App\Validators;

use App\Models\ModeloNoticia;
use App\Models\ModeloUsuario;

class MisRules
{

    public function maximoBorradoresActivos(string $value, string $fields, array $data): bool
    {
        $session = session();
        $modeloNoticia = model(ModeloNoticia::class);
        $cantidadBorradoresActivos = $modeloNoticia->obtenerCantidadNotciasActivasEnBorradorPorUsuario($session->id);
      
        if ($cantidadBorradoresActivos >= 3 && $data['es_activo_original']=="0" && $data['es_activo']>0 && $data['estado'] == "2") {
            return false;
        }
        return true;
    }
    public function validarRoles($rol)
    {
        $modeloUsuario = model(ModeloUsuario::class);
        // Verifica si al menos uno de los checkboxes está marcado
        if (empty($rol)) {
            // Ningún checkbox está marcado
            return false;
        } else {
            // Al menos uno de los checkboxes está marcado
            return true;
        }
    }

}