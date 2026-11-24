<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'username',
        'email',
        'password',
        'full_name',
        'avatar',
        'is_active',
        'last_login_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username'  => 'required|alpha_numeric_punct|min_length[3]|max_length[100]',
        'email'     => 'required|valid_email|max_length[150]',
        'full_name' => 'required|max_length[150]',
        'role_id'   => 'required|integer',
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'Username wajib diisi.',
            'min_length' => 'Username minimal 3 karakter.',
            'max_length' => 'Username maksimal 100 karakter.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
        'full_name' => [
            'required' => 'Nama lengkap wajib diisi.',
        ],
        'role_id' => [
            'required' => 'Role wajib dipilih.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function findByIdentifier(string $identifier): ?array
    {
        return $this->select('users.*, roles.slug AS role_slug, roles.name AS role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->groupStart()
            ->where('users.username', $identifier)
            ->orWhere('users.email', $identifier)
            ->groupEnd()
            ->first();
    }
}
