<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CaisseSeeder extends Seeder
{
    public function run()
{
    $this->db->table('caisse')->insertBatch([
        ['numero' => 'C01'],
        ['numero' => 'C02'],
    ]);

    $this->db->table('produit')->insertBatch([
        ['designation' => 'Biscuit', 'prix' => 1000, 'quantite_stock' => 50],
        ['designation' => 'Pain',    'prix' => 400,  'quantite_stock' => 30],
        ['designation' => 'Lait 1L', 'prix' => 800,  'quantite_stock' => 40],
        ['designation' => 'Riz 1kg', 'prix' => 1200, 'quantite_stock' => 60],
        ['designation' => 'Savon',   'prix' => 500,  'quantite_stock' => 25],
    ]);
}
}
