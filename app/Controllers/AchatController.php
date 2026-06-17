<?php
namespace App\Controllers;
use App\Models\ProduitModel;
use App\Models\AchatModel;
use App\Models\LigneModel;

class AchatController extends BaseController
{
    public function index()
    {
        // Redirige vers le choix de caisse si pas de session
        if (!session()->get('caisse_id')) {
            return redirect()->to('caisse');
        }

        $produitModel = new ProduitModel();
        return view('achat/saisie', [
            'produits' => $produitModel->findAll()
        ]);
    }

    public function cloturer()
    {
        $lignes    = json_decode($this->request->getPost('lignes'), true);
        $caisseId  = session()->get('caisse_id');

        // Insérer l'achat
        $achatModel = new AchatModel();
        $achatId    = $achatModel->insert([
            'caisse_id'  => $caisseId,
            'date_achat' => date('Y-m-d H:i:s'),
            'statut'     => 'cloture',
        ]);

        // Insérer les lignes
        $ligneModel = new LigneModel();
        foreach ($lignes as $ligne) {
            $ligneModel->insert([
                'achat_id'   => $achatId,
                'produit_id' => $ligne['produit_id'],
                'quantite'   => $ligne['quantite'],
                'montant'    => $ligne['montant'],
            ]);
        }

        return redirect()->to('achat');
    }
}