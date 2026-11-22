<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkProgramModel extends Model
{
    protected $table            = 'work_programs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['division_id', 'title', 'description', 'target_date', 'status'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function withDivision()
    {
        return $this->select('work_programs.*, divisions.name AS division_name')
            ->join('divisions', 'divisions.id = work_programs.division_id', 'left');
    }
}
