<main class="tk-main-bg">
    <section class="tk-main-section" wire:target="keyword" wire:loading.class="tk-section-preloader" >
        <div class="preloader-outer" wire:loading wire:target="keyword">
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-select2-id="9">
                    <div class="tb-dhb-mainheading" data-select2-id="8">
                        <h2>{{__('general.fav_items_label')}}</h2>
                    </div>
                </div>
                <div class="col-xl-12">
                   
                    <div class="tk-project-wrapper tk-template-project tk-template-projectvtwo">
                        <div class="tk-template-serach">
                            @if( $filter_by == 'project' )
                                <h5>{{__('project.all_projects')}}</h5>
                            @elseif( $filter_by == 'gig' )
                                <h5>{{__('general.all_gigs')}}</h5>
                            @elseif($filter_by == 'profile')
                                <h5>{{__('general.all_sellers')}}</h5>
                            @endif
                            <div class="tk-inputicon">
                                <input type="text" class="form-control" wire:model.debounce.500ms="search" placeholder="{{__('general.search')}}">
                                <i class="icon-search"></i>
                            </div>

                            @role('buyer')
                                <div class="tk-sortby">
                                    <div class="tk-actionselect tk-actionselect2">
                                        <span>{{__('gig.filter_by')}}</span>
                                        <div class="tk-select" wire:ignore>
                                            <select id="tk_item_type" data-hide_search_opt="true" class="form-control tk-select2">
                                                <option value="gig"> {{__('general.all_gigs')}} </option>
                                                <option value="profile" selected> {{__('general.all_sellers')}} </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endrole

                        </div>
                    </div>
                    @if( !$items->isEmpty() )
                        @if($filter_by == 'gig')
                            <ul class="tk-savelisting tk-searchgig_listing">
                        @endif
                        @foreach($items as $single)
                            @php
                                $item = null;
                                if($filter_by == 'project'){
                                    $item = $single->projects;
                                } elseif( $filter_by == 'gig' ){
                                    $item = $single->gigs;
                                } elseif( $filter_by == 'profile' ){
                                    $item = $single->sellers;
                                }
                            @endphp

                            @if( $filter_by == 'project' )
                                <x-project-item :project="$item" :user_role="'seller'" :currency_symbol="$currency_symbol" :list_type="'fav_project'" :address_format="$address_format"/>
                            @elseif( $filter_by == 'gig' )
                                <x-gig-item :gig="$item" :user_role="'buyer'" :address_format="$address_format" :currency_symbol="$currency_symbol" :fav_gigs="[]" :is_save_item="true"/>
                            @elseif( $filter_by == 'profile' )
                                <x-seller-item :user_role="'buyer'" :profile="$item" :favourite_sellers="[]" :currency_symbol="$currency_symbol" :is_save_item="true" />
                            @endif
                          
                        @endforeach

                        @if($filter_by == 'gig')
                            </ul>
                        @endif
                        
                        @if(!$items->isEmpty())
                            <div class="col-sm-12">
                                {{ $items->links('pagination.custom') }}
                            </div>
                        @endif
                    @else 
                        <div class="tk-submitreview">
                            <figure>
                                <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                            </figure>
                            <h4>{{ __('general.no_record') }}</h4>
                        </div>
                    @endif
                </div>
                    
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
    <script defer src="{{ asset('common/js/select2.min.js') }} "></script>
    <script defer src="{{ asset('js/app.js') }}"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            setTimeout(() => {
                iniliazeSelect2Scrollbar();
            }, 1000);
            $('#tk_item_type').on('change', function (e) {
                let item_type = $('#tk_item_type').select2("val");
                @this.set('filter_by', item_type);
            });

            window.addEventListener('declinedProposal', event => {
                $('.tk-user-info .buyer-name').text(event.detail.buyerName);
                $('.tk-user-content .buyer-image').attr('src', event.detail.buyerImage);
                $('.tk-popup-info .seller-name').text(event.detail.sellerName);
                $('.tk-popup-info .decline-reason').text(event.detail.declineReason);
                jQuery('#declined_proposal').modal('show');
            });
        });
    </script>
@endpush
