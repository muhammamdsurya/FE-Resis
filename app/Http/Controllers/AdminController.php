<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    private $user;
    private $apiUrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }

    private function getDetailData()
    {
        $id = $this->user['id'];
        $api = $this->apiUrl . 'admin/auth/data/' . $id;

        $response = Http::withApiSession()->get($api);


        return $response->json();
    }

    private function getProfileData()
    {

        // Mengonversi setiap timestamp ke objek Carbon
        $created = Carbon::parse($this->user['created_at']);
        $updated = Carbon::parse($this->user['updated_at']);

        // Mengubah zona waktu ke WIB (Asia/Jakarta)
        $createdWIB = $created->setTimezone('Asia/Jakarta');
        $updatedWIB = $updated->setTimezone('Asia/Jakarta');

        // Format tanggal sesuai kebutuhan
        $created_at = $createdWIB->format('d-m-Y H:i:s');
        $updated_at = $updatedWIB->format('d-m-Y H:i:s');

        return [
            'id' => $this->user['id'],
            'email' => $this->user['email'],
            'full_name' => $this->user['full_name'],
            'role' => $this->user['role'],
            'photo_profile' => $this->user['photo_profile'],
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }

    protected function fetchApiData($url)
    {
        $response = Http::withApiSession()->get($url);

        // Check if the response is successful
        if ($response->successful()) {
            return $response->body(); // Decode JSON response into an object
        } else {
            // Log the error with more context
            Log::error('Failed to fetch data from API: ' . $response->status() . ' - ' . $response->body());

        }
    }


    public function dashboard()
    {
        $title = 'Dashboard';

        $totalUsersData = $this->fetchApiData($this->apiUrl . 'statistics/users/count');
        $totalUsers = $totalUsersData['total_users'] ?? 0;

        $totalAdminsData = $this->fetchApiData($this->apiUrl . 'statistics/admins/count');
        $totalAdmins = $totalAdminsData['total_admins'] ?? 0;

        $totalCoursesData = $this->fetchApiData($this->apiUrl . 'statistics/courses/count');
        $totalCourses = $totalCoursesData['total_courses'] ?? 0;

        $totalBundlesData = $this->fetchApiData($this->apiUrl . 'statistics/courses/bundle/count');
        $totalBundles = $totalBundlesData['total_bundles'] ?? 0;

        $totalInstructorsData = $this->fetchApiData($this->apiUrl . 'statistics/instructors/count');
        $totalInstructors = $totalInstructorsData['total_instructors'] ?? 0;

        $totalSalesData = $this->fetchApiData($this->apiUrl . 'statistics/sales/count');
        $totalSales = $totalSalesData['total_sales'] ?? 0;

        $SalesData = $this->fetchApiData($this->apiUrl . 'statistics/sales/count');
        $Sales = $SalesData['total_sales'] ?? 0;

        return view('admin.dashboard', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "total_users" => $totalUsers,
            "total_admins" => $totalAdmins,
            "total_courses" => $totalCourses,
            "total_bundles" => $totalBundles,
            "total_instructors" => $totalInstructors,
            "total_sales" => $totalSales,
            "sales" => $Sales,
        ]);
    }

    public function kelas(Request $request)
    {

        $title = 'Data Kelas';
        $page = $request->input('page', 1); // Get the current page or default to 1

        $categories = $this->fetchApiData($this->apiUrl . 'courses/categories');
        $instructors = $this->fetchApiData($this->apiUrl . 'courses/instructors');
        $courses = $this->fetchApiData($this->apiUrl . 'courses?page=' . $page);

        return view('admin.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "courses" => $courses['data'],
            "pagination" => $courses['pagination'], // Get pagination data
            "categories" => json_encode($categories), // Encode the categories for JS
            "instructors" => json_encode($instructors), // Encode the categories for JS

        ]);
    }

    public function profile()
    {

        $title = 'Profile';
        $profileData = $this->getProfileData();
        $detailData = $this->getDetailData();

        // Lakukan operasi lain yang diperlukan

        return view('admin.profile', [
            "title" => $title,
            "full_name" => $profileData['full_name'],
            "role" => $detailData['type'],
            "email" => $profileData['email'],
            "photo_profile" => $profileData['photo_profile'],
            "created_at" => $profileData['created_at'],
            "updated_at" => $profileData['updated_at'],
        ]);
    }

    public function bundling(Request $request)
    {

        $title = 'Data Bundling';
        $page = $request->input('page', 1); // Get the current page or default to 1
        $bundles = $this->fetchApiData($this->apiUrl . 'courses/bundles?page=' . $page);


        return view('admin.bundling', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "bundles" => $bundles['data'],
            "pagination" => $bundles['pagination'], // Get pagination data
        ]);
    }

    public function sales()
    {

        $title = 'Data Penjualan';


        return view('admin.sales', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function dataAdmin()
    {

        $title = 'Data Admin';

        // Lakukan operasi lain yang diperlukan
        return view('admin.dataAdmin', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function getInstructor()
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/instructors');

        return $response->json();
    }
    public function dataPengajar()
    {

        $title = 'Data Pengajar';

        // Lakukan operasi lain yang diperlukan

        return view('admin.dataPengajar', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function dataSiswa()
    {

        $title = 'Data Siswa';

        return view('admin.dataSiswa', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }


    public  function detailKelas(Request $request, $id)
    {
        $title = '';

        $categories = $this->fetchApiData($this->apiUrl . 'courses/categories');
        $course = $this->fetchApiData($this->apiUrl . 'courses/'.$id);

        $selectedCourseContentId = $request->get("selectedCourseContentId") ?? '';
        // dd( json_decode($course));
        // $data = [
        //     "course_id" => "5a1e0960-2044-4e00-b0a6-a7352c324a1f",
        //     "content_title" => "Introduction",
        //     "content_description" => "Introduction to web development",
        //     "content_type" => "video",
        //     "video_article_content" => "Introduction to web development",
        //     "video_duration" => 60,
        // ];
        
        // // Mengencode array menjadi JSON
        // $jsonData = json_encode($data);
        

        // $apiSession = session('api_session');
        // dd($apiSession);

        return view('admin.detailKelas', [
            "title" => $title,
            "courseId" => $id,
            "selectedCourseContentId" => $selectedCourseContentId,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "categories" => json_decode($categories), // Encode the categories for JS
            "course" => json_decode($course), // Encode the categories for JS
        ]);
    }

    public  function detailBundling($id)
    {
        $title = '';

        $bundle = $this->fetchApiData($this->apiUrl . 'courses/bundles/' . $id);

        return view('admin.bundlingDetail', [
            "title" => $title,
            "courseId" => $id,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "bundle" => $bundle, // Encode the categories for JS
        ]);
    }


    public function diskusi($id)
    {
        $title = 'Diskusi';

        // $apiSession = session('api_session');
        // dd($apiSession);
        

        // Lakukan operasi lain yang diperlukan

        return view('user.diskusi', [
            "courseId" => $id,
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }
}
