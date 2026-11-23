<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryItemModel extends Model
{
    protected $table = 'gallery_items';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['gallery_id', 'file_path', 'media_type', 'caption', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}
