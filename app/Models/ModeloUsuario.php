<?php

namespace App\Models;
use CodeIgniter\Model;

class ModeloUsuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','apellido','correo','clave','es_editor','es_validador'];
}


?>

