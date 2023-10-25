<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MainController extends BaseController
{
    /**
     * Access the dashboard page
     * @return Application|Factory|View
     */
    public function index(){
        $user = auth()->user();

        // Periksa apakah pengguna memiliki peran tertentu
        if ($user->hasRole('Admin')) {
            $this->setPageTitle('Dashboard', 'dashboard');
            $subjects = Subject::all();
            $students_count = Student::count();
            return view('Manage.pages.Singles.dashboard', compact('subjects', 'students_count'));
        }else{
            return redirect()->route('attendance.index')->with('success', 'Attendance record created successfully');
        }

       
    }
}
