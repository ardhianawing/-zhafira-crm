<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::published()
            ->orderBy('tgl_post', 'desc')
            ->paginate(10);

        return view('marketing.news.index', compact('news'));
    }
}
