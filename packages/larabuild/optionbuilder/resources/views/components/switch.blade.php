@props([
    'disabled' => false,
])
@php 
    $selected_value = '';
    if(isset($value) ){
        if( is_array($value) && !empty($value) ){
            $selected_value = $value;
        }else{
           $selected_value = $value; 
        }        
    }
    $tab_key_id = $id;
    $label_id       = time().'_'.rand(1,99999);
    $name = '';
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']'.(!empty($options) && is_array($options) ? '[]' :'');
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']'.(!empty($options) && is_array($options) ? '[]' :'');
        }
    }else{
        if( !empty($options) && is_array($options) ){
            $id = !empty($id) ? $id.'[]' : '';
        }
        $name = $id;
    }  
@endphp
@if( !empty($repeater_type) && $repeater_type == 'single' )
    @if( !empty($options) && is_array($options) )
        @foreach($options as $key=> $single)
            @php
                $checked = false;
                if( !empty($selected_value) ){
                    if(in_array($key, $selected_value )){
                        $checked = true; 
                    }
                }elseif( !empty($default) && is_array($default) && in_array($key, $default ) ){
                    $checked = true;   
                }
                $label_id       = time().'_'.rand(1,99999);
            @endphp
            <div class="op-switchbtn">
                <input type="checkbox" id="{{ $label_id }}" data-multi_items="true" data-id="{{ $id ?? '' }}" name="{{ $name }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif @if( $checked ) checked @endif  value="{{ $key }}" class="op-input-field  {{ $class ?? '' }}" >
                <label for="{{ $label_id }}" class="op-textdes">
                    <span>{{ $single }}</span>
                </label>
            </div>
        @endforeach
    @else
        <div class="op-switchbtn">
            <input type="checkbox" id="{{ $label_id }}" data-multi_items="false" data-id="{{ $id ?? '' }}" name="{{ $name }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif   value="{{ $value ?? '' }}" @if( $selected_value == $db_value ) checked @endif class="op-input-field  {{ $class ?? '' }}" >
            <label for="{{ $label_id }}" class="op-textdes">
                <span >{{ $field_title ?? '' }}</span>
            </label>
        </div>
    @endif
@else
    <li class="form-group-wrap">
        @if( !empty($label_title) )
            <div class="form-group-half">
                <div class="op-textcontent">
                    <h6>
                        {!! $label_title !!}
                        @if( empty($repeater_id) && config('optionbuilder.developer_mode') == 'yes' )
                            <span class="op-alert">setting(‘{{ $tab_key }}.{{$tab_key_id}}’)</span>
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
                @if( !empty($options) && is_array($options) )
                    @foreach($options as $key=> $single)
                        @php
                            $checked = false;
                            if( !empty($selected_value) ){
                                if(in_array($key, $selected_value )){
                                    $checked = true; 
                                }
                            }elseif( !empty($default) && is_array($default) && in_array($key, $default ) ){
                                $checked = true;   
                            }
                            $label_id       = time().'_'.rand(1,99999);
                        @endphp
                        <div class="op-switchbtn">
                            <input type="checkbox" id="{{ $label_id }}" data-multi_items="true" data-id="{{ $id ?? '' }}" name="{{ $name }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif @if( $checked ) checked @endif  value="{{ $key }}" class="op-input-field  {{ $class ?? '' }}" >
                            <label for="{{ $label_id }}" class="op-textdes">
                                <span>{{ $single }}</span>
                            </label>
                        </div>
                    @endforeach
                @else
                    <div class="op-switchbtn">
                        <input type="checkbox" id="{{ $label_id }}" data-multi_items="false" data-id="{{ $id ?? '' }}" name="{{ $name }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif   value="{{ $value ?? '' }}" @if( $selected_value == $db_value ) checked @endif class="op-input-field  {{ $class ?? '' }}" >
                        <label for="{{ $label_id }}" class="op-textdes">
                            <span >{{ $field_title ?? '' }}</span>
                        </label>
                    </div>
                @endif
                @if( !empty($field_desc) )<span>{!! $field_desc !!}</span> @endif           
            </div>
        </div>
    </li>
@endif
