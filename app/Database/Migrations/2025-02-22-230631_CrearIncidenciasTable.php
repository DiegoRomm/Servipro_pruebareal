<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearIncidenciasTable extends Migration
{
    public function up()
    {
        // Definir la estructura de la tabla "incidencias"
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_trampa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false, // No permitimos valores nulos
            ],
            'fecha' => [
                'type'       => 'DATETIME',
            ],
            'tipo_plaga' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tipo_incidencia' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'notas' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'inspector' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addPrimaryKey('id');
        
        // Definir la clave foránea a la tabla trampas
        $this->forge->addForeignKey('id_trampa', 'trampas', 'id', 'CASCADE', 'CASCADE');
        
        // Crear la tabla
        $this->forge->createTable('incidencias');
    }

    public function down()
    {
        // Eliminar la tabla si se revierte la migración
        $this->forge->dropTable('incidencias');
    }
}
