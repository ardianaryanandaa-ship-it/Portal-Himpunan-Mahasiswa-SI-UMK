<?php

namespace App\Controllers\Frontend;

use App\Models\WorkProgramModel;

class ProgramController extends BaseFrontendController
{
    public function index()
    {
        $programs = model(WorkProgramModel::class)
            ->withDivision()
            ->orderBy('work_programs.target_date', 'ASC')
            ->findAll();

        $grouped = ['ongoing' => [], 'planned' => [], 'done' => []];
        foreach ($programs as $program) {
            $grouped[$program['status']][] = $program;
        }

        return $this->render('frontend/pages/programs', [
            'title'    => 'Program Kerja - ' . config('Organization')->name,
            'grouped'  => $grouped,
            'total'    => count($programs),
        ]);
    }
}
