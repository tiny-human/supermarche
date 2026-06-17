<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateAchats extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true],
            'caisse_id'  => ['type' => 'INTEGER', 'null' => false],
            'date_achat' => ['type' => 'TEXT', 'default' => date('Y-m-d H:i:s')],
            'statut'     => ['type' => 'TEXT', 'default' => 'en_cours'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('achat');
    }
    public function down() {
        $this->forge->dropTable('achat');
    }
}