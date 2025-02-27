<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearSedesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'direccion' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'ciudad' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'pais' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'fecha_creacion' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addPrimaryKey('id');

        // Crear la tabla
        $this->forge->createTable('sedes');
    }

    public function down()
    {
        $this->forge->dropTable('sedes');
    }
}
