<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to(site_url('/'));
        }

        return view('auth/login', ['title' => 'Staff login']);
    }

    public function attempt()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->to(site_url('login'))
                ->with('login_error', 'Enter both your username and password.')
                ->with('login_username', $username);
        }

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! password_verify($password, (string) $user['password'])) {
            return redirect()->to(site_url('login'))
                ->with('login_error', 'Invalid username or password.')
                ->with('login_username', $username);
        }

        // Rotate the session ID after authentication to reduce session fixation risk.
        session()->regenerate(true);
        session()->set([
            'user_id'   => (int) $user['id'],
            'username'  => $user['username'],
            'full_name' => $user['full_name'],
        ]);

        return redirect()->to(site_url('/'))->with('success', 'You are signed in.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
