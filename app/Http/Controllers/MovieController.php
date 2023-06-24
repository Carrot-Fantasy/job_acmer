<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Booking_Seat;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function Details(Request $request, $movieId)
    {
        return \view("movie-details")
            ->with("movie", Movie::find($movieId));
    }

    public function ShowInfo(Request $request, $movieId, $showId)
    {
        $m = Movie::find($movieId);
        $show = $m->Shows->where("id", $showId)->first();

        $seats = collect();
        foreach ($show->Booking as $b){
            $seats = $seats->concat($b->Seats);
        }

        //    <p>Time: 10:00, Date: 02 Oct, 2022</p>
        $date = new \DateTime($show->show_at);
        $date = "Time: ".$date->format("H:i").", Date: ".$date->format("d M, Y");

        return \view("movie-show")
            ->with("movie", $m)
            ->with("show", $show)
            ->with("show_atFormat", $date)
            ->with("seats", $seats);
    }

    public function Booking(Request $request, $showId)
    {
        if (session()->has("user")) {
            $user = session()->get("user");
            $seats = collect($request->input("seats"));
            $seats = $seats->map(function ($item, $key) {
                return explode("-", $item);
            });

            $book = Booking::where("user_id", $user->id)->where("show_id", $showId)->first();

            if ($book == null) {
                $book = new Booking();
                $book->user_id = $user->id;
                $book->show_id = $showId;
                $book->save();
            }

            foreach ($seats as $s) {
                $seat = new Booking_Seat();
                $seat->seat_row = $s[0];
                $seat->seat_col = $s[1];
                $seat->booking_id = $book->id;
                $seat->save();
            }
        }

        return back();
    }
}
