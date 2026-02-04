<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoLeadSeeder extends Seeder
{
    public function run(): void
    {
        $marketingUsers = User::where('role', 'marketing')->pluck('id')->toArray();

        $leads = [
            // New leads (unassigned)
            ['nama_customer' => 'Ahmad Fadli', 'no_hp' => '081234567890', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->addDays(3), 'assigned_to' => null],
            ['nama_customer' => 'Dewi Kartika', 'no_hp' => '082345678901', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->addDays(2), 'assigned_to' => null],
            ['nama_customer' => 'Rudi Hermawan', 'no_hp' => '083456789012', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->addDays(3), 'assigned_to' => null],

            // Marketing 1 leads
            ['nama_customer' => 'Siti Nurhaliza', 'no_hp' => '081111222233', 'status_prospek' => 'Cold', 'fase_followup' => 1, 'tgl_next_followup' => Carbon::today(), 'assigned_to' => $marketingUsers[0] ?? null, 'catatan_terakhir' => 'Sudah dihubungi, masih mempertimbangkan'],
            ['nama_customer' => 'Bambang Sutejo', 'no_hp' => '081222333344', 'status_prospek' => 'Warm', 'fase_followup' => 2, 'tgl_next_followup' => Carbon::today()->subDays(1), 'assigned_to' => $marketingUsers[0] ?? null, 'catatan_terakhir' => 'Tertarik dengan tipe villa C'],
            ['nama_customer' => 'Lisa Permata', 'no_hp' => '081333444455', 'status_prospek' => 'Hot', 'fase_followup' => 3, 'tgl_next_followup' => Carbon::today(), 'assigned_to' => $marketingUsers[0] ?? null, 'catatan_terakhir' => 'Akan survey minggu depan'],
            ['nama_customer' => 'Hendra Gunawan', 'no_hp' => '081444555566', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->addDays(3), 'assigned_to' => $marketingUsers[0] ?? null],
            ['nama_customer' => 'Fitri Rahayu', 'no_hp' => '081555666677', 'status_prospek' => 'Deal', 'fase_followup' => 3, 'tgl_next_followup' => null, 'assigned_to' => $marketingUsers[0] ?? null, 'catatan_terakhir' => 'Sudah booking villa tipe A'],

            // Marketing 2 leads
            ['nama_customer' => 'Joko Widodo', 'no_hp' => '082111222233', 'status_prospek' => 'Cold', 'fase_followup' => 1, 'tgl_next_followup' => Carbon::today()->subDays(2), 'assigned_to' => $marketingUsers[1] ?? null, 'catatan_terakhir' => 'Belum bisa dihubungi'],
            ['nama_customer' => 'Mega Putri', 'no_hp' => '082222333344', 'status_prospek' => 'Warm', 'fase_followup' => 2, 'tgl_next_followup' => Carbon::today(), 'assigned_to' => $marketingUsers[1] ?? null, 'catatan_terakhir' => 'Minta kirim brosur'],
            ['nama_customer' => 'Agus Salim', 'no_hp' => '082333444455', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->addDays(1), 'assigned_to' => $marketingUsers[1] ?? null],
            ['nama_customer' => 'Rina Marlina', 'no_hp' => '082444555566', 'status_prospek' => 'Hot', 'fase_followup' => 3, 'tgl_next_followup' => Carbon::today()->addDays(2), 'assigned_to' => $marketingUsers[1] ?? null, 'catatan_terakhir' => 'Negosiasi harga'],
            ['nama_customer' => 'Dedi Mulyadi', 'no_hp' => '082555666677', 'status_prospek' => 'Deal', 'fase_followup' => 3, 'tgl_next_followup' => null, 'assigned_to' => $marketingUsers[1] ?? null, 'catatan_terakhir' => 'Deal villa tipe B, DP sudah dibayar'],

            // Marketing 3 leads
            ['nama_customer' => 'Yuni Shara', 'no_hp' => '083111222233', 'status_prospek' => 'Warm', 'fase_followup' => 2, 'tgl_next_followup' => Carbon::today(), 'assigned_to' => $marketingUsers[2] ?? null, 'catatan_terakhir' => 'Tertarik tipe premium'],
            ['nama_customer' => 'Irfan Bachdim', 'no_hp' => '083222333344', 'status_prospek' => 'Cold', 'fase_followup' => 1, 'tgl_next_followup' => Carbon::today()->addDays(5), 'assigned_to' => $marketingUsers[2] ?? null],
            ['nama_customer' => 'Tika Panggabean', 'no_hp' => '083333444455', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->subDays(1), 'assigned_to' => $marketingUsers[2] ?? null],
            ['nama_customer' => 'Rizky Febian', 'no_hp' => '083444555566', 'status_prospek' => 'Hot', 'fase_followup' => 3, 'tgl_next_followup' => Carbon::today()->addDays(1), 'assigned_to' => $marketingUsers[2] ?? null, 'catatan_terakhir' => 'Akan bayar DP besok'],
            ['nama_customer' => 'Aurel Hermansyah', 'no_hp' => '083555666677', 'status_prospek' => 'Warm', 'fase_followup' => 2, 'tgl_next_followup' => Carbon::today()->addDays(3), 'assigned_to' => $marketingUsers[2] ?? null, 'catatan_terakhir' => 'Masih konsultasi dengan keluarga'],

            // Additional leads for variety
            ['nama_customer' => 'Atta Halilintar', 'no_hp' => '089111222233', 'status_prospek' => 'Hot', 'fase_followup' => 3, 'tgl_next_followup' => Carbon::today(), 'assigned_to' => $marketingUsers[0] ?? null, 'catatan_terakhir' => 'VIP customer, butuh villa besar'],
            ['nama_customer' => 'Raffi Ahmad', 'no_hp' => '089222333344', 'status_prospek' => 'Deal', 'fase_followup' => 3, 'tgl_next_followup' => null, 'assigned_to' => $marketingUsers[1] ?? null, 'catatan_terakhir' => 'Deal villa premium'],
            ['nama_customer' => 'Nagita Slavina', 'no_hp' => '089333444455', 'status_prospek' => 'Warm', 'fase_followup' => 2, 'tgl_next_followup' => Carbon::today()->subDays(3), 'assigned_to' => $marketingUsers[2] ?? null, 'catatan_terakhir' => 'Menunggu budget cair'],
            ['nama_customer' => 'Baim Wong', 'no_hp' => '089444555566', 'status_prospek' => 'New', 'fase_followup' => 0, 'tgl_next_followup' => Carbon::today()->addDays(3), 'assigned_to' => null],
            ['nama_customer' => 'Paula Verhoeven', 'no_hp' => '089555666677', 'status_prospek' => 'Cold', 'fase_followup' => 1, 'tgl_next_followup' => Carbon::today()->addDays(5), 'assigned_to' => $marketingUsers[0] ?? null],
            ['nama_customer' => 'Denny Cagur', 'no_hp' => '089666777788', 'status_prospek' => 'Warm', 'fase_followup' => 2, 'tgl_next_followup' => Carbon::today(), 'assigned_to' => $marketingUsers[1] ?? null, 'catatan_terakhir' => 'Minta lokasi villa yang strategis'],
        ];

        foreach ($leads as $leadData) {
            $lead = Lead::create([
                'nama_customer' => $leadData['nama_customer'],
                'no_hp' => $leadData['no_hp'],
                'status_prospek' => $leadData['status_prospek'],
                'fase_followup' => $leadData['fase_followup'],
                'tgl_next_followup' => $leadData['tgl_next_followup'],
                'catatan_terakhir' => $leadData['catatan_terakhir'] ?? null,
                'assigned_to' => $leadData['assigned_to'],
                'assigned_at' => $leadData['assigned_to'] ? now()->subDays(rand(1, 14)) : null,
            ]);
        }
    }
}
