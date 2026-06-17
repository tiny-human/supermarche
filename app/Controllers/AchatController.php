<?php

namespace App\Controllers;

class AchatController extends BaseController
{
    /**
     * Affiche l'interface de vente pour la caisse sélectionnée.
     */
    public function index($caisseId = null)
    {
        // Si l'ID n'est pas fourni dans l'URL, on tente de le récupérer en session
        $caisseId = $caisseId ?? session()->get('caisse_id');

        // Si aucune caisse n'est trouvée (accès direct sans sélection), on redirige
        if (!$caisseId) {
            return redirect()->to('/caisse')->with('error', 'Veuillez sélectionner une caisse avant de commencer.');
        }

        return view('achat', ['caisseId' => $caisseId]);
    }
}