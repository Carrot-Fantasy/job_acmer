<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function SignInIndex(Request $request, $movieId = -1, $showId = -1)
    {
        if ($movieId != -1 && $showId != -1) {
            session([
                "showInfo" => [
                    "movieId" => $movieId,
                    "showId" => $showId,
                ]
            ]);
        }

        return view("sign-in");
    }

    public function SignIn(Request $request)
    {
        $u = User::where("email", $request->email)->first();
        $v = Validator::make($request->all(), [
            "email" => "required|email",
            "pass" => [function($attr, $value, $fail) use($u) {
                if (Hash::check($value, $u->password) == false){
                    $fail("用户名或密码错误");
                }
            }]
        ])->validate();

        if ($request->remember) {
            $request->session()->put("user", $u);
        }

        if (session()->has("backRot")) {
            $path = session("backRot");
            session()->forget("backRot");
            return redirect($path);
        }

        if (session()->has("showInfo")) {
            return redirect()->route("show", session()->get("showInfo"));
        }

        return redirect("/");
    }

    public function SignUpIndex(Request $request) {
        return view("sign-up");
    }

    public function SingUp(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "pass" => ["confirmed", Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);

        DB::table("users")->insert([
            "email" => $request->email,
            "password" => Hash::make($request->pass)
        ]);

        return redirect("/sign-in/index");
    }

    public function MyBooking(Request $request)
    {
        if (session()->has("user")) {
            return view("my-bookings");
        }else{
            session()->put("backRot", "/myBooking");
            return redirect("/sign-in/index");
        }
    }

    public function Logout(Request $request)
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
