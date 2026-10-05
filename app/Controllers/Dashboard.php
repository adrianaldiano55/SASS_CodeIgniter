<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function student()
    {
        return view('student_dashboard');
    }

    public function faculty()
    {
        return view('faculty_dashboard');
    }
// GENERAL FUNCTIONS

}