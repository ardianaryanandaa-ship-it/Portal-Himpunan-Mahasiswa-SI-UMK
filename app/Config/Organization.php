<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Identitas organisasi. Semua nilai dibaca dari .env dengan prefix "organization.".
 */
class Organization extends BaseConfig
{
    public string $name = 'HIMA SI';
    public string $fullName = 'Himpunan Mahasiswa Sistem Informasi';
    public string $tagline = 'Bersama Membangun Generasi Digital';
    public string $period = '2025/2026';
    public string $university = 'Universitas Muria Kudus';
    public string $faculty = 'Fakultas Teknik';
    public string $programStudy = 'Sistem Informasi';
    public string $email = 'himasi@umk.ac.id';
    public string $whatsapp = '6281234567890';
    public string $address = 'Gedung PKM Lantai 2, Kampus UMK Gondangmanis, Bae, Kudus, Jawa Tengah 59327';
    public string $mapsUrl = 'https://maps.google.com/?q=Universitas+Muria+Kudus';
    public string $instagram = 'https://instagram.com/himasi.umk';
    public string $youtube = 'https://youtube.com/@himasi.umk';
    public string $github = 'https://github.com/himasi-umk';
    public string $tiktok = '';
    public string $logo = 'gambar/images-removebg-preview.png';
    public string $favicon = 'favicon.ico';

    /**
     * Nomor WhatsApp dalam format internasional tanpa tanda plus.
     */
    public function whatsappNumber(): string
    {
        $digits = preg_replace('/\D+/', '', $this->whatsapp) ?? '';

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }

    public function whatsappUrl(): string
    {
        return 'https://wa.me/' . $this->whatsappNumber();
    }

    public function logoUrl(): string
    {
        return base_url(ltrim($this->logo, '/'));
    }

    public function faviconUrl(): string
    {
        return base_url(ltrim($this->favicon, '/'));
    }

    /**
     * Daftar sosial media yang terisi di .env.
     *
     * @return array<string, string>
     */
    public function socialLinks(): array
    {
        return array_filter([
            'Instagram' => $this->instagram,
            'YouTube'   => $this->youtube,
            'GitHub'    => $this->github,
            'TikTok'    => $this->tiktok,
        ], static fn (string $url): bool => trim($url) !== '');
    }
}
