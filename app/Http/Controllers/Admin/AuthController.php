<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.pages.authentication.signin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();
        if ($admin) {
            if ($admin->password === sha1($request->password)) {
                //Auth::login($admin);
                Auth::guard('admin')->login($admin);
                $role = $admin->role;
                if ($role == 'mainadmin' || $role == 'reviewer' || $role == 'editor') {
                    return redirect()->intended('admin/dashboard');
                } elseif ($role == 'regional_partner') {
                    return redirect()->intended('/rp_dashboard');
                }
            }
            return redirect()->intended(route('index', absolute: false))->with('msg', 'Invalid Password.');
        }
        return redirect()->intended(route('index', absolute: false))->with('msg', 'Invalid Username.');;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
