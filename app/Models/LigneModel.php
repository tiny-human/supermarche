<?php

namespace App\Models;

use CodeIgniter\Model;

class LigneModel extends Model
{
    protected $table         = 'ligne_achat';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['achat_id', 'produit_id', 'quantite', 'montant'];
    
}
