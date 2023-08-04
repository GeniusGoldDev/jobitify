<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="tb-payouthistory tk-payouthistoryvtwo">
                <div class="tk-submitreview tk-submitreviewvtwo tk-seller-graph">
                    <div class="tb-dhb-mainheading tk-emptyheading">
                        <div class="tb-tabfiltertitle">
                            <h5>{{ __('transaction.withdrawal_history') }}</h5>
                        </div>
                        <div class="tb-sortby">
                            <form class="tb-themeform tb-displistform">
                                <fieldset>
                                    <div class="tb-themeform__wrap">
                                        <div class="wo-inputicon">
                                            <div class="tb-actionselect tb-actionselect2">
                                                <div class="tb-select" wire:ignore>
                                                    <select id="filter_status" data-hide_search_opt="true" class="form-control tk-select2">
                                                        <option value="">{{ __('general.all') }}</option>
                                                        <option value="pending">{{ __('general.pending') }}</option>
                                                        <option  value="completed">{{ __('general.approved') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>  
                        </div>
                    </div>
                    @if( !$payouts_history->isEmpty() )
                        <table class="table tb-table">
                            <thead>
                                <tr>
                                    <th>{{ __('transaction.ref_no')}}</th>
                                    <th>{{ __('transaction.date')}}</th>
                                    <th>{{ __('transaction.payout_type')}}</th>
                                    <th>{{ __('transaction.amount')}}</th>
                                    <th>{{ __('transaction.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payouts_history as $single)
                                    @php
                                    if( $single->status == 'processed' ){ 
                                        $single->status = 'completed';
                                    }
                                    $tag = getTag( $single->status );
                                    @endphp
                                    <tr>
                                        <td data-label="{{ __('transaction.ref_no') }}"><label><span>{{ $single->id }}</span></label></td>
                                        <td data-label="{{ __('transaction.date') }}">{{ date($date_format, strtotime( $single->created_at )) }}</td>
                                        <td data-label="{{ __('transaction.payout_type') }}"> <a href="javascript:void(0)"> {{ ucfirst( $single->payment_method )}}</a> </td>
                                        <td data-label="{{ __('transaction.amount') }}"><span>{{ getPriceFormat($currency_symbol, $single->amount) }} </span></td>
                                        <td data-label="{{ __('transaction.status') }}"><em class="{{ $tag['class'] }}">{{ $tag['text'] }}</em></td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        {{ $payouts_history->links('pagination.custom') }} 
                    @else
                        <div class="tk-emptypayout">
                            <figure>
                                <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                            </figure>
                            <h4>{{ __('general.no_record') }}</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            iniliazeSelect2Scrollbar();
            $('#filter_status').on('change', function (e) {
                let filter_status = $('#filter_status').select2("val");
                @this.set('filter_status', filter_status);
            });
        });
    </script>
@endpush