<?php

namespace App\Controllers\Frontend;

use App\Models\DivisionModel;
use App\Models\MemberModel;

class StructureController extends BaseFrontendController
{
    public function index()
    {
        $divisions = model(DivisionModel::class)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $members = model(MemberModel::class)
            ->select('members.*, divisions.name AS division_name')
            ->join('divisions', 'divisions.id = members.division_id', 'left')
            ->where('members.is_active', 1)
            ->orderBy('members.sort_order', 'ASC')
            ->orderBy('members.name', 'ASC')
            ->findAll();

        $grouped = [];
        foreach ($members as $member) {
            $key = $member['division_id'] !== null ? (int) $member['division_id'] : 0;
            $grouped[$key][] = $member;
        }

        return $this->render('frontend/pages/structure', [
            'title'     => 'Struktur Organisasi - ' . config('Organization')->name,
            'divisions' => $divisions,
            'grouped'   => $grouped,
        ]);
    }
}
