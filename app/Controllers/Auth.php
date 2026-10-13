<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function attemptLogin()
    {
        $loginId = trim((string) $this->request->getPost('loginId'));
        $password = $this->request->getPost('password');
        $usersModel = new UsersModel();
        $users = $usersModel
        
            ->groupStart()
                ->where('loginId', $loginId)
            ->groupEnd()
            ->first();
        if (!$users || !password_verify($password, $users['password'])) {
            return redirect()
                ->back()
                ->with('error', 'No User Available.');
        }
        $status = strtolower(trim((string) ($users['status'] ?? '')));
        if ($status !== 'approved') {
            $message = match ($status) {
                'pending' => 'Your account is waiting for faculty verification.',
                'declined' => 'Your account verification was declined. Please contact the faculty.',
                default => 'Your account has not been approved for sign-in.',
            };

            return redirect()
                ->back()
                ->with('error', $message);
        }
        session()->set([
            'id' => $users['id'],
            'role'    => $users['role'],
            'password' => $users['password'],
            'loginId' => $users['loginId'],
            'login_at' => date('Y-m-d H:i:s'),
            'isLoggedIn' => true
        ]);
        return $this->redirectBasedOnRole($users['role']);
    }
    public function attemptRegister()
    {
        $firstname = trim($this->request->getPost('firstname'));
        $middlename = trim($this->request->getPost('middlename'));
        $lastname = trim($this->request->getPost('lastname'));
        $sex = trim($this->request->getPost('sex'));
        $age = trim($this->request->getPost('age'));
        $program = trim($this->request->getPost('program'));
        $year = trim($this->request->getPost('year'));
        $contact = trim($this->request->getPost('contact'));
        $address = trim($this->request->getPost('address'));
        $email = trim($this->request->getPost('email'));
        $loginId = trim($this->request->getPost('loginId'));
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        if (empty($firstname) || empty($middlename) || empty($lastname) || empty($sex) || empty($age) || empty($program) || empty($year) || empty($contact) || empty($address) || empty($email) || empty($loginId) || empty($password) || empty($role)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'All fields are required.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please enter a valid email address.');
        }
        if (strlen($password) < 8) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Password must be at least 8 characters.');
        }
        $usersModel = new UsersModel();
        $existingUser = $usersModel
            ->where('email', $email)
            ->first();
        if ($existingUser) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An account with this email already exists.');
        }
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
        $inserted = $usersModel->insert([
            'firstname'      => $firstname,
            'middlename'     => $middlename,
            'lastname'        => $lastname,
            'sex'             => $sex,
            'age'             => $age,
            'program'         => $program,
            'year'            => $year,
            'contact'         => $contact,
            'address'         => $address,
            'email'           => $email,
            'password'  => $hashedPassword,
            'loginId'        => $loginId,
            'role'            => $role,
            'status'          => 'pending',
            'created_at'      => date('Y-m-d H:i:s'),
        ]);
        if ($inserted === false) {
            log_message('error', 'Unable to register user: {errors}', [
                'errors' => json_encode($usersModel->errors()),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unable to create your account. Please try again.');
        }

        return redirect()
            ->to('/login')
            ->with('success', 'Registration successful! Please wait for your user application to be verified.');
    }
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'Student':
                return redirect()->to('/student_dashboard');
            case 'Faculty':
                return redirect()->to('/faculty_dashboard');
            default:
                session()->destroy();
                return redirect()
                    ->to('/login')
                    ->with('error', 'Invalid user role.');
        }
    }

    public function logout()
    {
        $userId = session()->get('id');
        if ($userId) {
            (new UsersModel())->update($userId, [
                'logout_at' => date('Y-m-d H:i:s'),
            ]);
        }
        session()->destroy();

        return redirect()->to('/login');
    }
}
