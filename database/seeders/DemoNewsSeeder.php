<?php

namespace Database\Seeders;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoNewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'judul' => 'Promo Awal Tahun 2026 - Diskon 15%!',
                'isi_berita' => "Selamat tahun baru 2026!\n\nZhafira Villa memberikan promo spesial diskon 15% untuk pembelian villa di bulan Januari-Februari 2026.\n\nSyarat dan ketentuan:\n- Berlaku untuk semua tipe villa\n- DP minimal 30%\n- Promo tidak dapat digabung dengan promo lain\n\nHubungi tim marketing kami untuk informasi lebih lanjut!",
                'tgl_post' => Carbon::today()->subDays(5),
            ],
            [
                'judul' => 'Grand Opening Villa Tipe Premium',
                'isi_berita' => "Dengan bangga kami memperkenalkan Villa Tipe Premium terbaru!\n\nFasilitas:\n- Luas tanah 500m2\n- 4 kamar tidur\n- Private pool\n- Garden view\n- Smart home system\n\nHarga launching special hanya Rp 2,5 Milyar.\n\nSegera hubungi tim marketing untuk booking!",
                'tgl_post' => Carbon::today()->subDays(10),
            ],
            [
                'judul' => 'Tips: Cara Efektif Follow-up Customer',
                'isi_berita' => "Berikut tips follow-up yang efektif:\n\n1. Selalu follow-up tepat waktu sesuai jadwal\n2. Gunakan template WhatsApp yang sudah disediakan\n3. Catat setiap hasil komunikasi\n4. Update status prospek sesuai perkembangan\n5. Jangan spam customer, ikuti siklus 3-5-7\n\nSemangat tim marketing!",
                'tgl_post' => Carbon::today()->subDays(15),
            ],
            [
                'judul' => 'Update Harga Villa Januari 2026',
                'isi_berita' => "Daftar harga villa terbaru:\n\nTipe A: Rp 850.000.000\nTipe B: Rp 1.200.000.000\nTipe C: Rp 1.500.000.000\nTipe Premium: Rp 2.500.000.000\n\nHarga sudah termasuk:\n- Sertifikat HGB\n- IMB\n- Listrik 2200 watt\n- Air PDAM\n\nInfo lebih lanjut hubungi admin.",
                'tgl_post' => Carbon::today(),
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
