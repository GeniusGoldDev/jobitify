@props(['project','currency_symbol', 'address_format', 'list_type' => 'search_project' , 'favourite_projects' => [], 'user_role' ])
@php 
    $tag        = '';
    if($list_type == 'fav_project'){
        $proposal = $project->proposals->first();
        if(!empty( $proposal ) ){
            $tag = getTag( $proposal->status );
        }
    }
 
    $fav_class  = '';
    $_text      = __('general.save');
    if(in_array($project->id, $favourite_projects) || $list_type == 'fav_project'){
        $fav_class =  'tk-saved tk-liked';
        $_text =  __('general.saved');
    }

@endphp
<div class="tk-project-wrapper-two">
    @if($project->is_featured)
        <x-featured-tippy />
    @endif
    <span class="tk-project-tag-two {{ $project->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated' }}">
        {{ $project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project') }}
    </span>

    <div class="tk-project-box">
        <div class="tk-price-holder">
            <div class="tk-verified-info">

                @if(!empty($tag) )
                    <span class="{{ $tag['class'] }}">{{ $tag['text'] }}</span>
                @endif

                <a href="javascript:void(0)">
                    {{  $project->projectAuthor->full_name}}
                    <x-verified-tippy />
                </a>
                <h5>{{ $project->project_title }}</h5>
                <ul class="tk-template-view">
                    <li>
                        <i class="icon-calendar"></i>
                        <span> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )]) }} </span>
                    </li>
                    <li>
                        <i class="icon-map-pin"></i>
                        <span> {{ $project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name }} </span>
                    </li>
                    <li>
                        <i class="icon-check-circle"></i>
                        <span> {{ !empty($project->expertiseLevel) ? $project->expertiseLevel->name : '' }} </span>
                    </li>
                    <li>
                        <i class="{{ $project->project_hiring_seller > 1 ? 'icon-users' : 'icon-user' }}"></i>
                        <span>{{ $project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span>
                    </li>
                    @if(!is_null($project->project_visits_count))
                        <li>
                            <span>
                                <i class="icon-eye"></i>
                                {{ $project->project_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($project->project_visits_count) ] ) }}
                            </span>
                        </li>
                    @endif
                    @if($user_role == 'seller' || Auth::guest())
                        <li class="{{ $fav_class }} mt-0" wire:click.prevent="saveItem({{$project->id}})">
                            <i class="icon-heart"></i>
                            <a href="javascript:void(0)">{{ $_text}}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="tk-price">
                <span> {{ __('project.project_budget')   }}</span>
                <h4>{{ getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price) }}</h4>
                <div class="tk-project-option">
                    <a href="{{ route('project-detail', ['slug'=> $project->slug] ) }}" target="_blank" class="tk-invite-bidbtn">{{ __('project.view_detail') }}</a>
                </div>
            </div>
        </div>
        @if(!empty($project->project_description))
            @php 
                $description    = @json_decode($project->project_description);
                $desc           = '';
                if(!empty($description)){
                    $string         = preg_replace("/<br>|\n|\r|<br( ?)\/>/", " ", $description );
                    $desc           = strip_tags(trim($string));
                }
            @endphp
            @if(!empty($desc))
                <div class="tk-descriptions">
                    <p>{!! nl2br(add3DotsInText( $desc, '...', 230)) !!}</p>
                </div>
            @endif
        @endif
        @if(!$project->skills->isEmpty())
            <div class="tk-freelancer-holder">
                <ul class="tk-tags_links">
                    @foreach($project->skills as $skill)
                        <li>
                            <span class="tk-blog-tags">{{ $skill->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>