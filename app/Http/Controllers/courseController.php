<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class courseController extends Controller
{
    private $user;
    private $apiUrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }
    public function jenjang(Request $request)
    {

        $response = Http::withApiSession()->post($this->apiUrl . 'courses/categories', [
            'name' => $request->name // Include other necessary data here
        ]);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add category.'
            ], $response->status());
        }
    }

    public function getJenjang(Request $request)
    {
        if ($request->ajax()) {
            $response = Http::get($this->apiUrl + 'courses/categories');

            if ($response->successful()) {
                return DataTables::of($response)
                    ->addColumn('action', function ($response) {
                        return '<a href="/categories/' . $response->id . '/delete" class="btn btn-danger">Hapus</a>
                            <a href="/categories/' . $response->id . '/edit" class="btn btn-success">Edit</a>';
                    })
                    ->make(true);
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ], $response->status());
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed load data.'
                ], $response->status());
            }
        }

        return view('admin.kelas'); // Return the view with the DataTables setup
    }

    public function kelas(Request $request)

    {
        $response = Http::withApiSession()->post($this->apiUrl . 'courses', [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->level,
            'price' => $request->price,
            'purpose'  => $request->purpose,
            'instructor_id' => $request->instrutor_id,
        ]);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add courses.'
            ], $response->status());
        }
    }


    public function destroy($id)
    {
        try {
            // Replace this with the actual URL of your API
            $apiUrl = $this->apiUrl . 'courses/categories/' . $id;

            // Make the DELETE request to the external API
            $response = Http::withApiSession()->delete($apiUrl);

            if ($response->successful()) {
                // If the request was successful, return a success response
                return response()->json(['message' => 'Category deleted successfully.'], 200);
            } else {
                // Handle failure response from the API
                return response()->json(['error' => 'Failed to delete category.'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
