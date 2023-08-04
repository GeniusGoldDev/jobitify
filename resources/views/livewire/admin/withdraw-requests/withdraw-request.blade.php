<main class="tb-main" wire:key="{{time()}}">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_requests') .' ('. $requests->total() .')' }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_request" class="form-control tk-selectprice">
                                            <option value =""> {{ __('general.all') }} </option>
                                            <option value ="pending"> {{ __('general.pending') }} </option>
                                            <option value ="processed"> {{ __('general.processed_payment') }} </option>
                                            <option value ="complete"> {{ __('general.completed') }} </option>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_request"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$requests->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __( 'general.name' )}}</th>
                                <th>{{ __('general.date' )}}</th>
                                <th>{{ __('general.withdraw_amount' )}}</th>
                                <th>{{ __('general.payout_type' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{ __('general.account_detail' )}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $single)
                                @php
                                $tag = getTag( $single->status );
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __( 'general.name' )}}"><span>{!! $single->User->full_name !!}</span></td>
                                    <td data-label="{{ __('general.date' )}}"><span>{{ date($date_format, strtotime( $single->created_at )) }}</span></td>
                                    <td data-label="{{ __('general.withdraw_amount' )}}"><span>{{ getPriceFormat($currency_symbol, $single->amount) }}</span></td>
                                    <td data-label="{{ __('general.payout_type' )}}">
                                        @if($single->payment_method == 'escrow')
                                            <span>{{ __('billing_info.escrow') }}</span>
                                        @elseif($single->payment_method == 'paypal')
                                            <span>{{ __('billing_info.paypal') }}</span>
                                        @elseif($single->payment_method == 'payoneer')
                                            <span>{{ __('billing_info.payoneer_heading') }}</span>
                                        @elseif($single->payment_method == 'bank')
                                            <span>{{ __('billing_info.bank') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="{{ $tag['class'] }}">{{ $tag['text'] }}</em>
                                    </td>
                                    <td data-label="{{ __('general.account_detail' )}}">
                                        <ul class="tb-action-status">
                                            <li>
                                                @if( $single->status == 'pending' )
                                                <span>
                                                    <a href="javascript:;" onClick="confirmation({{ $single->id }})"  ><i class="fas fa-check"></i>{{ __('project.approve') }}</a>
                                                </span>
                                                @else
                                                    <span class="tb-approved"><i class="fas fa-check"></i>{{ __('project.approved') }}</span>     
                                                @endif
                                            </li>
                                            <li>
                                                <a href="javascript:;" wire:click.prevent="accountInfo({{$single->id}})" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    {{ $requests->links('pagination.custom') }}
                @else
                    @include('admin.no-record')
                @endif  
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tb-addonpopup" id="account-info-modal"  tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    @if( $payment_method == 'escrow' )
                        <h4> {{ __('billing_info.escrow_acc_info') }} </h4>
                    @elseif( $payment_method == 'paypal' ) 
                        <h4> {{ __('billing_info.paypal_info') }} </h4>
                    @elseif( $payment_method == 'payoneer' ) 
                        <h4> {{ __('billing_info.payoneer_acc_info') }} </h4>
                    @elseif( $payment_method == 'bank'  ) 
                        <h4> {{ __('billing_info.bank_acc_info') }} </h4>
                    @endif
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <ul class="tb-userinfo">
                    
                        @if( $payment_method == 'escrow' )
                            <li>
                                <span>{{ __('general.email') }}:</span>
                                <h6>{{ $account_info['escrow_email'] }}</h6>
                            </li>
                        @elseif( $payment_method == 'paypal' ) 
                            <li>
                                <span>{{ __('general.email') }}:</span>
                                <h6>{{ $account_info['paypal_email'] }}</h6>
                            </li>
                        @elseif( $payment_method == 'payoneer'  ) 
                            <li>
                                <span>{{ __('general.email') }}:</span>
                                <h6>{{ $account_info['payoneer_email'] }}</h6>
                            </li>
                        @elseif( $payment_method == 'bank' ) 
                            <li>
                                <span>{{ __('billing_info.account_title') }}:</span>
                                <h6>{{ $account_info['title'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.account_number') }}:</span>
                                <h6>{{ $account_info['account_number'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.bank_name') }}:</span>
                                <h6>{{ $account_info['bank_name'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.routing_number') }}:</span>
                                <h6>{{ $account_info['routing_number'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.bank_iban') }}:</span>
                                <h6>{{ $account_info['bank_iban'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.bank_bic_swift') }}:</span>
                                <h6>{{ $account_info['bank_bic_swift'] }}</h6>
                            </li>
                        @endif
                    </ul>
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

            $('#filter_request').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_request').on('change', function (e) {
                let filter_request = $('#filter_request').select2("val");
                @this.set('filter_request', filter_request);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        window.addEventListener('account-info-modal', event => {
            $('#account-info-modal').modal(event.detail.modal);
        });
    });
  
    function confirmation( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'approveRequestConfirm';
        let type_color      = 'green';
        let btn_class      = 'success';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
@endpush
