<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
<<<<<<< HEAD
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['title', 'description', 'event_date', 'cover_image', 'is_published', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}
=======
    protected $table            = 'galleries';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'title', 'image', 'description', 'event_date', 'is_active', 'sort_order', 'created_by',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
>>>>>>> origin/nando
