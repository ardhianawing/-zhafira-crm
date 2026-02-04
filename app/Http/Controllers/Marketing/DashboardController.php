<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\News;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $today = Carbon::today()->format('Y-m-d');

        // 1. Variabel Statistik (Kotak-kotak atas)
        $totalLeads = Lead::assignedTo($userId)->count();
        $hotLeads = Lead::assignedTo($userId)->where('status_prospek', 'Hot')->count();
        $todaysTasks = Lead::assignedTo($userId)
            ->whereDate('tgl_next_followup', '=', $today)
            ->whereNotIn('status_prospek', ['Deal', 'Loss']) 
            ->count();
        $overdueLeads = Lead::assignedTo($userId)
            ->whereDate('tgl_next_followup', '<', $today)
            ->whereNotIn('status_prospek', ['Deal', 'Loss']) 
            ->count();

        // 2. Variabel Banner Notifikasi (Baris 5)
        $todayTasksCount = $todaysTasks + $overdueLeads;

        // 3. Variabel Follow-up List (Baris 121)
        $todaysFollowups = Lead::assignedTo($userId)
            ->whereDate('tgl_next_followup', '<=', $today)
            ->whereNotIn('status_prospek', ['Deal', 'Loss'])
            ->orderByRaw("CASE WHEN status_prospek = 'Hot' THEN 0 ELSE 1 END")
            ->orderBy('tgl_next_followup', 'asc')
            ->get();

        // 4. Variabel Berita (Baris 160) - Harus 'recentNews'
        $recentNews = News::latest()->limit(3)->get();

        // 5. Variabel Leads Terbaru
        $recentLeads = Lead::assignedTo($userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Kirim semuanya dengan nama yang pas sesuai permintaan file Blade
        return view('marketing.dashboard', compact(
            'totalLeads', 
            'hotLeads', 
            'todaysTasks', 
            'overdueLeads',
            'todayTasksCount', 
            'todaysFollowups', 
            'recentNews', // Nama ini sudah diperbaiki
            'recentLeads'
        ));
    }
}