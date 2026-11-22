<?php

namespace App\Models;

use CodeIgniter\Model;

class EventRegistrationModel extends Model
{
    protected $table            = 'event_registrations';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'event_id', 'name', 'nim', 'email', 'phone', 'study_program', 'notes', 'status',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
