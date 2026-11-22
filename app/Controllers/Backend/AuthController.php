<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        if (session()->get('user_id')) {
            return redirect()->to(site_url('admin'));
        }

        return view('backend/auth/login', [
            'title'      => 'Masuk - ' . config('Organization')->name,
            'identifier' => session()->getFlashdata('identifier') ?? '',
        ]);
    }

    public function attemptLogin()
    {
        $identifierInput = $this->request->getPost('identifier');
        $identifier      = is_string($identifierInput) ? trim($identifierInput) : '';
        $passwordInput   = $this->request->getPost('password');
        $password        = is_string($passwordInput) ? $passwordInput : '';

        $rules = [
            'identifier' => 'required|max_length[150]',
            'password'   => 'required|max_length[255]',
        ];
        $messages = [
            'identifier' => [
                'required' => 'Username atau email wajib diisi.',
                'max_length' => 'Username atau email terlalu panjang.',
            ],
            'password' => [
                'required' => 'Kata sandi wajib diisi.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                ->with('identifier', $identifier)
                ->with('errors', $this->validator->getErrors());
        }

        $throttlerKey = 'backend-login-' . sha1($this->request->getIPAddress());
        if (! service('throttler')->check($throttlerKey, 5, 300)) {
            return redirect()->back()
                ->with('identifier', $identifier)
                ->with('error', 'Terlalu banyak percobaan masuk. Coba lagi beberapa menit lagi.');
        }

        $userModel = model(PenggunaModel::class);
        $user      = $userModel->findByIdentifier($identifier);

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->with('identifier', $identifier)
                ->with('error', 'Username/email atau kata sandi tidak valid.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()
                ->with('identifier', $identifier)
                ->with('error', 'Akun Anda sedang dinonaktifkan. Hubungi Super Admin.');
        }

        service('throttler')->remove($throttlerKey);
        session()->regenerate(true);
        session()->set([
            'user_id'   => $user['id'],
            'user_name' => $user['full_name'],
            'username'  => $user['username'],
            'role_slug' => $user['role_slug'],
            'role_name' => $user['role_name'] ?: role_label($user['role_slug']),
        ]);

        $userModel->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);

        return redirect()->to(site_url('admin'))->with('message', 'Selamat datang, ' . $user['full_name'] . '.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'))->with('message', 'Anda telah keluar.');
    }
}
