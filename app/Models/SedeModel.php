<?php

namespace App\Models;

use CodeIgniter\Model;

class SedeModel extends Model
{
    protected $table      = 'sedes'; // Nombre de la tabla
    protected $primaryKey = 'id';    // Clave primaria

    protected $allowedFields = ['nombre', 'direccion', 'ciudad', 'pais', 'fecha_creacion']; // Campos permitidos
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = '';
    protected $deletedField = '';
}