<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MerchantModel;
use CodeIgniter\HTTP\ResponseInterface;

class MerchantAdminController extends BaseController
{
    public function create()
    {
        $data = $this->request->getJSON(true); // POST JSON

        if (!isset($data['name'], $data['email'], $data['password'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Name, email, and password are required.',
            ]);
        }

        $merchantModel = new MerchantModel();

        // Cek duplikasi email
        if ($merchantModel->where('email', $data['email'])->first()) {
            return $this->response->setStatusCode(409)->setJSON([
                'error' => 'Merchant with this email already exists.',
            ]);
        }

        $keys = $merchantModel->generateKeys();

        $newMerchant = [
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => password_hash($data['password'], PASSWORD_BCRYPT),
            'api_key'     => $keys['api_key'],
            'api_token'   => $keys['api_token'],
            'secret_key'  => $keys['secret_key'],
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $merchantModel->insert($newMerchant);

        return $this->response->setStatusCode(201)->setJSON([
            'message' => 'Merchant created successfully.',
            'credentials' => [
                'api_key'    => $keys['api_key'],
                'api_token'  => $keys['api_token'],
                'secret_key' => $keys['secret_key'],
            ],
        ]);
    }
public function registerForm()
{
    return view('admin/merchant_register');
}


public function registerSubmit()
{
    helper('form');

    $data = $this->request->getPost();

    if (!isset($data['name'], $data['email'], $data['password'])) {
        return redirect()->back()->with('error', 'Semua field wajib diisi.');
    }

    $merchantModel = new \App\Models\MerchantModel();

    if ($merchantModel->where('email', $data['email'])->first()) {
        return redirect()->back()->with('error', 'Email sudah terdaftar.');
    }

    $keys = $merchantModel->generateKeys();

    $merchantModel->insert([
        'name'       => $data['name'],
        'email'      => $data['email'],
        'password'   => password_hash($data['password'], PASSWORD_BCRYPT),
        'api_key'    => $keys['api_key'],
        'api_token'  => $keys['api_token'],
        'secret_key' => $keys['secret_key'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    return view('admin/merchant_register', ['credentials' => $keys]);
}
}
