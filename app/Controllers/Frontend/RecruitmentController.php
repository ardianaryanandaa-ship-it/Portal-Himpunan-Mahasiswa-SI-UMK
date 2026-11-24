<?php

namespace App\Controllers\Frontend;

use App\Libraries\HtmlSanitizer;
use App\Libraries\Uploader;
use App\Models\RecruitmentApplicationModel;
use App\Models\RecruitmentPeriodModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class RecruitmentController extends BaseFrontendController
{
    public function index()
    {
        $model = model(RecruitmentPeriodModel::class)
            ->where('status', 'published')
            ->orderBy('start_date', 'DESC');

        $periods = $model->paginate(9, 'rekrutmen');

        $counts = [];
        foreach ($periods as $period) {
            $counts[(int) $period['id']] = model(RecruitmentApplicationModel::class)
                ->where('period_id', $period['id'])
                ->countAllResults();
        }

        return $this->render('frontend/pages/recruitment/index', [
            'title'   => 'Rekrutmen Anggota - ' . config('Organization')->name,
            'periods' => $periods,
            'pager'   => $model->pager,
            'counts'  => $counts,
        ]);
    }

    public function show(string $slug)
    {
        $period = $this->findPublished($slug);

        $applicationCount = model(RecruitmentApplicationModel::class)
            ->where('period_id', $period['id'])
            ->countAllResults();

        return $this->render('frontend/pages/recruitment/show', [
            'title'            => $period['title'] . ' - ' . config('Organization')->name,
            'period'           => $period,
            'description'      => HtmlSanitizer::clean((string) $period['description']),
            'requirements'     => HtmlSanitizer::clean((string) $period['requirements']),
            'applicationCount' => $applicationCount,
            'isOpen'           => $this->isOpen($period, $applicationCount),
        ]);
    }

    public function apply(string $slug)
    {
        $period = $this->findPublished($slug);

        $applicationCount = model(RecruitmentApplicationModel::class)
            ->where('period_id', $period['id'])
            ->countAllResults();

        if (! $this->isOpen($period, $applicationCount)) {
            return redirect()->to(site_url('rekrutmen/' . $period['slug']))
                ->with('recruitment_error', 'Pendaftaran rekrutmen ini sudah ditutup.');
        }

        $throttlerKey = 'public-rekrutmen-' . sha1($this->request->getIPAddress());
        if (! service('throttler')->check($throttlerKey, 5, 300)) {
            return redirect()->back()->withInput()
                ->with('recruitment_error', 'Terlalu banyak pengiriman dari jaringan ini. Coba lagi beberapa menit lagi.');
        }

        $rules = [
            'name'          => 'required|max_length[150]',
            'nim'           => 'required|max_length[30]',
            'email'         => 'required|valid_email|max_length[150]',
            'phone'         => 'required|max_length[30]',
            'study_program' => 'permit_empty|max_length[100]',
            'motivation'    => 'required|max_length[3000]',
        ];
        $messages = [
            'name'       => ['required' => 'Nama lengkap wajib diisi.', 'max_length' => 'Nama maksimal 150 karakter.'],
            'nim'        => ['required' => 'NIM wajib diisi.', 'max_length' => 'NIM maksimal 30 karakter.'],
            'email'      => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.', 'max_length' => 'Email maksimal 150 karakter.'],
            'phone'      => ['required' => 'Nomor telepon wajib diisi.', 'max_length' => 'Nomor telepon maksimal 30 karakter.'],
            'motivation' => ['required' => 'Motivasi wajib diisi.', 'max_length' => 'Motivasi maksimal 3000 karakter.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('recruitment_errors', $this->validator->getErrors());
        }

        $nim    = trim((string) $this->request->getPost('nim'));
        $exists = model(RecruitmentApplicationModel::class)
            ->where('period_id', $period['id'])
            ->where('nim', $nim)
            ->countAllResults() > 0;

        if ($exists) {
            return redirect()->back()->withInput()
                ->with('recruitment_error', 'NIM tersebut sudah mendaftar pada periode ini.');
        }

        try {
            $cv = (new Uploader())->document($this->request->getFile('cv'), 'recruitment');
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('recruitment_error', $exception->getMessage());
        }

        if ($cv === null) {
            return redirect()->back()->withInput()
                ->with('recruitment_error', 'Berkas CV wajib diunggah (PDF, DOC, atau DOCX maksimal 5 MB).');
        }

        model(RecruitmentApplicationModel::class)->insert([
            'period_id'     => $period['id'],
            'name'          => trim((string) $this->request->getPost('name')),
            'nim'           => $nim,
            'email'         => trim((string) $this->request->getPost('email')),
            'phone'         => trim((string) $this->request->getPost('phone')),
            'study_program' => trim((string) $this->request->getPost('study_program')),
            'motivation'    => trim((string) $this->request->getPost('motivation')),
            'cv'            => $cv,
            'status'        => 'pending',
        ]);

        return redirect()->to(site_url('rekrutmen/' . $period['slug']))
            ->with('recruitment_success', 'Pendaftaran berhasil dikirim. Silakan tunggu informasi seleksi dari pengurus.');
    }

    private function findPublished(string $slug): array
    {
        $period = model(RecruitmentPeriodModel::class)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if ($period === null) {
            throw new PageNotFoundException('Periode rekrutmen tidak ditemukan.');
        }

        return $period;
    }

    private function isOpen(array $period, int $applicationCount): bool
    {
        if ($period['status'] !== 'published') {
            return false;
        }

        $today = date('Y-m-d');
        if ($today < $period['start_date'] || $today > $period['end_date']) {
            return false;
        }

        if ($period['quota'] !== null && $applicationCount >= (int) $period['quota']) {
            return false;
        }

        return true;
    }
}
