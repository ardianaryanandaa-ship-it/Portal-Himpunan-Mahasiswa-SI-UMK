<?php

use Config\Organization;

if (! function_exists('current_user')) {
    /**
     * Data pengguna yang sedang masuk dari session.
     *
     * @return array<string, mixed>
     */
    function current_user(): array
    {
        return [
            'id'        => session('user_id'),
            'name'      => session('user_name'),
            'username'  => session('username'),
            'role_slug' => session('role_slug'),
            'role_name' => session('role_name'),
        ];
    }
}

if (! function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return (bool) session('user_id');
    }
}

if (! function_exists('has_role')) {
    /**
     * Cek apakah pengguna memiliki salah satu role yang diminta.
     */
    function has_role(string ...$slugs): bool
    {
        $role = (string) session('role_slug');

        return $role !== '' && in_array($role, $slugs, true);
    }
}

if (! function_exists('role_label')) {
    function role_label(?string $slug): string
    {
        return [
            'super-admin'   => 'Super Admin',
            'pengurus-inti' => 'Pengurus Inti',
            'kominfo'       => 'Kominfo',
            'panitia'       => 'Panitia',
        ][$slug ?? ''] ?? 'Pengguna';
    }
}

if (! function_exists('organization')) {
    function organization(): Organization
    {
        return config(Organization::class);
    }
}
