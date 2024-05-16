<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ModeloBorrador extends Model
    {
        protected $table = 'borrador';
        protected $allowedFields = ['id_noticia', 'titulo', 'id_categoria','descripcion', 'imagen'];

        public function obtenerTotalBorradoresNoticia($idNoticia) { 
            return $this->where(['id_noticia' => $idNoticia])
                        ->countAllResults();
        }

        public function obtenerBorradoresNoticia($idNoticia, $offSet = 0) {
            return $this->asArray()
                        ->where(['id_noticia' => $idNoticia])
                        ->join('categoria','categoria.id = borrador.id_categoria')
                        ->orderBy('fecha_modificacion', 'DESC')
                        ->select('borrador.*, categoria.nombre as categoria')
                        ->findAll(2, $offSet);
        }
    }
?>