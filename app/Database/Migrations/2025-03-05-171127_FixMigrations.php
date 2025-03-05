<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixMigrations extends Migration
{
    public function up()
    {
        // First, clean up the migrations table
        $this->db->query('TRUNCATE TABLE migrations');
        
        // Create sedes table
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
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sedes', true); // true means "IF NOT EXISTS"
        
        // Create planos table
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
            'descripcion' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'archivo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'fecha_creacion' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('sede_id', 'sedes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('planos', true);
        
        // Create trampas table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'plano_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'coordenada_x' => [
                'type'       => 'FLOAT',
            ],
            'coordenada_y' => [
                'type'       => 'FLOAT',
            ],
            'estado' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'activo',
            ],
            'fecha_creacion' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('plano_id', 'planos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trampas', true);
        
        // Create incidencias table
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
                'null'       => false,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_trampa', 'trampas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('incidencias', true);
    }

    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraints
        $this->forge->dropTable('incidencias', true);
        $this->forge->dropTable('trampas', true);
        $this->forge->dropTable('planos', true);
        $this->forge->dropTable('sedes', true);
    }
}
