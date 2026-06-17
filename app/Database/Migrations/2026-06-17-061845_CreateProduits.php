<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateProduits extends Migration {
    public function up() {
        $this->forge->addField([
            'id'             => ['type' => 'INTEGER', 'auto_increment' => true],
            'designation'    => ['type' => 'TEXT', 'null' => false],
            'prix'           => ['type' => 'REAL', 'null' => false],
            'quantite_stock' => ['type' => 'INTEGER', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('produit');
    }
    public function down() {
        $this->forge->dropTable('produit');
    }
}