<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('proposal.all_proposals') .' ('. $proposals->total() .')' }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">        
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_proposal" class="form-control tk-selectprice">
                                            <option value =""> {{ __('proposal.all_proposals') }} </option>
                                            <option value ="pending"> {{ __('general.pending') }} </option>
                                            <option value ="publish"> {{ __('general.publish') }} </option>
                                            <option value ="hired"> {{ __('general.hired') }} </option>
                                            <option value ="completed"> {{ __('general.completed') }} </option>
                                            <option value ="declined"> {{ __('general.cancelled') }} </option>
                                            <option value ="disputed"> {{ __('general.disputed') }} </option>
                                            <option value ="refunded"> {{ __('general.refunded') }} </option>
                                        </select>
                                    </div>
                                </div>  
                                
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" class="form-control">
                                            @foreach($per_page_opt as $opt ){
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_project"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-proposalslist">
                @if( !$proposals->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('project.project_title' )}}</th>
                                <th>{{ __('proposal.created_date' )}}</th>
                                <th>{{ __('project.project_budget' )}}</th>
                                <th>{{ __('proposal.proposal_budget' )}}</th>
                                <th>{{ __('proposal.payout_type' )}}</th>
                                <th>{{__('general.status')}}<i class="fas fa-sort"></i></th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $single)
                                @php
                                $tag = getTag( $single->status );
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __('project.project_title' )}}">
                                        <div class="tk-proposal-title">
                                            <a href="{{ route('project-detail', ['slug'=> $single->project->slug] ) }}" target="_blank">{!! $single->project->project_title !!}</a> 
                                            <span>{{ $single->proposalAuthor->full_name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('proposal.created_date' )}}"><span>{{ date($date_format, strtotime( $single->created_at )) }}</span></td>
                                    <td data-label="{{ __('project.project_budget' )}}"><span>{{ getProjectPriceFormat($single->project->project_type, $currency_symbol, $single->project->project_min_price, $single->project->project_max_price) }}</span></td>
                                    <td data-label="{{ __('proposal.proposal_budget' )}}"><span>{{getPriceFormat($currency_symbol,$single->proposal_amount).($single->project->project_type == 'hourly' ? '/hr' : '')}}</span></td>
                                    <td data-label="{{ __('proposal.payout_type' )}}"><span>{{ $single->payout_type }}</span></td>
                                    <td data-label="{{__('general.status')}}"><em class="{{ $tag['class'] }}">{{ $tag['text'] }}</span></td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-status">
                                            <li>
                                                @if( $single->status == 'pending' )
                                                <span>
                                                    <a href="javascript:;" onClick="confirmation({{ $single->id }})"  ><i class="fas fa-check"></i>{{ __('proposal.approve') }}</a>
                                                </span>
                                                @else
                                                    <span class="tb-approved"><i class="fas fa-check"></i>{{ __('proposal.approved') }}</span>     
                                                @endif
                                            </li>
                                            <li>
                                                <span>
                                                    <a href="javascript:;" wire:click.prevent="showComment({{ $single->id }})"><i class="icon-message-square"></i></a>
                                                </span>
                                            </li>
                                            <li>
                                                <a href="{{route('proposal-detail',['slug' => $single->project->slug , 'id' => $single->id])}}" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                           
                                            <li> <a href="javascript:void(0);" onClick="deleteProposal({{ $single->id }})" class="tb-delete" ><i class="icon-trash-2"></i></a> </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                        {{ $proposals->links('pagination.custom') }}  
                    @else
                        @include('admin.no-record')
                    @endif  
                </div>
            </div>
        </div>
    </div>
    <div wire:igonre.self class="modal fade tb-addonpopup" id="special_comment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered tb-modaldalog">
            <div class="modal-content">
            <div class="tb-popuptitle">
                <h5>{{ __('proposal.special_comments_to_emp') }}</h5>
                <a href="javascrcript:void(0)" data-bs-dismiss="modal" class="close">
                    <i class="icon-x"></i>
                </a>
            </div>
            <div class="modal-body tb-popup-content">
                <div class="tb-popup-info">
                    <p class="tb-special-comment"></p>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        
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

        document.addEventListener('show-comment', function (event) {
            let comment = event.detail.comment;
            jQuery('.tb-special-comment').text(comment);
            jQuery('#special_comment').modal('show');
        });
        
    });

    function confirmation( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'approveProposalConfirm';
        let type_color      = 'green';
        let btn_class      = 'success';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
        
    }

    function deleteProposal( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'deleteProposal';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
@endpush
