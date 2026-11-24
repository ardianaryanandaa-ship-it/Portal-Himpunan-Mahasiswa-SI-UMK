<?php

namespace App\Libraries;

use CodeIgniter\Model;

class Slugger
{
    /**
     * Membuat slug unik berdasarkan judul dan tabel model.
     */
    public static function unique(Model $model, string $title, ?int $ignoreId = null): string
    {
        $base = url_title($title, '-', true);
        if ($base === '') {
            $base = 'item-' . time();
        }

        $slug     = $base;
        $counter  = 2;
        $primary  = 'id';

        while (true) {
            $builder = $model->builder()->where('slug', $slug);
            if ($ignoreId !== null) {
                $builder->where($primary . ' !=', $ignoreId);
            }
            if ($builder->countAllResults() === 0) {
                return $slug;
            }

            $slug = $base . '-' . $counter;
            $counter++;
        }
    }
}
