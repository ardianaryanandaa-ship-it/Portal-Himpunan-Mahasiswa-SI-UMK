<?php

namespace App\Models;

use CodeIgniter\Model;

class RecruitmentPeriodModel extends Model
{
    protected $table            = 'recruitment_periods';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'title', 'slug', 'description', 'requirements', 'start_date', 'end_date', 'quota', 'status', 'created_by',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
