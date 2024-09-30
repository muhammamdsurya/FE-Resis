<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    private $user;
    private $apiUrl;
    private $courseContentCtrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
        $this->courseContentCtrl = new courseContentController();
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
            return $response->json();
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
        $page = $request->input('page', 1); // Default ke halaman 1 jika tidak ada

        // Ambil nilai input 'q' dari form
        $query = $request->input('q');

        if ($query) {
            // Fetch courses dengan parameter query
            $courses = $this->fetchApiData($this->apiUrl . 'courses/search?q=' . urlencode($query));
        } else {
            // Fetch courses tanpa pencarian
            $courses = $this->fetchApiData($this->apiUrl . 'courses?page=' . $page);
        }

        // Kode lain untuk categories, instructors, dll.
        $categories = $this->fetchApiData($this->apiUrl . 'courses/categories');
        $instructors = $this->fetchApiData($this->apiUrl . 'courses/instructors');

        return view('admin.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "courses" => $courses,
            "pagination" => $courses['pagination'] ?? null,
            "categories" => json_encode($categories),
            "instructors" => json_encode($instructors),
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

        // Ambil nilai input 'q' dari form
        $query = $request->input('q');

        if ($query) {
            // Fetch courses dengan parameter query
            $bundles = $this->fetchApiData($this->apiUrl . 'courses/bundles/search?q=' . urlencode($query));
        } else {
            // Fetch courses tanpa pencarian
            $bundles = $this->fetchApiData($this->apiUrl . 'courses/bundles?page=' . $page);
        }

        return view('admin.bundling', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "bundles" => $bundles,
            "pagination" => $bundles['pagination'] ?? null,
        ]);
    }

    public function sales(Request $request)
    {
        $title = 'Data Penjualan';

        // Check if the request is AJAX
        if ($request->ajax()) {
            $dataSales = $this->fetchApiData($this->apiUrl . 'statistics/sales/transactions');

            // Here, you would typically handle pagination, searching, and ordering if your API supports it.
            $data = $dataSales['data']; // Assuming your API returns the relevant data
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row['created_at'])->format('Y-m-d H:i:s');
                })
                ->make(true);
        }

        // For non-AJAX requests, load the view normally
        return view('admin.sales', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            // You can remove "dataSales" and "pagination" if you don't need to pass it to the view
        ]);
    }


    public function dataAdmin()
    {

        $title = 'Data Admin';

        $dataAdmin = $this->fetchApiData($this->apiUrl . 'statistics/admins');

        // Lakukan operasi lain yang diperlukan
        return view('admin.dataAdmin', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "data" => $dataAdmin,
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

    public function detailKelas(Request $request, $id)
    {
        $title = 'Detail Kelas';

        $categories = $this->fetchApiData($this->apiUrl . 'courses/categories');
        $instructors = $this->fetchApiData($this->apiUrl . 'courses/instructors');
        $course = $this->fetchApiData($this->apiUrl . 'courses/' . $id);
        // Initialize course contents, assuming it's fetched properly
        $courseContents = $this->courseContentCtrl->courseContents($id) ?? []; // Fetch course contents safely
        $courseContent = null;
        $previousCourseContentId = '';
        $nextCourseContentId = '';

        $videoType = 'video';
        $addSrcType = 'additional_source';
        $quizType = 'quiz';

        $selectedCourseContentId = $request->get("selectedCourseContentId") ?? '';

        if ($selectedCourseContentId != '') {
            $selectedIndex = -1; // Use -1 to indicate not found initially
            foreach ($courseContents as $index => $content) {
                if ($content->id === $selectedCourseContentId) {
                    $selectedIndex = $index; // Set the selected index
                    $courseContent = $content; // Assign selected course content
                    break;
                }
            }

            // Initialize next and previous IDs
            if ($selectedIndex !== -1) { // Ensure we found the selected index
                if ($selectedIndex > 0) {
                    $previousCourseContentId = $courseContents[$selectedIndex - 1]->id;
                }
                if ($selectedIndex < count($courseContents) - 1) {
                    $nextCourseContentId = $courseContents[$selectedIndex + 1]->id;
                }
            }

            // Check if $courseContent is not null before accessing its properties
            if ($courseContent) {
                if ($courseContent->content_type == $videoType) {
                    $courseContentVideo = $this->courseContentCtrl->courseContentVideo($id, $selectedCourseContentId);
                    $courseContent->video = $courseContentVideo;
                } elseif ($courseContent->content_type == $addSrcType) {
                    $courseContentSrc = $this->courseContentCtrl->courseContentSrc($id, $selectedCourseContentId);
                    $courseContent->src = $courseContentSrc;
                } elseif ($courseContent->content_type == $quizType) {
                    $courseContentQuiz = $this->courseContentCtrl->courseContentQuiz($id, $selectedCourseContentId);
                    $courseContent->quiz = $courseContentQuiz;
                }
            }
        }


        // dd($courseContent);

        return view('admin.detailKelas', [
            "title" => $title,
            "courseId" => $id,
            "selectedCourseContentId" => $selectedCourseContentId,
            "previousCourseContentId" => $previousCourseContentId,
            "nextCourseContentId" => $nextCourseContentId,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "categories" => json_decode(json_encode($categories)), // Encode the categories for JS
            "course" => json_decode(json_encode($course)), // Encode the categories for JS
            "instructors" => json_decode(json_encode($instructors)), // Encode the categories for JS
            "courseContent" => $courseContent, // Encode the categories for JS
            "courseContents" => $courseContents, // Encode the categories for JS
            "videoType" => $videoType,
            "addSrcType" => $addSrcType,
            "quizType" => $quizType,
        ]);
    }


    public  function detailBundling($id)
    {
        $title = '';

        $bundle = $this->fetchApiData($this->apiUrl . 'courses/bundles/' . $id);
        $courses = $this->fetchApiData($this->apiUrl . 'courses');
        // Fetch the course IDs from the API
        $idCourse = $this->fetchApiData($this->apiUrl . 'courses/bundles/' . $id . '/courses');
        // Check if $idCourse is an array and not empty
        if (is_array($idCourse) && !empty($idCourse)) {
            // Initialize an array to hold course details
            $courseDetails = [];

            // Iterate over the course IDs
            foreach ($idCourse as $courseId) {
                // Fetch details for each course ID
                $detail = $this->fetchApiData($this->apiUrl . 'courses/' . $courseId);

                // Store the details in the courseDetails array
                $courseDetails[] = $detail;
            }
            // If course details are empty, set a message
            if (empty($courseDetails)) {
                $courseDetails = ['message' => 'Belum ada data'];
            }
        } else {
            // Handle the case where no course IDs were returned
            $courseDetails = ['message' => 'Belum ada data'];
        }


        return view('admin.bundlingDetail', [
            "title" => $title,
            "courseId" => $id,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "bundle" => $bundle, //
            "courses" => $courses['data'],
            "courseDetails" => $courseDetails
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
