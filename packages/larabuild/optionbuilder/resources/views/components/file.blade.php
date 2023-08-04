@props([
    'disabled' => false,
])
@php
   $name = '';
    $id         = !empty($id) ? $id : '';
    
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.'][]';
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.'][]';
            $repeater_id = "$repeater_id".'['.$index.']';
        }
    }else{

        $name = !empty($id) ? $id.'[]' : '';
    }
   
@endphp
@if( !empty($repeater_type) && $repeater_type == 'single' )
    <ul class="op-upload-img">
        <li class="op-upload-img-info">
            <div class="op-uploads-img-data">
                <label> <em><i class="icon-plus"></i></em>
                    <input type="file" data-id="{{ $id ?? '' }}"  @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif @if( !empty($repeater_id) ) data-repeater_id="{{$repeater_id}}" @endif data-max_size="{{$max_size ?? 1}}" data-ext="{{ !empty($ext) ? json_encode($ext) : '*'}}" accept="{{ !empty($ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $ext))  : '*' }}"  @if( !empty($multi) &&  $multi) data-multi_items="true" multiple @else data-multi_items="false"  @endif >
                </label>
            </div>
        </li>
        <li class="op-upload-img-info op-img-thumbnail d-none">
            <div class="op-upload-data">
                <figure>
                    <img src="#" >
                </figure>
                <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                <input type="hidden" />
            </div>
        </li>
        @if( !empty($value) )
            @if( is_array($value) )
                @foreach($value as $single )
                    <li class="op-upload-img-info op-img-thumbnail">
                        <div class="op-upload-data">
                            <figure>
                                @php
                                    $path = 'storage/'.$single['path'];
                                    if($single['type'] == 'file'){
                                        $path = 'vendor/optionbuilder/images/file-preview.png';
                                    }
                                @endphp
                                <img src="{{ asset( $path ) }}" >
                            </figure>
                            <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                            <input type="hidden" name="{{ $name }}" value="{{json_encode($single)}}" />
                        </div>
                    </li>
                @endforeach
            @endif
        @endif
    </ul>
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
                <ul class="op-upload-img">
                    <li class="op-upload-img-info">
                        <div class="op-uploads-img-data">
                            <label> <em><i class="icon-plus"></i></em>
                                <input type="file" data-id="{{ $id ?? '' }}" @if(!empty($parent_rep)) data-parent_rep="{{$parent_rep}}" @endif @if( !empty($repeater_id) ) data-repeater_id="{{$repeater_id}}"  @endif data-max_size="{{$max_size ?? 1}}" data-ext="{{ !empty($ext) ? json_encode($ext) : '*'}}" accept="{{ !empty($ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $ext))  : '*' }}"  @if( !empty($multi) &&  $multi) data-multi_items="true" multiple @else data-multi_items="false"  @endif >
                            </label>
                        </div>
                    </li>
                    <li class="op-upload-img-info op-img-thumbnail d-none">
                        <div class="op-upload-data">
                            <figure>
                                <img src="#" >
                            </figure>
                            <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                            <input type="hidden" />
                        </div>
                    </li>
                    @if( !empty($value) )
                        @if( is_array($value) )
                            @foreach($value as $single )
                                <li class="op-upload-img-info op-img-thumbnail">
                                    <div class="op-upload-data">
                                        <figure>
                                            @php
                                                $path = 'storage/'.$single['path'];
                                                if($single['type'] == 'file'){
                                                    $path = 'vendor/optionbuilder/images/file-preview.png';
                                                }
                                            @endphp
                                            <img src="{{ asset( $path ) }}" >
                                        </figure>
                                        <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                                        <input type="hidden" name="{{ $name }}" value="{{json_encode($single)}}" />
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    @endif
                </ul>
                @if( !empty($field_desc) )<span>{!! $field_desc !!}</span> @endif           
            </div>
        </div>
    </li>
@endif

