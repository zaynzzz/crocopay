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
