<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearPlanosTable extends Migration
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
            'sede_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'archivo' => [
                'type'       => 'JSON',
                'null'       => true,
            ],
            'fecha_creacion' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'descripcion' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addPrimaryKey('id');

        // Definir la clave foránea
        $this->forge->addForeignKey('sede_id', 'sedes', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla
        $this->forge->createTable('planos');
    }

    public function down()
    {
        // Eliminar la tabla
        $this->forge->dropTable('planos');
    }
}
