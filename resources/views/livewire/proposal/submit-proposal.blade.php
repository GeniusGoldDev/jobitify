<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="preloader-outer" wire:loading wire:target="submitProposal">
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="tk-project-wrapper">
                        <div wire:ignore class="tk-project-box">
                            <div class="tk-servicedetailtitle">
                                @if($project->is_featured)
                                    <span wire:ignore class="tk-featureditem tippy" data-tippy-content="{{__('settings.featured_project')}}"><i class="icon icon-zap"></i></span>
                                @endif
                                <h3>{{ $project->project_title }}</h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at)]) }}</span></li>
                                    <li><span><i class="icon-map-pin"></i> {{ $project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <form class="tk-themeform">
                                <fieldset>
                                    <div class="tk-themeform__wrap">
                                        <div class="form-group">
                                            <label class="tk-label">{{__('proposal.budget_rate')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="number" wire:model.debounce.300ms="proposal_amount"  class="form-control tk-themeinput @error('proposal_amount') tk-invalid @enderror" placeholder="{{__('proposal.budget_rate_placeholder')}}" required="required">
                                            </div>
                                            @error('proposal_amount')
                                                <div class="tk-errormsg"> 
                                                    <span>{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        @if($proposal_amount > 0)
                                            <div class="form-group">
                                                <ul class="tk-budgetlist">
                                                    <li>
                                                        <span>{{__('proposal.total_budget')}}</span>
                                                        <h6>{{ getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price) }}</h6>
                                                    </li>
                                                
                                                    <li>
                                                        <span>{{__('proposal.budget_rate')}}</span>
                                                        <h6>{{ getPriceFormat($currency_symbol,$working_budget).( $project->project_type == 'hourly' ? '/hr' : '') }}</h6>
                                                    </li>
                                                    
                                                    <li>
                                                        <span>
                                                            {{__('proposal.service_fee_tax')}} @if($commission_type == 'percentage' || $commission_type == 'commission_tier_per') <strong>({{ $commission_value }}%)</strong>@endif  
                                                        </span>
                                                        <h6>-{{ getPriceFormat($currency_symbol,$admin_share).( $project->project_type == 'hourly' ? '/hr' : '') }}</h6>
                                                    </li>
                                                
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <div class="tk-totalamout">
                                                    <span>{{__('proposal.total_amount')}}</span>
                                                    <h5>{{ getPriceFormat($currency_symbol,$seller_share).( $project->project_type == 'hourly' ? '/hr' : '') }}</h5>
                                                </div>
                                            </div>
                                        @endif
                                       
                                        @if($project->project_type == 'fixed')
                                            <div class="form-group tk-paid-version">
                                                <div class="tk-betaversion-wrap">
                                                    @if( $proposal_milestone_payout == 'yes' )
                                                        <div class="tk-betaversion-info-two">
                                                            <h5>{{__('proposal.how_to_paid_text')}}</h5>
                                                            <p>{{__('proposal.how_to_paid_desc')}}</p>
                                                        </div>
                                                    @endif
                                                    <ul class="tk-paid-option {{ ($proposal_fixed_payout == 'yes' && $proposal_milestone_payout == 'no') || ($proposal_fixed_payout == 'no' && $proposal_milestone_payout == 'yes') ? 'tk-single-option' : '' }}">
                                                        @if( $proposal_milestone_payout == 'yes' )
                                                            <li>
                                                                <div class="tk-projectpaid-list {{ $is_milestone == 'yes' ?  'active' : '' }}" wire:click.prevent="updateType('milestone')">
                                                                    <lable class="tk-projectprice-option {{ $proposal_fixed_payout == 'no' ? 'tk-projectpaid-single' : '' }}" for="project-milestone">
                                                                        <img src="{{ asset('images/proposal/milestone.png')}}">
                                                                        <div class="tk-paifinfo">
                                                                            <h6>{{__('proposal.work_with_milestones')}}</h6>
                                                                            <span>{{__('proposal.work_with_milestones_desc')}}</span>
                                                                        </div>
                                                                    </lable>
                                                                </div>
                                                            </li>
                                                        @endif  

                                                        @if( $proposal_fixed_payout == 'yes' )
                                                            <li>
                                                                <div class="tk-projectpaid-list {{ $is_milestone == 'no' ?  'active' : '' }}" wire:click.prevent="updateType('fixed')">
                                                                    <lable class="tk-projectprice-option {{ $proposal_milestone_payout == 'no' ? 'tk-projectpaid-single' : '' }}" for="project-fixed">
                                                                        <img src="{{ asset('images/proposal/fixed.png')}}">
                                                                        <div class="tk-paifinfo">
                                                                            <h6>{{__('proposal.fixed_price_project')}}</h6>
                                                                            <span>{{ __('proposal.fixed_price_project_desc')}}</span>
                                                                        </div>
                                                                    </lable>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                    @if( $is_milestone == 'yes' )
                                                        <div class="tk-add-price-slots">
                                                            <label class="tk-label">{{__('proposal.add_milestone_desc')}}
                                                                <a href="javascript:;" wire:click.prevent="addNewMilestone" class="tk-addicon">{{__('proposal.add_milestone_btn_text')}} <i class="icon-plus"></i></a>
                                                            </label>
                                                            @if(!empty($available_milestones))
                                                                <div wire:sortable="updateMilestoneOrder" wire:sortable.options="{ animation: 250 }">
                                                                    @foreach($available_milestones as $key => $single)
                                                                    
                                                                        <div wire:sortable.item="{{ $key }}" wire:key="milestone-{{ $key }}" class="tk-milestones-prices">
                                                                            <div wire:sortable.handle class="tk-draghandler"></div>
                                                                            <div class="tk-grapinput">
                                                                                <div class="tk-milestones-input">
                                                                                    <div class="tk-placeholderholder tk-addslots">
                                                                                        <input type="number" wire:model.defer="available_milestones.{{ $key }}.price"  placeholder="{{__('proposal.add_price_placeholder')}}" class="form-control tk-themeinput {{ ($errors->has('available_milestones.'.$key.'.price') ? ' tk-invalid' : '') }}" required="required">     
                                                                                        @if($errors->has('available_milestones.'.$key.'.price'))
                                                                                            <div class="tk-errormsg">
                                                                                                <span> {{ $errors->first('available_milestones.'.$key.'.price') }}</span>
                                                                                            </div> 
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="tk-placeholderholder">
                                                                                        <input type="text" wire:model.defer="available_milestones.{{ $key }}.title" placeholder="{{__('proposal.enter_title')}}" class="form-control tk-themeinput {{ ($errors->has('available_milestones.'.$key.'.title') ? ' tk-invalid' : '') }}" required="required">    
                                                                                        @if($errors->has('available_milestones.'.$key.'.title'))
                                                                                            <div class="tk-errormsg">
                                                                                                <span> {{ $errors->first('available_milestones.'.$key.'.title') }}</span>
                                                                                            </div> 
                                                                                        @endif
                                                                                    </div>
                                                                                    <a href="javascript:void(0)" wire:click.prevent="updateMilestone({{ $key }})" class="tk-removeicon"><i class="icon-trash-2"></i></a>
                                                                                </div>
                                                                                <div class="tk-placeholderholder">
                                                                                    <textarea  wire:model.defer="available_milestones.{{ $key }}.description" class="form-control tk-themeinput" placeholder="{{__('proposal.add_desc')}}"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="tk-comment-section">
                                            <div class="form-group">
                                                <label class="tk-label">{{__('proposal.add_comment')}} </label>
                                                <div class="tk-placeholderholder">
                                                    <textarea wire:model.defer="special_comments" class="form-control tk-themeinput @error('special_comments') tk-invalid @enderror"></textarea>
                                                </div>
                                                @error('special_comments')
                                                    <div class="tk-errormsg">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>  

                    @if(!$author && $submit_proposal) 
                        <div class="tk-proposal-btn">
                            <a href="javascript:;" wire:click.prevent="submitProposal" class="tk-btn-solid-lg-lefticon">{{__('proposal.submit_btn_txt')}}</a>
                            <a href="javascript:;" wire:click.prevent="submitProposal('draft')" class="tk-btnline">{{__('proposal.save_as_draft')}}</a>
                        </div>
                    @endif

                </div>
                <div wire:ignore class="col-lg-5 col-xl-4">
                    <aside>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box tk-projectprice">
                                <div class="tk-sidebar-title">
                                    <span class="tk-project-tag {{  $project->project_type == 'fixed' ? 'tk-ongoing-updated' :  'tk-success-tag-updated'  }}">{{  $project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')   }}</span>
                                    <h3>{{ getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price) }}</h3>
                                    @if($project->project_type == 'hourly')<em>{{ __('project.estimated_hours', ['max_hours' => $project->project_max_hours, 'type' => $project->project_payment_mode]) }}</em>@endif
                                </div>
                            </div>
                            <div class="tk-project-box">
                                <div class="tk-sidebar-title">
                                    <h5>{{ __('project.project_requirements') }} </h5>
                                </div>
                                <ul class="tk-project-requirement">
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
                                                        <span> {!! $single->name !!} </span>
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
                                            $author_image   = 'images/default-user-50x50.png';
                                        }
                                        @endphp
                                        <img src="{{ asset($author_image)}}" alt="{{ $project->projectAuthor->full_name }}">
                                        <div wire:ignore class="tk-verified-info">
                                            <h5> {{ $project->projectAuthor->full_name}} 
                                                <i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="{{__('general.verified_user')}}" ></i>
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
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
@push('scripts')
    <script defer src="{{ asset('common/js/livewire-sortable.js') }}"></script> 
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