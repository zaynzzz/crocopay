<?php
// app/Controllers/Admin/ClientAdminController.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ClientAdminController extends BaseController
{
    public function registerForm()
    {
        return view('admin/client_register');
    }

    public function registerSubmit()
    {
        helper('form');

        $data = $this->request->getPost();

        if (!isset($data['name'], $data['email'], $data['password'])) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        $userModel = new UserModel();

        if ($userModel->where('email', $data['email'])->first()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar.');
        }

        $userModel->insert([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => password_hash($data['password'], PASSWORD_BCRYPT),
        ]);

        return redirect()->back()->with('success', 'Client berhasil didaftarkan.');
    }
}
