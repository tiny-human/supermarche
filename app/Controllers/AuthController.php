<?php

namespace App\Controllers;

use App\Models\EmployeModel;

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
        $model = new EmployeModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Recherche de l'employé par email
        $user = $model->where('email', $email)->where('actif', 1)->first();

        if ($user) {
            // Vérification du mot de passe haché (Exigence C14)
            if (password_verify($password, $user['password'])) {
                
                // Préparation des données de session
                $ses_data = [
                    'id'            => $user['id'],
                    'nom'           => $user['nom'],
                    'prenom'        => $user['prenom'],
                    'email'         => $user['email'],
                    'role'          => $user['role'],
                    'departement_id'=> $user['departement_id'],
                    'isLoggedIn'    => TRUE,
                ];
                
                $session->set($ses_data);

                // Redirection selon le rôle
                return redirect()->to('/' . $user['role'] . '/dashboard');
            } else {
                $session->setFlashdata('error', 'Mot de passe incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email introuvable ou compte inactif.');
            return redirect()->to('/login');
        }
    }

    // Déconnexion
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}