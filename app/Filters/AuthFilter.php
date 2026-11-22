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
        $userId = $session->get('user_id');

        if (! $userId) {
            return redirect()->to(site_url('login'));
        }

        $user = model(PenggunaModel::class)
            ->select('id')
            ->where('id', $userId)
            ->where('is_active', 1)
            ->first();

        if ($user === null) {
            $session->destroy();

            return redirect()->to(site_url('login'))->with('error', 'Sesi berakhir. Silakan masuk kembali.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
