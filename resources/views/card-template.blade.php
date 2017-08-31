<{{ $tag }} class="game-card {{ $class or '' }}" data-id="{{ $card['id'] }}"{!! isset($style) ? ' style="' . $style . '"' : '' !!}
            data-require-suit="{{ (empty($card['suit_id']) || ($card['Action'] && $card['Action']['require_suit'])) ? 1 : 0 }}"
>
    <div class="info">
        <div class="item">{{ $card['name'] }}</div>
        @if($card['Suit'])
            <div class="item">
                <img src="{{ asset('assets/img/upload/suits/' . $card['Suit']['icon']) }}" width="15">
            </div>
        @endif
    </div>
    @if(isset($icons) && $icons)
        <div class="icons">
            <a href="#" title="Editar"
               data-toggle="modal" data-target="#modal-card"
               data-load="{{ route('admin.cards.edit', ['id' => $card['id']]) }}"
            >
                <b class="fa fa-edit"></b>
            </a>
            <a href="#" class="delete" title="Excluir"
               data-toggle="modal" data-target="#modal-card-delete"
               data-action="{{ route('admin.cards.destroy', ['id' => $card['id']]) }}"
            >
                <b>&times;</b>
            </a>
        </div>
    @endif
    @if(empty($card['image']))
        <div class="large fit-height">{{ $card['name'] }}</div>
    @else
        <div class="large center-block-absolute">
            <img src="{{ asset('assets/img/upload/cards/' . $card['image']) }}">
        </div>
    @endif
    <div class="info-bottom">
        @if($card['Suit'])
            <div class="item">
                <img src="{{ asset('assets/img/upload/suits/' . $card['Suit']['icon']) }}" width="15">
            </div>
        @endif
        <div class="item">{{ $card['name'] }}</div>
    </div>
</{{ $tag }}>