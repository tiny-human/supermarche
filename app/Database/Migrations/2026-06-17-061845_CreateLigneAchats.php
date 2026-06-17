<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateLigneAchats extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true],
            'achat_id'   => ['type' => 'INTEGER', 'null' => false],
            'produit_id' => ['type' => 'INTEGER', 'null' => false],
            'quantite'   => ['type' => 'INTEGER', 'null' => false],
            'montant'    => ['type' => 'REAL', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('ligne_achat');
    }
    public function down() {
        $this->forge->dropTable('ligne_achat');
    }
}