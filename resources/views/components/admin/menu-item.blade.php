@props(['menu'])
<li class="dd-item" data-id="{{$menu->id}}">
    <div class="tb-menuaccordion_wrap">
        <div class="tb-menuaccordion_header" id="menu-accordion-{{$menu->id}}">
            <a href="javascript:void(0);" class="tb-slotchange dd-handle"><img src="{{asset('images/sort-icon.svg')}}" ></a>
            <div class="tb-checkbox">
                <input id="item-{{ $menu->id }}" value="{{ $menu->id }}" type="checkbox">
                <label for="item-{{ $menu->id }}">{{ $menu->label }}</label>
            </div>
            <span class="tb-accordionmenu" data-bs-toggle="collapse" data-bs-target="#accordionmenu-{{$menu->id}}" aria-expanded="false">{{ $menu->type == 'page' ? __('pages.pages') : __('pages.custom') }} <i class="icon-chevron-right"></i> </span>
        </div>
        <div id="accordionmenu-{{$menu->id}}" class="collapse" aria-labelledby="menu-accordion-{{$menu->id}}" data-parent="#menu-items">
            <div class="tb-menuaccordion_content">
                <div class="form-group">
                    <label class="tb-titleinput"> {{ __('pages.add_label') }}  </label>
                    <input type="text" name="item-name[{{$menu->id}}]" value="{{ $menu->label }}" class="form-control" placeholder="{{ __('pages.add_label') }}">
                </div>
                <div class=" form-group">
                    <label class="tb-titleinput">{{ __('pages.enter_url') }}</label>
                    <input type="text" name="item-route[{{$menu->id}}]" value="{{ $menu->route }}" class="form-control" placeholder="{{ __('pages.enter_url') }}">
                </div>
                <input type="hidden" name="item-type[{{$menu->id}}]" value="{{ $menu->type }}" >
                <div class="form-group">
                    <a href="javascript:void(0);" class="tb-removemenu remove-item">{{__('pages.delete_menu') }} <i class="icon-trash-2"></i></a>
                </div>
            </div>
        </div>
    </div>
    @if( !$menu->children->isEmpty() ) 
        <ol class="tb-menuaccordion_child dd-list">
            @foreach( $menu->children as $child)
                <x-admin.menu-item :menu="$child" />
            @endforeach
        </ol>
    @endif
</li>
