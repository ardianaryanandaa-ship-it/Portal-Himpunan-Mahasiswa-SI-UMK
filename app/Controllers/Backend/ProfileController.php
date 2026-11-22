<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Uploader;
use App\Models\PenggunaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class ProfileController extends BaseController
{
    public function index()
    {
        $user = model(PenggunaModel::class)
            ->select('users.*, roles.name AS role_name, roles.slug AS role_slug')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->find((int) session('user_id'));

        if ($user === null) {
            throw new PageNotFoundException('Profil tidak ditemukan.');
        }

        return view('backend/profile/index', [
            'title' => 'Profil Saya',
            'user'  => $user,
        ]);
    }

    public function update()
    {
        $id    = (int) session('user_id');
        $model = model(PenggunaModel::class);
        $user  = $model->find($id);
        if ($user === null) {
            throw new PageNotFoundException('Profil tidak ditemukan.');
        }

        $rules = [
            'full_name' => 'required|max_length[150]',
            'username'  => 'required|alpha_numeric_punct|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[150]',
        ];
        $messages = [
            'full_name' => ['required' => 'Nama lengkap wajib diisi.', 'max_length' => 'Nama lengkap maksimal 150 karakter.'],
            'username'  => ['required' => 'Username wajib diisi.', 'min_length' => 'Username minimal 3 karakter.'],
            'email'     => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $email    = trim((string) $this->request->getPost('email'));

        if ($model->withDeleted()->where('username', $username)->where('id !=', $id)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }
        if ($model->withDeleted()->where('email', $email)->where('id !=', $id)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Email sudah digunakan.');
        }

        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'username'  => $username,
            'email'     => $email,
        ];

        try {
            $avatar = (new Uploader())->image($this->request->getFile('avatar'), 'avatars');
            if ($avatar !== null) {
                $data['avatar'] = $avatar;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->update($id, $data);

        session()->set([
            'user_name' => $data['full_name'],
            'username'  => $data['username'],
        ]);

        return redirect()->to(site_url('admin/profil'))->with('message', 'Profil berhasil diperbarui.');
    }

    public function changePassword()
    {
        return view('backend/profile/password', [
            'title' => 'Ganti Kata Sandi',
        ]);
    }

    public function updatePassword()
    {
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]|max_length[255]',
            'new_password_confirm' => 'required|matches[new_password]',
        ];
        $messages = [
            'current_password' => ['required' => 'Kata sandi saat ini wajib diisi.'],
            'new_password' => [
                'required'   => 'Kata sandi baru wajib diisi.',
                'min_length' => 'Kata sandi baru minimal 8 karakter.',
            ],
            'new_password_confirm' => [
                'required' => 'Konfirmasi kata sandi wajib diisi.',
                'matches'  => 'Konfirmasi kata sandi tidak sama.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $model = model(PenggunaModel::class);
        $user  = $model->find((int) session('user_id'));
        if ($user === null) {
            throw new PageNotFoundException('Profil tidak ditemukan.');
        }

        if (! password_verify((string) $this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Kata sandi saat ini tidak sesuai.');
        }

        $model->update($user['id'], [
            'password' => password_hash((string) $this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(site_url('admin/profil'))->with('message', 'Kata sandi berhasil diperbarui.');
    }
}
