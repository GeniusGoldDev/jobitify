@props(['menu'])
<li class="{{!$menu->children->isEmpty() ? 'menu-item-has-children' : ''}}">
    <a href="{{ !empty($menu->route) ? url($menu->route ) : url('/') }}">{!! ucfirst($menu->label) !!}</a>
    @if( !$menu->children->isEmpty() )
        <ul class="sub-menu">
            @foreach( $menu->children as $child)
                <x-menu-item :menu="$child" />
            @endforeach
        </ul>
    @endif
</li>
