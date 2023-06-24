@extends("base")

@section("main")
    <h1 class="text-center text-xl mt-5">My Bookings</h1>
    <div class="text-center">
        <table class="border w-[100%] mt-5">
            <thead>
                <th class="border p-2">DateTime</th>
                <th class="border p-2">Movie</th>
                <th class="border p-2">Cinema</th>
                <th class="border p-2">Seats</th>
            </thead>
            <tbody>
                @foreach(\App\Models\User::find(session("user")->id)->Booking as $b)
                <tr class="border p-2">
                    <td class="border p-2">{{ $b->Show->show_at }}</td>
                    <td class="border p-2">{{ $b->Show->Movie->title }}</td>
                    <td class="border p-2"> {{ $b->Show->Cinemas->name }} ({{ $b->Show->Cinemas->address }})</td>
                    <td class="border p-2">
                        @foreach($b->seats as $s)
                        Row: {{$s->seat_row}} SeatNo: {{$s->seat_col}} <br />
                        @endforeach
                    </td>
                </tr>
                @endforeach
{{--                <tr class="border p-2">--}}
{{--                    <td class="border p-2">2022-10-03 12:10</td>--}}
{{--                    <td class="border p-2">The Corporation</td>--}}
{{--                    <td class="border p-2">Virtual World (#877, Smith Avenue)</td>--}}
{{--                    <td class="border p-2">--}}
{{--                        Row: 8 SeatNo: 5 <br />--}}
{{--                        Row: 8 SeatNo: 6 <br />--}}
{{--                    </td>--}}
{{--                </tr>--}}
            </tbody>
        </table>
    </div>
@endsection
