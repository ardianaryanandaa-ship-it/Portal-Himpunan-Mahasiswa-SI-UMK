<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\AspirasiModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $db    = db_connect();
        $today = date('Y-m-d');

        $count = static function (string $table, array $where = []) use ($db): int {
            if (! $db->tableExists($table)) {
                return 0;
            }

            $builder = $db->table($table);
            if ($where !== []) {
                $builder->where($where);
            }

            return $builder->countAllResults();
        };

        $stats = [
            'aspirations_pending' => $count('aspirations', ['status' => 'pending', 'deleted_at' => null]),
            'aspirations_all'     => $count('aspirations', ['deleted_at' => null]),
            'news_published'      => $count('news', ['status' => 'published', 'deleted_at' => null]),
            'events_upcoming'     => $db->tableExists('events')
                ? $db->table('events')->where('start_at >=', $today . ' 00:00:00')->where('status', 'published')->where('deleted_at', null)->countAllResults()
                : 0,
            'registrations'       => $count('event_registrations', ['status' => 'registered']),
            'recruitment_pending' => $count('recruitment_applications', ['status' => 'pending']),
            'galleries'           => $count('galleries', ['is_active' => 1]),
            'users'               => $count('users', ['deleted_at' => null]),
        ];

        $latestAspirations = model(AspirasiModel::class)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        $upcomingEvents = [];
        if ($db->tableExists('events')) {
            $upcomingEvents = $db->table('events')
                ->where('start_at >=', $today . ' 00:00:00')
                ->where('status', 'published')
                ->where('deleted_at', null)
                ->orderBy('start_at', 'ASC')
                ->get(4)
                ->getResultArray();
        }

        return view('backend/dashboard/index', [
            'title'            => 'Dashboard',
            'stats'            => $stats,
            'latestAspirations'=> $latestAspirations,
            'upcomingEvents'   => $upcomingEvents,
        ]);
    }
}
