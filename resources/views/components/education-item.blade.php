@props(['education', 'index'])

@php 

    $collapse_class     = 'collapsed';
    $area_expended      = 'false';
    $show_desc_class    = '';
    if($index == 0 && !empty($education->deg_description)){
        $show_desc_class    = 'show';
        $collapse_class     = '';
        $area_expended      = 'true';
    }
@endphp
<li>
    <div class="tk-accordion_title {{$collapse_class}}" data-bs-toggle="collapse" role="button" data-bs-target="#education-{{$education->id}}" aria-expanded="{{$area_expended}}">
        <div class="tk-qualification-title">
            <h5>{!! $education->deg_title !!}</h5>
            <ul class="tk-qualifinfo">
                <li><span><i class="icon-home"></i> {!! $education->deg_institue_name !!}</span></li>
                @if(!empty($education->address))
                    <li><span><i class="icon-map-pin"></i>{!! $education->address !!}</span></li>
                @endif
                <li>
                    <span>
                        <i class="icon-calendar"></i> 
                        @if($education->is_ongoing)
                            {{ date('F d, Y', strtotime($education->deg_start_date)) }} - {{_('general.present')}}
                        @else
                            {{ date('F d, Y', strtotime($education->deg_start_date)) }}&nbsp;&nbsp;- &nbsp;&nbsp;{{ date('F d, Y', strtotime($education->deg_end_date)) }}
                        @endif
                    </span>
                </li>
            </ul>
        </div>
        @if(!empty($education->deg_description))
             <i class="icon-plus"></i>
        @endif
    </div>
    @if(!empty($education->deg_description))
        <div class="collapse {{$show_desc_class}}" id="education-{{$education->id}}" data-bs-parent="#tk-accordion">
            <div class="tk-accordion_info">
                <p>{{$education->deg_description}}</p>
            </div>
        </div>
    @endif
</li>