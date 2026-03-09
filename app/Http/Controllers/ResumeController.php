<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // WAJIB ADA
use Illuminate\Support\Facades\Log;

class ResumeController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf|max:2048',
            'experience_years' => 'required',
            'job_description' => 'required',
        ]);

        try {
            $file = $request->file('resume');


            // AMBIL COOKIE DARI SNIPPET POSTMAN ANDA
            $sessionCookie = 'session=MTc3MzA3ODUxN3xEWDhFQVFMX2dBQUJFQUVRQUFEX2t2LUFBQU1HYzNSeWFXNW5EQXNBQ1hCbGNuTnZibDlwWkFaemRISnBibWNNSmdBa01HTXpZbVJtWWpjdFl6bGxNaTAwTVRVNExUa3dNek10TURsbFlqZzRNR0k1TmpJeUJuTjBjbWx1Wnd3SEFBVmxiV0ZwYkFaemRISnBibWNNRkFBU1oyeGxibTV4YkdGQVoyMWhhV3d1WTI5dEJuTjBjbWx1Wnd3R0FBUnliMnhsQm5OMGNtbHVad3dHQUFSMWMyVnl8pjH8L9H4z1kkrcCctojS8AvGSMTWVQdI_uJGd8EpCXY=';

                $apiSession = session('api_session');

            $response = Http::timeout(120)
                ->withoutVerifying()
                ->withHeaders([
                    'Cookie' => $apiSession, // WAJIB ADA AGAR TIDAK 401
                    'Accept' => 'application/json',
                ])
                ->attach('resume', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                ->post('https://akuanalis.com/api/v1/resume/analyze', [
                    'experience_years' => $request->experience_years,
                    'job_description' => $request->job_description,
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'match_percentage' => $response['match_percentage'] ?? 0,
                    'strength' => $response['strength'] ?? '-',
                    'recommendation' => $response['recommendation'] ?? '-',
                    'improvement_points' => $response['improvement_points'] ?? '-',
                ]);
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'API Error: ' . $response->status(),
                    'detail' => $response->json(), // Untuk melihat alasan ditolak
                ],
                $response->status(),
            );
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
