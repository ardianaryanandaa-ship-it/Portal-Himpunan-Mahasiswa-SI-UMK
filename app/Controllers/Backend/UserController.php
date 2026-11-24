<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\PeranModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserController extends BaseController
{
    private function roles(): array
    {
        return model(PeranModel::class)->orderBy('id', 'ASC')->findAll();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        $model = model(PenggunaModel::class)
            ->select('users.*, roles.name AS role_name, roles.slug AS role_slug')
            ->join('roles', 'roles.id = users.role_id', 'left');

        if ($keyword !== '') {
            $model->groupStart()
                ->like('users.full_name', $keyword)
                ->orLike('users.username', $keyword)
                ->orLike('users.email', $keyword)
                ->groupEnd();
        }

        return view('backend/users/index', [
            'title'   => 'Kelola Pengguna',
            'users'   => $model->orderBy('users.full_name', 'ASC')->paginate(10, 'users'),
            'pager'   => $model->pager,
            'keyword' => $keyword,
        ]);
    }

    public function create()
    {
        return view('backend/users/form', [
            'title' => 'Tambah Pengguna',
            'user'  => null,
            'roles' => $this->roles(),
        ]);
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|max_length[150]',
            'username'  => 'required|alpha_numeric_punct|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[150]',
            'role_id'   => 'required|is_natural_no_zero',
            'password'  => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];
        $messages = $this->messages();

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model    = model(PenggunaModel::class);
        $username = trim((string) $this->request->getPost('username'));
        $email    = trim((string) $this->request->getPost('email'));

        if ($model->withDeleted()->where('username', $username)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }
        if ($model->withDeleted()->where('email', $email)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Email sudah digunakan.');
        }

        $model->insert([
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'username'  => $username,
            'email'     => $email,
            'role_id'   => (int) $this->request->getPost('role_id'),
            'password'  => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1,
        ]);

        return redirect()->to(site_url('admin/pengguna'))->with('message', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = model(PenggunaModel::class)->find($id);
        if ($user === null) {
            throw new PageNotFoundException('Pengguna tidak ditemukan.');
        }

        return view('backend/users/form', [
            'title' => 'Edit Pengguna',
            'user'  => $user,
            'roles' => $this->roles(),
        ]);
    }

    public function update(int $id)
    {
        $model = model(PenggunaModel::class);
        $user  = $model->find($id);
        if ($user === null) {
            throw new PageNotFoundException('Pengguna tidak ditemukan.');
        }

        $rules = [
            'full_name' => 'required|max_length[150]',
            'username'  => 'required|alpha_numeric_punct|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[150]',
            'role_id'   => 'required|is_natural_no_zero',
        ];
        if (! $this->validate($rules, $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $email    = trim((string) $this->request->getPost('email'));

        if ($model->withDeleted()->where('username', $username)->where('id !=', $id)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan pengguna lain.');
        }
        if ($model->withDeleted()->where('email', $email)->where('id !=', $id)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'Email sudah digunakan pengguna lain.');
        }

        $isActive = (int) $this->request->getPost('is_active') === 1 ? 1 : 0;
        if ($id === (int) session('user_id') && $isActive === 0) {
            return redirect()->back()->withInput()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'username'  => $username,
            'email'     => $email,
            'role_id'   => (int) $this->request->getPost('role_id'),
            'is_active' => $isActive,
        ];

        $newPassword = (string) $this->request->getPost('password');
        if ($newPassword !== '') {
            if (mb_strlen($newPassword) < 8) {
                return redirect()->back()->withInput()->with('error', 'Kata sandi baru minimal 8 karakter.');
            }
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to(site_url('admin/pengguna'))->with('message', 'Data pengguna berhasil diperbarui.');
    }

    public function toggleActive(int $id)
    {
        $model = model(PenggunaModel::class);
        $user  = $model->find($id);
        if ($user === null) {
            throw new PageNotFoundException('Pengguna tidak ditemukan.');
        }

        if ($id === (int) session('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $model->update($id, ['is_active' => (int) $user['is_active'] === 1 ? 0 : 1]);

        return redirect()->back()->with('message', 'Status pengguna berhasil diubah.');
    }

    public function delete(int $id)
    {
        if ($id === (int) session('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $model = model(PenggunaModel::class);
        if ($model->find($id) === null) {
            throw new PageNotFoundException('Pengguna tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/pengguna'))->with('message', 'Pengguna berhasil dihapus.');
    }

    public function resetPassword(int $id)
    {
        $model = model(PenggunaModel::class);
        if ($model->find($id) === null) {
            throw new PageNotFoundException('Pengguna tidak ditemukan.');
        }

        $rules = [
            'new_password'     => 'required|min_length[8]|max_length[255]',
            'new_password_confirm' => 'required|matches[new_password]',
        ];
        $messages = [
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

        $model->update($id, [
            'password' => password_hash((string) $this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->back()->with('message', 'Kata sandi pengguna berhasil direset.');
    }

    private function messages(): array
    {
        return [
            'full_name' => ['required' => 'Nama lengkap wajib diisi.', 'max_length' => 'Nama lengkap maksimal 150 karakter.'],
            'username'  => [
                'required' => 'Username wajib diisi.',
                'min_length' => 'Username minimal 3 karakter.',
                'max_length' => 'Username maksimal 100 karakter.',
                'alpha_numeric_punct' => 'Username hanya boleh berisi huruf, angka, dan tanda baca.',
            ],
            'email' => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.'],
            'role_id' => ['required' => 'Role wajib dipilih.', 'is_natural_no_zero' => 'Role tidak valid.'],
            'password' => ['required' => 'Kata sandi wajib diisi.', 'min_length' => 'Kata sandi minimal 8 karakter.'],
            'password_confirm' => ['required' => 'Konfirmasi kata sandi wajib diisi.', 'matches' => 'Konfirmasi kata sandi tidak sama.'],
        ];
    }
}
