@props([
    'disabled' => false,
])
@php
   $name = '';
    $id         = !empty($id) ? $id : '';
    
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']';
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']';
        }
    }else{
        $name = $id;
    }
@endphp
@if( !empty($repeater_type) && $repeater_type == 'single' )
        <div class="op-rangecollpase">
            <div class="op-textcontent op-rangeslider">
                <div class="op-rangeval">
                    <span class="range-min"></span>
                    <span class="range-max"></span>
                </div>
                <div class="range-slider" data-format="{{ !empty($options['format'])  ? $options['format'] : ''}}"  data-min_value="{{ !empty($value['min'])  ? $value['min'] : ''}}" data-max_value="{{ !empty($value['max'])  ? $value['max'] : ''}}" data-option_min="{{ !empty($options['min'])  ? $options['min'] : 1}}" data-option_max="{{ !empty($options['max'])  ? $options['max'] : 100}}"></div>
            </div>         
            <div class="op-inputrangewrap form-group-wrap">
                <div class="op-rangeinput form-group-half">
                    <label class="op-range-label" for="">{{ __('optionbuilder::option_builder.min_value') }}</label>
                    <input type="number" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif data-id="{{ $id ?? '' }}"  name="{{ $name }}[min]" />
                </div>
                <div class="op-rangeinput form-group-half">
                    <label class="op-range-label" for="">{{ __('optionbuilder::option_builder.max_value') }}</label>
                        <input type="number" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif data-id="{{ $id ?? '' }}"  name="{{ $name }}[max]" />
                </div>
            </div>
        </div> 
@else
    <li class="form-group-wrap">
        @if( !empty($label_title) )
            <div class="form-group-half">
                <div class="op-textcontent">
                    <h6>
                        {!! $label_title !!}
                        @if( empty($repeater_id) && config('optionbuilder.developer_mode') == 'yes' )
                            <span class="op-alert">setting(‘{{ $tab_key }}.{{$id}}’)</span>
                        @endif
                    </h6>
                    @if( !empty( $label_desc) )
                        <em>{!! $label_desc !!}</em>
                    @endif
                </div>
            </div>
        @endif
        <div class="form-group-half">
            <div class="op-rangecollpase">
                <div class="op-textcontent op-rangeslider">
                    <div class="op-rangeval">
                        <span class="range-min"></span>
                        <span class="range-max"></span>
                    </div>
                    <div class="range-slider" data-format="{{ !empty($options['format'])  ? $options['format'] : ''}}"  data-min_value="{{ !empty($value['min'])  ? $value['min'] : ''}}" data-max_value="{{ !empty($value['max'])  ? $value['max'] : ''}}" data-option_min="{{ !empty($options['min'])  ? $options['min'] : 1}}" data-option_max="{{ !empty($options['max'])  ? $options['max'] : 100}}"></div>
                </div>         
                <div class="op-inputrangewrap form-group-wrap op-textcontent">
                    <div class="op-rangeinput form-group-half">
                        <label  class="op-range-label" for="">{{ __('optionbuilder::option_builder.min_value') }}</label>
                        <input type="number" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif data-id="{{ $id ?? '' }}"  name="{{ $name }}[min]" />
                    </div>
                    <div class="op-rangeinput form-group-half">
                        <label  class="op-range-label" for="">{{ __('optionbuilder::option_builder.max_value') }}</label>
                         <input type="number" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif data-id="{{ $id ?? '' }}"  name="{{ $name }}[max]" />
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
