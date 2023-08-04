@php 
    $userInfo   = getUserInfo();
    $user_name  = !empty($userInfo['user_name']) ? $userInfo['user_name'] : '';
    $activeMethod = [];
@endphp
<div class="tk-paymentways tk-project-box">
    <div class="@role('buyer') tk-ecrow-setup @endrole tk-projectboxinner">
        <div class="tk-seller-details">
            <div class="tk-seller-heading">
                <div class="tk-seller-name">
                    @if($default_selected == 'escrow')
                        <h6>{{__('transaction.escrow')}}</h6>
                    @elseif($default_selected == 'paypal')
                        <h6>{{__('transaction.paypal')}}</h6>
                    @elseif($default_selected == 'payoneer')
                        <h6>{{__('transaction.payoneer')}}</h6>
                    @elseif($default_selected == 'bank')
                        <h6>{{__('transaction.bank')}}</h6>
                    @endif
                </div>
                @if( !empty($default_selected) )
                    <div class="tk-seller-logo">
                        <img src="{{asset('images/payment_methods/'.$default_selected.'.png')}}">
                    </div>
                @endif
            </div>
            @if( $default_selected == 'escrow' && !empty( $payoutSettings['escrow']['escrow_email'] ) )
                <h3>{{ stringInputMask( $payoutSettings['escrow']['escrow_email'] ) }}</h3>
            @elseif( $default_selected == 'paypal' && !empty($payoutSettings['paypal']['paypal_email']) )
                <h3>{{ stringInputMask( $payoutSettings['paypal']['paypal_email'] ) }}</h3>
            @elseif( $default_selected == 'payoneer' && !empty($payoutSettings['payoneer']['payoneer_email']) )
                <h3>{{ stringInputMask( $payoutSettings['payoneer']['payoneer_email'] ) }}</h3>
            @elseif( $default_selected == 'bank' && !empty($payoutSettings['bank']) )
                <h5>
                    {{ __('billing_info.bank_name') . ' : '. stringInputMask($payoutSettings['bank']['bank_name']) }}
                    <br>
                    {{ __('billing_info.account_number'). ' : '. stringInputMask( $payoutSettings['bank']['account_number'] ) }}
                </h5>
            @endif
        </div>
        @role('seller')
            <div class="tk-withdrawamount">
                <div class="tk-themeform tk-payment-submenu">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group tk-formlimit">
                                <label for="paypal_email" class="tk-label tk-required">{{ __('transaction.withdraw_amount') }}</label>
                                <div class="tk-inputicon">
                                    <input type="number" wire:model.defer="amount" class="form-control @error('amount') tk-invalid @enderror" placeholder="{{__('transaction.withdraw_amount')}}" autocomplete="off">
                                    <em class="tk-maxlimitt">{{ __('transaction.max_limit') }}: {{ $currency_symbol .number_format($available_balance, 2) }}</em>
                                </div>
                                @error('amount')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        @endrole
        <h5>{{__('billing_info.setup_payout_methods')}}</h5>
        <ul class="tk-payoutmethod tk-payoutmethodvtwo">
            @if( $method_type == 'escrow' )
                <li class="tk-radiobox">
                    <input type="radio" value="escrow" @if($default_selected == 'escrow' ) checked @endif class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-escrow" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="{{asset('images/payment_methods/escrow.png')}}">
                            <span>{{__('billing_info.escrow_heading')}}</span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-escrow" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="escrow_email" class="tk-label tk-required">{{ __('billing_info.escrow_email_label') }}</label>
                                    <input type="text" wire:model.defer="escrow_email" id="escrow_email" class="form-control @error('escrow_email') tk-invalid @enderror" placeholder="{{__('billing_info.escrow_email_placeholder')}}">
                                    @error('escrow_email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="escrow_email" class="tk-label tk-required">{{ __('billing_info.escrow_apikey_label') }}</label>
                                    <input type="text" wire:model.defer="escrow_api_key" class="form-control @error('escrow_api_key') tk-invalid @enderror" placeholder="{{__('billing_info.escrow_apikey_placeholder')}}">
                                    @error('escrow_api_key')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="tb-paymetdesc pt-0">
                                        <p>
                                            <em>{{__('billing_info.escrow_desc')}}<span>{{ __('billing_info.more_about') }} <a target="blank" href="https://www.escrow.com/">{{__('billing_info.escrow_site')}}</a> <span>|</span> <a target="_blank" href="https://www.escrow.com/signup-page">{{__('billing_info.create_account')}}</a></span></em>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group pt-0 tk-profileform__holder w-100 text-right">
                                    <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('escrow')" class="tk-btn-solid">{!! __('general.save') !!}</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            @elseif($method_type == 'others')
                <li class="tk-radiobox">
                    <input type="radio" value="paypal" @if( $default_selected == 'paypal' ) checked @endif class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-paypal" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="{{asset('images/payment_methods/paypal.png')}}">
                            <span>{{__('billing_info.paypal_heading')}}</span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-paypal" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="paypal_email" class="tk-label tk-required">{{__('billing_info.paypal_email_label')}}</label>
                                    <input type="text" wire:model.defer="paypal_email" id="paypal_email" class="form-control @error('paypal_email') tk-invalid @enderror" placeholder="{{__('billing_info.paypal_email_label')}}">
                                    @error('paypal_email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="tb-paymetdesc pt-0">
                                        <p>
                                            <em>{!! __('billing_info.paypal_desc',['paypal_link' => '<a target="_blank" href="https://www.paypal.com/"> '.__('billing_info.paypal').' </a>', 'create_account' => '<a target="_blank" href="https://www.paypal.com/signup/">'.__('billing_info.create_account').'</a>'] ) !!}</em>
                                        </p>
                                    </div>
                                    <div class="tk-profileform__holder w-100 text-right">
                                        <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('paypal')" class="tk-btn-solid">{!! __('general.save') !!}</a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <li class="tk-radiobox">
                    <input type="radio" value="payoneer" @if( $default_selected == 'payoneer' ) checked @endif class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-payoneer" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="{{asset('images/payment_methods/payoneer.png')}}">
                            <span>{{__('billing_info.payoneer_heading')}}</span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-payoneer" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="payoneer_email" class="tk-label tk-required">{{__('billing_info.payoneer_email_label')}}</label>
                                    <input type="email" wire:model.defer="payoneer_email" id="payoneer_email" class="form-control @error('payoneer_email') tk-invalid @enderror" placeholder="{{__('billing_info.payoneer_email_label')}}">
                                    @error('payoneer_email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="tb-paymetdesc pt-0">
                                        <p>
                                            <em>{!! __('billing_info.payoneer_desc',['payoneer_link' => '<a target="_blank" href="https://www.payoneer.com/"> '.__('billing_info.payoneer_heading').' </a>', 'create_account' => '<a target="_blank" href="https://www.payoneer.com/accounts/">'.__('billing_info.create_account').'</a>'] ) !!}</em>
                                        </p>
                                    </div>
                                    <div class="tk-profileform__holder w-100 text-right">
                                        <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('payoneer')" class="tk-btn-solid">{!! __('general.save') !!}</a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <li class="tk-radiobox">
                    <input type="radio" value="bank" @if($default_selected == 'bank' ) checked @endif class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-bank" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="{{asset('images/payment_methods/bank.png')}}">
                            <span>{{__('billing_info.bank_heading')}}</span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-bank" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="bank_title" class="tk-label tk-required">{{__('billing_info.account_title')}}</label>
                                    <input type="text" wire:model.defer="bankAccountInfo.title" id="bank_title" class="form-control @error('bankAccountInfo.title') tk-invalid @enderror" placeholder="{{__('billing_info.account_title')}}">
                                    @error('bankAccountInfo.title')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bank_account_number" class="tk-label tk-required">{{__('billing_info.account_number')}}</label>
                                    <input type="text" wire:model.defer="bankAccountInfo.account_number" id="bank_account_number" class="form-control @error('bankAccountInfo.account_number') tk-invalid @enderror" placeholder="{{__('billing_info.account_number')}}">
                                    @error('bankAccountInfo.account_number')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bank_name" class="tk-label tk-required">{{__('billing_info.bank_name')}}</label>
                                    <input type="text" wire:model.defer="bankAccountInfo.bank_name" id="bank_name" class="form-control @error('bankAccountInfo.bank_name') tk-invalid @enderror" placeholder="{{__('billing_info.bank_name')}}">
                                    @error('bankAccountInfo.bank_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="routing_number" class="tk-label tk-required">{{__('billing_info.routing_number')}}</label>
                                    <input type="text" wire:model.defer="bankAccountInfo.routing_number" id="routing_number" class="form-control @error('bankAccountInfo.routing_number') tk-invalid @enderror" placeholder="{{__('billing_info.routing_number')}}">
                                    @error('bankAccountInfo.routing_number')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bank_iban" class="tk-label tk-required">{{__('billing_info.bank_iban')}}</label>
                                    <input type="text" wire:model.defer="bankAccountInfo.bank_iban" id="bank_iban" class="form-control @error('bankAccountInfo.bank_iban') tk-invalid @enderror" placeholder="{{__('billing_info.bank_iban')}}">
                                    @error('bankAccountInfo.bank_iban')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="bank_bic_swift" class="tk-label tk-required">{{__('billing_info.bank_bic_swift')}}</label>
                                    <input type="text" wire:model.defer="bankAccountInfo.bank_bic_swift" id="bank_bic_swift" class="form-control @error('bankAccountInfo.bank_bic_swift') tk-invalid @enderror" placeholder="{{__('billing_info.bank_bic_swift')}}">
                                    @error('bankAccountInfo.bank_bic_swift')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="tk-profileform__holder w-100 text-right">
                                        <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('bank')" class="tk-btn-solid">{!! __('general.save') !!}</a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            @endif
            @error('payout_type')
                <div class="tk-errormsg">
                    <span>{{$message}}</span> 
                </div>
            @enderror
        </ul>
    </div>
    @role('seller')
        <a href="javascript:void(0)" wire:click.prevent="withdraw" wire:loading.class="tk-pointer-events-none" class="tk-withdraw-button tk-withdrawamt">
            <b wire:loading wire:target="withdraw"> {{__('general.waiting')}} </b>
            <b wire:loading.remove wire:target="withdraw">{{__('transaction.withdraw_now')}} </b>
        </a>
    @endrole
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.payout-method').on('click', function (e) {
                @this.set('payout_type', $(this).val(), true);
            });

            $(document).on('click', '.tk-payoutmethod .form-check-label', function(){
                let _this = $(this);
                if( _this.attr('aria-expanded') == 'true') {
                    _this.closest('.tk-radiobox').addClass('tk-expanded');
                } else {
                    _this.closest('.tk-radiobox').removeClass('tk-expanded');
                }
            })
        });
    </script>
@endpush