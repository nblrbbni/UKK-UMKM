<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return auth()->guard('admin'); // Gunakan guard 'admin'
    }

    public function showLoginForm()
    {
        return view('auth.admin-login'); // Buat blade untuk login admin
    }
}
