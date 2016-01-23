<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = \Auth::user();

        return view('admin.index', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = \Auth::user();

        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->action('Admin\AdminController@index');
    }
}
