<?php

namespace App\Models;

use CodeIgniter\Model;

class DivisionModel extends Model
{
    protected $table            = 'divisions';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'description', 'sort_order'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
