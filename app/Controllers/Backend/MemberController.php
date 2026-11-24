<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Uploader;
use App\Models\DivisionModel;
use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class MemberController extends BaseController
{
    public function index()
    {
        $divisionId = (int) $this->request->getGet('division_id');
        $keyword    = trim((string) $this->request->getGet('q'));

        $model = model(MemberModel::class)
            ->select('members.*, divisions.name AS division_name')
            ->join('divisions', 'divisions.id = members.division_id', 'left');

        if ($divisionId > 0) {
            $model->where('members.division_id', $divisionId);
        }
        if ($keyword !== '') {
            $model->groupStart()->like('members.name', $keyword)->orLike('members.position', $keyword)->groupEnd();
        }

        return view('backend/members/index', [
            'title'      => 'Anggota Organisasi',
            'members'    => $model->orderBy('members.division_id', 'ASC')->orderBy('members.sort_order', 'ASC')->paginate(15, 'anggota'),
            'pager'      => $model->pager,
            'divisions'  => model(DivisionModel::class)->orderBy('sort_order', 'ASC')->findAll(),
            'divisionId' => $divisionId,
            'keyword'    => $keyword,
        ]);
    }

    public function create()
    {
        return view('backend/members/form', [
            'title'     => 'Tambah Anggota',
            'member'    => null,
            'divisions' => model(DivisionModel::class)->orderBy('sort_order', 'ASC')->findAll(),
            'selectedDivision' => (int) $this->request->getGet('division_id'),
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'division_id' => (int) $this->request->getPost('division_id'),
            'name'        => trim((string) $this->request->getPost('name')),
            'position'    => trim((string) $this->request->getPost('position')),
            'period'      => trim((string) $this->request->getPost('period')),
            'sort_order'  => (int) $this->request->getPost('sort_order'),
            'is_active'   => (int) $this->request->getPost('is_active') === 1 ? 1 : 0,
        ];

        try {
            $photo = (new Uploader())->image($this->request->getFile('photo'), 'members');
            if ($photo !== null) {
                $data['photo'] = $photo;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        model(MemberModel::class)->insert($data);

        return redirect()->to(site_url('admin/divisi/anggota'))->with('message', 'Anggota berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $member = model(MemberModel::class)->find($id);
        if ($member === null) {
            throw new PageNotFoundException('Anggota tidak ditemukan.');
        }

        return view('backend/members/form', [
            'title'     => 'Edit Anggota',
            'member'    => $member,
            'divisions' => model(DivisionModel::class)->orderBy('sort_order', 'ASC')->findAll(),
            'selectedDivision' => (int) $member['division_id'],
        ]);
    }

    public function update(int $id)
    {
        $model  = model(MemberModel::class);
        $member = $model->find($id);
        if ($member === null) {
            throw new PageNotFoundException('Anggota tidak ditemukan.');
        }

        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'division_id' => (int) $this->request->getPost('division_id'),
            'name'        => trim((string) $this->request->getPost('name')),
            'position'    => trim((string) $this->request->getPost('position')),
            'period'      => trim((string) $this->request->getPost('period')),
            'sort_order'  => (int) $this->request->getPost('sort_order'),
            'is_active'   => (int) $this->request->getPost('is_active') === 1 ? 1 : 0,
        ];

        try {
            $photo = (new Uploader())->image($this->request->getFile('photo'), 'members');
            if ($photo !== null) {
                $data['photo'] = $photo;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->update($id, $data);

        return redirect()->to(site_url('admin/divisi/anggota'))->with('message', 'Anggota berhasil diperbarui.');
    }

    public function toggleActive(int $id)
    {
        $model  = model(MemberModel::class);
        $member = $model->find($id);
        if ($member === null) {
            throw new PageNotFoundException('Anggota tidak ditemukan.');
        }

        $model->update($id, ['is_active' => (int) $member['is_active'] === 1 ? 0 : 1]);

        return redirect()->back()->with('message', 'Status anggota berhasil diubah.');
    }

    public function delete(int $id)
    {
        $model = model(MemberModel::class);
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/divisi/anggota'))->with('error', 'Anggota tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/divisi/anggota'))->with('message', 'Anggota berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'division_id' => 'required|is_natural_no_zero',
            'name'        => 'required|max_length[150]',
            'position'    => 'required|max_length[150]',
            'period'      => 'permit_empty|max_length[50]',
            'sort_order'  => 'permit_empty|integer',
        ];
    }

    private function messages(): array
    {
        return [
            'division_id' => ['required' => 'Divisi wajib dipilih.', 'is_natural_no_zero' => 'Divisi tidak valid.'],
            'name' => ['required' => 'Nama anggota wajib diisi.', 'max_length' => 'Nama maksimal 150 karakter.'],
            'position' => ['required' => 'Jabatan wajib diisi.', 'max_length' => 'Jabatan maksimal 150 karakter.'],
        ];
    }
}
