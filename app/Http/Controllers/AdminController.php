<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

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
        $created_at = $createdWIB->format('d-m-Y, H:i');
        $updated_at = $updatedWIB->format('d-m-Y, H:i');

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

        $totalBundlesData = $this->fetchApiData($this->apiUrl . 'statistics/courses/bundles/count');
        $totalBundles = $totalBundlesData['total_course_bundles'] ?? 0;

        $totalInstructorsData = $this->fetchApiData($this->apiUrl . 'statistics/instructors/count');
        $totalInstructors = $totalInstructorsData['total_instructors'] ?? 0;

        $totalSalesData = $this->fetchApiData($this->apiUrl . 'statistics/sales/count?month=1');
        $totalSales = $totalSalesData['total_sales'] ?? 0;

        $SalesData = $this->fetchApiData($this->apiUrl . 'statistics/sales?few_months=6');
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

    public function sales()
    {

        $title = 'Data Penjualan';
        $dataSales = $this->fetchApiData($this->apiUrl . 'statistics/sales/transactions');

        return view('admin.sales', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "dataSales" => json_decode(json_encode($dataSales['data'])),
            "pagination" => $dataSales['pagination'], // Assuming your API returns pagination information in the response
            // You can remove "dataSales" and "pagination" if you don't need to pass it to the view
        ]);
    }


    public function dataAdmin(Request $request)
    {

        $title = 'Data Admin';

        $dataAdmin = $this->fetchApiData($this->apiUrl . 'statistics/admins');
        $detailData = $this->getDetailData();


        // Lakukan operasi lain yang diperlukan
        return view('admin.dataAdmin', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "type" => $detailData['type'],
            "dataAdmin" => json_decode(json_encode($dataAdmin['data'])),
            "pagination" => $dataAdmin['pagination'], // Assuming your API returns pagination information in the response

        ]);
    }

    public function getInstructor()
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/instructors');

        return $response->json();
    }
    public function dataPengajar(Request $request)
    {
        $title = 'Data Pengajar';

        $dataInstructor = $this->fetchApiData($this->apiUrl . 'statistics/instructors');


        return view('admin.dataPengajar', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "dataInstructor" => json_decode(json_encode($dataInstructor['data'])),
            "pagination" => $dataInstructor['pagination'], // Assuming your API returns pagination information in the response

        ]);
    }

    public function dataSiswa(Request $request)
    {

        $title = 'Data Siswa';
        $dataSiswa = $this->fetchApiData($this->apiUrl . 'statistics/users');

        return view('admin.dataSiswa', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "dataSiswa" => json_decode(json_encode($dataSiswa['data'])),
            "pagination" => $dataSiswa['pagination'], // Assuming your API returns pagination information in the response

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
        $courses = $this->fetchApiData($this->apiUrl . 'statistics/courses');
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
            "courses" => $courses,
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
    public function downloadAdmin(Request $request)
    {
        // Mendapatkan data admin dari API
        $dataAdmin = $this->fetchApiData($this->apiUrl . 'statistics/admins');

        $data = json_decode(json_encode($dataAdmin));

        // Mengatur output CSV
        $output = fopen('php://output', 'w');

        // Menulis header CSV
        fputcsv($output, ['Name', 'Email', 'Type', 'Created At']); // Sesuaikan header

        // Menulis setiap baris data
        foreach ($data->data as $admin) {
            fputcsv($output, [
                $admin->name,
                $admin->email,
                $admin->type,
                Carbon::parse($admin->created_at)->format('d-m-Y'), // Mengubah format tanggal
            ]);
        }

        // Menentukan header untuk download
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="data_admin_' . date('d-m-Y') . '.csv"');

        // Menutup output
        fclose($output);
        exit; // Menghentikan script agar tidak ada output lain yang tercetak
    }

    public function downloadUser(Request $request)
    {
        // Mendapatkan data admin dari API
        $dataUser = $this->fetchApiData($this->apiUrl . 'statistics/users');

        $data = json_decode(json_encode($dataUser));

        // Mengatur output CSV
        $output = fopen('php://output', 'w');

        // Menulis header CSV
        fputcsv($output, ['Name', 'Email', 'Study Level', 'Institution', 'Birth Date', 'Created At']); // Sesuaikan header

        // Menulis setiap baris data
        foreach ($data->data as $admin) {
            fputcsv($output, [
                $admin->name,
                $admin->email,
                $admin->study_level,
                $admin->institution,
                Carbon::parse($admin->birth)->format('d-m-Y'), // Mengubah format tanggal
                Carbon::parse($admin->created_at)->format('d-m-Y'), // Mengubah format tanggal
            ]);
        }

        // Menentukan header untuk download
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="data_siswa_' . date('d-m-Y') . '.csv"');

        // Menutup output
        fclose($output);
        exit; // Menghentikan script agar tidak ada output lain yang tercetak
    }

    function downloadInstructor(Request $request)
    {
        // Mendapatkan data admin dari API
        $dataUser = $this->fetchApiData($this->apiUrl . 'statistics/instructors');

        $data = json_decode(json_encode($dataUser));

        // Mengatur output CSV
        $output = fopen('php://output', 'w');

        // Menulis header CSV
        fputcsv($output, ['Name', 'Email', 'Education', 'Experience']); // Sesuaikan header

        // Menulis setiap baris data
        foreach ($data->data as $admin) {
            fputcsv($output, [
                $admin->name,
                $admin->email,
                $admin->education,
                $admin->experience,
            ]);
        }

        // Menentukan header untuk download
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="data_instruktur_' . date('d-m-Y') . '.csv"');

        // Menutup output
        fclose($output);
        exit; // Menghentikan script agar tidak ada output lain yang tercetak
    }

    function downloadSales(Request $request)
    {
        // Mendapatkan data admin dari API
        $dataSales = $this->fetchApiData($this->apiUrl . 'statistics/sales');

        $data = json_decode(json_encode($dataSales));

        // Mengatur output CSV
        $output = fopen('php://output', 'w');

        // Menulis header CSV
        fputcsv($output, ['Name', 'Email', 'Transaction Type', 'Product Name', 'Course Price', 'Transaction Fee', 'Tax', 'Total Amount', 'Payment Status', 'Payment Type', 'Created At']);

        // Menulis setiap baris data
        foreach ($data->data as $sale) {
            fputcsv($output, [
                $sale->name,
                $sale->email,
                $sale->transaction_type,
                $sale->product_name,
                number_format($sale->course_price, 0, ',', '.'), // Format harga kursus
                number_format($sale->transaction_fee, 0, ',', '.'), // Format biaya transaksi
                number_format($sale->tax, 0, ',', '.'), // Format pajak
                number_format($sale->total_amount, 0, ',', '.'), // Format total amount
                $sale->payment_status,
                $sale->payment_type,
                Carbon::parse($sale->created_at)->format('d-m-Y H:i'), // Mengubah format tanggal
            ]);
        }

        // Menentukan header untuk download
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="data_sales_' . date('d-m-Y') . '.csv"');

        // Menutup output
        fclose($output);
        exit; // Menghentikan script agar tidak ada output lain yang tercetak
    }


    public function downloadCourse(Request $request)
    {
        // Mendapatkan data course dari API
        $response = Http::withApiSession()->get($this->apiUrl . 'statistics/courses/csv');

        // Memeriksa jika permintaan berhasil
        if ($response->successful()) {
            // Mengambil konten CSV dari respons
            $csvContent = $response->body();

            // Menentukan header untuk download
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="data_kelas_' . date('d-m-Y') . '.csv"',
            ];

            // Mengembalikan respons CSV
            return Response::make($csvContent, 200, $headers);
        }

        // Mengembalikan respons error jika tidak berhasil
        return redirect()->back()->with('error', 'Failed to download CSV');
    }

    public function downloadCourseBundle(Request $request)
    {
        // Mendapatkan data course dari API
        $response = Http::withApiSession()->get($this->apiUrl . 'statistics/courses/bundles/csv');

        // Memeriksa jika permintaan berhasil
        if ($response->successful()) {
            // Mengambil konten CSV dari respons
            $csvContent = $response->body();

            // Menentukan header untuk download
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="data_bundling_' . date('d-m-Y') . '.csv"',
            ];

            // Mengembalikan respons CSV
            return Response::make($csvContent, 200, $headers);
        }

        // Mengembalikan respons error jika tidak berhasil
        return redirect()->back()->with('error', 'Failed to download CSV');
    }
}
