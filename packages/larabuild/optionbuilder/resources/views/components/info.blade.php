
@if( !empty($label_title) )
    <li class="op-separator-wrap">
        <div class="op-textcontent">
            <h6>{!! $label_title !!}</h6>
            @if( !empty( $label_desc) )
                <em>{!! $label_desc !!}</em>
            @endif
        </div>
    </li>
@endif

