<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('transaction.all_transactions') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                            
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_earning" class="form-control tk-selectprice">
                                            <option value =""> {{ __('transaction.all_transactions') }} </option>
                                            <option value ="pending"> {{ __('general.pending') }} </option>
                                            <option value ="processed"> {{ __('general.hired') }} </option>
                                            <option value ="completed"> {{ __('general.completed') }} </option>
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
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$earnings->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('transaction.ref_no' )}}</th>
                                <th>{{ __('transaction.created_date' )}}</th>
                                <th>{{ __('transaction.total_amount' )}}</th>
                                <th>{{ __('transaction.admin_fees' )}}</th>
                                <th>{{ __('transaction.payment_type' )}}</th>
                                <th>{{ __('transaction.payment_method' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earnings as $single)
                                @php
                                $tag = getTag( $single->transaction->status );
                                $currency_symbol = '';
                                $currency_detail = currencyList($single->transaction->TransactionDetail->currency);
                                    if( !empty($currency_detail) ){
                                        $currency_symbol = $currency_detail['symbol']; 
                                    }
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __('transaction.ref_no' )}}"><span>{{ !empty($single->transaction->trans_ref_no) ? $single->transaction->trans_ref_no : $single->transaction->invoice_ref_no }}</span></td>
                                    <td data-label="{{ __('transaction.created_date' )}}"><span>{{ date($date_format, strtotime( $single->transaction->updated_at )) }}</span></td>
                                    <td data-label="{{ __('transaction.total_amount' )}}"><span>{{getPriceFormat($currency_symbol, $single->transaction->TransactionDetail->amount + $single->transaction->TransactionDetail->used_wallet_amt) }}</span></td>
                                    <td data-label="{{ __('transaction.admin_fees' )}}"><span>{{getPriceFormat($currency_symbol, $single->amount) }}</span></td>
                                    <td data-label="{{ __('transaction.payment_type' )}}"><span>{{ ucfirst($single->transaction->payment_type) }}</span></td>
                                    <td data-label="{{ __('transaction.payment_method' )}}"><span>{{ ucfirst($single->transaction->payment_method) }}</span></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="{{ $tag['class'] }}">{{ $tag['text'] }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-status"> 
                                            <li>
                                                <a href="javascript:;" wire:click.prevent="earningDetail({{ $single->transaction->id }})"><i class="icon-eye"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                        {{ $earnings->links('pagination.custom') }}  
                    @else
                        @include('admin.no-record')
                    @endif  
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="transaction_detail_popup"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content tb-transaction-detail">
                    <div class="tb-popuptitle">
                        <h4> {{ __('transaction.transaction_detail') }} </h4>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        @if(!empty($transaction_detail) )
                            <ul class="tb-userinfo-list" id="{{$modal_id}}">
                                <li>
                                    <span>{{ __('transaction.invoice_no') }}:</span>
                                    <h6>{{ $transaction_detail['id'] }}</h6>
                                </li>
                                <li>
                                    <span>{{ __('transaction.created_date') }}:</span>
                                    <h6>{{ date($date_format, strtotime( $transaction_detail['date'] )) }}</h6>
                                </li>
                                @if( $transaction_detail['type'] == 'project' && !empty($transaction_detail['project_title']) )
                                    <li>
                                        <span>{{ __('transaction.project_title') }}:</span>
                                        <h6>{!! $transaction_detail['project_title'] !!}</h6>
                                    </li>
                                @endif
                                <li>
                                    <span>{{ __('transaction.transaction_title') }}:</span>
                                    <h6>{!! $transaction_detail['transaction_title'] !!}</h6>
                                </li>
                                <li>
                                    <span>{{ __('transaction.transaction_type') }}:</span>
                                    <h6>{{ ucfirst($transaction_detail['type']) }}</h6>
                                </li>
                                <li>
                                    <span>{{ __('transaction.payment_method') }}:</span>
                                    <h6>{{ ucfirst($transaction_detail['payment_method']) }}</h6>
                                </li>
                                <li>
                                    <span>{{ __('transaction.transaction_amount') }}:</span>
                                    <h6>{{getPriceFormat($transaction_detail['currency'], $transaction_detail['total_amount']) }}</h6>
                                </li>
                                @if( $transaction_detail['type'] == 'project' && !empty($transaction_detail['seller_amount']) )
                                    <li>
                                        <span>{{ __('transaction.seller_amount') }}:</span>
                                        <h6>{{getPriceFormat($transaction_detail['currency'], $transaction_detail['seller_amount']) }}</h6>
                                    </li>
                                    <li>
                                        <span>{{ __('transaction.admin_amount') }}:</span>
                                        <h6>{{getPriceFormat($transaction_detail['currency'], $transaction_detail['admin_amount']) }}</h6>
                                    </li>
                                @endif
                                <li>
                                    <span>{{ __('transaction.buyer') }}:</span>
                                    <h6>{{ $transaction_detail['buyer'] }}</h6>
                                </li>
                                @if( $transaction_detail['type'] == 'project' && !empty($transaction_detail['seller']) )
                                    <li>
                                        <span>{{ __('transaction.seller') }}:</span>
                                        <h6>{{ $transaction_detail['seller'] }}</h6>
                                    </li>
                                @endif
                            </ul> 
                        @endif                      
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

            $('#filter_earning').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_earning').on('change', function (e) {
                let filter_earning = $('#filter_earning').select2("val");
                @this.set('filter_earning', filter_earning);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        window.addEventListener('transaction-detail-modal', event => {
            $(document).find('#'+event.detail.modal_id).mCustomScrollbar();
            $('#transaction_detail_popup').modal('show');
        });
    });
</script>
@endpush
