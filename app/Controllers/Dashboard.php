<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Dashboard extends BaseController
{

    public function student()
    {
        return $this->renderDashboard('student_dashboard');
    }

    public function faculty()
    {
        return $this->renderDashboard('faculty_dashboard');
    }

    private function renderDashboard(string $view)
    {
        $userId = session()->get('id');
        $user = $userId ? (new UsersModel())->find($userId) : null;

        if (!is_array($user)) {
            log_message('error', 'Unable to load the current user profile for the dashboard.');

            return redirect()
                ->to('/login')
                ->with('error', 'Your account information could not be loaded. Please sign in again.');
        }

        $fullName = trim(implode(' ', array_filter([
            $user['firstname'] ?? '',
            $user['middlename'] ?? '',
            $user['lastname'] ?? '',
        ], static fn ($name) => trim((string) $name) !== '')));

        $profileDetails = [
            ['label' => 'Account ID', 'value' => $user['id'] ?? ''],
            ['label' => 'Login ID', 'value' => $user['loginId'] ?? ''],
            ['label' => 'Role', 'value' => $user['role'] ?? ''],
            ['label' => 'First Name', 'value' => $user['firstname'] ?? ''],
            ['label' => 'Middle Name', 'value' => $user['middlename'] ?? ''],
            ['label' => 'Last Name', 'value' => $user['lastname'] ?? ''],
            ['label' => 'Sex', 'value' => $user['sex'] ?? ''],
            ['label' => 'Age', 'value' => $user['age'] ?? ''],
            ['label' => 'Email Address', 'value' => $user['email'] ?? ''],
            ['label' => 'Program', 'value' => $user['program'] ?? ''],
            ['label' => 'Year Level', 'value' => $user['year'] ?? ''],
            ['label' => 'Contact', 'value' => $user['contact'] ?? ''],
            ['label' => 'Address', 'value' => $user['address'] ?? ''],
            ['label' => 'Account Status', 'value' => $user['status'] ?? ''],
            ['label' => 'Last Login', 'value' => $user['login_at'] ?? ''],
            ['label' => 'Last Logout', 'value' => $user['logout_at'] ?? ''],
        ];

        return view($view, [
            'userProfile' => $user,
            'profileName' => $fullName !== '' ? $fullName : ($user['loginId'] ?? 'User'),
            'profileDetails' => $profileDetails,
        ]);
    }
// GENERAL FUNCTIONS

}