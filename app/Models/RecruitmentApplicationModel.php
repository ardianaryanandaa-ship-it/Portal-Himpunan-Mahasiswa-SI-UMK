<?php

namespace App\Models;

use CodeIgniter\Model;

class RecruitmentApplicationModel extends Model
{
    protected $table            = 'recruitment_applications';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'period_id', 'name', 'nim', 'email', 'phone', 'study_program', 'motivation', 'cv', 'status',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
