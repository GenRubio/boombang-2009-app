@extends('layouts.app')
@section('title')
    <title>BoomBang Game Luncher</title>
@endsection
@section('personal-style')
    <style>
      .container-game{
          width: 1013px;
          height: 658px;
          position: absolute;
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
            ver: '4828183727',
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
            '1013px',
            '658px',
            '9.0.115',
            './http://boombang.tv/swfobject/expressInstall.swf/',
            flashvars, params, attributes
        );
    })();

</script>

<div id="bb_swf_container" class="container-game">
    <object type="application/x-shockwave-flash" id="flash_boombang">
        <param name="movie" id="flash_boombang" />
    </object>
</div>
@endsection