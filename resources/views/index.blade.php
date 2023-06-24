@extends("base")

@section("main")
<form id="form" action="{{ url("/") }}" method="get" onchange="this.submit()">
<main>
    <section>
        <ul class="flex bg-slate-400 p-3" onclick="form.submit()">
            <li class="mr-2">
                <a class="search s-show-date p-5 hover:font-bold s-selected" @checked(request("date", "All") == "All")>
                    <label for="date-All">All</label>
                    <input hidden id="date-All" type="radio" name="date" value="All" @checked(request("date", "All") == "All")>
                </a>
            </li>
            <li class="mr-2">
                <a class="search s-show-date p-5 hover:font-bold " @checked(request("date", "All") == "2022-10-02")>
                    <label for="2022-10-02">2022-10-02</label>
                    <input hidden id="2022-10-02" type="radio" name="date" value="2022-10-02" @checked(request("date", "All") == "2022-10-02")>
                </a>
            </li>
            <li class="mr-2">
                <a class="search s-show-date p-5 hover:font-bold " @checked(request("date", "All") == "2022-10-03")>
                    <label for="2022-10-03">2022-10-03</label>
                    <input hidden id="2022-10-03" type="radio" name="date" value="2022-10-03" @checked(request("date", "All") == "2022-10-03")>
                </a>
            </li>
        </ul>
    </section>
    <section>
        <fieldset class="border p-2">
            <legend>Choose genres:</legend>
            <div>
                <input class="ml-5 s-rel cursor-pointer" type="radio" id="all" name="rel" value="all"
                    data-value="all" @checked(request("rel", "all") == "all")>
                <label class="search cursor-pointer" for="all">All genres</label>
                <input class="ml-5 s-rel cursor-pointer" type="radio" id="or" name="rel" value="or" @checked(request("rel", "all") == "or")>
                <label class="cursor-pointer" for="or">Include one of the selected</label>
                <input class="ml-5 s-rel cursor-pointer" type="radio" id="and" name="rel" value="and" @checked(request("rel", "all") == "and")>
                <label class="cursor-pointer" for="and">Include all of the selected</label>
            </div>
            <div class="flex flex-wrap ">
                @foreach(\App\Models\Genre::all() as $g)
                    <div class="flex ml-5 my-1 s-genres">
                        <input disabled class="s-genre " type="checkbox" id="genre-{{ $g->id }}" name="genre[]" value="{{ $g->id }}"
                               @checked(collect(request()->input("genre"))->contains($g->id))
                        >
                        <label class="ml-1   text-gray-500 " for="genre-{{ $g->id }}">{{ $g->name }}</label>
                    </div>
                @endforeach
            </div>
        </fieldset>
    </section>
    <section class="mt-2 border-b-2">
        <input class="w-[300px] py-1 px-2 border mb-2 rounded" type="search" name="search"
            placeholder="Input to serach movies' title" value="{{ request()->search }}">
        <button class="p-1 border rounded">Search</button>
        <spanv class="ml-10">Display </spanv>
        <select name="per" class="p-1 border rounded">
            <option value="1" @selected(request("per", 1) == 1)>1</option>
            <option value="5" @selected(request("per", 1) == 5)>5</option>
            <option value="10" @selected(request("per", 1) == 10)>10</option>
        </select>
        <span>Movies Per Page</span>
    </section>
    <section>
        <ul>
            @foreach($movie_paginate as $m)
                <li class="flex my-3">
                    <a href="{{ url("/movie-details/$m->id") }}" target="_blank">
                        @if($m->id > 10)
                            <figure class="w-[300px]"><img src="images/posters/coming-soon.png" alt=""></figure>
                        @else
                            <figure class="w-[300px]"><img src="images/posters/{{ $m->id }}.jpg" alt=""></figure>
                        @endif
                    </a>
                    <div class="flex flex-col ml-4">
                        <p class="mb-2">
                            <span class="font-bold text-xl mr-2">
                                <a href="{{ url("/movie-details/$m->id") }}" target="_blank">{{ $m->title}}</a>
                            </span>
                            @foreach($m->Genres as $g)
                                <span class="p-1 bg-slate-400 text-sm rounded text-white">{{ $g->name }}</span>
                            @endforeach
                        </p>
                        <p class="mb-2">{{ $m->brief }}</p>
                        <p class="mb-2">
                            <span class="font-bold">Duration:</span>
                            <spam class="ml-2">{{ $m->duration }} min.</spam>
                        </p>
                        <p class="mb-2">
                            <span class="font-bold">Director(s):</span>
                            @foreach($m->Directors as $d)
                            <span class="ml-2">{{ $d->first_name }} {{ $d->last_name }}</span>
                            @endforeach
                        </p>
                        <p class="" mb-2>
                            <span class="font-bold">Performers:</span>
                            @foreach($m->Performers as $p)
                            <span class="ml-2">{{ $p->first_name }} {{ $p->last_name }}</span>
                            @endforeach
                        </p>
                        <p>
                            <span class="font-bold">Shown In:</span>
                        <ul>
                            @foreach($m->Shows as $s)
                            <li class="my-1"><span class="ml-5"><a
                                        class="p-1 hover:text-gray-100 hover:bg-slate-400"
                                        href="{{ route("show", ["movieId" => $m->id, "showId" => $s->id]) }}"
                                        target="_blank">{{ $s->Cinemas->name }} ({{$s->show_at}})</a></span></li>
                            @endforeach
                        </ul>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
</main>
{{$movie_paginate}}
</form>
@endsection

@section("js")
    <script>
        $("[name='rel']").each(function () {
            if (this.checked && this.id !== "all"){
                $("[name='genre[]']").each(function () {
                    this.disabled = false
                })
            }
        })

        // $("input[name=search]").on("click", function (e) {
        //     if ($("input[name=search]").val()) {
        //         $("form").submit();
        //     }
        // })
    </script>
@endsection
