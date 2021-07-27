@extends('layouts.app')
@section('title')
    <title>BoomBang</title>
@endsection
@section('content')
    <div class="container">
        <div class="mt-4">

            <a href="{{ route('play') }}" target="popup" onclick="window.open('{{ route('play') }}'); return false;"
                class="btn btn-primary">Play</a>
        </div>
        <br>
        <div class="mt-4">
            <div class="play-full-screen">
            </div>
        </div>
    </div>
@endsection


@section('personal-script')
    <script>
        setTimeout(function() {
            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('set.screen') }}",
                    method: "GET",
                    data: {
                        width: window.screen.width,
                        height: window.screen.height
                    },
                    success: function(data) {
                        $('.play-full-screen').html(data.content);
                    }
                })
            })
        }, 1500)
    </script>
@endsection
