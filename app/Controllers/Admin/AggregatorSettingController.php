<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AggregatorSettingModel;
    use App\Models\AggDisbursementModel;

class AggregatorSettingController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AggregatorSettingModel();
    }

    // ===== QRIS =====
    public function index() // /admin/aggregator/qris
    {
        $data['aggregators'] = $this->model->where('type', 'qris')->findAll();
        return view('Admin/aggregator_qris_settings', $data);
    }

    public function update() // /admin/aggregator/qris/update
    {
        $selected = $this->request->getPost('aggregator');
        $this->model->where('type', 'qris')->set(['is_primary' => false])->update();
        $this->model->where('name', $selected)->set(['is_primary' => true])->update();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Aggregator QRIS updated.',
        ]);
    }

    public function toggle($name) // /admin/aggregator/qris/toggle/:name
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $agg = $this->model->where('name', $name)->where('type', 'qris')->first();
        $newStatus = !$agg['enabled'];
        $this->model->update($agg['id'], ['enabled' => $newStatus]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Status QRIS updated.',
            'enabled' => $newStatus,
        ]);
    }

    // ===== DISBURSEMENT =====
    public function disbursement()
    {
        $data['aggregators'] = $this->model->where('type', 'disbursement')->findAll();
        return view('Admin/aggregator_disbursement_settings', $data);
    }

    public function updateDisbursement()
    {
        $selected = $this->request->getPost('aggregator');
        $this->model->where(['type' => 'disbursement', 'is_primary' => true])
                    ->set(['is_primary' => false])
                    ->update();
        $this->model->where(['type' => 'disbursement', 'name' => $selected])
                    ->set(['is_primary' => true])
                    ->update();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Disbursement aggregator updated.',
        ]);
    }

    public function toggleDisbursement($name)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $agg = $this->model->where(['type' => 'disbursement', 'name' => $name])->first();
        $newStatus = !$agg['enabled'];
        $this->model->update($agg['id'], ['enabled' => $newStatus]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Status updated.',
            'enabled' => $newStatus,
        ]);
    }

}
