<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.pages.account.profile',  compact('admin'));
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:6', 'max:20',function ($attribute, $value, $fail) {
                if (sha1($value) !== Auth::guard('admin')->user()->password) {
                    $fail('Current password is incorrect.');
                }
            }],
            'new_password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->password = sha1($request->new_password);
        dd($admin->password);
        $admin->save();
        Auth::logout();
        return redirect()->route('index')->with('msg', 'Password changed successfully. Please log in again.');
    }
}
