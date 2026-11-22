<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        helper(['form', 'url']);

        if (session()->get('user_id')) {
            return redirect()->to(site_url('admin'));
        }

        return view('backend/auth/login', [
            'title' => 'Login - HIMA SI',
            'identifier' => session()->getFlashdata('identifier') ?? '',
        ]);
    }

    public function attemptLogin()
    {
        helper(['form', 'url']);

        $identifierInput = $this->request->getPost('identifier');
        $identifier = is_string($identifierInput) ? trim($identifierInput) : '';
        $rules = [
            'identifier' => 'required|max_length[150]',
            'password'   => 'required|max_length[255]',
        ];

        if (! $this->validate($rules)) {
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

        $passwordInput = $this->request->getPost('password');
        $password = is_string($passwordInput) ? $passwordInput : '';
        $userModel = model(PenggunaModel::class);
        $user = $userModel
            ->groupStart()
            ->where('username', $identifier)
            ->orWhere('email', $identifier)
            ->groupEnd()
            ->where('is_active', 1)
            ->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->with('identifier', $identifier)
                ->with('error', 'Username/email atau kata sandi tidak valid.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id'   => $user['id'],
            'user_name' => $user['full_name'],
        ]);

        if (! $userModel->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')])) {
            log_message('error', 'Gagal memperbarui last_login_at untuk pengguna ID ' . $user['id']);
        }

        return redirect()->to(site_url('admin'));
    }

    public function logout()
    {
        helper('url');
        session()->destroy();

        return redirect()->to(site_url('login'))->with('message', 'Anda telah keluar.');
    }
}