<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new AdminModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $admin = $model->where('username', $username)->first();

        if ($admin && password_verify($password, $admin['password'])) {
            $session->set('is_logged_in', true);
            $session->set('admin_id', $admin['id']);
            return redirect()->to('/admin');
        } else {
            return redirect()->back()->with('error', 'Login gagal');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
