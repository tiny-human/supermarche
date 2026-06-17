<?php
namespace App\Controllers;
use App\Models\CaisseModel;

class CaisseController extends BaseController
{
    public function index()
    {
        $caisseModel = new CaisseModel();
        $caisses = $caisseModel->findAll();

        return view('caisse/caisse', ['caisses' => $caisses]);
    }

    public function valider()
    {
        $caisseId = $this->request->getPost('caisse');

        if (!$caisseId) {
            return redirect()->to('/caisse')->with('error', 'Aucune caisse sélectionnée.');
        }

        // On stocke bien l'ID en session
        session()->set('caisse_id', $caisseId);
        
        // Redirection propre vers l'URL /achat
        return redirect()->to('/achat');
    }
}