<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidenciaModel extends Model
{
    protected $table      = 'incidencias'; // Nombre de la tabla
    protected $primaryKey = 'id';     // Clave primaria

    protected $allowedFields = [
        'id_trampa', 'sede_id', 'fecha', 'tipo_plaga', 'tipo_incidencia', 
        'notas', 'inspector'
    ]; // Campos permitidos
}