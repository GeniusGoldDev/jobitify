@props([
    'disabled' => false,
])
@php                    
    $selected_value = !empty($value) ? $value : []; 
    $name = '';
    $tab_key_id = $id;
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']'.(!empty($options) && !empty($multi) && $multi ? '[]' :'');
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']'.(!empty($options) && !empty($multi) && $multi ? '[]' :'');
        }
    }else{
        if( !empty($options) && is_array($options) && !empty($multi) && $multi ){
            
            $id = !empty($id) ? $id.'[]' : '';
        }
        $name = $id;
    }  
@endphp

@if( !empty($repeater_type) && $repeater_type == 'single' )
    @if( !empty($options) && is_array($options) )         
        <div class="op-select"> 
            <select @if(!empty($multi) && $multi) multiple data-multi_items="true" @endif class="op-input-field form-control op-selectoption {{ $class ?? '' }}" data-id="{{ $id ?? '' }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif name="{{ $name }}" data-placeholder="{{$placeholder ?? ''}}">
                
                @foreach($options as $key=> $single)
                    @php
                        $selected = false;
                        if( !empty($selected_value) ){
                            if( is_array($selected_value) && in_array($key, $selected_value ) ){
                                $selected = true;    
                            }elseif( $selected_value == $key ){
                                $selected = true;     
                            }
                        }elseif( !empty($default) ){
                            if( is_array($default) && in_array($key, $default ) ){
                                $selected = true;    
                            }elseif( $default == $key ){
                                $selected = true;     
                            }
                        }
                    @endphp
                    <option value="{{ $key }}" {{ $selected ? 'selected' : '' }}>{{ $single }}</option>
                @endforeach    
            </select>
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
                    <div class="op-select"> 
                        <select @if(!empty($multi) && $multi) multiple data-multi_items="true" @endif class="op-input-field form-control op-selectoption {{ $class ?? '' }}" data-id="{{ $id ?? '' }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif name="{{ $name  }}"   data-placeholder="{{$placeholder ?? ''}}">
                            
                            @foreach($options as $key=> $single)
                                @php
                                    $selected = false;
                                    if( !empty($selected_value) ){
                                        if( is_array($selected_value) && in_array($key, $selected_value ) ){
                                            $selected = true;    
                                        }elseif( $selected_value == $key ){
                                            $selected = true;     
                                        }
                                    }elseif( !empty($default) ){
                                        if( is_array($default) && in_array($key, $default ) ){
                                            $selected = true;    
                                        }elseif( $default == $key ){
                                            $selected = true;     
                                        }
                                    }
                                @endphp
                                <option value="{{ $key }}" {{ $selected ? 'selected' : '' }}  >{{ $single }}</option>
                            @endforeach    
                        </select>
                    </div>
                @endif    
                @if( !empty($field_desc) )<span>{!! $field_desc !!}</span> @endif           
            </div>
        </div>
    </li>
@endif
