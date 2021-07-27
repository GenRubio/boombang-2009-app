@extends('layouts.app')
@section('title')
    <title>BoomBang Game Luncher</title>
@endsection
@section('personal-style')
    <style>
        .log-out{
            color: white;
            font-size:40px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <script type="text/javascript" src="{{ asset('js/play/common.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/play/swfobject.js') }}"></script>
    <script type="text/javascript">
        (function() {
            var flashvars = {
                sw1: '',
                sw2: '',
                sw3: '',
                sw4: '',
                sw5: '0',
                lang: 'e',
                locale: 'es_ES',
                ver: '4828183723',
            };
            var params = {
                play: 'true',
                loop: 'false',
                quality: 'high',
                allowscriptaccess: 'always',
                allowFullScreen: 'true',
                bgcolor: '#0099cc',
            };
            var attributes = {
                id: 'flash_boombang'
            };
            swfobject.embedSWF(
                "{{ url('/static/flash_esp/BoomBangLoader.swf') }}",
                'flash_boombang',
                '{{ $width }}px',
                '{{ $height }}px',
                '9.0.115',
                './http://boombang.tv/swfobject/expressInstall.swf/',
                flashvars, params, attributes
            );
        })();
    </script>

    <div id="bb_swf_container" style=" width: {{ $width }}px; height: {{ $height }}px; position: absolute;">
        <object type="application/x-shockwave-flash" id="flash_boombang">
            <param name="movie" id="flash_boombang" />
        </object>
    </div>
    <div class="container-fluid" style="position: absolute; z-index:99999;">
        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6 pt-3 pr-5">
                <div class="d-flex justify-content-end log-out">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('personal-script')
    <script>
        setTimeout(function() {
            $(document).ready(function(){
            $('.log-out').click(function(){
                window.close();
            })
        });
        }, 1500)
    </script>
@endsection
