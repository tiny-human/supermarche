<?php
namespace App\Controllers;
use App\Models\CaisseModel;

class CaisseController extends BaseController
{
    public function index()
    {
        $caisseModel = new CaisseModel();
        return view('caisse/caisse', [
            'caisses' => $caisseModel->findAll()
        ]);
    }

    public function valider()
    {
        // Bug 1 corrigé : caisse_id au lieu de caisse
        $caisseId = $this->request->getPost('caisse_id');

        if (!$caisseId) {
            return redirect()->to('caisse')->with('error', 'Aucune caisse sélectionnée.');
        }

        $caisseModel = new CaisseModel();
        $caisse      = $caisseModel->find($caisseId);

        // Bug 4 corrigé : on stocke aussi caisse_numero
        session()->set('caisse_id',     $caisse['id']);
        session()->set('caisse_numero', $caisse['numero']);

        return redirect()->to('achat');
    }
}