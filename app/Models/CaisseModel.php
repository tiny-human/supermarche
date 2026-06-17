<?php

namespace App\Models;

use CodeIgniter\Model;

class CaisseModel extends Model
{
    protected $table            = 'caisse';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['numero'];

    // Validation
    protected $validationRules      = [
        'numero' => 'required|min_length[1]|max_length[255]',
    ];
    protected $validationMessages   = [
        'numero' => [
            'required' => 'Le numéro de caisse est obligatoire.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}