<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIncidenciasTable extends Migration
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
            'trampa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'fecha' => [
                'type'       => 'DATETIME',
            ],
            'resultado' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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

        // Definir la clave foránea
        $this->forge->addForeignKey('trampa_id', 'trampas', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla
        $this->forge->createTable('incidencias');
    }

    public function down()
    {
        // Eliminar la tabla si se revierte la migración
        $this->forge->dropTable('incidencias');
    }
}