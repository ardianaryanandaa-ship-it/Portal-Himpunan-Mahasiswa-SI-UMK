<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class Uploader
{
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const IMAGE_MIMES      = ['image/jpeg', 'image/png', 'image/webp'];
    private const DOC_EXTENSIONS   = ['pdf', 'doc', 'docx'];
    private const DOC_MIMES        = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    /**
     * Simpan gambar dengan nama acak. Mengembalikan path relatif terhadap public/.
     */
    public function image(?UploadedFile $file, string $folder): ?string
    {
        return $this->store($file, $folder, self::IMAGE_EXTENSIONS, self::IMAGE_MIMES, 2 * 1024 * 1024, 'Gambar');
    }

    /**
     * Simpan berkas pendaftaran (CV/berkas) dengan nama acak.
     */
    public function document(?UploadedFile $file, string $folder): ?string
    {
        return $this->store($file, $folder, self::DOC_EXTENSIONS, self::DOC_MIMES, 5 * 1024 * 1024, 'Berkas');
    }

    private function store(
        ?UploadedFile $file,
        string $folder,
        array $allowedExtensions,
        array $allowedMimes,
        int $maxBytes,
        string $label
    ): ?string {
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $file->isValid()) {
            throw new RuntimeException($label . ' gagal diunggah. Silakan coba lagi.');
        }

        if ($file->getSize() > $maxBytes) {
            throw new RuntimeException($label . ' terlalu besar. Maksimal ' . round($maxBytes / 1024 / 1024) . ' MB.');
        }

        $extension = strtolower($file->getClientExtension() ?: $file->getExtension());
        $mime      = (string) $file->getMimeType();

        if (! in_array($extension, $allowedExtensions, true) || ! in_array($mime, $allowedMimes, true)) {
            throw new RuntimeException($label . ' harus berformat ' . strtoupper(implode(', ', $allowedExtensions)) . '.');
        }

        $targetDirectory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . trim($folder, '/\\');
        if (! is_dir($targetDirectory) && ! mkdir($targetDirectory, 0755, true) && ! is_dir($targetDirectory)) {
            throw new RuntimeException('Folder unggahan tidak dapat dibuat.');
        }

        $name = $file->getRandomName();
        if (! $file->move($targetDirectory, $name)) {
            throw new RuntimeException($label . ' gagal disimpan.');
        }

        return 'uploads/' . trim($folder, '/\\') . '/' . $name;
    }
}
