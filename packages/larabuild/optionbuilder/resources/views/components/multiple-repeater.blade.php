@props([
    'disabled' => false,
])
<li class="form-group-wrap op-textcontent">
    @if( !empty($label_title) )
        <div class="form-group-half">
            <div class="op-textcontent">
                <h6>
                    {!! $label_title !!}
                    @if( config('optionbuilder.developer_mode') == 'yes' )
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
            <div class="accordion op-accordion" id="{{$id ?? ''}}">
                @if( !empty($value) && is_array($value) )
                    @php
                        $title_index = 1;
                    @endphp
                    @foreach($value as $index=> $single )
                        @php
                            $mapping_fields = !empty($fields) && is_array($fields) ? $fields : [];
                        @endphp
                        <div class="op-accordion-item">
                            <div class="op-item">
                                <h2 data-bs-toggle="collapse" class="op-collase-sec" data-title="{{ $repeater_title ?? '' }}" data-bs-target="#op-rep-accord-{{$index}}" aria-expanded="false">{{ $repeater_title ?? '' }} {{ $title_index++ }}</h2>
                                <div class="op-icons">
                                    <a href="javascript:void(0)" data-repeater_id="{{$id ?? ''}}" class="op-trashclr op-trash-mul-rep"> <i class="icon-trash-2"></i></a>
                                    <span class="op-accordion-angle op-collase-sec" data-bs-toggle="collapse" data-bs-target="#op-rep-accord-{{$index}}" aria-expanded="false"><i class="icon-chevron-right"></i></span>
                                </div>
                            </div>
                            <div id="op-rep-accord-{{$index}}" class="accordion-collapse collapse" data-bs-parent="#{{$id ?? ''}}">
                                <div class="accordion-body">
                                    @if( !empty($mapping_fields) && is_array($mapping_fields) )
                                        @php
                                            foreach($single as $key=> $item){
                                                $field_index = array_search($key, array_column($mapping_fields, 'id'));
                                                if( $field_index !== false ){
                                                    $mapping_fields[$field_index]['value'] = $item;
                                                }
                                            }
                                        @endphp
                                        {!! getSectionSetting(['tab_key' => $tab_key, 'index' => $index, 'repeater_id' => ($id ??  '') ], $mapping_fields) !!}
                                    @endif    
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="op-accordion-item">
                        <div class="op-item">
                            <h2 data-bs-toggle="collapse" class="op-collase-sec" data-title="{{ $repeater_title ?? '' }}" data-bs-target="#op-rep-accord-0" aria-expanded="false">{{ $repeater_title ?? '' }}</h2>
                            <div class="op-icons">
                                <a href="javascript:void(0)" data-repeater_id="{{$id ?? ''}}" class="op-trashclr op-trash-mul-rep"> <i class="icon-trash-2"></i></a>
                                <span class="op-accordion-angle op-collase-sec" data-bs-toggle="collapse" data-bs-target="#op-rep-accord-0" aria-expanded="false"><i class="icon-chevron-right"></i></span>
                            </div>
                        </div>
                        <div id="op-rep-accord-0" class="accordion-collapse collapse" data-bs-parent="#{{$id ?? ''}}">
                            <div class="accordion-body">
                                @if( !empty($fields) && is_array($fields) )
                                    {!! getSectionSetting(['tab_key' => $tab_key, 'index' => rand(1,999).time(), 'repeater_id' => ($id ??  '') ], $fields) !!}
                                @endif    
                            </div>
                        </div>
                    </div>     
                @endif        
            </div> 
        </div>
        <div class="op-add-dwonload">
            <a class="op-btn-two more-mul-rep" data-repeater="{{$id ?? ''}}" href="javascript:;"><i class="icon-plus"></i>{{ __('optionbuilder::option_builder.add_more') }}</a>
        </div>
    </div>
</li>
