<?php
namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
 protected $allowedFields = [
        'project_id', 'merchant_id', 'order_id', 'aggregator_ref_id', 
        'reff_id', 'amount', 'status', 'payment_method', 'provider', 
        'external_ref', 'created_at', 'updated_at', 'paid_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Enable timestamps for tracking
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'merchant_id' => 'required|integer',
        'order_id'    => 'required|alpha_numeric',
        'amount'      => 'required|decimal',
        'status'      => 'required|in_list[pending,completed,failed]',
        'payment_method' => 'required|alpha_numeric',
        'provider'    => 'required|alpha_numeric',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}