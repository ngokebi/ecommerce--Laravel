<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        // $brands = DB::table('brands')->get();

        return view('frontend.index');
    }

    public function UserLogout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function UserProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.pages.profile', compact('user'));
        return view('frontend.body.profilesiderbar', compact('user'));
    }

    public function UpdateProfile(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ],

        );

        $id = Auth::user()->id;
        $user = User::find($id);

        if ($user) {

            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->email = $request['email'];

            $user->save();

            return redirect()->back();
        }
    }

    public function UpdatePicture(Request $request)
    {

        $validated = $request->validate(
            [
                'profile_photo_path' => 'required|mimes:jpg,jpeg,png',
            ],

        );

        $id = Auth::user()->id;
        $user = User::find($id);

        if ($user) {

            if ($request->file('profile_photo_path')) {
                $file = $request->file('profile_photo_path');
                if (file_exists('upload/user_images/' . $user->profile_photo_path)) {
                    @unlink(public_path('upload/user_images/' . $user->profile_photo_path));
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('upload/user_images'), $filename);
                    $user['profile_photo_path'] = $filename;
                } else {
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('upload/user_images'), $filename);
                    $user['profile_photo_path'] = $filename;
                }
            }

            $user->save();

            return redirect()->back();
        }
    }

    public function UpdatePassword(Request $request)
    {
        $validated = $request->validate(
            [
                'current_password' => 'required',
                'password' => 'required|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@_&*%]).*$/|confirmed',
            ],

        );

        $id = Auth::user()->id;

        $hashedPassword = User::find($id)->password;

        if (Hash::check($request->current_password, $hashedPassword)) {

            $user = User::find($id);

            $user->password = Hash::make($request->password);

            $user->save();

            Auth::logout();

            return redirect()->route('user.logout');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
