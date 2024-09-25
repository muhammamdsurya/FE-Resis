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
        public function dashboard()
    {

        $title = 'Dashboard';

        // Lakukan operasi lain yang diperlukan

        return view('admin.dashboard', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function kelas()
    {

        $title = 'Data Kelas';


        return view('admin.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
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

    public function bundling()
    {

        $title = 'Data Bundling';

        return view('admin.bundling', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
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

    public function getInstructor(){
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


    public  function detailKelas(Request $request,$id)
    {
        $title = '';



        // $apiSession = session('api_session');
        // dd($apiSession);
        // $courseCtrl = new courseController();
        // $courseData =   $courseCtrl->getKelasById($id);

        $selectedCourseContentId = $request->get("selectedCourseContentId") ?? '';
        $data = [
            "course_id" => "5a1e0960-2044-4e00-b0a6-a7352c324a1f",
            "content_title" => "Introduction",
            "content_description" => "Introduction to web development",
            "content_type" => "video",
            "video_article_content" => "Introduction to web development",
            "video_duration" => 60,
        ];
        
        // Mengencode array menjadi JSON
        $jsonData = json_encode($data);
        

        $apiSession = session('api_session');
        dd([
            'course_content_form'=>  $jsonData]);

        return view('admin.detailKelas', [
            "title" => $title,
            "courseId" => $id,
            "selectedCourseContentId" => $selectedCourseContentId,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
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
