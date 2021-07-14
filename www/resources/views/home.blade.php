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
    </div>
@endsection


@section('personal-script')
    <script>
        let play = document.getElementById('play')
    </script>
@endsection
