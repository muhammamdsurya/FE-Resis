<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserDataController extends Controller
{

    private $user;
    private $apiUrl;
    public function __construct()
    {
        $this->apiUrl = env('API_URL');
        $this->user = session('user');

    }
    public function completePost(Request $request)
    {

        function formatDateToISO($input) {
            $date = new DateTime($input, new DateTimeZone('UTC'));
            // Format ke dalam format yang diinginkan
            return $date->format('Y-m-d\TH:i:s') . 'Z';
        }

        try {
            // Construct the API URL for updating the category
            $apiUrl = $this->apiUrl . 'users/auth/data' ;
            $id =  $this->user['id'];

            // Make the PUT request to the external API
            $response = Http::withApiSession()->post($apiUrl, [
                // Assuming you need to send data with the request, include it here
                'person_id' => $id,
                'birth' => formatDateToISO($request->birth),
                'study_level' => $request->study_level,
                'institution' => $request->institution
            ]);

            if ($response->successful()) {
                // Jika permintaan berhasil, arahkan ke view dengan pesan sukses
                return redirect()->route('user.dashboard')->with([
                    'message' => 'Data berhasil ditambahkan.',
                    'details' => null
                ]);
            } else {
                // Tangani respons gagal dari API dan arahkan ke view dengan pesan error dan rincian
                return redirect()->route('user.data')->with([
                    'message' => 'Data gagal ditambahkan.',
                    'details' => $response->json() // Sertakan rincian respons API jika tersedia
                ]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
