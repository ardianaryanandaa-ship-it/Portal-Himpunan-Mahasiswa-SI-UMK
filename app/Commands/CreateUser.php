<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class CreateUser extends BaseCommand
{
    protected $group = 'Auth';
    protected $name = 'users:create';
    protected $description = 'Create an account that can access the content backend.';

    public function run(array $params)
    {
        $username = CLI::prompt('Username', null, 'required|alpha_numeric_punct|max_length[100]');
        $email = CLI::prompt('Email', null, 'required|valid_email|max_length[150]');
        $fullName = CLI::prompt('Nama lengkap', null, 'required|max_length[150]');
        $password = CLI::prompt('Kata sandi (minimal 12 karakter)', null, 'required|min_length[12]|max_length[255]');

        $db = Database::connect();
        $users = $db->table('users');
        $exists = $db->table('users')
            ->groupStart()
            ->where('username', $username)
            ->orWhere('email', $email)
            ->groupEnd()
            ->countAllResults();

        if ($exists > 0) {
            CLI::error('Username atau email sudah digunakan.');

            return;
        }

        $now = date('Y-m-d H:i:s');
        $inserted = $users->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'full_name' => $fullName,
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if (! $inserted) {
            throw new \RuntimeException('Akun gagal dibuat di database.');
        }

        CLI::write('Akun berhasil dibuat. Silakan masuk melalui halaman /login.', 'green');
    }
}
