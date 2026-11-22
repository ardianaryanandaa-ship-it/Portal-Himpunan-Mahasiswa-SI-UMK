<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\DivisionModel;
use App\Models\WorkProgramModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class WorkProgramController extends BaseController
{
    public function index()
    {
        $status     = (string) $this->request->getGet('status');
        $divisionId = (int) $this->request->getGet('division_id');

        $model = model(WorkProgramModel::class)->withDivision();
        if (in_array($status, ['planned', 'ongoing', 'done'], true)) {
            $model->where('work_programs.status', $status);
        }
        if ($divisionId > 0) {
            $model->where('work_programs.division_id', $divisionId);
        }

        return view('backend/programs/index', [
            'title'      => 'Program Kerja',
            'programs'   => $model->orderBy('work_programs.target_date', 'ASC')->paginate(12, 'proker'),
            'pager'      => $model->pager,
            'divisions'  => model(DivisionModel::class)->orderBy('sort_order', 'ASC')->findAll(),
            'status'     => $status,
            'divisionId' => $divisionId,
        ]);
    }

    public function create()
    {
        return view('backend/programs/form', [
            'title'     => 'Tambah Program Kerja',
            'program'   => null,
            'divisions' => model(DivisionModel::class)->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(WorkProgramModel::class)->insert([
            'division_id' => $this->request->getPost('division_id') ?: null,
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'target_date' => $this->request->getPost('target_date') ?: null,
            'status'      => (string) $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('admin/proker'))->with('message', 'Program kerja berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $program = model(WorkProgramModel::class)->find($id);
        if ($program === null) {
            throw new PageNotFoundException('Program kerja tidak ditemukan.');
        }

        return view('backend/programs/form', [
            'title'     => 'Edit Program Kerja',
            'program'   => $program,
            'divisions' => model(DivisionModel::class)->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $model = model(WorkProgramModel::class);
        if ($model->find($id) === null) {
            throw new PageNotFoundException('Program kerja tidak ditemukan.');
        }

        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'division_id' => $this->request->getPost('division_id') ?: null,
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'target_date' => $this->request->getPost('target_date') ?: null,
            'status'      => (string) $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('admin/proker'))->with('message', 'Program kerja berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $model = model(WorkProgramModel::class);
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/proker'))->with('error', 'Program kerja tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/proker'))->with('message', 'Program kerja berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'title'       => 'required|max_length[200]',
            'target_date' => 'permit_empty|valid_date[Y-m-d]',
            'status'      => 'required|in_list[planned,ongoing,done]',
        ];
    }

    private function messages(): array
    {
        return [
            'title' => ['required' => 'Judul program kerja wajib diisi.', 'max_length' => 'Judul maksimal 200 karakter.'],
            'target_date' => ['valid_date' => 'Tanggal target tidak valid.'],
            'status' => ['required' => 'Status wajib dipilih.', 'in_list' => 'Status tidak valid.'],
        ];
    }
}
