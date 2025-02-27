<?php

namespace App\Models;

use CodeIgniter\Model;

class TrampaModel extends Model
{
    protected $table      = 'trampas'; // Nombre de la tabla
    protected $primaryKey = 'id';     // Clave primaria

    protected $allowedFields = [
        'sede_id', 'plano_id', 'nombre', 'tipo', 'ubicacion', 
        'coordenada_x', 'coordenada_y', 'fecha_instalacion', 'estado'
    ]; // Campos permitidos
}