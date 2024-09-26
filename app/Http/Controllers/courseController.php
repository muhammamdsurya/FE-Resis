<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
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

    protected function fetchApiData($url)
    {
        $response = Http::withApiSession()->get($url);

        // Check if the response is successful
        if ($response->successful()) {
            return $response->json(); // Decode JSON response into an object
        } else {
            // Log the error with more context
            Log::error('Failed to fetch data from API: ' . $response->status() . ' - ' . $response->body());
        }
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


    public function getCourse(Request $request)
    {

        $title = 'Kelas Kami';
        $page = $request->input('page', 1); // Get the current page or default to 1

        $categories = $this->fetchApiData($this->apiUrl . 'courses/categories');
        $instructors = $this->fetchApiData($this->apiUrl . 'courses/instructors');
        $courses = $this->fetchApiData($this->apiUrl . 'courses?page=' . $page);

        return view('kelas', [
            "title" => $title,
            "courses" => $courses['data'],
            "pagination" => $courses['pagination'], // Get pagination data
            "categories" => json_encode($categories), // Encode the categories for JS
            "instructors" => json_encode($instructors), // Encode the categories for JS

        ]);
    }

    public  function detailKelas($id)
    {
        $title = 'Detail Kelas';

        $courses = $this->fetchApiData($this->apiUrl . 'courses/' . $id);

        return view('detailKelas', [
            "title" => $title,
            "courseId" => $id,
            "courses" => $courses, // Encode the categories for JS
        ]);
    }

    public function kelas(Request $request)

    {
        $price = (int) $request->input('price');

        $apiSession = session('api_session');

        // Definisikan headers
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession
        ];


        // Definisikan body sebagai array associative
        $body = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $price,
            'purpose'  => $request->purpose,
            'instructor_id' => $request->instructor_id,
        ];

        // Kirimkan request POST
        $response = Http::withHeaders($headers)->post($this->apiUrl . 'courses', $body);

        // Tampilkan response body
        if ($response->successful()) {

            return redirect()->route('admin.kelas')->with([
                'message' => 'Data berhasil ditambahkan.',
                'details' => null
            ]);
        }
    }


    public function editKelas (Request $request) {

        $apiSession = session('api_session');

        // Definisikan headers
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session='. $apiSession
        ];

        // Definisikan body sebagai array associative
        $body = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => (int) $request->price,
            'purpose'  => $request->purpose,
            'instructor_id' => $request->instructor_id,

        ];

        // Kirimkan request PUT
        $response = Http::withHeaders($headers)->put($this->apiUrl. 'courses/'. $request->id, $body);

        // Tampilkan response body
        if ($response->successful()) {
            return redirect()->route('admin.detailKelas')->with([
               'message' => 'Data berhasil diperbarui.',
                'details' => null
            ]);
        }
    }

    public function bundlePost(Request $request)

    {
        $price = (int) $request->input('price');

        $apiSession = session('api_session');

        // Definisikan headers
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession
        ];


        // Definisikan body sebagai array associative
        $body = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $price,
        ];

        // Kirimkan request POST
        $response = Http::withHeaders($headers)->post($this->apiUrl . 'courses/bundles', $body);

        // Tampilkan response body
        if ($response->successful()) {

            return redirect()->route('admin.kelas')->with([
                'message' => 'Data berhasil ditambahkan.',
                'details' => null
            ]);
        }
    }

    public function bundleEdit(Request $request, $id) // Get $id directly from the route parameter
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric', // Ensure price is a number
        ]);

        // Fetch the API session from the session
        $apiSession = session('api_session');

        // Define headers for the API request
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession,
        ];

        // Prepare the body of the request
        $body = [
            'name' => $request->input('name'), // Directly using input()
            'description' => $request->input('description'),
            'price' => (int) $request->input('price'), // Cast to int for price
        ];

        // Construct the API URL for updating the bundle
        $apiUrl = $this->apiUrl . 'courses/bundles/' . $id;

        // Send the PUT request to update the bundle
        $response = Http::withHeaders($headers)->put($apiUrl, $body);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->route('admin.bundling')->with('message', 'Data berhasil diperbarui.');
        } else {
            // Handle the case where the update was not successful
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui data.']);
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

    public function editCategory(Request $request, $id)
    {
        try {
            // Construct the API URL for updating the category
            $apiUrl = $this->apiUrl . 'courses/categories/' . $id;

            // Make the PUT request to the external API
            $response = Http::withApiSession()->put($apiUrl, [
                // Assuming you need to send data with the request, include it here
                'name' => $request->name // Example data if you are updating the category's name
            ]);

            if ($response->successful()) {
                // If the request was successful, return a success response
                return response()->json(['message' => 'Category successfully updated.'], 200);
            } else {
                // Handle failure response from the API
                return response()->json([
                    'error' => 'Failed to update category.',
                    'details' => $response->json() // Include API response details if available
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'error' => 'An error occurred while updating the category.',
                'exception' => $e->getMessage() // Provide exception message for debugging
            ], 500);
        }
    }
}
