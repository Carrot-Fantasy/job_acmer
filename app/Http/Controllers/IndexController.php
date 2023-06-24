<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class IndexController extends Controller
{
    public function Index(Request $request) {
        //....
        $date = $request->input("date", "All");

        $gs = $request->Input("genre");
        if ($gs == null){
            $gs = [-1];
        }

        $ms = Movie::
            whereHas("Shows", function (Builder $q) use ($date) {
                if ($date != "All") {
                    $q->where("show_at", "like", "$date%");
                }
                $q->where("show_at", ">", \Carbon\Carbon::now('Asia/shanghai'));
            })
            ->whereHas("Genres", function (Builder $q) use ($request, $gs) {

                if ($request->input("rel") == "or") {
                    $q->whereIn("id", $gs);
                }
            });

        if ($request->input("rel") == "and") {
            foreach ($gs as $g) {
                $ms->whereRelation("Genres", "id", $g);
            }
        }

        $ms->where("title", "like", "%$request->search%");

        return view("index")
            ->with("movie_paginate", $ms->paginate($request->input("per", 1))->withQueryString());
    }
}
