<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthController extends BaseController
{
    // Affiche la page de connexion
    public function index()
    {
        // Si déjà connecté, on redirige vers le dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/' . session()->get('role') . '/dashboard');
        }
        return view('auth/login');
    }

    // Traite la tentative de connexion
    public function login()
    {
        $session = session();
        $model = new UtilisateurModel();

        $nom = $this->request->getPost('nom');
        $password = $this->request->getPost('password');

        // Recherche de l'utilisateur par nom (basé sur ton UtilisateurModel)
        $user = $model->where('nom', $nom)->first();

        if ($user) {
            // Vérification du mot de passe haché (Exigence C14)
            if (password_verify($password, $user['mot_de_passe'])) {
                
                // Préparation des données de session
                $ses_data = [
                    'id'            => $user['id'],
                    'nom'           => $user['nom'],
                    'role'          => $user['role'],
                    'isLoggedIn'    => TRUE, // Correspond maintenant à ton AuthFilter
                ];
                
                $session->set($ses_data);

                return redirect()->to('/caisse');
            } else {
                $session->setFlashdata('error', 'Mot de passe incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Utilisateur introuvable.');
            return redirect()->to('/login');
        }
    }

    // Déconnexion
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    /**
     * Affiche le formulaire d'inscription ou traite l'inscription.
     */
    public function register()
    {
        // Si déjà connecté, on redirige vers le dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/' . session()->get('role') . '/dashboard');
        }

        helper(['form']); // Charge le helper de formulaire pour set_value() et csrf_field()

        if ($this->request->getMethod() === 'post') {
            // Définition des règles de validation pour l'inscription
            $rules = [
                'nom' => [
                    'rules'  => 'required|min_length[3]|max_length[50]|is_unique[utilisateur.nom]',
                    'errors' => [
                        'required'   => 'Le nom d\'utilisateur est obligatoire.',
                        'min_length' => 'Le nom d\'utilisateur doit contenir au moins 3 caractères.',
                        'max_length' => 'Le nom d\'utilisateur ne doit pas dépasser 50 caractères.',
                        'is_unique'  => 'Ce nom d\'utilisateur est déjà pris.',
                    ],
                ],
                'mot_de_passe' => [
                    'rules'  => 'required|min_length[6]|max_length[255]',
                    'errors' => [
                        'required'   => 'Le mot de passe est obligatoire.',
                        'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.',
                        'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
                    ],
                ],
                'confirm_mot_de_passe' => [
                    'rules'  => 'required|matches[mot_de_passe]',
                    'errors' => [
                        'required' => 'La confirmation du mot de passe est obligatoire.',
                        'matches'  => 'Les mots de passe ne correspondent pas.',
                    ],
                ],
            ];

            if (! $this->validate($rules)) {
                // La validation a échoué, on retourne au formulaire avec les erreurs
                return view('auth/register', ['validation' => $this->validator]);
            }

            // La validation a réussi, on enregistre l'utilisateur
            $model = new UtilisateurModel();
            $model->save([
                'nom'          => $this->request->getPost('nom'),
                'mot_de_passe' => password_hash($this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT),
                'role'         => 'employe', // Rôle par défaut pour les nouveaux utilisateurs
            ]);

            session()->setFlashdata('success', 'Votre compte a été créé avec succès. Veuillez vous connecter.');
            return redirect()->to('/login');
        }

        // Pour une requête GET, on affiche simplement le formulaire d'inscription
        return view('auth/register');
    }
}