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

            <a href="{{ route('play.full.hd') }}" target="popup" onclick="window.open('{{ route('play.full.hd') }}'); return false;"
                class="btn btn-primary">Play HD</a>
        </div>
    </div>
@endsection


@section('personal-script')

@endsection
