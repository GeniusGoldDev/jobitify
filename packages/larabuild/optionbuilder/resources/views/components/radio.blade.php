@props([
    'disabled' => false,
])
@php 
    
    $selected_value = (isset($value) && !is_null($value) ? $value :(isset($default) && !is_null($default) ? $default :  '')); 
    $name = '';
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
    @if( !empty($options) && is_array($options) )
        @foreach($options as $key=> $single)
            @php
                $label_id       = time().'_'.rand(1,99999);
            @endphp
            <div class="op-radiobtn">
                <input type="radio" id="{{ $label_id }}"  @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif data-id="{{ $id }}" name="{{ $name  }}" @if( $selected_value == $key ) checked @endif  value="{{ $key }}" class="op-input-field {{ $class ?? '' }}" >
                <label for="{{ $label_id }}">{{ $single }}</label>
            </div>
        @endforeach
    @endif
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
        @if( !empty($options) && is_array($options) )
            <div class="form-group-half">
                <div class="op-textcontent">
                    @foreach($options as $key=> $single)
                        @php
                            $label_id       = time().'_'.rand(1,99999);
                        @endphp
                        <div class="op-radiobtn">
                            <input type="radio" id="{{ $label_id }}" data-id="{{ $id }}" name="{{ $name  }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif @if( $selected_value == $key ) checked @endif  value="{{ $key }}" class="op-input-field {{ $class ?? '' }}" >
                            <label for="{{ $label_id }}">{{ $single }}</label>
                        </div>
                    @endforeach
                    @if( !empty($field_desc) )<span>{!! $field_desc !!}</span> @endif           
                </div>
            </div>
        @endif
    </li>
@endif
