<main>
    <section class="tk-main-section tk-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box">
                            <div class="tk-servicedetailtitle">
                                @if($project->is_featured)
                                    <span wire:ignore data-tippy-content="{{__('settings.featured_project')}}" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                @endif
                                <h3>{{ $project->project_title }}</h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )]) }}</span></li>
                                    <li><span><i class="icon-map-pin"></i> {{ $project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            @php
                                $video_url = '';
                                $files = '';
                                if(!empty($project->attachments)){
                                    $attachments = unserialize($project->attachments);
                                    if(!empty($attachments['video_url'])){
                                        $video_url = $attachments['video_url'];
                                    }
                                    if(!empty($attachments['files'])){
                                        $files = $attachments['files'];
                                    }
                                }
                            @endphp
                            @if($video_url != '')
                                <div class="tk-project-holder">
                                    @php
                                        $width		= 780;
                                        $height		= 402;
                                        $url 			= parse_url( $video_url );
                                        $video_html		= '';
                                        if ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com') {
                                            $video_html	.= '<figure class="tk-projectdetail-img">';
                                            $content_exp  = explode("/" , $video_url);
                                            $content_vimo = array_pop($content_exp);
                                            $video_html	.= '<iframe width="' . $width . '" height="' . $height  . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
                                        ></iframe>';
                                            $video_html	.= '</figure>';
                                        } else if($url['host'] == 'youtu.be') {
                                            $video_html	.= '<figure class="tk-projectdetail-img">';
                                            $video_html	.= preg_replace(
                                                "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                                                "<iframe width='" . $width ."' height='" . $height  . "' src=\"//www.youtube.com/embed/$2\" frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
                                                $video_url
                                            );
                                            $video_html	.= '</figure>';
                                        } else if($url['host'] == 'dai.ly') {
                                            $path		= str_replace('/','',$url['path']);
                                            $content	= str_replace('dai.ly','dailymotion.com/embed/video/',$video_url);
                                            $video_html	.= '<figure class="tk-projectdetail-img">';
                                                $video_html	.= '<iframe width="' . $width . '" height="' . $height  . '" src="' . $content  . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                                            $video_html	.= '</figure>';
                                        }else {
                                            $video_html	.= '<figure class="tk-projectdetail-img">';
                                            $content = str_replace(array (
                                                'watch?v=' ,
                                                'http://www.dailymotion.com/' ) , array (
                                                'embed/' ,
                                                '//www.dailymotion.com/embed/' ) , $video_url);
                                            $content	= str_replace('.com/video/','.com/embed/video/',$content);
                                            $video_html	.= '<iframe width="' . $width . '" height="' . $height  . '" src="' . $content  . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                                            $video_html	.= '</figure>';
                                        }
                                    @endphp
                                    @if( !empty($video_html) )
                                        {!! $video_html !!} 
                                    @endif
                                </div>
                            @endif
                            @if($project->project_description !='')
                                <div class="tk-project-holder">
                                    <div class="tk-project-title">
                                        <h4>{{ __('project.pro_desc') }}</h4>
                                    </div>
                                    <div class="tk-jobdescription">
                                        <div class="tk-project-holder tk-project-description">
                                            <div class="tk-jobdescription">
                                                {!! json_decode($project->project_description) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!$project->skills->isEmpty())
                                <div class="tk-project-holder">
                                    <div class="tk-project-title">
                                        <h4> {{ __('project.skills_required') }} </h4>
                                    </div>
                                    <div class="tk-blogtags tk-skillstags">
                                        <ul class="tk-tags_links">
                                            @foreach($project->skills as $single)
                                                <li>
                                                    <span class="tk-blog-tags">{!! $single->name !!}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            @if( !empty($files) && Auth::user() )
                                <div class="tk-project-holder">
                                    <div class="tk-betaversion-wrap">
                                        <div class="tk-betaversion-info">
                                            <h5>{{  __('project.attachments_available') }} </h5>
                                            <p>{{  __('project.attachments_available_txt',['buyer_name'=> $project->projectAuthor->full_name]) }} </p>
                                        </div>
                                        <div class="tk-downloadbtn">
                                            <a href="javascript:;" wire:click.prevent="downloadAttachments('{{ $project->id }}')" class="tk-btn-solid-lefticon">{{  __('project.download_files') }} <i class="icon-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">
                    <aside>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box tk-projectprice">
                                <div class="tk-sidebar-title">
                                    <span class="tk-project-tag {{  $project->project_type == 'fixed' ? 'tk-ongoing-updated' :  'tk-success-tag-updated'  }}">{{  $project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')   }}</span>
                                    <h3>{{ getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price) }}</h3>
                                    @if($project->project_type == 'hourly')<em>{{ __('project.estimated_hours', ['max_hours' => $project->project_max_hours, 'type' => $project->project_payment_mode]) }}</em>@endif
                                </div>
                                          
                                <div class="tk-sidebarpkg__btn">
                                    @if( $userRole != 'buyer' && ( $edit_proposal || !$proposal_submitted ) )
                                        <a href="{{route('submit-proposal', ['slug' => $project->slug] )}}" class="tk-btn-solid-lg"> {{ $edit_proposal ?  __('proposal.edit_proposal')  : __('project.apply_to_project') }} </a>
                                    @endif
                                    @role('seller')  
                                        <a href="javascript:void(0)" wire:click.prevent="saveProject({{$project->id}})" class="{{$save_project ? 'tk-btnline tk-liked tk-saved' : 'tk-btnline tk-save' }} "> 
                                            <i class="icon-heart"></i>
                                            <span>{{ $save_project ? __('general.saved') : __('project.add_to_save')}}</span>
                                        </a>
                                    @endrole
                                </div>
                                   
                               
                            </div>
                            <div class="tk-project-box">
                                <div class="tk-sidebar-title">
                                    <h5>{{ __('project.project_requirements') }} </h5>
                                </div>
                                <ul class="tk-project-requirement tk-projectdetail-req">
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <div class="tk-project-requirement_content">
                                            <em>{{ __('project.project_category') }}</em>
                                            <div class="tk-requirement-tags">
                                                <span>{{ !empty($project->category) ? $project->category->name : '' }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="icon-users"></i>
                                        <div class="tk-project-requirement_content">
                                            <em> {{ __('project.hiring_capacity') }} </em>
                                            <div class="tk-requirement-tags">
                                                <span>{{ $project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @if( $project->project_type == 'hourly' )
                                        <li>
                                            <i class="icon-dollar-sign"></i>
                                            <div class="tk-project-requirement_content">
                                                <em> {{ __('project.payment_mode') }} </em>
                                                <div class="tk-requirement-tags">
                                                    <span>{{ ucfirst($project->project_payment_mode) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if(!empty($project->expertiseLevel))
                                        <li>
                                            <i class="icon-briefcase"></i>
                                            <div class="tk-project-requirement_content">
                                                <em>{{ __('project.expert_level') }}</em>
                                                <div class="tk-requirement-tags">
                                                    <span>{{  $project->expertiseLevel->name }}</span>
                                                </div>
                                            </div>
                                        </li> 
                                    @endif
                                    @if(!$project->languages->isEmpty())
                                        <li>
                                            <i class="icon-book-open"></i>
                                            <div class="tk-project-requirement_content">
                                                <em>{{ __('project.languages') }} </em>
                                                <div class="tk-requirement-tags">
                                                    @foreach($project->languages as $single)
                                                        <span>{!! $single->name !!}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <div class="tk-project-requirement_content">
                                            <em>{{ __('project.project_duration') }}</em>
                                            <div class="tk-requirement-tags">
                                                <span>{{ !empty($project->projectDuration) ? $project->projectDuration->name : '' }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @if($project->type == 'hourly' && !project->projectPaymentMode->isEmpty())
                                        <li>
                                            <i class="icon-clock"></i>
                                            <div class="tk-project-requirement_content">
                                                <em>{{ __('project.payment_mode') }}</em>
                                                <div class="tk-requirement-tags">
                                                    <span>{{ $project->projectPaymentMode->name }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-verified-title">
                                    <div class="tk-projectinfo_title">
                                        @php
                                            if(!empty($project->projectAuthor->image)){
                                                $image_path     = getProfileImageURL($project->projectAuthor->image, '50x50');
                                                $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';
                                            }else{
                                                $author_image = 'images/default-user-50x50.png';
                                            }
                                        @endphp
                                        <img src="{{ asset($author_image) }}" alt="{{ $project->projectAuthor->full_name }}">
                                        <div class="tk-verified-info">
                                            <h5> {{ $project->projectAuthor->full_name }} 
                                                @if($project->projectAuthor->user->userAccountSetting->verification == 'approved')
                                                    <i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="{{__('general.verified_user')}}" ></i>
                                                @endif
                                            </h5>
                                            <em> {{ __('project.member_since',['date' => date( $date_format, strtotime($project->projectAuthor->created_at))]) }}</em>
                                        </div>
                                    </div>
                                    <div class="tk-projectinfo_description">
                                        @if(!empty($project->projectAuthor->description))<p>{!! $project->projectAuthor->description !!}</p>@endif
                                    </div>
                                </div>
                                <ul class="tk-checkout-info">
                                    @if(!empty($project->projectAuthor->address))    
                                        <li>
                                            <div class="tk-total-title">
                                                <i class="icon-map-pin"></i>
                                                <em>{{ __('project.located_in') }} </em>
                                            </div>
                                            <span>{{ getUserAddress($project->projectAuthor->address, $address_format) }}</span>
                                        </li>
                                    @endif    
                                    <li>
                                        <div class="tk-total-title">
                                            <i class="icon-bookmark"></i>
                                            <em>{{ __('project.total_posted_projects') }}</em>
                                        </div>
                                        <span>{{ $posted_projects }}</span>
                                    </li>
                                    <li>
                                        <div class="tk-total-title">
                                            <i class="icon-clock"></i>
                                            <em>{{ __('project.hired_projects') }}</em>
                                        </div>
                                        <span>{{ $hired_projects }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @if(!empty($adsense_code))
                            <div class="tk-advertisment-area">
                                {!! $adsense_code !!}
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
            <div class="row">
                @if(!$related_projects->isEmpty())
                    <div class="col-lg-12">
                        <div class="tk-relatedproject_title">
                            <h3>{{ __('project.project_you_like') }} </h3>
                        </div>
                    </div>
                    @foreach($related_projects as $single)            
                        <div class="col-lg-6 col-xl-4">
                            <div class="tk-project-wrapper tk-otherproject">
                                @if(!empty($single->is_featured))
                                    <span wire:ignore data-tippy-content="{{__('settings.featured_project')}}" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                @endif
                                <span class="tk-project-tag-two {{ $single->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated' }}">{{ $single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project') }}</span>

                                <div class="tk-project-box">
                                    <div class="tk-verified-info">
                                        <a href="javascript:void(0)">
                                            {{ $single->projectAuthor->full_name }}
                                            @if($single->projectAuthor->user->userAccountSetting->verification == 'approved')
                                                <i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="{{__('general.verified_user')}}" ></i>
                                            @endif
                                        </a>
                                        <h5><a href="{{ route('project-detail', ['slug'=> $single->slug] ) }}">{{ $single->project_title }}</a></h5>
                                    </div>
                                    <ul class="tk-projectinfo-list">
                                        <li><i class="icon-calendar"></i> {{ getTimeDiff( $single->updated_at ) }}</li>
                                        <li><i class="icon-map-pin"></i> {{ $single->projectLocation->id == 3 ? (!empty($single->address) ? getUserAddress($single->address, $address_format) : $single->project_country ) : $single->projectLocation->name }}</li>
                                        @if(!empty($single->expertiseLevel))<li><i class="icon-briefcase"></i>{{  $single->expertiseLevel->name }}</li>@endif
                                        <li><i class="icon-users"></i> {{ $single->project_hiring_seller .' '. ($single->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</li>
                                    </ul>
                                    <div class="tk-project-price">
                                        <h6>{{ __('project.project_budget')   }}</h6>
                                        <h4>{{ getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach 
                @endif      
            </div>
        </div>
    </section>
</main>

@push('scripts')
    <script defer src="{{ asset('common/js/popper-core.js') }}"></script> 
    <script defer src="{{ asset('common/js/tippy.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            let tb_tippy = document.querySelector(".tippy");
                if (tb_tippy !== null) {
                    tippy(".tippy", {
                        animation: "scale",
                    });
                }
        });
    </script>
@endpush