<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidenciaModel extends Model
{
    protected $table      = 'incidencias'; // Nombre de la tabla
    protected $primaryKey = 'id';         // Clave primaria

    protected $allowedFields = [
        'trampa_id', 'fecha', 'resultado', 'notas', 'inspector'
    ]; // Campos permitidos
}