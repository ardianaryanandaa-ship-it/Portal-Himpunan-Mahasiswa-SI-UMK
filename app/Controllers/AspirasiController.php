<?php

namespace App\Controllers;

use App\Models\AspirasiModel;

class AspirasiController extends BaseController
{
    public function store()
    {
        helper(['form', 'url']);

        $rules = [
            'name'     => 'permit_empty|max_length[150]',
            'nim'      => 'permit_empty|max_length[30]',
            'email'    => 'permit_empty|valid_email|max_length[150]',
            'phone'    => 'permit_empty|max_length[30]',
            'category' => 'required|in_list[kegiatan,akademik,organisasi,lainnya]',
            'subject'  => 'required|max_length[150]',
            'message'  => 'required|max_length[5000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('aspiration_errors', $this->validator->getErrors());
        }

        $isAnonymous = (string) $this->request->getPost('is_anonymous') === '1';
        $model = model(AspirasiModel::class);
        $model->insert([
            'name'         => $isAnonymous ? null : trim((string) $this->request->getPost('name')),
            'nim'          => trim((string) $this->request->getPost('nim')),
            'email'        => trim((string) $this->request->getPost('email')),
            'phone'        => trim((string) $this->request->getPost('phone')),
            'category'     => (string) $this->request->getPost('category'),
            'subject'      => trim((string) $this->request->getPost('subject')),
            'message'      => trim((string) $this->request->getPost('message')),
            'is_anonymous' => $isAnonymous ? 1 : 0,
            'status'       => 'pending',
            'is_published' => 0,
        ]);

        if ($model->errors()) {
            return redirect()->back()
                ->withInput()
                ->with('aspiration_error', 'Aspirasi belum dapat disimpan. Silakan coba lagi.');
        }

        return redirect()->to(site_url('/#aspirations'))
            ->with('aspiration_success', 'Terima kasih! Aspirasi Anda berhasil dikirim dan akan ditinjau oleh pengurus.');
    }
}
