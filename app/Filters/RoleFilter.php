<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Contoh pemakaian pada route: role:super-admin,kominfo
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $allowed = is_array($arguments)
            ? $arguments
            : explode(',', (string) $arguments);

        $allowed = array_values(array_filter(array_map('trim', $allowed)));
        $role    = (string) session('role_slug');

        if ($role !== '' && in_array($role, $allowed, true)) {
            return null;
        }

        $response = service('response');

        if ($request->isAJAX()) {
            return $response->setStatusCode(403)->setJSON([
                'error' => 'Anda tidak memiliki hak akses untuk tindakan ini.',
            ]);
        }

        return $response
            ->setStatusCode(403)
            ->setBody(view('errors/html/error_403', [
                'title' => 'Akses Ditolak',
            ]));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
