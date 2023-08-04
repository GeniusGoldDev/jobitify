<main class="tb-main">
    <div class="row">
        <div class="col-md-6 tb-md-50">
            <div class="tb-dhb-mainheading">
                <h4>{{__('disputes.disputes_listing')}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <div wire:ignore class="tb-select">
                                        <select class="form-control" id="filter_status">
                                            <option value ="">{{ __('disputes.all_dispute_opt')  }} </option>
                                            <option value="refunded">{{ __('disputes.resolved_dispute_opt') }}</option>
                                            <option value="disputed">{{ __('disputes.new_dispute_opt') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search" autocomplete="off" placeholder="{{__('disputes.search_placeholder')}}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            @if(!empty($disputes) && $disputes->count() > 0)
                <div class="tb-disputetable tb-disputetablev2">
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('disputes.ref_label')  }}</th>
                                <th>{{ __('disputes.buyer_name_label') }}</th>
                                <th>{{ __('disputes.saller_name_label') }}</th>
                                <th>{{ __('disputes.date_lable') }}</th>
                                <th>{{ __('disputes.satatus_label') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($disputes as $single)
                                @php
                                    $seller = $buyer = '';
                                    $creator_role_id        = $single->disputeCreator->role_id;
                                    $disputeCreatorRole     = getRoleById($creator_role_id);
                                    $receiver_role_id       = $single->disputeReceiver->role_id;
                                    $disputeReceiverRole    = getRoleById($receiver_role_id);

                                    if( $disputeCreatorRole == 'seller' && $disputeReceiverRole == 'buyer'){
                                        $seller = $single->disputeCreator;
                                        $buyer  = $single->disputeReceiver;
                                    } else {
                                        $seller = $single->disputeReceiver;
                                        $buyer  = $single->disputeCreator;
                                    }
                                    $disputeStatus = getDisputeStatusTag($single->status);
                                @endphp
                                <tr class="tk-dispute-item" wire:click="getDisputeInfo({{$single->id}})" data-id="{{$single->id}}">
                                    <td data-label="{{ __('disputes.ref_label') }}">
                                        <span> {{$single->id}} </span>
                                    </td>
                                    <td data-label="{{ __('disputes.buyer_name_label') }}"> 
                                        @if(!empty($buyer))
                                            <span><a href="javascript:void(0)">{{$buyer->full_name}}</a> </span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('disputes.saller_name_label') }}"> 
                                        @if(!empty($seller))
                                            <span><a href="javascript:void(0)">{{$seller->full_name}}</a> </span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('disputes.date_lable') }}">
                                        <span>{{date($date_format, strtotime($single->created_at))}} </span>
                                    </td>
                                    <td data-label="{{ __('disputes.satatus_label') }}">
                                        <em class="{{$disputeStatus['class']}}">{{$disputeStatus['text']}}</em>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else   
                @include('admin.no-record')
            @endif
        </div>
       
        <div class="col-md-6 tb-md-50">
            @if(!empty($dispute_id))
                @livewire('admin.disputes.dispute-detail',array(
                    'dispute_id'       => $dispute_id,
                    'date_format'      => $date_format,
                    'allowFileSize'    => $allowFileSize, 
                    'allowFileExt'     => $allowFileExt,
                    'currency_symbol'  => $currency_symbol,
                ))
            @else
                <div class="tb-nocommision d-flex">
                    <img src="{{asset('images/empty.png')}}" alt="">
                    <span>{{__('disputes.select_dispute')}}</span>
                </div>
            @endif
        </div>
    </div>
</main>

@push('scripts')

<script>
    document.addEventListener('livewire:load', function () {

        $(document).on('click', '.tk-dispute-item', function() {
            let _this   = jQuery(this);
            let id      = _this.data('id');
            $('.tk-dispute-item.active').removeClass('active');
            $(this).addClass('active');
            updateUrlParam('id', id);
        });

        setTimeout(function() {

            $('#filter_status').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_status').on('change', function (e) {
                let filter_status = $('#filter_status').select2("val");
                @this.set('filter_status', filter_status);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        function updateUrlParam(key, value) {
            if (history.pushState) {
                let searchParams = new URLSearchParams(window.location.search);
                searchParams.set(key, value);
                let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
                window.history.pushState({path: newurl}, '', newurl);
            }
        }
    });

</script>
@endpush