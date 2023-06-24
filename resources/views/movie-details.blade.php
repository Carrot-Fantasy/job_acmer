@extends("base")

@section("main")

@section("h1")
<h1 class="text-2xl text-center mt-4">The Corporation</h1>
@show

<li class="flex my-3">

    @if($movie->id > 10)
        <img src="{{ asset("images/posters/coming-soon.png") }}" alt="">
    @else
        <img src="{{ asset("images/posters/$movie->id.jpg") }}" alt="">
    @endif


    <div class="flex flex-col ml-4">
        <p class="mb-2">
            <span class="font-bold text-xl mr-2">The Corporation</span>
            <span class="p-1 bg-slate-400 text-sm rounded text-white">Documentary</span>
            <span class="p-1 bg-slate-400 text-sm rounded text-white">History</span>
        </p>
        <p class="mb-2">Documentary that looks at the concept of the corporation throughout recent history up to
            its present-day dominance.</p>
        <p class="mb-2">
            <span class="font-bold">Director(s):</span>
            <span class="ml-2">Mark Achbar</span>
            <span class="ml-2">Jennifer Abbott</span>
        </p>
        <p class="mb-2">
            <span class="font-bold">Performers:</span>
            <span class="ml-2">Mikela Jay</span>
            <span class="ml-2">Rob Beckwerment</span>
            <span class="ml-2">Christopher Gora</span>
            <span class="ml-2">Nina Jones</span>
            <span class="ml-2">Mike Bonanno</span>
        </p>
        <p>
            <span class="font-bold">Shown In:</span>
        <ul>
            @foreach($movie->Shows as $s)
                <li class="my-1"><span class="ml-5"><a
                            class="p-1 hover:text-gray-100 hover:bg-slate-400"
                            href="{{ route("show", ["movieId" => $movie->id, "showId" => $s->id]) }}"
                            >{{ $s->Cinemas->name }} ({{$s->show_at}})</a></span></li>
            @endforeach
        </ul>
        </p>
    </div>
</li>
@section("info")
<div class="">
    {{ $movie->synopsis }}
</div>
@show
@endsection

