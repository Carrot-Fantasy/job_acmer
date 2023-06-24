<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Go To Movies</title>
    <link rel="stylesheet" href="{{ asset("css/style.css") }}" />
    <script src=" {{ asset("js/jquery-3.6.0.min.js") }}"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        a[checked] {
            font-weight: bold;
        }
        @yield("style")
    </style>
</head>
<body class="antialiased">
<div class="max-w-[1000px] mx-auto">
    <header>
        <nav class="flex justify-between mt-0 border-b-2 border-slate-400 py-3">
            <ul class="flex items-end">
                <li class="px-5">
                    <a href="{{ url("/") }}">
                        <img class="w-10 h-10 mr-2"
                             src=" {{asset("images/rolls.png")}} " alt="logo"><span class="text-xl">Go To
                                Movies</span>
                    </a>
                </li>
                <li class="px-5"><a href="{{ url("/") }}">Home</a></li>
                <li class="px-5"><a href="{{ url("/myBooking") }}">My Bookings</a></li>
            </ul>
            <ul class="flex items-end">
                @section("User")
                    @if(session()->has("user"))
                        <li class="px-5"><a href="{{ url("logout") }}">Log Out</a></li>
                    @else
                        <li class="px-5"><a href="{{ url("sign-in/index") }}">Sign in</a></li>
                        <li class="px-5"><a href="{{ url("sign-up/index") }}">Sign up</a></li>
                    @endif
                @show
            </ul>
        </nav>
    </header>
    @yield("main")
    <footer class="mt-5">
        <hr>
        <p class="text-center">&copy; Online Service For Movies, all rights reserved. 2022</p>
    </footer>
</div>
    @yield("js")
</body>

</html>
