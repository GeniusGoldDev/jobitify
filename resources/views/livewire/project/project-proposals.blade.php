<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box tk-employerproject">
                            <div class="tk-employerproject-title">
                                @if($project->is_featured)
                                    <span wire:ignore data-tippy-content="{{__('settings.featured_project')}}" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                @endif
                                <span class="tk-project-tag-two {{  $project->project_type == 'fixed' ? 'tk-ongoing-updated' :  'tk-success-tag-updated'  }}">{{  $project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')   }}</span>
                                <h3>{{ $project->project_title }}</h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )]) }}</span></li>
                                    <li><span><i class="icon-map-pin"></i>{{ $project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name }}</span></li>
                                    <li><span><i class="icon-briefcase"></i>{{ !empty($project->expertiseLevel) ? $project->expertiseLevel->name : '' }}</span></li>
                                    <li><span><i class="{{ $project->project_hiring_seller > 1 ? 'icon-users' : 'icon-user' }}"></i>{{ $project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span></li>
                                </ul>
                            </div>
                            <div class="tk-price">
                                <span>{{ __('project.project_budget') }}</span>
                                <h4>{{ getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price) }}</h4>
                                <div class="tk-project-detail">
                                    
                                    @if($project->status == 'draft' || $project->status == 'pending')<a href="{{ route('create-project', [ 'step'=> 2, 'id'=> $project->id ] ) }}" class="tk-edit-project"><i class="icon-edit-3"></i> {{ __('project.edit_project') }}</a>@endif
                                    <a href="{{ route('project-detail', ['slug'=> $project->slug] ) }}" class="tk-btn-solid-lg">{{ __('project.view_project') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-box tk-project-box-two tk-allproposallist">
                            <div class=" tk-proposal">
                                <div class="tk-propposal_title">
                                    <h5>{{ __('proposal.all_proposals') }} <span>({{ !$project->proposals->isEmpty() ? number_format($project->proposals->count()) : 0 }})</span></h5>
                                </div>
                            </div>
                            <div class="tk-template-serach-wrapper">
                                <div class="tk-select" wire:ignore>
                                    <select id="filter_proposal" class="form-control tk-selectprice">
                                        <option value ="">{{ __('proposal.all_proposals') }}</option>
                                        <option value ="publish"> {{ __('general.publish') }} </option>
                                        <option value ="hired"> {{ __('general.hired') }} </option>
                                        <option value ="completed"> {{ __('general.completed') }} </option>
                                        <option value ="rejected"> {{ __('general.rejected') }} </option>
                                        <option value ="declined"> {{ __('general.cancelled') }} </option>
                                        <option value ="refunded"> {{ __('general.refunded') }} </option>
                                    </select>
                                </div>
                                <div class="tk-template-serach">
                                    <div class="tk-inputicon">
                                        <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="{{ __('general.search_with_keyword') }}">
                                        <i class="icon-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-box tk-table-wrapper">
                            <div wire:loading.class="tk-section-preloader">
                                <div class="preloader-outer" wire:loading>
                                    <div class="tk-preloader">
                                        <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                                    </div>
                                </div>
                                @if(!$project->proposals->isEmpty())    
                                    <table class="table tk-proinvoices_table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('proposal.title') }}</th>
                                                <th>{{ __('proposal.bid_price') }}</th>
                                                <th>{{ __('proposal.dated') }}</th>
                                                <th>{{ __('general.status') }}</th>
                                                <th>{{ __('general.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($project->proposals as $single)
                                                @php
                                                    if(!empty($single->proposalAuthor->image)){
                                                        $image_path     = getProfileImageURL($single->proposalAuthor->image, '60x60');
                                                        $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-60x60.png';
                                                    }else{
                                                        $author_image = 'images/default-user-60x60.png';
                                                    }
                                                    $tag = getTag( $single->status );
                                                @endphp
                                                <tr>
                                                    <td data-label="{{ __('proposal.title') }}">
                                                        <div class="tk-project-table-content">
                                                            <img src="{{ asset($author_image) }}" alt="{{ $single->proposalAuthor->full_name }}">
                                                            <div class="tk-project-table-info">
                                                                <span> {{ $single->proposalAuthor->full_name }}</span>
                                                                <ul class="tk-blogviewdates">
                                                                    <li>
                                                                        <i class="fas fa-star tk-yellow"></i>
                                                                        <em> {{ ratingFormat( $single->proposalAuthor->ratings_avg_rating ) }} </em>
                                                                        <span>( {{ $single->proposalAuthor->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($single->proposalAuthor->ratings_count) ]) }} )</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="{{ __('proposal.bid_price') }}">{{ getPriceFormat( $currency_symbol,$single->proposal_amount ).( $project->project_type == 'hourly' ? '/hr' : '') }} </td>
                                                    <td data-label="{{ __('proposal.dated') }}">{{ date($date_format, strtotime($single->updated_at)) }}</td>
                                                    <td data-label="{{ __('general.status') }}"><span class="{{ $tag['class'] }}">{{ $tag['text'] }}</span></td>
                                                    @if( in_array($single->status, array('hired', 'completed', 'refunded', 'queued', 'rejected', 'disputed')))
                                                        <td data-label="{{ __('general.actions') }}"><a href="{{route('project-activity', [ 'slug'=> $project->slug, 'id'=> $single->id ])}}">{{ __('project.project_activity') }}</a></td>
                                                    @else
                                                        <td data-label="{{ __('general.actions') }}"><a href="{{route('proposal-detail', [ 'slug'=> $project->slug, 'id'=> $single->id ])}}">{{ __('proposal.proposal_detail') }}</a></td>    
                                                    @endif
                                                </tr>
                                            @endforeach  
                                        </tbody>
                                    </table>
                                @else
                                    <div class="tk-submitreview">
                                        <figure>
                                            <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                                        </figure>
                                        <h4>{{ __('proposal.proposal_not_received') }}</h4>
                                    </div>    
                                @endif    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@push('scripts')
    <script defer src="{{ asset('common/js/popper-core.js') }}"></script> 
    <script defer src="{{ asset('common/js/tippy.js') }}"></script>
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            let tb_tippy = document.querySelector(".tippy");
            if (tb_tippy !== null) {
                tippy(".tippy", {
                    animation: "scale",
                });
            }
            setTimeout(function() {
                
                $('#filter_proposal').select2(
                    { allowClear: true, minimumResultsForSearch: Infinity  }
                );

                $('#filter_proposal').on('change', function (e) {
                    let filter_proposal = $('#filter_proposal').select2("val");
                    @this.set('filter_proposal', filter_proposal);
                });

                iniliazeSelect2Scrollbar();
            }, 50);
        });

    </script>
@endpush