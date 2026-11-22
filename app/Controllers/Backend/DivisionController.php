<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\DivisionModel;
use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DivisionController extends BaseController
{
    public function index()
    {
        $divisions = model(DivisionModel::class)->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->findAll();

        $memberCounts = [];
        foreach (model(MemberModel::class)->select('division_id, COUNT(*) AS total')->groupBy('division_id')->findAll() as $row) {
            $memberCounts[(int) $row['division_id']] = (int) $row['total'];
        }

        return view('backend/divisions/index', [
            'title'        => 'Struktur Organisasi',
            'divisions'    => $divisions,
            'memberCounts' => $memberCounts,
        ]);
    }

    public function create()
    {
        return view('backend/divisions/form', [
            'title'    => 'Tambah Divisi',
            'division' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(DivisionModel::class)->insert([
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'sort_order'  => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to(site_url('admin/divisi'))->with('message', 'Divisi berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $division = model(DivisionModel::class)->find($id);
        if ($division === null) {
            throw new PageNotFoundException('Divisi tidak ditemukan.');
        }

        return view('backend/divisions/form', [
            'title'    => 'Edit Divisi',
            'division' => $division,
        ]);
    }

    public function update(int $id)
    {
        $model = model(DivisionModel::class);
        if ($model->find($id) === null) {
            throw new PageNotFoundException('Divisi tidak ditemukan.');
        }

        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'sort_order'  => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to(site_url('admin/divisi'))->with('message', 'Divisi berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $model = model(DivisionModel::class);
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/divisi'))->with('error', 'Divisi tidak ditemukan.');
        }

        if (model(MemberModel::class)->where('division_id', $id)->countAllResults() > 0) {
            return redirect()->back()->with('error', 'Divisi masih memiliki anggota. Pindahkan atau hapus anggotanya terlebih dahulu.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/divisi'))->with('message', 'Divisi berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'name'       => 'required|max_length[150]',
            'sort_order' => 'permit_empty|integer',
        ];
    }

    private function messages(): array
    {
        return [
            'name' => ['required' => 'Nama divisi wajib diisi.', 'max_length' => 'Nama divisi maksimal 150 karakter.'],
            'sort_order' => ['integer' => 'Urutan harus berupa angka.'],
        ];
    }
}
