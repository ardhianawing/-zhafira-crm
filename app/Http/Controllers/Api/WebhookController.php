<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    // Terima data satu per satu dari Sheets
    public function handleGoogleSheets(Request $request)
    {
        if ($request->secret !== config('app.webhook_secret')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Cek duplikat berdasarkan Nomor HP
        $exists = Lead::where('no_hp', $request->nomor)->exists();

        if (!$exists) {
            Lead::create([
                'nama_customer' => $request->nama,
                'no_hp' => $request->nomor,
                'status_prospek' => $request->status ?? 'New',
                'sumber_lead' => 'Google Sheets',
                'keterangan' => $request->keterangan,
                'assigned_to' => null, // Tetap kosong agar Admin yang bagi lewat Rotator di web
            ]);
            return response()->json(['message' => 'Lead berhasil masuk ke antrean']);
        }

        return response()->json(['message' => 'Lead sudah ada (duplicate)']);
    }

    // Terima banyak data sekaligus dari Sheets
    public function handleBulkGoogleSheets(Request $request)
    {
        if ($request->secret !== config('app.webhook_secret')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $leads = $request->leads;
        $count = 0;

        foreach ($leads as $data) {
            $exists = Lead::where('no_hp', $data['nomor'])->exists();
            if (!$exists) {
                Lead::create([
                    'nama_customer' => $data['nama'],
                    'no_hp' => $data['nomor'],
                    'status_prospek' => $data['status'] ?? 'New',
                    'sumber_lead' => 'Google Sheets Bulk',
                    'keterangan' => $data['keterangan'],
                    'assigned_to' => null,
                ]);
                $count++;
            }
        }

        return response()->json(['message' => $count . ' Leads berhasil masuk ke antrean']);
    }

    // Terima data dari WhatsApp Bot
    public function handleWhatsApp(Request $request)
    {
        if ($request->secret !== config('app.webhook_secret')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Normalize phone number
        $phone = preg_replace('/[^0-9]/', '', $request->nomor);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        // Cek duplikat
        $exists = Lead::where('no_hp', $phone)
            ->orWhere('no_hp', '0' . substr($phone, 2))
            ->orWhere('no_hp', '+62' . substr($phone, 2))
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => true,
                'message' => 'Lead sudah ada (duplicate)',
                'action' => 'skipped'
            ]);
        }

        $lead = Lead::create([
            'nama_customer' => $request->nama,
            'no_hp' => $phone,
            'status_prospek' => 'New',
            'sumber_lead' => 'WhatsApp',
            'keterangan' => $request->pesan,
            'assigned_to' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lead berhasil masuk ke antrean',
            'lead_id' => $lead->id,
            'action' => 'created'
        ]);
    }
}