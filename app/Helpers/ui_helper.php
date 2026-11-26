<?php

if (! function_exists('status_badge')) {
    /**
     * Warna dan label badge untuk status program kerja.
     *
     * @return array{0: string, 1: string}
     */
    function status_badge(string $status): array
    {
        return [
            'planned' => ['warning', 'Direncanakan'],
            'ongoing' => ['primary', 'Berjalan'],
            'done'    => ['success', 'Selesai'],
        ][$status] ?? ['secondary', ucfirst($status)];
    }
}
