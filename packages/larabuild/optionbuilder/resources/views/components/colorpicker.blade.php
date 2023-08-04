@props([
    'disabled' => false,
])
@php
    $name = '';
    $id = !empty($id) ? $id : '';

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
    <div class="op-colorpicker">
        <div class="op-inputbtn-wrapper colorPicker">
            <input  type="text" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif  data-id="{{ $id ?? '' }}"  name="{{ $name }}"  value="{{ $value ?? '' }}" class="op-input-field form-control getcolor {{ $class ?? '' }}" placeholder="{{ $placeholder ?? '' }}">
            <span class="op-inputbtn"><span class="colorPicker--preview"></span></span>
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
            <div class="op-textcontent">
                <div class="op-inputbtn-wrapper colorPicker">
                    <input  type="text" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif  data-id="{{ $id ?? '' }}"  name="{{ $name }}"  value="{{ $value ?? '' }}" class="op-input-field form-control getcolor {{ $class ?? '' }}" placeholder="{{ $placeholder ?? '' }}">
                    <span class="op-inputbtn"><span class="colorPicker--preview"></span></span>
                </div>
                @if( !empty($field_desc) )<span>{!! $field_desc !!}</span> @endif           
            </div>
        </div>
    </li>
@endif
