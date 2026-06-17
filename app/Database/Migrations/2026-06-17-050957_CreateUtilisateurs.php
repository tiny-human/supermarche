<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUtilisateurs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INTEGER', 'auto_increment' => true],
            'username' => ['type' => 'TEXT', 'null' => false],
            'password' => ['type' => 'TEXT', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('utilisateur');
    }

    public function down()
    {
        $this->forge->dropTable('utilisateur');
    }

}
