<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\HtmlSanitizer;
use App\Libraries\Slugger;
use App\Libraries\Uploader;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class EventController extends BaseController
{
    private const STATUSES = [
        'draft'     => 'Draf',
        'published' => 'Terbit',
        'closed'    => 'Ditutup',
    ];

    private function model(): EventModel
    {
        return model(EventModel::class);
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $status  = (string) $this->request->getGet('status');

        $model = $this->model()
            ->select('events.*, (SELECT COUNT(*) FROM event_registrations WHERE event_registrations.event_id = events.id) AS registration_count');

        if ($keyword !== '') {
            $model->groupStart()->like('title', $keyword)->orLike('location', $keyword)->groupEnd();
        }
        if (array_key_exists($status, self::STATUSES)) {
            $model->where('status', $status);
        }

        return view('backend/events/index', [
            'title'   => 'Event & Kegiatan',
            'events'  => $model->orderBy('start_at', 'DESC')->paginate(10, 'event'),
            'pager'   => $model->pager,
            'keyword' => $keyword,
            'status'  => $status,
            'statuses' => self::STATUSES,
        ]);
    }

    public function create()
    {
        return view('backend/events/form', [
            'title' => 'Tambah Event',
            'event' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $startAt = $this->normalizeDateTime((string) $this->request->getPost('start_at'));
        $endAt   = $this->normalizeDateTime((string) $this->request->getPost('end_at'));
        $deadline = $this->normalizeDateTime((string) $this->request->getPost('registration_deadline'));

        if ($endAt !== null && strtotime($endAt) < strtotime($startAt)) {
            return redirect()->back()->withInput()->with('error', 'Waktu selesai tidak boleh sebelum waktu mulai.');
        }
        if ($deadline !== null && strtotime($deadline) > strtotime($startAt)) {
            return redirect()->back()->withInput()->with('error', 'Batas pendaftaran tidak boleh melewati waktu mulai event.');
        }

        $model = $this->model();
        $title = trim((string) $this->request->getPost('title'));
        $data  = [
            'title'                 => $title,
            'slug'                  => Slugger::unique($model, $title),
            'description'           => HtmlSanitizer::clean((string) $this->request->getPost('description')),
            'location'              => trim((string) $this->request->getPost('location')),
            'start_at'              => $startAt,
            'end_at'                => $endAt,
            'registration_deadline' => $deadline,
            'quota'                 => $this->request->getPost('quota') !== '' ? (int) $this->request->getPost('quota') : null,
            'status'                => (string) $this->request->getPost('status'),
            'created_by'            => (int) session('user_id'),
        ];

        try {
            $poster = (new Uploader())->image($this->request->getFile('poster'), 'events');
            if ($poster !== null) {
                $data['poster'] = $poster;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->insert($data);

        return redirect()->to(site_url('admin/event'))->with('message', 'Event berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $event = $this->model()->find($id);
        if ($event === null) {
            throw new PageNotFoundException('Event tidak ditemukan.');
        }

        return view('backend/events/form', [
            'title' => 'Edit Event',
            'event' => $event,
        ]);
    }

    public function update(int $id)
    {
        $model = $this->model();
        $event = $model->find($id);
        if ($event === null) {
            throw new PageNotFoundException('Event tidak ditemukan.');
        }

        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $startAt  = $this->normalizeDateTime((string) $this->request->getPost('start_at'));
        $endAt    = $this->normalizeDateTime((string) $this->request->getPost('end_at'));
        $deadline = $this->normalizeDateTime((string) $this->request->getPost('registration_deadline'));

        if ($endAt !== null && strtotime($endAt) < strtotime($startAt)) {
            return redirect()->back()->withInput()->with('error', 'Waktu selesai tidak boleh sebelum waktu mulai.');
        }
        if ($deadline !== null && strtotime($deadline) > strtotime($startAt)) {
            return redirect()->back()->withInput()->with('error', 'Batas pendaftaran tidak boleh melewati waktu mulai event.');
        }

        $title = trim((string) $this->request->getPost('title'));
        $data  = [
            'title'                 => $title,
            'slug'                  => $event['title'] === $title ? $event['slug'] : Slugger::unique($model, $title, (int) $id),
            'description'           => HtmlSanitizer::clean((string) $this->request->getPost('description')),
            'location'              => trim((string) $this->request->getPost('location')),
            'start_at'              => $startAt,
            'end_at'                => $endAt,
            'registration_deadline' => $deadline,
            'quota'                 => $this->request->getPost('quota') !== '' ? (int) $this->request->getPost('quota') : null,
            'status'                => (string) $this->request->getPost('status'),
        ];

        try {
            $poster = (new Uploader())->image($this->request->getFile('poster'), 'events');
            if ($poster !== null) {
                $data['poster'] = $poster;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->update($id, $data);

        return redirect()->to(site_url('admin/event'))->with('message', 'Event berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $model = $this->model();
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/event'))->with('error', 'Event tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/event'))->with('message', 'Event berhasil dihapus.');
    }

    public function participants(int $id)
    {
        $event = $this->model()->find($id);
        if ($event === null) {
            throw new PageNotFoundException('Event tidak ditemukan.');
        }

        $keyword = trim((string) $this->request->getGet('q'));

        $model = model(EventRegistrationModel::class)->where('event_id', $id);
        if ($keyword !== '') {
            $model->groupStart()
                ->like('name', $keyword)
                ->orLike('nim', $keyword)
                ->orLike('email', $keyword)
                ->groupEnd();
        }

        return view('backend/events/participants', [
            'title'         => 'Peserta ' . $event['title'],
            'event'         => $event,
            'participants'  => $model->orderBy('created_at', 'ASC')->paginate(20, 'peserta'),
            'pager'         => $model->pager,
            'keyword'       => $keyword,
            'total'         => model(EventRegistrationModel::class)->where('event_id', $id)->countAllResults(),
        ]);
    }

    public function deleteParticipant(int $eventId, int $registrationId)
    {
        $event = $this->model()->find($eventId);
        if ($event === null) {
            throw new PageNotFoundException('Event tidak ditemukan.');
        }

        $registrations = model(EventRegistrationModel::class);
        $registration  = $registrations->where('id', $registrationId)->where('event_id', $eventId)->first();
        if ($registration !== null) {
            $registrations->delete($registrationId);
        }

        return redirect()->to(site_url('admin/event/' . $eventId . '/peserta'))->with('message', 'Data peserta berhasil dihapus.');
    }

    public function exportParticipants(int $id)
    {
        $event = $this->model()->find($id);
        if ($event === null) {
            throw new PageNotFoundException('Event tidak ditemukan.');
        }

        $rows = model(EventRegistrationModel::class)
            ->where('event_id', $id)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $filename = 'peserta-' . $event['slug'] . '-' . date('Ymd-His') . '.csv';

        $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'wb');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, ['No', 'Nama', 'NIM', 'Email', 'Telepon', 'Program Studi', 'Catatan', 'Waktu Daftar']);

        foreach ($rows as $index => $row) {
            fputcsv($output, [
                $index + 1,
                $this->csvCell($row['name']),
                $this->csvCell($row['nim']),
                $this->csvCell($row['email']),
                $this->csvCell($row['phone']),
                $this->csvCell((string) $row['study_program']),
                $this->csvCell((string) $row['notes']),
                $row['created_at'],
            ]);
        }

        fclose($output);

        return $this->response;
    }

    private function rules(): array
    {
        return [
            'title'                 => 'required|max_length[200]',
            'location'              => 'required|max_length[200]',
            'start_at'              => 'required',
            'end_at'                => 'permit_empty',
            'registration_deadline' => 'permit_empty',
            'quota'                 => 'permit_empty|is_natural_no_zero',
            'status'                => 'required|in_list[draft,published,closed]',
        ];
    }

    private function messages(): array
    {
        return [
            'title'    => ['required' => 'Judul event wajib diisi.', 'max_length' => 'Judul maksimal 200 karakter.'],
            'location' => ['required' => 'Lokasi event wajib diisi.', 'max_length' => 'Lokasi maksimal 200 karakter.'],
            'start_at' => ['required' => 'Waktu mulai event wajib diisi.'],
            'quota'    => ['is_natural_no_zero' => 'Kuota harus berupa angka lebih dari nol.'],
            'status'   => ['required' => 'Status wajib dipilih.', 'in_list' => 'Status tidak valid.'],
        ];
    }

    private function normalizeDateTime(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        $value = str_replace('T', ' ', $value);
        $time  = strtotime($value);

        return $time === false ? null : date('Y-m-d H:i:s', $time);
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
