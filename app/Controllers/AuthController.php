<?php
namespace App\Controllers;

use App\Models\MerchantModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new MerchantModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $merchant = $model->where('email', $email)->first();

        if ($merchant) {
            if (password_verify($password, $merchant['password'])) {
                $session->set([
                    'merchant_id' => $merchant['id'],
                    'merchant_name' => $merchant['name'],
                    'is_logged_in' => true
                ]);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan.');
            return redirect()->back();
        }
    }

        public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[merchants.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new \App\Models\MerchantModel();

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $model->insert($data);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
