<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // WAJIB ADA
use Illuminate\Support\Facades\Log;

class ResumeController extends Controller
{
    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }
    /**
     * Helper untuk mengambil session dengan format yang benar
     */
    private function getFormattedApiSession()
    {
        $apiSession = session('api_session');

        if (!$apiSession) {
            return null;
        }

        // Pastikan format mengandung prefix 'session='
        if (!str_contains($apiSession, 'session=')) {
            $apiSession = 'session=' . $apiSession;
        }

        return $apiSession;
    }

    public function analyze(Request $request)
    {
        $apiSession = $this->getFormattedApiSession();

        $request->validate([
            'resume' => 'required|mimes:pdf|max:2048',
            'experience_years' => 'required',
            'job_description' => 'required',
        ]);

        try {
            $file = $request->file('resume');

            $response = Http::timeout(120)
                ->withoutVerifying()
                ->withHeaders([
                    'Cookie' => $apiSession, // Formatnya sudah "session=xxxx" dari fungsi login
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

            // 2. Jika API mengembalikan 401, artinya session di server tujuan sudah expire
            if ($response->status() === 401) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Sesi API telah berakhir, silakan login ulang ke aplikasi.',
                    ],
                    401,
                );
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'API Error: ' . $response->status(),
                    'detail' => $response->json(),
                ],
                $response->status(),
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function getCredits()
    {
        $apiSession = $this->getFormattedApiSession();

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Cookie' => $apiSession])
                ->get('https://akuanalis.com/api/v1/credits'); // Sesuaikan endpoint aslinya

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['credits' => 0], 200);
        } catch (\Exception $e) {
            return response()->json(['credits' => 0], 500);
        }
    }

    public function history(Request $request)
    {
        $apiSession = $this->getFormattedApiSession();
        $page = $request->get('page', 1); // Ambil halaman saat ini, default 1

        $response = Http::withoutVerifying()
            ->withHeaders(['Cookie' => $apiSession])
            ->get('https://akuanalis.com/api/v1/resume/', [
                'page' => $page,
                'per_page' => 10,
            ]);

        //             // TAMBAHKAN INI UNTUK CEK DATA
        // dd($response->json());
        $data = $response->json();

        return view('user.resume', [
            'full_name' => $this->user['full_name'],
            'results' => $data['results'] ?? [],
            'total' => $data['total'] ?? 0,
            'per_page' => $data['per_page'] ?? 10,
            'current_page' => $data['page'] ?? 1,
        ]);
    }

    public function report($id)
    {
        $apiSession = $this->getFormattedApiSession();

        // 1. Ambil Detail Resume
        $resumeResponse = Http::withoutVerifying()
            ->withHeaders(['Cookie' => $apiSession])
            ->get("https://akuanalis.com/api/v1/resume/{$id}");

        if (!$resumeResponse->successful()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $resumeData = $resumeResponse->json();


        // 2. Ambil Rekomendasi Kursus (Berdasarkan ID kategori dari resume)
        $courses = [];
        if (!empty($resumeData['course_categories'])) {
            $categoryIds = collect($resumeData['course_categories'])->pluck('category_id')->toArray();

            $courseResponse = Http::withoutVerifying()
                ->withHeaders(['Cookie' => $apiSession])
                ->post('https://akuanalis.com/api/v1/courses/by-categories', [
                    'category_ids' => $categoryIds,
                ]);

            $coursesJson = $courseResponse->json();

            $courses = $coursesJson['data'] ?? [];
        }

        return view('user.report', [
            'full_name' => $this->user['full_name'],
            'data' => $resumeData,
            'courses' => $courses,
        ]);
    }
}
