@extends("movie-details")

@section("style")
    .select{
        background-color: lightgreen;
    }
    .locked{
        background-color: gray;
    }
@endsection

@section("h1")
@endsection

@section("User")
    @if(session()->has("user"))
        <li class="px-5"><a href="{{ url("logout") }}">Log Out</a></li>
    @else
        <li class="px-5"><a href="{{ url("sign-in/index/$movie->id/$show->id") }}">Sign in</a></li>
        <li class="px-5"><a href="{{ url("sign-up/index") }}">Sign up</a></li>
    @endif
@endsection

@section("info")
    <p class="mt-2 ml-5">
    <p>Cinema: {{ $show->Cinemas->name }} ({{ $show->Cinemas->address }})</p>
    <p>{{ $show_atFormat }}</p>
    <span>Seats Available:
    </span>
    <form action="{{ url("/booking/$show->id") }}" class="inline">
        @if (session()->has("user"))
        <button disabled class="btn-booking p-1 border rounded disabled:text-gray-400">Booking Now</button>
        @endif
    </form>
    <div class="seats mt-2">

    </div>
    <div class="screen w-[100%] py-5 text-center text-2xl">screen</div>

@endsection

@section("js")
<script>
        let seats = {{ \Illuminate\Support\Js::from($seats) }};
        let CanSelectSeat = {{ session()->has("user") ? 1 : 0 }};


        let row = {{ $show->Cinemas->seat_row_count }};
        let col = {{ $show->Cinemas->seat_col_count }}
        for (let i = row; i > 0; i--) {

            $(".seats").append(`
                    <div class="row text-center">
                    </div>
                `)
            for (let j = 1; j <= col; j++) {
                $(".seats .row").last().append(`
                        <span class="seat  col h-6 w-6 border inline-block" data-row="${i}" data-col="${j}"
                        title="row: ${i}, col: ${j}"></span>
                    `
                )
            }
        }


        if (CanSelectSeat) {
            $(".seats").on("click", function (e) {
                if ($(e.target).hasClass("col")) {
                    let sr = $(e.target).data().row
                    let sc = $(e.target).data().col
                    $(e.target).toggleClass("select")
                    if ($(e.target).hasClass("select")) {
                        $("form").append(`
                        <input hidden name="seats[]" data-row="${sr}" data-col="${sc}" value="${sr}-${sc}">
                    `)
                    }else{
                        $("form input").each(function (index, item) {
                            if ($(item).data().row === sr && $(item).data().col === sc) {
                                $(item).remove()
                            }
                        })
                    }

                    $(".btn-booking").attr("disabled", $("form input").length === 0)
                }
            })
        }

        seats.forEach(seat => {
            let row = seat.seat_row;
            let col = seat.seat_col;
            $(".seat").each(function (index, item) {

                if ($(item).data().row === row && $(item).data().col === col) {
                    $(item).addClass("locked")
                }
            })
        })

        $(".btn-booking").click(function (e) {
            e.preventDefault();
            if (confirm("您将预订演出并预订所选的座位，继续吗?")){
                $("form").submit()
            }
        })
</script>
@endsection

