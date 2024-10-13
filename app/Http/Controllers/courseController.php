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

        // Check if the first API request was successful
        if ($response->successful()) {
            // Get the new bundle ID from the response
            $courseId = $response->json()['course']['id'];

            // Prepare for the image upload (second API request)
            if ($request->hasFile('image')) {
                // Use the attach method for a multipart/form-data request
                $imageResponse = Http::withHeaders(['Cookie' => 'session=' . $apiSession])
                    ->attach(
                        'thumbnail_image',
                        fopen($request->file('image')->getRealPath(), 'r'), // Open the file for reading
                        $request->file('image')->getClientOriginalName() // Get the original filename
                    )
                    ->put($this->apiUrl . "courses/{$courseId}/thumbnail");

                // Check if the image upload was successful
                if (!$imageResponse->successful()) {
                    return redirect()->route('admin.kelas')->with('error', 'Image upload failed: ' . $imageResponse->body());
                }
            }

            return redirect()->route('admin.kelas')->with([
                'message' => 'Data berhasil ditambahkan.',
                'details' => null
            ]);
        }
    }


    public function editKelas(Request $request, $id)
    {

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
            'price' => (int) $request->price,
            'purpose'  => $request->purpose,
            'instructor_id' => $request->instructor_id,

        ];

        $apiUrl = $this->apiUrl . 'courses/' . $id;

        // Kirimkan request PUT
        $response = Http::withHeaders($headers)->put($apiUrl, $body);

        if ($response->successful()) {
            // Check if a new thumbnail was uploaded
            // Prepare for the image upload (second API request)
            if ($request->hasFile('image')) {
                // Use the attach method for a multipart/form-data request
                $imageResponse = Http::withHeaders(['Cookie' => 'session=' . $apiSession])
                    ->attach(
                        'thumbnail_image',
                        fopen($request->file('image')->getRealPath(), 'r'), // Open the file for reading
                        $request->file('image')->getClientOriginalName() // Get the original filename
                    )
                    ->put($this->apiUrl . "courses/" . $id . "/thumbnail");

                // Check if the image upload was successful

                // Cek respons API
                if ($imageResponse->successful()) {
                    // Debugging: Print response body to see if image upload succeeded
                    return back()->with('message', 'Data dan thumbnail berhasil diperbarui.');
                } else {
                    return back()->withErrors(['msg' => 'Data berhasil diperbarui, tetapi gagal mengunggah thumbnail.']);
                }
            }
            // If no thumbnail is uploaded, only update the body
            return back()->with('message', 'Data berhasil diperbarui.');
        } else {
            // Handle case where the bundle data update fails
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui data.']);
        }
    }
    public function bundlePost(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Validate the image
        ]);

        // Initialize API session
        $apiSession = session('api_session');

        // Define headers for the API requests
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession,
        ];

        // Prepare the body for the first API request as JSON
        $body = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => (int) $request->input('price'),
        ];

        // Send the POST request for creating a bundle (first API request)
        $response = Http::withHeaders($headers)->post($this->apiUrl . 'courses/bundles', $body);

        // Check if the first API request was successful
        if ($response->successful()) {
            // Get the new bundle ID from the response
            $courseBundleId = $response->json()['id'];

            // Prepare for the image upload (second API request)
            if ($request->hasFile('image')) {
                // Use the attach method for a multipart/form-data request
                $imageResponse = Http::withHeaders(['Cookie' => 'session=' . $apiSession])
                    ->attach(
                        'thumbnail_image',
                        fopen($request->file('image')->getRealPath(), 'r'), // Open the file for reading
                        $request->file('image')->getClientOriginalName() // Get the original filename
                    )
                    ->put($this->apiUrl . "courses/bundles/{$courseBundleId}/thumbnail");

                // Check if the image upload was successful
                if (!$imageResponse->successful()) {
                    return redirect()->route('admin.bundling')->with('error', 'Image upload failed: ' . $imageResponse->body());
                }
            }

            return redirect()->route('admin.bundling')->with('message', 'Data berhasil ditambahkan.');
        }

        return redirect()->route('admin.bundling')->with('error', 'Failed to create bundle: ' . $response->body());
    }


    public function bundleEdit(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric', // Validate price as numeric
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar (opsional)
        ]);

        // Fetch the API session from the session
        $apiSession = session('api_session');

        // Define headers for the API request
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession,
        ];

        // Prepare the body of the request for updating the bundle data
        $body = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => (int) $request->input('price'),
        ];

        // API URL for updating the bundle data
        $apiUrl = $this->apiUrl . 'courses/bundles/' . $id;

        // Send the PUT request to update the bundle data
        $response = Http::withHeaders($headers)->put($apiUrl, $body);

        // Check if the bundle data update was successful
        if ($response->successful()) {
            // Check if a new thumbnail was uploaded
            // Prepare for the image upload (second API request)
            if ($request->hasFile('image')) {
                // Use the attach method for a multipart/form-data request
                $imageResponse = Http::withHeaders(['Cookie' => 'session=' . $apiSession])
                    ->attach(
                        'thumbnail_image',
                        fopen($request->file('image')->getRealPath(), 'r'), // Open the file for reading
                        $request->file('image')->getClientOriginalName() // Get the original filename
                    )
                    ->put($this->apiUrl . "courses/bundles/" . $id . "/thumbnail");

                // Check if the image upload was successful

                // Cek respons API
                if ($imageResponse->successful()) {
                    // Debugging: Print response body to see if image upload succeeded
                    return back()->with('message', 'Data dan thumbnail berhasil diperbarui.');
                } else {
                    return back()->withErrors(['msg' => 'Data berhasil diperbarui, tetapi gagal mengunggah thumbnail.']);
                }
            }
            // If no thumbnail is uploaded, only update the body
            return back()->with('message', 'Data berhasil diperbarui.');
        } else {
            // Handle case where the bundle data update fails
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui data.']);
        }
    }


    public function bundleCoursePost(Request $request, $id)
    {
        // Fetch the API session from the session
        $apiSession = session('api_session');

        // Define headers for the API request
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession,
        ];

        $bundleSelect = $request->input('bundleSelect');

        $body = array_values(array_unique($bundleSelect)); // Remove duplicates if needed

        // Construct the API URL for updating the bundle
        $apiUrl = $this->apiUrl . 'courses/bundles/' . $id . '/courses';

        // Send the PUT request to update the bundle
        $response = Http::withHeaders($headers)->post($apiUrl, $body);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->route('admin.bundling')->with('message', 'Data berhasil diperbarui.');
        } else {
            // Handle the case where the update was not successful
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui data.']);
        }
    }

    public function bundleCourseDelete(Request $request, $id)
    {
        // Validasi incoming request untuk courseIds
        $request->validate([
            'courseIds' => 'required|array', // Memastikan courseIds adalah array
            'courseIds.*' => 'required|string', // Memastikan setiap courseId adalah string
        ]);

        // Ambil courseIds dari request
        $courseIds = $request->input('courseIds');

        // Buat URL API untuk menghapus kursus dari bundel
        $apiUrl = $this->apiUrl . 'courses/bundles/' . $id . '/courses';

        // Kirim permintaan DELETE ke API dengan courseIds dalam body
        $response = Http::withHeaders([
            'Content-Type' => 'application/json', // Pastikan konten adalah JSON
            'Cookie' => 'session=' . session('api_session') // Ambil sesi dari session
        ])->delete($apiUrl, $courseIds); // Mengirimkan courseIds sebagai body

        // Periksa apakah permintaan berhasil
        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Kelas berhasil dihapus.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete course bundle.'], 500);
        }
    }



    public function destroyBundle($id)
    {

        $apiUrl = $this->apiUrl . 'courses/bundles/' . $id;

        $response = Http::withApiSession()->delete($apiUrl);

        if ($response->successful()) {
            // Optionally, add logic to remove the item from your database
            return response()->json(['message' => 'Course bundle deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Failed to delete course bundle.'], 500);
    }


    public function destroyCourse($id)
    {

        $apiUrl = $this->apiUrl . 'courses/' . $id;

        $response = Http::withApiSession()->delete($apiUrl);

        if ($response->successful()) {
            // Optionally, add logic to remove the item from your database
            return response()->json(['message' => 'Course bundle deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Failed to delete course bundle.'], 500);
    }

    public function destroy($id)
    {

        $apiUrl = $this->apiUrl . 'courses/categories/' . $id;

        $response = Http::withApiSession()->delete($apiUrl);
        print_r($response->body());

        if ($response->successful()) {
            // Optionally, add logic to remove the item from your database
            return response()->json(['message' => 'Course bundle deleted successfully.'], 200);
        }

        return response()->json(['message' => $id . 'Failed to delete course bundle'], 500);
    }


    public function editCategory(Request $request, $id)
    {
        try {
            // Construct the API URL for updating the category
            $apiUrl = $this->apiUrl . 'courses/categories/' . $id;

            // Make the PUT request to the external API
            $response = Http::withApiSession()->put($apiUrl, [
                'name' => $request->name // Example data if you are updating the category's name
            ]);

            // Check if the request was successful
            if ($response->successful()) {
                // Check if the response has content
                $responseData = $response->json(); // If there's any JSON response
                if (!empty($responseData)) {
                    return response()->json([
                        'message' => 'Category updated successfully',
                        'data' => $responseData // Return the data from the API if present
                    ]);
                } else {
                    // No data returned, just return success
                    return response()->json([
                        'message' => 'Category updated successfully but no data returned from API.'
                    ]);
                }
            } else {
                // Handle failure cases, including client errors
                return response()->json([
                    'message' => 'Failed to update category',
                    'error' => $response->body() // Return the error message if any
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllCourse($page)
    {
        // Pass the page parameter in the API request
        $response = Http::withApiSession()->get($this->apiUrl . 'courses', [
            'page' => $page
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getSearchCourse($query)
    {
        // Pass the page parameter in the API request
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/search?q=', [
            'q' => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getAllBundling($page)
    {
        // Pass the page parameter in the API request
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/bundles', [
            'page' => $page
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getCourseById($courseId)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId);

        return json_decode($response->getBody()->getContents());
    }

    public function getCourseContentById($courseId) {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/contents');

        return json_decode($response->getBody()->getContents());
    }

    public function getCourseRating($courseId) {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/ratings');

        dd($response->body());
        return json_decode($response->getBody()->getContents());
    }


    public function getBundlingById($courseBundleId)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/bundles/' . $courseBundleId);

        return json_decode($response->getBody()->getContents());
    }
    public function getBundlingContentById($courseBundleId) {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/bundles/' . $courseBundleId . '/courses');

        return json_decode($response->getBody()->getContents());
    }


}
