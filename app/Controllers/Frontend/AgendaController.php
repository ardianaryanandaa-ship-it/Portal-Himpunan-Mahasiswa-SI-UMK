<?php

namespace App\Controllers\Frontend;

use App\Libraries\HtmlSanitizer;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AgendaController extends BaseFrontendController
{
    public function index()
    {
        $model = model(EventModel::class)
            ->where('status', 'published')
            ->orderBy('start_at', 'DESC');

        $events = $model->paginate(9, 'agenda');

        $counts = [];
        foreach ($events as $event) {
            $counts[(int) $event['id']] = model(EventRegistrationModel::class)
                ->where('event_id', $event['id'])
                ->countAllResults();
        }

        return $this->render('frontend/pages/agenda/index', [
            'title'  => 'Agenda Kegiatan - ' . config('Organization')->name,
            'events' => $events,
            'pager'  => $model->pager,
            'counts' => $counts,
        ]);
    }

    public function show(string $slug)
    {
        $event = $this->findPublished($slug);

        $registrationCount = model(EventRegistrationModel::class)
            ->where('event_id', $event['id'])
            ->countAllResults();

        $related = model(EventModel::class)
            ->where('status', 'published')
            ->where('id !=', $event['id'])
            ->orderBy('start_at', 'DESC')
            ->findAll(3);

        return $this->render('frontend/pages/agenda/show', [
            'title'             => $event['title'] . ' - ' . config('Organization')->name,
            'event'             => $event,
            'content'           => HtmlSanitizer::clean((string) $event['description']),
            'registrationCount' => $registrationCount,
            'registrationOpen'  => $this->registrationOpen($event, $registrationCount),
            'related'           => $related,
        ]);
    }

    public function register(string $slug)
    {
        $event = $this->findPublished($slug);

        $registrationCount = model(EventRegistrationModel::class)
            ->where('event_id', $event['id'])
            ->countAllResults();

        if (! $this->registrationOpen($event, $registrationCount)) {
            return redirect()->to(site_url('agenda/' . $event['slug']))
                ->with('agenda_error', 'Pendaftaran event ini sudah ditutup.');
        }

        $throttlerKey = 'public-agenda-' . sha1($this->request->getIPAddress());
        if (! service('throttler')->check($throttlerKey, 5, 300)) {
            return redirect()->back()->withInput()
                ->with('agenda_error', 'Terlalu banyak pengiriman dari jaringan ini. Coba lagi beberapa menit lagi.');
        }

        $rules = [
            'name'          => 'required|max_length[150]',
            'nim'           => 'required|max_length[30]',
            'email'         => 'required|valid_email|max_length[150]',
            'phone'         => 'required|max_length[30]',
            'study_program' => 'permit_empty|max_length[100]',
            'notes'         => 'permit_empty|max_length[1000]',
        ];
        $messages = [
            'name'  => ['required' => 'Nama lengkap wajib diisi.', 'max_length' => 'Nama maksimal 150 karakter.'],
            'nim'   => ['required' => 'NIM wajib diisi.', 'max_length' => 'NIM maksimal 30 karakter.'],
            'email' => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.', 'max_length' => 'Email maksimal 150 karakter.'],
            'phone' => ['required' => 'Nomor telepon wajib diisi.', 'max_length' => 'Nomor telepon maksimal 30 karakter.'],
            'notes' => ['max_length' => 'Catatan maksimal 1000 karakter.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('agenda_errors', $this->validator->getErrors());
        }

        $nim = trim((string) $this->request->getPost('nim'));
        $exists = model(EventRegistrationModel::class)
            ->where('event_id', $event['id'])
            ->where('nim', $nim)
            ->countAllResults() > 0;

        if ($exists) {
            return redirect()->back()->withInput()
                ->with('agenda_error', 'NIM tersebut sudah terdaftar pada event ini.');
        }

        if ($event['quota'] !== null && $registrationCount >= (int) $event['quota']) {
            return redirect()->back()->withInput()
                ->with('agenda_error', 'Kuota peserta event ini sudah penuh.');
        }

        model(EventRegistrationModel::class)->insert([
            'event_id'      => $event['id'],
            'name'          => trim((string) $this->request->getPost('name')),
            'nim'           => $nim,
            'email'         => trim((string) $this->request->getPost('email')),
            'phone'         => trim((string) $this->request->getPost('phone')),
            'study_program' => trim((string) $this->request->getPost('study_program')),
            'notes'         => trim((string) $this->request->getPost('notes')),
            'status'        => 'registered',
        ]);

        return redirect()->to(site_url('agenda/' . $event['slug']))
            ->with('agenda_success', 'Pendaftaran berhasil. Sampai jumpa di ' . $event['title'] . '!');
    }

    private function findPublished(string $slug): array
    {
        $event = model(EventModel::class)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if ($event === null) {
            throw new PageNotFoundException('Event tidak ditemukan.');
        }

        return $event;
    }

    private function registrationOpen(array $event, int $registrationCount): bool
    {
        if ($event['status'] !== 'published') {
            return false;
        }

        $now = time();
        if (strtotime($event['start_at']) <= $now) {
            return false;
        }

        if (! empty($event['registration_deadline']) && strtotime($event['registration_deadline']) < $now) {
            return false;
        }

        if ($event['quota'] !== null && $registrationCount >= (int) $event['quota']) {
            return false;
        }

        return true;
    }
}
