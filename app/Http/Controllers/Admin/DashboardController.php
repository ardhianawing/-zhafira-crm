<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Global
        $stats = [
            'total_leads' => Lead::count(),
            'hot_leads' => Lead::where('status_prospek', 'Hot')->count(),
            'deal_leads' => Lead::where('status_prospek', 'Deal')->count(),
            'unassigned' => Lead::whereNull('assigned_to')->count(),
        ];

        // 2. Performa Tim Marketing (Data untuk Tabel Performa)
        $marketingPerformance = User::where('role', 'marketing')
            ->withCount([
                'leads as total' => function($query) {
                    $query->whereNotIn('status_prospek', ['Loss']);
                },
                'leads as hot' => function($query) {
                    $query->where('status_prospek', 'Hot');
                },
                'leads as deal' => function($query) {
                    $query->where('status_prospek', 'Deal');
                }
            ])
            ->get()
            ->sortByDesc('deal'); // Urutkan dari yang paling banyak closing (Deal)

        // 3. Data Chart Sederhana (Leads Masuk 7 Hari Terakhir)
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7Days[] = [
                'day' => $date->format('d M'),
                'count' => Lead::whereDate('created_at', $date)->count()
            ];
        }

        return view('admin.dashboard', compact('stats', 'marketingPerformance', 'last7Days'));
    }
}