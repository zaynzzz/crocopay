<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'merchant_id',
        'name',
        'api_key',
        'api_token',
        'secret_key',
        'balance',
        'webhook_url', 
        'description', 
        'created_at',
        'updated_at'
    ];
    public function incrementBalance($projectId, $amount)
    {
        return $this->builder()
            ->where('id', $projectId)
            ->set('balance', "balance + $amount", false)
            ->update();
    }

}

