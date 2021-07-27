<a class="btn btn-primary" href="{{ route('play.full.screen', ['height' => $height, 'width' => $width]) }}"
    target="popup"
    onclick="window.open('{{ route('play.full.screen', ['height' => $height, 'width' => $width]) }}'); return false;">
    Play Full Screen
</a>
