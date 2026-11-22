<?php

namespace App\Models;

use CodeIgniter\Model;

class AspirasiModel extends Model
{
    protected $table            = 'aspirations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'nim',
        'email',
        'phone',
        'category',
        'subject',
        'message',
        'is_anonymous',
        'status',
        'is_published',
        'published_name',
        'published_role',
        'published_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
