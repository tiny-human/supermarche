<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\AchatModel;
use App\Models\LigneModel;

class AchatController extends BaseController
{
    public function index()
    {
        if (!session()->get('caisse_id')) {
            return redirect()->to('caisse');
        }

        $produitModel = new ProduitModel();
        return view('achat', [
            'produits' => $produitModel->findAll()
        ]);
    }

    public function cloturer()
    {
        $lignes     = json_decode($this->request->getPost('lignes'), true);
        $caisseId   = session()->get('caisse_id');

        $achatModel  = new AchatModel();
        $ligneModel  = new LigneModel();
        $produitModel = new ProduitModel();

        $achatId = $achatModel->insert([
            'caisse_id'  => $caisseId,
            'date_achat' => date('Y-m-d H:i:s'),
            'statut'     => 'cloture',
        ]);

        foreach ($lignes as $ligne) {
            $ligneModel->insert([
                'achat_id'   => $achatId,
                'produit_id' => $ligne['produit_id'],
                'quantite'   => $ligne['quantite'],
                'montant'    => $ligne['montant'],
            ]);

            $produit = $produitModel->find($ligne['produit_id']);
            $produitModel->update($ligne['produit_id'], [
                'quantite_stock' => $produit['quantite_stock'] - $ligne['quantite']
            ]);
        }

        return redirect()->to('achat');
    }
}
