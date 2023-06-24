<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Show;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class ApiController extends Controller
{
        public function Login (Request $request)
        {
            if (Auth::attempt($request->all(["email", "password"]), true)) {

                $user = \auth()->user();
                $token = Str::random(60);
                $user->api_token = $token;
                $user->api_token_refreshed_at = now();
                $user->save();

                return response([
                    "msg" => "Success",
                    "token" => $token,
                    "user" => collect($user->toArray())->except(["api_token", "api_token_refreshed_at"])
                ], 200);
            }else{
                return response([
                    "msg" => "User credential is invalid",
                ], 401);
            }

        }

        public function Logout(Request $request)
        {
//            $token = $request->Authorization;
//            $user = User::where("api_token", $token)->first();

            $token = $request->header("Authorization");
            $user = null;
            if ($token != null) {
                $user = User::where("api_token", $token)->first();
            }


            if ($user && $user->api_token == $token) {
                $user->api_token = "";
                $user->save();
                auth()->logout();
                return response([
                    "msg" => "Success",
                ], 200);
            }else{
                return response([
                    "msg" => "Unauthorized",
                ], 401);
            }

        }

        public function GetMovies(Request $request)
        {
            $limit = $request->count;
            return response([
                "msg" => "Success",
                "movies" => Movie::orderBy("release_date", "desc")->limit($limit)->get()->map(function ($item, $key) {
                    return $item->only(["id", "title", "brief", "release_date"]);
                })
            ], 200);

        }

        public function GetMovieByTitle(Request $request)
        {
            $ms = Movie::orderBy("release_date", "desc")
                ->where("title", "like", "%$request->title%")
                ->limit(5)
                ->get()
                ->map(function ($item, $key) {
                    return $item->only(["id", "title", "brief", "release_date"]);
                }
            );

            return response([
                "msg" => "Success",
                "search_for" => $request->title,
                "movie_count" => $ms->count(),
                "movies" => $ms,
            ], 200);
        }

        public function GetCinema(Request $request, $cinema_id, $date)
        {
            $show = Show::with(["Cinemas", "Movie"])
                ->where("cinema_id", $cinema_id)
                ->where("show_at", ">", $date)
                ->get()
                ->map(function ($item, $key) {
                    $s = collect($item);
                    $s = $s->except(["movie_id", "cinema_id", "published"]);
                    $s["cinemas"] = collect($s["cinemas"])->except(["shows_interval"]);
                    $s["movie"] = collect($s["movie"])->except(["grade", "duration", "synopsis"]);
                    return $s;
                })
            ;

            return response([
                "msg" => "Success",
                "movie_shows" => $show,
            ], 200);
        }

        public function GetAllCinemas(Request $request)
        {
            return response([
                "msg" => "Success",
                "cinemas" => Cinema::all()->map(function ($item, $key) {
                    return collect($item)->except("shows_interval");
                })
            ], 200);
        }

        public function CreateMovieShows(Request $request)
        {
            $token = $request->header("Authorization");
            $user = null;
            if ($token != null) {
                $user = User::where("api_token", $token)->first();
            }

            if ($user == null) {
                return response([
                    "msg" => "Unauthorized",
                ], 401);
            }

            if (!$user->is_admin) {
                return response([
                    "msg" => "Forbidden",
                ], 403);
            }

            if ($request->movie_shows == null || count($request->movie_shows) == 0){
                return response([
                    "msg" => "Data error",
                ], 422);
            }

            foreach ($request->movie_shows as $ms) {
                $s = null;
                if (array_key_exists("id", $ms)) {
                    $s = Show::find($ms["id"]);
                }else{
                    $s = new Show();
                }
                $s->cinema_id = $ms["cinema_id"];
                $s->movie_id = $ms["movie_id"];
                $s->show_at = $ms["show_at"];
                $s->published = $ms["published"];
                $s->save();
            }

            return response([
                "msg" => "Success",
            ], 200);
        }
}
