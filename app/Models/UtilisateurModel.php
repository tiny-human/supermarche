<?php

namespace App\Models;

use CodeIgniter\Model;
class UtilisateurModel extends Model
{
    protected $table         = 'utilisateurs';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = ['nom', 'mot_de_passe', 'role'];
}
?>