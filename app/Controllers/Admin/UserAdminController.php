<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserAdminController extends BaseController
{
    public function createForm()
    {
        return view('admin/user_register');
    }

    public function createSubmit()
    {
        helper(['form']);
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
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Client berhasil didaftarkan.');
    }
}
