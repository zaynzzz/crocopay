<?php
// app/Controllers/Admin/AggregatorSettingController.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AggregatorSettingModel;

class AggregatorSettingController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AggregatorSettingModel();
    }

    public function index()
    {
        $data['aggregators'] = $this->model->findAll();
        return view('admin/aggregator_settings', $data);
    }

    public function update()
    {
        $selected = $this->request->getPost('aggregator');
        $this->model->where('is_primary', true)->set(['is_primary' => false])->update();
        $this->model->where('name', $selected)->set(['is_primary' => true])->update();

       return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Aggregator updated.',
    ]);
    }

   public function toggle($name)
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid request']);
    }

    $agg = $this->model->where('name', $name)->first();
    $newStatus = !$agg['enabled'];
    $this->model->update($agg['id'], ['enabled' => $newStatus]);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Status updated.',
        'enabled' => $newStatus,
    ]);
}
}
