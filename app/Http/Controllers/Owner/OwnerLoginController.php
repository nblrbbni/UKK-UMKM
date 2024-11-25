<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OwnerLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/owner/dashboard';

    public function __construct()
    {
        $this->middleware('guest:owner')->except('logout');
    }

    protected function guard()
    {
        return auth()->guard('owner'); // Gunakan guard 'owner'
    }

    public function showLoginForm()
    {
        return view('auth.owner-login'); // Buat blade untuk login owner
    }
}
