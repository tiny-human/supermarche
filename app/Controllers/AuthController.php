<?php
namespace App\Controllers;
use App\Models\UtilisateurModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('caisse');
        }
        return view('auth/login');
    }

    public function login()
    {
        $model    = new UtilisateurModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && $user['password'] === $password) {
            session()->set([
                'user_id'     => $user['id'],
                'username'    => $user['username'],
                'isLoggedIn'  => true,
            ]);
            return redirect()->to('caisse');
        }

        session()->setFlashdata('error', 'Identifiants incorrects.');
        return redirect()->to('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('caisse');
        }
        return view('auth/register');
    }
}