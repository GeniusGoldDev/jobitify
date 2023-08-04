<main class="tk-main-bg">
    <section class="tk-main-section" wire:loading.class="tk-section-preloader" >
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    @if(!$proposals->isEmpty() && $search_project !='')<h3>{{ $proposals->count() .' '.  __('general.search_result') }} “{{ $search_project }}”</h3>@endif
                </div>
                <div class="col-xl-12">
                    <div class="tk-project-wrapper tk-template-project">
                        <div class="tk-template-serach ">
                            <h5> {{ $filter_project != '' ? __('general.'.$filter_project)  :  __('project.all_projects') }} </h5>
                            <div class="tk-search-wrapper">
                                <div class="tk-generalsearch">
                                    <label> {{ __('general.search') }}</label>
                                    <div class="tk-inputicon">
                                        <input type="text" wire:model.debounce.500ms="search_project" class="form-control" placeholder="{{ __('general.search_with_keyword') }}">
                                        <i class="icon-search"></i>
                                    </div>
                                </div>

                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <label> {{ __('project.project_type') }}</label>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="project_type"  class="form-control tk-selectprice">
                                                    <option value =""> {{ __('project.all_projects') }} </option>
                                                    <option value ="fixed"> {{ __('project.fixed_type') }} </option>
                                                    <option value ="hourly"> {{ __('project.hourly_type') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <label> {{ __('project.project_status') }}</label>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                @php  
                                                    $statuses = [
                                                        'all'       => __('project.all_projects'),
                                                        'draft'     => __('general.draft'),
                                                        'pending'   => __('general.pending'),
                                                        'publish'   => __('general.publish'),
                                                        'hired'     => __('general.hired'),
                                                        'completed' => __('general.completed'),
                                                        'rejected'  => __('general.rejected'),
                                                        'declined'  => __('general.declined'),
                                                        'refunded'  => __('general.refunded'),
                                                        'refunded'  => __('general.refunded'),
                                                        'cancelled' => __('general.cancelled'),
                                                    ]; 
                                                @endphp
                                                <select id="filter_project" class="form-control tk-selectprice">
                                                    @foreach($statuses as $key => $status)
                                                        <option value ="{{$key != 'all' ? $key : '' }}" {{ $filter_project == $key ? 'selected' : '' }} > {{ $status }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!$proposals->isEmpty())
                        @foreach($proposals as $single)
                            @php
                               $tag = getTag( $single->status );
                            @endphp
                            <div class="tk-project-wrapper-two">
                                @if($single->project->is_featured)
                                    <x-featured-tippy />
                                @endif
                                <div class="tk-project-box">
                                    <div class=" tk-price-holder">
                                        <div class="tk-verified-info">
                                            <div class="tk-verified-info-tags">
                                                <span class="{{ $tag['class'] }}">{{ $tag['text'] }}</span>
                                            </div>
                                            <strong wire:ignore>
                                                {{ $single->project->projectAuthor->full_name }}  
                                                <x-verified-tippy />
                                            </strong>
                                            <h5>{{ $single->project->project_title }}</h5>
                                            <ul class="tk-template-view">
                                                <li>
                                                    <i class="icon-calendar"></i>
                                                    <span> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $single->project->updated_at )]) }} </span>
                                                </li>
                                                <li>
                                                    <i class="icon-map-pin"></i>
                                                    <span> {{ $single->project->projectLocation->id == 3 ? (!empty($single->project->address) ? getUserAddress($single->project->address, $address_format) : $single->project->project_country ) : $single->project->projectLocation->name }} </span>
                                                </li>
                                                <li>
                                                    <i class="icon-briefcase"></i>
                                                    <span> {{ !empty($single->project->expertiseLevel) ? $single->project->expertiseLevel->name : '' }} </span>
                                                </li>
                                                <li>
                                                    <i class="{{ $single->project_hiring_seller > 1 ? 'icon-users' : 'icon-user' }}"></i>
                                                    <span>{{ $single->project->project_hiring_seller .' '. ($single->project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tk-price tk-tagholder">
                                            <em class="tk-project-tag-two {{ $single->project->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated' }}">{{ $single->project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project') }}</em>
                                            <span> {{ __('project.project_budget') }}</span>
                                            <h4>{{ getProjectPriceFormat($single->project->project_type, $currency_symbol, $single->project->project_min_price, $single->project->project_max_price) }}</h4>
                                            @if( $single->status == "hired" || $single->status == "completed" || $single->status == "refunded" || $single->status == "disputed")
                                            <a href="{{route('project-activity',['slug' => $single->project->slug,'id' => $single->id ])}}" class="tk-invite-bidbtn">{{ __('project.project_activity') }}</a>
                                            @endif
                                        </div>

                                        <div class="tk-projectsstatus_option">
                                            <a href="javascript:void(0);"><i class="icon-more-horizontal"></i></a>
                                            <ul class="tk-contract-list" style="display: none;">
                                                @if( $single->status == 'pending' || $single->status == 'draft' )
                                                    <li>
                                                        <a href="{{route('submit-proposal', ['slug' => $single->project->slug] )}}" >{{ __('proposal.edit_proposal') }} </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" wire:click.prevent="deleteProposal({{ $single->id }})" >{{ __('proposal.delete_proposal') }} </a>
                                                    </li>
                                                @endif
                                                @if($single->status == 'publish')
                                                    <li>
                                                        <a href="{{ route('proposal-detail', ['slug'=> $single->project->slug, 'id' => $single->id] ) }}" >{{ __('proposal.view_proposal') }} </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('project-detail', ['slug'=> $single->project->slug] ) }}" >{{ __('project.view_project') }} </a>
                                                </li>
                                            </ul>
                                        </div>
                                       
                                    </div>
                                    @if($single->status == 'declined')
                                        <div class="tk-statusview_alert tk-employerproject">
                                            <span><i class="icon-info"></i>{{ __('proposal.decline_reason_descrip') }}</span>
                                            <a class="tk-alert-readbtn" wire:click.prevent="DeclineProposal({{ $single->id}})"  >{{ __('proposal.read_comment') }} <i class="icon-chevron-right"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="tk-submitreview">
                            <figure>
                                <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                            </figure>
                            <h4>{{ __('general.no_record') }}</h4>
                        </div>
                    @endif
                </div>
                @if(!$proposals->isEmpty())
                    <div class="col-sm-12">
                        {{ $proposals->links('pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
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
</main>

@push('scripts')
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
    
            setTimeout(function() {
                $('#filter_project, #project_type').select2(
                    { allowClear: true, minimumResultsForSearch: Infinity  }
                );

                $('#filter_project').on('change', function (e) {
                    let filter_project = $('#filter_project').select2("val");
                    @this.set('filter_project', filter_project);
                });

                $('#project_type').on('change', function (e) {
                    let project_type = $('#project_type').select2("val");
                    @this.set('project_type', project_type);
                });

                iniliazeSelect2Scrollbar();
            }, 50);

            window.addEventListener('declinedProposal', event => {
                $('.tk-user-info .buyer-name').text(event.detail.buyerName);
                $('.tk-user-content .buyer-image').attr('src', event.detail.buyerImage);
                $('.tk-popup-info .seller-name').text(event.detail.sellerName);
                $('.tk-popup-info .decline-reason').text(event.detail.declineReason);
                jQuery('#declined_proposal').modal('show');
            });

            $(document).on('click', '.tk-projectsstatus_option > a', function(event) {
                // Close all open windows
                jQuery(".tk-contract-list").stop().slideUp(300);
                // Toggle this window open/close
                jQuery(this).next(".tk-contract-list").stop().slideToggle(300);
            });
        });

    </script>
@endpush