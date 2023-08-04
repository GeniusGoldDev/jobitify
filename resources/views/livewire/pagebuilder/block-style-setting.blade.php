<div wire:ignore.self class="tab-pane fade" id="style-setting">
    @if( empty($block_id) )
        <div class="at-empty-block-settings">
        <span>{{ __('pages.no_block_style_settings')}}</span>
        </div>
    @else
        <div class="at-pagebuilder-navs">
            <form id="at-style-form">
                <div class="at-template-sections">
                    <div  wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#postion-setting" aria-expanded="true">
                        <strong>{{ __('pages.position_settings') }}</strong> 
                    </div>
                    <div wire:ignore.self id="postion-setting" class="collapse show">
                        <div class="at-components-content">
                            <ul class="at-style-component">
                                <li>
                                    <label class="at-label">{{ __('pages.width') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $position['width'] }}" class="form-control" name="position[width]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.height') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $position['height'] }}" class="form-control" name="position[height]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.min_width') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $position['min_width'] }}" class="form-control" name="position[min_width]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.min_height') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $position['min_height'] }}" class="form-control" name="position[min_height]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.max_width') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $position['max_width'] }}" class="form-control" name="position[max_width]" placeholder="{{ __('pages.enter_value')}}">
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.max_height') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $position['max_height'] }}" class="form-control" name="position[max_height]" placeholder="{{ __('pages.enter_value')}}">
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="at-template-sections">
                    <div  wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#padding-setting" aria-expanded="true">
                        <strong>{{ __('pages.padding_settings') }}</strong> 
                    </div>
                    <div wire:ignore.self id="padding-setting" class="collapse show">
                        <div class="at-components-content">
                            <ul class="at-style-component">
                                <li>
                                    <label class="at-label">{{ __('pages.padding_top') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $padding['top'] }}" class="form-control" name="padding[top]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.padding_right') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $padding['right'] }}" class="form-control" name="padding[right]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.padding_bottom') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $padding['bottom'] }}" class="form-control" name="padding[bottom]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.padding_left') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $padding['left'] }}" class="form-control" name="padding[left]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="at-template-sections">
                    <div  wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#margin-setting" aria-expanded="false">
                        <strong>{{ __('pages.margin_settings') }}</strong> 
                    </div>
                    <div wire:ignore id="margin-setting" class="collapse">
                        <div class="at-components-content">
                            <ul class="at-style-component">
                                <li>
                                    <label class="at-label">{{ __('pages.margin_top') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $margin['top'] }}" class="form-control" name="margin[top]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.margin_right') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $margin['right'] }}" class="form-control" name="margin[right]" placeholder="{{ __('pages.enter_value')}}"  >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.margin_bottom') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $margin['bottom'] }}" class="form-control" name="margin[bottom]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label">{{ __('pages.margin_left') }}</label>
                                    <div class="at-inputicon">
                                        <input type="number" value="{{ $margin['left'] }}" class="form-control" name="margin[left]" placeholder="{{ __('pages.enter_value')}}" >
                                        <i><span class="at-pixel">{{ __('pages.px') }}</span></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="at-template-sections">
                    <div wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#text-align" aria-expanded="false">
                        <strong>{{ __('pages.advance_settings') }}</strong> 
                    </div>
                    <div wire:ignore.self id="text-align" class="collapse">
                        <div class="at-components-content">
                            <label class="at-label">{{ __('pages.text_alignment') }}</label>
                            <input type="hidden" id="at_text_align_input" data-block_key="{{$block_key}}" name="text_align" value="" />
                            <ul class="at-aligntext-style">
                                <li class="{{ $text_align == 'left' ? 'active' : '' }}" data-value="left">
                                    <label for="at-aligin-left"><i class="icon-align-left"></i></label>
                                </li>
                                <li class="{{ $text_align == 'right' ? 'active' : '' }}" data-value="right">
                                    <label for="at-aligin-right"><i class="icon-align-right"></i></label>
                                </li>
                                <li class="{{ $text_align == 'center' ? 'active' : '' }}" data-value="center">
                                    <label for="at-aligin-center"><i class="icon-align-center"></i></label>
                                </li>
                                <li class="{{ $text_align == 'justify' ? 'active' : '' }}" data-value="justify">
                                    <label for="at-justify-center"><i class="icon-align-justify"></i></label>
                                </li>
                            </ul>
                        </div>
                        <div class="at-components-content">
                            <label class="at-label">{{ __('pages.custom_class') }}</label>
                            <input class="w-100" type="text" id="at_custom_class" data-block_key="{{$block_key}}" name="custom_class" value="{{$custom_class}}" />
                            <p>{{__('pages.custom_class_desc')}}</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            document.addEventListener('updateStyleClass', event => {
                let _class = event.detail.class;
                let _style = event.detail.style;
                if($(document).find('.'+ _class + ' style').length){
                    $(document).find('.'+ _class + ' style').html(_style);
                } else {
                    $(document).find('.'+ _class).append(`<style>${_style}</style>`);
                }
            });

            $(document).on('click', 'ul.at-aligntext-style li', function(e){
                let _this = $(this);
                let value       = _this.data('value');
                let isActive    = _this.hasClass('active');
                let input       = $('#at_text_align_input');
                $('ul.at-aligntext-style li').removeClass('active');

                if(isActive){
                    input.val('')
                    _this.removeClass('active');
                } else {
                    _this.addClass('active');
                    input.val(value) 
                }
                input.change();
            });
        });
    </script>
@endpush
   