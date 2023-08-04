<main class="tb-main tb-mainbg" wire:key="{{time()}}">
    <div class="row">
        <div class="col-12">
            <div class="tb-dhb-mainheading pb-0">
                <h2> {{__('pages.menu_management') }}</h2>
                <div class="tb-sortingoption">
                    <a href="javascript:void(0);" wire:click.prevent="addMenu" class="tb-menubtn">{{ __('pages.add_new_menu') }} <i class="icon-plus"></i></a>
                    <div class="tb-selectoption">
                        <span class="tb-select">
                            <select wire:model="menu_id">
                                <option>{{ __('pages.select_menu') }}</option>
                                @if( !$menu_list->isEmpty() )
                                    @foreach($menu_list as $single )
                                        <option value="{{$single->id}}">{{$single->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="tb-accordion {{ !$menu_id ? 'disabled' : '' }}" id="theme-accordion">
                @if( !$site_pages->isEmpty() )  
                    <div class="tb-accordion_wrap" wire:ignore>
                        <div class="tb-accordion_header" id="accordionone">
                            <h2 data-bs-toggle="collapse" data-bs-target="#tb-collapseone" aria-expanded="true">{{__('pages.pages') }}</h2>
                        </div>
                        <div id="tb-collapseone" class="collapse show" aria-labelledby="accordionone" data-parent="#theme-accordion">
                            <div class="tb-accordion_content tb-menupages_list">
                                <div class="tb-addmenupages mCustomScrollbar">
                                    @foreach($site_pages as $single)
                                        <div class="tb-checkbox">
                                            <input id="page-{{$single->id}}"  value="{{$single->id}}"  type="checkbox">
                                            <label for="page-{{$single->id}}">{{ $single->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="tb-menupages_footer">
                                    <div class="tb-checkbox">
                                        <input id="select_pages" name="select_pages" type="checkbox">
                                        <label for="select_pages">{{ __('pages.select_all_pages') }}</label>
                                    </div>
                                    <a href="javascript:void(0);" class="tb-btn add-menu-pages">{{ __('pages.add_to_menu') }}</a>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                @endif
                <div class="tb-accordion_wrap">
                    <div class="tb-accordion_header" id="accordiontwo">
                        <h2 data-bs-toggle="collapse" data-bs-target="#tb-collapsetwo" aria-expanded="true">{{ __('pages.custom_url') }}</h2>
                    </div>
                    <div id="tb-collapsetwo" class="collapse show" aria-labelledby="accordiontwo" data-parent="#theme-accordion">
                        <div class="tb-accordion_content">
                            <form class="tb-themeform tb-form-menu">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="tb-titleinput">{{ __('pages.add_label') }}</label>
                                        <input type="text" wire:model.defer="custom_page_title" class="form-control  @error('custom_page_title') tk-invalid @enderror" placeholder="{{ __('pages.add_label') }}">
                                        @error('custom_page_title')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class=" form-group">
                                        <label class="tb-titleinput">{{ __('pages.enter_url') }}</label>
                                        <input type="text" wire:model.defer="custom_page_route" class="form-control" placeholder="{{ __('pages.enter_url') }}">
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:void(0);" class="tb-btn" wire:click.prevent="addCustomPage">{{ __('pages.add_to_menu') }}</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-8">
            <div class="tb-addmenu">
                <div class="tb-addmenu_head">
                    <label class="tb-titleinput">{{ __('pages.menu_title') }} </label>
                    <input type="text" wire:model.defer="menu_title" class="form-control @error('menu_title') tk-invalid @enderror" placeholder="{{ __('pages.menu_title') }}">
                    @error('menu_title')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span> 
                        </div>
                    @enderror
                </div>
                <div class="tb-addmenu_content">
                    @if( $menu_id )
                        <p>{{ __('pages.menu_arrange') }}</p>
                        @if( !empty($menu_items) && $menu_items->count() > 0)
                            <div class="tb-selectmenu">
                                <div class="tb-checkbox">
                                    <input id="select-menu-items" class="select-menu-items" type="checkbox">
                                    <label for="select-menu-items">{{ __('pages.select_all_menu') }}</label>
                                </div>
                                <a href="javascript:void(0);" class="tb-removemenu d-none remove-selected-items">{{ __('pages.remove_selected_menu') }}<i class="icon-trash-2"></i></a>
                            </div>
                            <div class="dd" id="menu-items-edit">
                                <form class="tb-themeform tb-form-menu menu-item-form">
                                    <ol class="tb-menuaccordion dd-list" id="menu-items">
                                        @foreach($menu_items as $single)
                                            <x-admin.menu-item :menu="$single" />
                                        @endforeach
                                    </ol>
                                    <input type="hidden" name="updateItems" id="updateItems">
                                    <input type="hidden" name="removalIds" id="removalIds">
                                </form>
                            </div>
                            <div class="tb-selectmenu">
                                <div class="tb-checkbox">
                                    <input id="allselectmenu" class="select-menu-items" type="checkbox">
                                    <label for="allselectmenu">{{ __('pages.select_all_menu') }}</label>
                                </div>
                                <a href="javascript:void(0);" class="tb-removemenu d-none remove-selected-items">{{ __('pages.remove_selected_menu') }} <i class="icon-trash-2"></i></a>
                            </div>
                        @else
                            <div class="tb-addheremenu">
                                <span>{{ __('pages.no_menu_items_found') }}</span>
                            </div>
                        @endif
                    @endif
                    <div class="tb-selectmenu_position">
                        <h6>{{ __('pages.menu_position') }}</h6>
                        <ul class="tb-menuposition_list">
                            <li>
                                <div class="tb-radiobox">
                                    <input id="menu-header" {{ $menu_location == 'header' ? 'checked' : '' }} name="menu_location" value="header" type="radio">
                                    <label for="menu-header">{{ __('pages.add_header_menu') }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="tb-radiobox">
                                    <input id="menu-footer" {{ $menu_location == 'footer' ? 'checked' : '' }} name="menu_location" value="footer" type="radio">
                                    <label for="menu-footer">{{ __('pages.add_footer_menu') }}</label>
                                </div>
                            </li>
                        </ul>
                        @error('menu_location')
                            <div class="tk-errormsg">
                                <span>{{$message}}</span> 
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="tb-addmenu_footer">
                    <a href="javascript:void(0);" class="tb-btn {{ !$add_menu && $menu_id ? 'update-menu-items' : '' }}" wire:click.prevent="{{ $add_menu && !$menu_id ? 'createMenu' : '' }}">{{ __('pages.save_menu') }}</a>
                    @if( $menu_id )<a href="javascript:void(0);" class="tb-removemenu" onClick="deleteMenu({{$menu_id}})">{{ __('pages.delete_menu') }} <i class="icon-trash-2"></i></a>@endif
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
    <script defer src="{{ asset('admin/js/vendor/jquery.nestable.min.js')}}"></script>
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var removal_Ids = [];
            setTimeout(function() {

                $('.tb-menuposition_list input[type="radio"]').on('click', function (e) {
                    $('.tb-menuposition_list input[type="radio"]').prop('checked', false);
                    $(this).prop('checked', true);
                    @this.set('menu_location', e.target.value, true);
                });

                $('.add-menu-pages').on('click', function (e) {
                    let page_ids = [];
                    $(".tb-menupages_list input[type='checkbox']:checked").not('#select_pages').each(function(){
                        page_ids.push(this.value); 
                    });
                    if( page_ids != '' ){
                        @this.set('page_ids', page_ids, true);
                        @this.call('addPages');
                        $('.tb-menupages_list input[type="checkbox"]').prop('checked', false);
                    }
                });

                $("#select_pages").on('click', function(){
                    $('.tb-menupages_list input[type="checkbox"]').prop('checked', this.checked);
                });

                $(document).on('click', '.select-menu-items', function(e) {
                    if(this.checked){
                        $('.remove-selected-items').removeClass('d-none');
                    }else{
                        $('.remove-selected-items').addClass('d-none');
                    }
                    $('.tb-menuaccordion_wrap input[type="checkbox"]').prop('checked', this.checked);
                });

                $(document).on('click', '.tb-menuaccordion_wrap input[type="checkbox"]', function(e) {
                    let checked= $('.tb-menuaccordion_wrap input[type="checkbox"]:checked');
                    if(checked.length){
                        $('.remove-selected-items').removeClass('d-none');
                    }else{
                        $('.remove-selected-items').addClass('d-none');
                    }
                });
                $(document).on('click', '.update-menu-items', function(e) {
                    if(removal_Ids.length){
                        $('#removalIds').val(window.JSON.stringify(removal_Ids))
                    }
                    updateItems($('#menu-items-edit').data('output', $('#updateItems')));
                    let form = $('.menu-item-form').serialize();
                    @this.call('updateMenuItems', form);
                    removalIds = [];
                });

                let updateItems = function(e){
                    let list   = e.length ? e : $(e.target),
                    output = list.data('output');
                    if (typeof output != 'undefined' && window.JSON) {
                        output.val(window.JSON.stringify(list.nestable('serialize')));
                    }
                };
                
                window.addEventListener('initializeSortable', event=>{

                    $('#menu-items-edit').nestable({
                        group: 1,
                        maxDepth:10
                    }).on('change', updateItems);
                    
                    updateItems($('#menu-items-edit').data('output', $('#updateItems')));
                });

                $(document).on('change', ".dd-item input[type='checkbox']", function(e) {
                    let _this = jQuery(this);
                    let isChecked = _this.is(':checked');
                    _this.closest('.dd-item').each(function(index, ev){
                        let __this = jQuery(this);
                        __this.find("input[type='checkbox']").prop('checked', isChecked);
                    });
                });

                $(document).on('click', '.remove-selected-items', function(e) {
                    
                    $(".dd-item input[type='checkbox']:checked").each(function(e){
                        let _this = jQuery(this);
                        removal_Ids.push(_this.val())
                        _this.closest('.dd-item').remove();
                    });
                    if( $('ol#menu-items li').length == 0 ){
                        $('.tb-selectmenu').remove()
                    }
                });

                $(document).on('click', '.remove-item', function(e) {
                    let _this= $(this);
                    _this.closest('.dd-item').each(function(index, ev){
                        let __this = jQuery(this);
                        __this.find("input[type='checkbox']").each(function(i){
                            removal_Ids[i] = $(this).val();
                        });
                    });
                    $(this).closest('li').remove();
                    
                    if( $('ol#menu-items li').length == 0 ){
                        $('.tb-selectmenu').remove()
                    }
                });

            }, 50);
        });
    
        function deleteMenu( id ){
            
            let title           = '{{ __("general.confirm") }}';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'confirmDeleteMenu';
            let type_color      = 'red';
            let btn_class       = 'danger';
            ConfirmationBox({title, content, action, id,  type_color, btn_class})
        }
    </script>
@endpush('scripts')