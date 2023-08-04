<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tb-dhb-mainheading tb-disputes-title">
                        <h4>{{__('disputes.disputes_listing')}}</h4>
                        <div class="tb-sortby">
                            <form class="tb-themeform tb-displistform">
                                <fieldset>
                                    <div class="tb-themeform__wrap">
                                        <div class="form-group wo-inputicon wo-inputheight">
                                            <i class="icon-search"></i>
                                            <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="{{__('disputes.search_placeholder')}}">
                                        </div>
                                        <div class="wo-inputicon">
                                            <div class="tb-actionselect tb-actionselect2">
                                                <span>{{ __('general.sort_by')  }}:</span>
                                                <div wire:ignore class="tb-select tk-select">
                                                    <select id="dispute_filter" data-hide_search_opt="true" class="form-control tk-select2">
                                                        <option value="">{{ __('disputes.all_dispute_opt')  }} </option>
                                                        <option value="disputed">{{ __('disputes.new_dispute_opt') }}</option>
                                                        <option value="refunded">{{ __('disputes.refund_dispute_opt') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                  
                    @if(!empty($disputes) && $disputes->count() > 0)
                        <table class="table tb-table">
                            <thead>
                                <tr>
                                    <th>{{__('general.ref_no')}}</th>
                                    <th>{{$userRole == 'buyer' ? __('disputes.saller_name_label') : __('disputes.buyer_name_label')}} </th>
                                    <th>{{__('disputes.date_lable')}}</th>
                                    <th>{{__('disputes.amount_lable')}}</th>
                                    <th>{{__('disputes.satatus_label')}}</th>
                                    <th>{{__('disputes.action_label')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($disputes as $key => $dispute)
                                    @php
                                        $creatorRoleId          = $dispute->disputeCreator->role_id;
                                        $disputeCreatorRole     = getRoleById($creatorRoleId);
                                        $receiverRoleId         = $dispute->disputeReceiver->role_id;
                                        $disputeReceiverRole    = getRoleById($receiverRoleId);
                                        $userName               = '';
                                        if( $disputeCreatorRole == $userRole ){
                                            $userName = $dispute->disputeReceiver->full_name;
                                        } else {
                                            $userName = $dispute->disputeCreator->full_name;
                                        }
                                        
                                        $disputeStatus = getDisputeStatusTag($dispute->status);
                                    @endphp
                                    <tr>
                                        <td data-label="{{__('general.ref_no')}}">{{$dispute->id}}</td>
                                        <td data-label="{{$userRole == 'buyer' ? __('disputes.saller_name_label') : __('disputes.buyer_name_label')}}"><a href="javascript:void(0);">{{$userName}}</a> </td>
                                        <td data-label="{{__('disputes.date_lable')}}">{{date($date_format, strtotime($dispute->created_at))}}</td>
                                        <td data-label="{{__('disputes.amount_lable')}}"><span>{{getPriceFormat($currency_symbol,$dispute->price)}}</span></td>
                                        <td data-label="{{__('disputes.satatus_label')}}">
                                            <div class="tb-dispueitems tb-dispueitemsv2">
                                                <span class="{{$disputeStatus['class']}}">{{$disputeStatus['text']}}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{__('disputes.action_label')}}">
                                            <a href="{{route('dispute-detail',['id' => $dispute->id])}}" class="tb-vieweye">
                                                <span class="ti-eye"></span> {{__('disputes.view_label')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $disputes->links('pagination.custom') }}
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
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        iniliazeSelect2Scrollbar();
        $(document).on('change', '#dispute_filter', function (e) {
            let value     = $('#dispute_filter').select2("val");
            @this.set('filter_status',value);
        });

    });
</script>
@endpush