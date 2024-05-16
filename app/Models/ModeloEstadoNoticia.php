<?php
    namespace App\Models;
    use CodeIgniter\Model;
    use Config\MiConfiguracion; 

    class ModeloEstadoNoticia extends Model
    {
        protected $table = 'estado_noticia';
        protected $allowedFields = ['id_usuario','id_noticia','id_estado','observaciones'];

        
        public function publicarYFinalizarNoticiasAutomticamente(){

            $dias = config('MiConfiguracion')->dias;

            d("Ejecutando actualización automática de noticias...");

            $subconsulta = '(SELECT MAX(fecha) 
                            FROM estado_noticia 
                            WHERE estado_noticia.id_noticia = noticia.id)';

            $campos =  'noticia.id as id, 
                        noticia.es_activo, 
                        estado_noticia.fecha';

            $noticias =  $this->db->table("estado_noticia")
            ->join("noticia", "noticia.id = estado_noticia.id_noticia")
            ->where("es_activo = 1")
            ->where("fecha = $subconsulta")
            ->where("id_estado", 1)
            ->where("fecha <= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 5 DAY)")
            ->groupBy('noticia.id')
            ->select('noticia.id')
            ->get()->getResultArray();

            d("Publicando automaticamente " . count($noticias) . " noticias.");

            foreach($noticias as $noticia){
                $this->save([
                    'id_noticia'=> $noticia['id'],
                    'id_estado'=> 5,
                    'observaciones'=> 'Publicada automáticamente por sistema',
                    'id_usuario'=> 1,            
                ]);
            }

            $noticias =  $this->db->table("estado_noticia")
            ->join("noticia", "noticia.id = estado_noticia.id_noticia")
            ->where("es_activo = 1")
            ->where("fecha = $subconsulta")
            ->where("id_estado", 5)
            ->where("fecha < DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL $dias DAY)")
            ->groupBy('noticia.id')
            ->select('noticia.id, fecha')
            ->get()->getResultArray();

            d("Finalizando automaticamente " . count($noticias) . " noticias.");

            foreach($noticias as $noticia){
                $this->save([
                    'id_noticia'=> $noticia['id'],
                    'id_estado'=> 7,
                    'observaciones'=> 'Finalizada automáticamente por sistema',
                    'id_usuario'=> 1,            
                ]);
            }


        }

    }
?>