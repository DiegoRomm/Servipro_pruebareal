<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTrampasTable extends Migration
{
    public function up()
    {
              // Definir la estructura de la tabla "trampas"
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
                'plano_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true, // Opcional, ya que no todas las trampas están asociadas a un plano
                ],
                'nombre' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'tipo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                ],
                'ubicacion' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'coordenada_x' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true, // Opcional, dependiendo de si la trampa está asociada a un plano
                ],
                'coordenada_y' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true, // Opcional, dependiendo de si la trampa está asociada a un plano
                ],
                'fecha_instalacion' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ]
            ]);
    
            // Definir la clave primaria
            $this->forge->addPrimaryKey('id');
    
            // Definir las claves foráneas
            $this->forge->addForeignKey('sede_id', 'sedes', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('plano_id', 'planos', 'id', 'CASCADE', 'CASCADE');
    
            // Crear la tabla
            $this->forge->createTable('trampas');
    }

    public function down()
    {
        // Eliminar la tabla
        $this->forge->dropTable('trampas');
    }
}
