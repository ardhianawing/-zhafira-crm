<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'isi_berita',
        'tgl_post',
    ];

    protected function casts(): array
    {
        return [
            'tgl_post' => 'date',
        ];
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('tgl_post', 'desc')->limit($limit);
    }

    public function scopePublished($query)
    {
        return $query->where('tgl_post', '<=', now()->toDateString());
    }
}
