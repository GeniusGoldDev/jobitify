<div>
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tk-project-wrapper">
                            @if(!$project->isEmpty)
                                <div class="tk-project-box tk-employerproject">
                                    <div class="tk-employerproject-title">
                                        @if($project->is_featured)
                                            <span wire:ignore data-tippy-content="{{__('settings.featured_project')}}" class="tk-featureditem tippy">
                                                <i class="icon icon-zap"></i>
                                            </span>
                                        @endif

                                        <span class="tk-project-tag-two {{$project->project_type == 'hourly' ? 'tk-success-tag-updated' : 'tk-ongoing-updated'}}">
                                            {{$project->project_type == 'hourly' ? __('project.project_houly_type') : __('project.project_fixed_type')}}
                                        </span>
                                        <h3>{{$project->project_title}}</h3>
                                        <ul class="tk-blogviewdates">
                                            <li><span><i class="icon-calendar"></i> 
                                            {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )]) }}
                                        </span></li>
                                            @if(!empty($project->address))
                                            <li><span><i class="icon-map-pin"></i>{{ $project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name }}</span></li>
                                            @endif
                                            @if(!empty($project->expertiseLevel))
                                                <li><span><i class="icon-briefcase"></i>{{ $project->expertiseLevel->name }}</span></li>
                                            @endif
                                            <li>
                                                <span><i class="icon-users"></i>
                                                {{ $project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tk-price">
                                        <h4>{{getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)}}</h4>
                                        @if(($proposal->status == "completed" || $proposal->status == "hired") && $userRole != 'admin')
                                            <div class="tk-project-detail">
                                                <a href="{{route('project-activity',['slug' => $project->slug,'id' => $proposal->id ])}}" class="tk-btn-solid">{{__('proposal.project_activity')}}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if( !empty($proposal->proposalAuthor) )
                            @php
                                $author         = $proposal->proposalAuthor;
                                $image_path     = getProfileImageURL($author->image, '60x60');
                                $image          = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-60x60.png';
                            @endphp
                            <div class="tk-project-box tk-profile-view">
                                <div class="tk-project-table-content">
                                    <img src="{{asset($image)}}" alt="images">
                                    <div class="tk-project-table-info">
                                        <h4>{{$author->full_name}}</h4>
                                        <ul class="tk-blogviewdates">
                                            <li>
                                                <i class="fas fa-star tk-yellow"></i>
                                                <em> {{ratingFormat( $author->ratings_avg_rating ) }} </em>
                                                <span>({{ $author->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($author->ratings_count)]) }} ) </span>

                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{route('seller-profile',[ 'slug'=> $author->slug ])}}" class="tk-btn-solid tk-success-tag">{{__('proposal.view_profile')}}</a>
                                </div>
                            </div>
                            @endif

                            @if( !empty($proposal) )
                                <div class="tk-project-box tk-working-rate shadow-none">
                                    <div class="tk-project-price">
                                        @if($project->project_type == 'hourly')
                                            <h5>{{ __('proposal.author_hourly_rate_heading',['author_name' => $proposal->proposalAuthor->first_name])}}</h5>
                                        @else
                                            <h5>{{ __('proposal.author_fixed_rate_heading',['author_name' => $proposal->proposalAuthor->first_name])}}</h5>
                                        @endif
                                        <span>{{getPriceFormat($currency_symbol,$proposal->proposal_amount).($project->project_type == 'hourly' ? '/hr' : '')}}</span>
                                    </div>
                                </div>

                                @if(!$proposal->milestones->isEmpty())
                                <div class="tk-projectsinfo tk-project-box">
                                    <div class="tk-offer-milestone">
                                        <div class="tk-projectsinfo_title">
                                            <h4>{{__('proposal.offered_milestones')}}</h4>
                                            @role('buyer')
                                                <p>{!!__('proposal.offered_milestones_desc') !!}</p>
                                            @endrole
                                        </div>

                                        <ul class="tk-projectsinfo_list">
                                            @foreach($proposal->milestones as $key => $milestone)
                                                <li>
                                                    <div class="tk-statusview">
                                                        <div class="tk-statusview_head">
                                                            <div class="tk-statusview_title">
                                                                <h5>{{$milestone->title}}</h5>
                                                                <span>{{getPriceFormat($currency_symbol,$milestone->price)}}</span>
                                                            </div>
                                                        </div>
                                                        <p>{!! nl2br($milestone->description) !!}</p>

                                                        @php 
                                                        $escrow_milestone = true;
                                                        if( $proposal->status == "declined" || $proposal->status == "completed" ){
                                                            $escrow_milestone = false;
                                                        } 
                                                        @endphp
                                                        @if( $userRole == 'buyer' && $escrow_milestone && !$processed_milestones )
                                                            <button wire:click.prevent="escrowMilestone({{$key}})" class="tk-btnline" id="single-select">{{__('proposal.hire_milestone_btn_txt')}}</button>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                                <div class="tk-projectsinfo tk-project-box">
                                    <div class="tk-offer-milestone">
                                        <div class="tk-milestones-content">
                                            <h6>{{ __('proposal.special_comments_to_emp')}}</h6>
                                            <p>{!! nl2br($proposal->special_comments) !!}</p>
                                        </div>
                                    </div>
                                </div>

                                @if( $proposal->status == 'publish' || $proposal->status == 'declined')
                                        @if( $proposal->status == 'declined' )
                                        <div class="tk-project-box">
                                            <div class="tk-statusview_alert tk-employerproject">
                                                <span><i class="icon-info"></i>{{ __('proposal.decline_reason_descrip') }}</span>
                                                <a class="tk-alert-readbtn" wire:click.prevent="ShowDeclineProposalReason"  >{{ __('proposal.read_comment') }} <i class="icon-chevron-right"></i></a>
                                            </div>
                                        </div>
                                        @elseif( $proposal->status == 'publish' && $userRole == 'buyer')
                                            <div class="tk-project-box">
                                                <div class="tk-bidbtn tk-proposals-btn">
                                                    <button class="tk-decline" wire:click.prevent="confirmDeclineProposal" > {{__('proposal.decline_proposal')}} </button>
                                                    @if( $project->project_type == 'hourly' || ( $project->project_type == 'fixed' && $proposal->milestones->isEmpty()) )
                                                        <button class="tk-btn-solid-lg" wire:click.prevent="hireSeller">{{__('proposal.hire_seller_name',['author_name' => $proposal->proposalAuthor->full_name])}}</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div wire:ignore.self class="modal fade tb-addonpopup" id="tk_decline_reason" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> {{ __('proposal.add_decline_reason') }} </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <textarea wire:model.defer="decline_reason" class="form-control  @error('decline_reason') tk-invalid @enderror"></textarea>
                    @error('decline_reason')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span> 
                        </div>
                    @enderror
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:void(0);" wire:click.prevent="declinedProposal" class="tb-btn">{{__('general.save_update')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:igonre.self class="modal fade" id="declined_proposal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog tk-modal-dialog-default modal-dialog-centered">
            <div class="modal-content">
            <div class="tk-popuptitle">
                <h5>{{ __('proposal.employer_comments') }}</h5>
                <a href="javascrcript:void(0)" data-bs-dismiss="modal" class="close">
                    <i class="icon-x"></i>
                </a>
            </div>
            <div class="modal-body tk-popup-content">
                <div class="tk-statusview_alert">
                    <span><i class="icon-info"></i>{{ __('proposal.decline_text') }}</span>
                </div>
                <div class="tk-popup-info">
                    <div class="tk-user-content">
                        <img class="buyer-image">
                        <div class="tk-user-info">
                            <h6 class="buyer-name"></h6>
                        </div>
                    </div>
                </div>
                <div class="tk-popup-info">
                    <h6 class="seller-name"></h6>
                    <p class="decline-reason"></p>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

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
            window.addEventListener('show-decline-reason-modal', event => {
                jQuery('#tk_decline_reason').modal(event.detail.modal);
            });

            window.addEventListener('ShowdeclinedProposalReason', event => {
                $('.tk-user-info .buyer-name').text(event.detail.buyerName);
                $('.tk-user-content .buyer-image').attr('src', event.detail.buyerImage);
                $('.tk-popup-info .seller-name').text(event.detail.sellerName);
                $('.tk-popup-info .decline-reason').text(event.detail.declineReason);
                jQuery('#declined_proposal').modal('show');
            });

        });
    </script>
@endpush
