<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProjectModel;

class ProjectsController extends BaseController
{
    public function index()
    {
        $merchantId = session()->get('merchant_id'); // asumsi login merchant
        $projectModel = new ProjectModel();

        $data['projects'] = $projectModel->where('merchant_id', $merchantId)->findAll();
        return view('projects/index', $data);
    }

    public function create()
    {
        return view('projects/create');
    }
    public function edit($id)
    {
        $merchantId = session('merchant_id');
        $projectModel = new ProjectModel();
        $project = $projectModel->where('id', $id)
                                ->where('merchant_id', $merchantId)
                                ->first();

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project tidak ditemukan atau tidak punya akses.");
        }

        return view('projects/edit', ['project' => $project]);
    }
    public function update($id)
    {
        $merchantId = session('merchant_id');
        $projectModel = new ProjectModel();

        $project = $projectModel->where('id', $id)
                                ->where('merchant_id', $merchantId)
                                ->first();

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project tidak ditemukan atau tidak punya akses.");
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'webhook_url' => $this->request->getPost('webhook_url'),
            'description' => $this->request->getPost('description'),
        ];

        $projectModel->update($id, $data);

        return redirect()->to('/projects')->with('success', 'Project updated.');
    }
   public function delete($id)
    {
        $merchantId = session('merchant_id');
        $userPassword = session('password'); // contoh: simpan password saat login (harus hash)
        $inputPassword = $this->request->getPost('password_confirmation');
        $inputName = $this->request->getPost('project_name_confirmation');

        $projectModel = new ProjectModel();
        $project = $projectModel->where('id', $id)
                                ->where('merchant_id', $merchantId)
                                ->first();

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project tidak ditemukan.");
        }

        // ❗ validasi nama project
        if (trim($inputName) !== $project['name']) {
            return redirect()->back()->with('error', 'Nama project tidak cocok.');
        }


        // ❗ validasi password (contoh pakai hash)
        $MerchantModel = new \App\Models\MerchantModel();
        $user = $MerchantModel->find($merchantId); // asumsikan merchant_id = user id

        if (!$user || !password_verify($inputPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        // $projectModel->delete($id)
        $deleted = $projectModel->delete($id);

        return redirect()->to('/projects')->with('success', 'Project berhasil dihapus.');
    }



    public function store()
    {
        $merchantId = session()->get('merchant_id');
        helper('text');

        
    $data = [
        'merchant_id' => $merchantId,
        'name' => $this->request->getPost('name'),
        'webhook_url' => $this->request->getPost('webhook_url'),
        'description' => $this->request->getPost('description'),
        'api_key' => bin2hex(random_bytes(16)),
        'api_token' => bin2hex(random_bytes(16)),
        'secret_key' => bin2hex(random_bytes(16)),
        'balance' => 0,
    ];

        $projectModel = new ProjectModel();
        $projectModel->insert($data);

        return redirect()->to('/projects')->with('success', 'Project created.');
    }
    public function show($id)
{
    $merchantId = session('merchant_id');

    $projectModel = new \App\Models\ProjectModel();
    $project = $projectModel->where('id', $id)
                            ->where('merchant_id', $merchantId)
                            ->first();

    if (!$project) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project tidak ditemukan atau tidak punya akses.");
    }

    return view('projects/show', ['project' => $project]);
}

}
