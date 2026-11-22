<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\HtmlSanitizer;
use App\Libraries\Slugger;
use App\Models\RecruitmentApplicationModel;
use App\Models\RecruitmentPeriodModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RecruitmentController extends BaseController
{
    private const PERIOD_STATUSES = [
        'draft'     => 'Draf',
        'published' => 'Terbit',
        'closed'    => 'Ditutup',
    ];

    private const APPLICATION_STATUSES = [
        'pending'  => 'Menunggu',
        'accepted' => 'Diterima',
        'rejected' => 'Ditolak',
    ];

    private function periods(): RecruitmentPeriodModel
    {
        return model(RecruitmentPeriodModel::class);
    }

    public function index()
    {
        $model = $this->periods()->select('recruitment_periods.*, (SELECT COUNT(*) FROM recruitment_applications WHERE recruitment_applications.period_id = recruitment_periods.id) AS application_count');

        return view('backend/recruitment/index', [
            'title'    => 'Rekrutmen Anggota',
            'periods'  => $model->orderBy('start_date', 'DESC')->paginate(10, 'rekrutmen'),
            'pager'    => $model->pager,
            'statuses' => self::PERIOD_STATUSES,
        ]);
    }

    public function create()
    {
        return view('backend/recruitment/form', [
            'title'  => 'Tambah Periode Rekrutmen',
            'period' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $start = (string) $this->request->getPost('start_date');
        $end   = (string) $this->request->getPost('end_date');
        if (strtotime($end) < strtotime($start)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
        }

        $model = $this->periods();
        $title = trim((string) $this->request->getPost('title'));

        $model->insert([
            'title'        => $title,
            'slug'         => Slugger::unique($model, $title),
            'description'  => HtmlSanitizer::clean((string) $this->request->getPost('description')),
            'requirements' => HtmlSanitizer::clean((string) $this->request->getPost('requirements')),
            'start_date'   => $start,
            'end_date'     => $end,
            'quota'        => $this->request->getPost('quota') !== '' ? (int) $this->request->getPost('quota') : null,
            'status'       => (string) $this->request->getPost('status'),
            'created_by'   => (int) session('user_id'),
        ]);

        return redirect()->to(site_url('admin/rekrutmen'))->with('message', 'Periode rekrutmen berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $period = $this->periods()->find($id);
        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        return view('backend/recruitment/form', [
            'title'  => 'Edit Periode Rekrutmen',
            'period' => $period,
        ]);
    }

    public function update(int $id)
    {
        $model  = $this->periods();
        $period = $model->find($id);
        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $start = (string) $this->request->getPost('start_date');
        $end   = (string) $this->request->getPost('end_date');
        if (strtotime($end) < strtotime($start)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
        }

        $title = trim((string) $this->request->getPost('title'));

        $model->update($id, [
            'title'        => $title,
            'slug'         => $period['title'] === $title ? $period['slug'] : Slugger::unique($model, $title, $id),
            'description'  => HtmlSanitizer::clean((string) $this->request->getPost('description')),
            'requirements' => HtmlSanitizer::clean((string) $this->request->getPost('requirements')),
            'start_date'   => $start,
            'end_date'     => $end,
            'quota'        => $this->request->getPost('quota') !== '' ? (int) $this->request->getPost('quota') : null,
            'status'       => (string) $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('admin/rekrutmen'))->with('message', 'Periode rekrutmen berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $model = $this->periods();
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/rekrutmen'))->with('error', 'Periode rekrutmen tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/rekrutmen'))->with('message', 'Periode rekrutmen berhasil dihapus.');
    }

    public function applications(int $id)
    {
        $period = $this->periods()->find($id);
        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        $status  = (string) $this->request->getGet('status');
        $keyword = trim((string) $this->request->getGet('q'));

        $model = model(RecruitmentApplicationModel::class)->where('period_id', $id);
        if (array_key_exists($status, self::APPLICATION_STATUSES)) {
            $model->where('status', $status);
        }
        if ($keyword !== '') {
            $model->groupStart()->like('name', $keyword)->orLike('nim', $keyword)->orLike('email', $keyword)->groupEnd();
        }

        return view('backend/recruitment/applications', [
            'title'      => 'Pendaftar ' . $period['title'],
            'period'     => $period,
            'applications' => $model->orderBy('created_at', 'ASC')->paginate(20, 'pendaftar'),
            'pager'      => $model->pager,
            'status'     => $status,
            'keyword'    => $keyword,
            'statuses'   => self::APPLICATION_STATUSES,
            'counts'     => [
                'all'      => model(RecruitmentApplicationModel::class)->where('period_id', $id)->countAllResults(),
                'pending'  => model(RecruitmentApplicationModel::class)->where('period_id', $id)->where('status', 'pending')->countAllResults(),
                'accepted' => model(RecruitmentApplicationModel::class)->where('period_id', $id)->where('status', 'accepted')->countAllResults(),
                'rejected' => model(RecruitmentApplicationModel::class)->where('period_id', $id)->where('status', 'rejected')->countAllResults(),
            ],
        ]);
    }

    public function application(int $id, int $applicationId)
    {
        $period = $this->periods()->find($id);
        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        $application = model(RecruitmentApplicationModel::class)
            ->where('id', $applicationId)
            ->where('period_id', $id)
            ->first();
        if ($application === null) {
            throw new PageNotFoundException('Pendaftar tidak ditemukan.');
        }

        return view('backend/recruitment/application', [
            'title'       => 'Detail Pendaftar',
            'period'      => $period,
            'application' => $application,
            'statuses'    => self::APPLICATION_STATUSES,
        ]);
    }

    public function updateApplicationStatus(int $id, int $applicationId)
    {
        $period = $this->periods()->find($id);
        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        $status = (string) $this->request->getPost('status');
        if (! array_key_exists($status, self::APPLICATION_STATUSES)) {
            return redirect()->back()->with('error', 'Status pendaftar tidak valid.');
        }

        $model       = model(RecruitmentApplicationModel::class);
        $application = $model->where('id', $applicationId)->where('period_id', $id)->first();
        if ($application === null) {
            throw new PageNotFoundException('Pendaftar tidak ditemukan.');
        }

        $model->update($applicationId, ['status' => $status]);

        return redirect()->to(site_url('admin/rekrutmen/' . $id . '/pendaftar/' . $applicationId))->with('message', 'Status pendaftar berhasil diperbarui.');
    }

    public function exportApplications(int $id)
    {
        $period = $this->periods()->find($id);
        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        $rows = model(RecruitmentApplicationModel::class)
            ->where('period_id', $id)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $filename = 'pendaftar-' . $period['slug'] . '-' . date('Ymd-His') . '.csv';

        $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'wb');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, ['No', 'Nama', 'NIM', 'Email', 'Telepon', 'Program Studi', 'Motivasi', 'CV', 'Status', 'Waktu Daftar']);

        foreach ($rows as $index => $row) {
            fputcsv($output, [
                $index + 1,
                $this->csvCell($row['name']),
                $this->csvCell($row['nim']),
                $this->csvCell($row['email']),
                $this->csvCell($row['phone']),
                $this->csvCell((string) $row['study_program']),
                $this->csvCell((string) $row['motivation']),
                $row['cv'] !== null ? base_url($row['cv']) : '',
                self::APPLICATION_STATUSES[$row['status']] ?? $row['status'],
                $row['created_at'],
            ]);
        }

        fclose($output);

        return $this->response;
    }

    private function rules(): array
    {
        return [
            'title'      => 'required|max_length[200]',
            'start_date' => 'required|valid_date[Y-m-d]',
            'end_date'   => 'required|valid_date[Y-m-d]',
            'quota'      => 'permit_empty|is_natural_no_zero',
            'status'     => 'required|in_list[draft,published,closed]',
        ];
    }

    private function messages(): array
    {
        return [
            'title'      => ['required' => 'Judul periode wajib diisi.', 'max_length' => 'Judul maksimal 200 karakter.'],
            'start_date' => ['required' => 'Tanggal mulai wajib diisi.', 'valid_date' => 'Tanggal mulai tidak valid.'],
            'end_date'   => ['required' => 'Tanggal selesai wajib diisi.', 'valid_date' => 'Tanggal selesai tidak valid.'],
            'quota'      => ['is_natural_no_zero' => 'Kuota harus berupa angka lebih dari nol.'],
            'status'     => ['required' => 'Status wajib dipilih.', 'in_list' => 'Status tidak valid.'],
        ];
    }

    private function csvCell(string $value): string
    {
        $value = trim($value);
        if ($value !== '' && in_array($value[0], ['=', '+', '-', '@'], true)) {
            return "'" . $value;
        }

        return $value;
    }
}
