<?php

namespace App\Filters;

use App\Models\PenggunaModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('url');
        $session = session();
        $userId  = $session->get('user_id');

        if (! $userId) {
            return redirect()->to(site_url('login'))->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Ambil ulang role dari database agar perubahan hak akses langsung berlaku.
        $user = model(PenggunaModel::class)
            ->select('users.id, users.username, users.full_name, roles.slug AS role_slug, roles.name AS role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.id', $userId)
            ->where('users.is_active', 1)
            ->first();

        if ($user === null) {
            $session->destroy();

            return redirect()->to(site_url('login'))->with('error', 'Sesi berakhir. Silakan masuk kembali.');
        }

        $session->set([
            'user_id'   => $user['id'],
            'user_name' => $user['full_name'],
            'username'  => $user['username'],
            'role_slug' => $user['role_slug'],
            'role_name' => $user['role_name'] ?: role_label($user['role_slug']),
        ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
