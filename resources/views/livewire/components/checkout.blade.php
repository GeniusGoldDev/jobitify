<main class="tk-main-two tk-main-bg">
    <section class="tk-main-section">
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-7">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box">
                            <div class="tk-checkout-title">
                                <h4>{{__('checkout.checkout_heading')}}</h4>
                            </div>
                            <form class="tk-themeform">
                                <fieldset>
                                    <div class="tk-themeform__wrap">
                                        <div class="form-group form-group-half">
                                            <label class="tk-label tk-required">{{__('checkout.frist_name')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="first_name" placeholder="{{__('checkout.first_name_palceholder')}}" class="form-control tk-themeinput @error('first_name') tk-invalid @enderror">
                                            </div>
                                            @error('first_name')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-half">
                                            <label class="tk-label tk-required">{{__('checkout.last_name')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="last_name" class="form-control tk-themeinput @error('last_name') tk-invalid @enderror" placeholder="{{__('checkout.last_name_palceholder')}}">
                                            </div>
                                            @error('last_name')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-half">
                                            <label class="tk-label">{{__('checkout.company_label')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="text"wire:model.defer="company" placeholder="{{__('checkout.company_placeholder')}}" class="form-control tk-themeinput">
                                            </div>
                                        </div>
                                        <div class="form-group-half form-group_vertical">
                                            <label class="tk-label tk-required">{{__('checkout.country_lablel')}}</label>
                                            <div class="@error('country_id') tk-invalid @enderror">
                                                <div class="tk-select" wire:ignore >
                                                    <select name="pro-country" class="tk-select2" id="tk-country" data-placeholder="{{__('profile_settings.country_palceholder')}}" data-placeholderinput="{{__('general.search')}}">
                                                        <option label="{{__('profile_settings.country_palceholder')}}"></option>
                                                        @foreach( $countries as $country )
                                                            <option {{$country['id'] == $country_id ? 'selected' : ''}} value="{{$country['id']}}" >{{$country['name']}}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            </div>
                                            @error('country_id')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group-half form-group_vertical">
                                            <label class="tk-label tk-required">{{__('checkout.state_lablel')}}</label>
                                            <div class="@error('state_id') tk-invalid @enderror">
                                                <div class="tk-select">
                                                    <select name="pro-country" class="tk-select2" id="tk-states" data-placeholder="{{__('checkout.state_placeholder')}}" data-placeholderinput="{{__('general.search')}}">
                                                        @if( $has_states )
                                                            <option label="{{__('checkout.state_placeholder')}}"></option>
                                                            @foreach( $states as $state )
                                                                <option {{$state['id'] == $state_id ? 'selected' : ''}} value="{{$state['id']}}" >{{$state['name']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            @error('state_id')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-group-half">
                                            <label class="tk-label tk-required">{{__('checkout.zipcode_label')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="postal_code" class="form-control tk-themeinput @error('postal_code') tk-invalid @enderror" placeholder="{{__('checkout.zipcode_placeholder')}}">
                                            </div>
                                            @error('postal_code')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="tk-label tk-required">{{__('checkout.address_label')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="text"wire:model.defer="address" placeholder="{{__('checkout.address_placeholder')}}" class="form-control tk-themeinput @error('address') tk-invalid @enderror">
                                            </div>
                                            @error('address')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-half">
                                            <label class="tk-label tk-required">{{__('checkout.city_label')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="city" placeholder="{{__('checkout.city_placeholder')}}" class="form-control tk-themeinput @error('city') tk-invalid @enderror" >
                                            </div>
                                            @error('city')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-group-half">
                                            <label class="tk-label tk-required">{{__('checkout.phone_label')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="tel" wire:model.defer="phone" placeholder="{{__('checkout.phone_placeholder')}}" class="form-control tk-themeinput @error('phone') tk-invalid @enderror">
                                            </div>
                                            @error('phone')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="tk-label tk-required">{{__('checkout.email_label')}}</label>
                                            <div class="tk-placeholderholder">
                                                <input type="email" wire:model.defer="email" placeholder="{{__('checkout.email_placeholder')}}" class="form-control tk-themeinput @error('phone') tk-invalid @enderror">
                                            </div>
                                            @error('email')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span> 
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tk-project-box">
                            <div class="tk-projectbtns">
                                <span>{!!__('checkout.submit_form_desc',['privacy_policy_url'=> '<a href="javascript:void(0)">'. __("checkout.privacy_policy").' </a>' ]) !!}</span>
                                <a href="javascript:;"  class="checkout tk-btn-solid-lg-lefticon">{{__('checkout.continue_btn')}}<i class="icon-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <aside class="tk-status-holder">
                        <div class="tk-ordersumery-title">
                            <h4>{{__('checkout.order_summary')}}</h4>
                        </div>
                        <div class="tk-ordersumery-content">
                            @if( !empty($project_data['project_title']) )
                                <span>{{__('checkout.project_title')}}</span>
                                <strong>{{$project_data['project_title']}}</strong>
                            @elseif(!empty($package_data['package_title']))  
                                <span>{{__('checkout.package_name')}}</span>
                                <strong>{{$package_data['package_title']}}</strong> 
                            @elseif(!empty($gig_data['gig_title']))  
                                <span>{{__('checkout.gig_name')}}</span>
                                <strong>{{$gig_data['gig_title']}}</strong>  
                            @endif
                        </div>
                        <div class="tk-ordersumery-content">
                            <span>{{__('checkout.order_detail')}}</span>
                            <ul class="tk-order-detail">
                                @if( !empty($project_data) )
                                    @if( $project_data['payout_type'] == 'milestone' )
                                        <li>
                                            <h6>{{$project_data['milestone_title']}}</h6>
                                            <span>{{getPriceFormat($currency_symbol, $project_data['milestone_price'])}}</span>
                                        </li>
                                    @elseif( $project_data['payout_type'] == 'hourly' )
                                        <li>
                                            <h6>{{$project_data['timecard_title'] .' '. __('general.hourly_timecard')}}</h6>
                                            <span>{{getPriceFormat($currency_symbol, $project_data['timecard_price'])}}</span>
                                        </li>   
                                    @else
                                        <li>
                                            <h6>{{__('checkout.proposal_amount')}}</h6>
                                            <span>{{getPriceFormat($currency_symbol, $project_data['proposal_amount'])}}</span>
                                        </li>
                                    @endif

                                    <li class="tk-total-amount">
                                        <h5>{{__('checkout.total')}}</h5>
                                        @if( $project_data['payout_type'] == 'milestone' )
                                            @php
                                                $total = $project_data['milestone_price'];
                                            @endphp
                                            <span>{{getPriceFormat($currency_symbol, $project_data['milestone_price'])}}</span>
                                        @elseif($project_data['payout_type'] == 'hourly')
                                            @php
                                                $total = $project_data['timecard_price'];
                                            @endphp
                                            <span>{{getPriceFormat($currency_symbol, $project_data['timecard_price'])}}</span>
                                        @elseif( !empty($project_data['proposal_amount']) )
                                            @php
                                                $total = $project_data['proposal_amount'];
                                            @endphp
                                            <span>{{getPriceFormat($currency_symbol, $project_data['proposal_amount'])}}</span>
                                        @endif
                                    </li>
                                @elseif( !empty($package_data) )
                                    @php
                                        $total = $package_data['package_price'];
                                    @endphp 
                                    <li>
                                        <h6>{{__('checkout.package_price')}}</h6>
                                        <span>{{getPriceFormat($currency_symbol, $package_data['package_price'])}}</span>
                                    </li>
                                @elseif( !empty($gig_data) ) 
                                    <li>
                                        <h6>{{__('checkout.gig_plan_type')}}</h6>
                                        <span>{{ $gig_data['plan_type'] }}</span>
                                    </li>
                                    <li>
                                        <h6>{{__('checkout.gig_plan_price')}}</h6>
                                        <span>{{getPriceFormat($currency_symbol, $gig_data['plan_price'])}}</span>
                                    </li>
                                    @php
                                        $total = $gig_data['plan_price'];
                                    @endphp
                                    @if(!empty($gig_data['gig_addons']))
                                        <hr>
                                        <li>
                                            <h6>{{ __('checkout.gig_addons') }}</h6>
                                        </li>
                                        <hr>
                                        @foreach($gig_data['gig_addons'] as $single)
                                            @php
                                                $total +=$single['price']; 
                                            @endphp
                                            <li>
                                                <h6>{{ $single['title'] }}</h6>
                                                <span>{{getPriceFormat($currency_symbol, $single['price'])}}</span>
                                            </li>
                                        @endforeach  
                                    @endif      
                                    <li class="tk-total-amount">
                                        <h5>{{__('checkout.total')}}</h5>
                                        <span>{{getPriceFormat($currency_symbol, $total)}}</span>
                                    </li>  
                                @endif
                            </ul>
                        </div>
                        @if( !empty($available_payment_methods) )
                            <div class="tk-payment-methods tk-checkoutsummary">
                                <ul class="tk-priorityradio">
                                    @foreach( $available_payment_methods as $key => $record )
                                        <li class="tk-paymentoption">
                                            <div class="tk-form-checkbox">
                                                <input class="form-check-input tk-form-check-input-sm selected_payment_method" wire:model="payment_method"  type="radio" id="radio-{{$key}}" {{ $payment_method == 'key' ? 'checked' : '' }}    value="{{$key}}"   />
                                                <label class="form-check-label" for="radio-{{$key}}" class="tb-radiolist">
                                                    <img src="{{asset('images/payment_methods/'.$key.'.png')}}" >
                                                    <span class="tb-prioritymain">{{ ucfirst($key) }} </span>
                                                </label>
                                            </div>
                                            @if( $payment_method == 'stripe' )
                                                <div class="tb-cardinfo">
                                                    <input class="StripeElement form-control card_holder_name"  placeholder="{{ __('checkout.card_holder_name')}}" required>                             
                                                    <div id="card-element"></div>
                                                    <div class="tk-errormsg card-errors d-none">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                    @if( $wallet_balance )
                                        <li class="tk-wallet-option">
                                            <div class="tk-switchservice">
                                                <span>{{ __('checkout.use_wallet_amt')}} ({{ getPriceFormat($currency_symbol, $wallet_balance)  }})</span>
                                                <div class="tk-onoff">
                                                    <input type="checkbox" id="use-wallet-bal" />
                                                    <label for="use-wallet-bal">
                                                        <em><i></i></em>
                                                        <span class="tk-enable"></span><span class="tk-disable"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                                @error('payment_method') 
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span> 
                                    </div>    
                                @enderror
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>   
    </section>
    <!-- checkout info -->
</main>
@push('styles')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a !important;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endpush 
@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script defer src="https://js.stripe.com/v3/"></script>
<script>
     document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('#tk-states').select2( { allowClear: true, });
            iniliazeSelect2Scrollbar();
            $('#tk-states').on('change', function (e) {
                let country = $('#tk-states').select2("val");
                @this.set('state_id', country, true);
            });
        })
    });
    
    document.addEventListener('livewire:load', function () {

        let stripe = '';
        let StripePaymentMethod = null;
        let card = '';
        let stripe_client_secret = '';
        let use_wallet = false;

        setTimeout(() => {
            jQuery('.tk-select2').each(function(index, item) {
                let _this = jQuery(this);
                _this.select2( { allowClear: true, });
            });
            iniliazeSelect2Scrollbar(); 
        }, 500);

        $(document).on('change','#tk-country',function (e) {
            let country = $('#tk-country').select2("val");
            @this.set('country_id', country);
        });

        $(document).on('change','#tk-states', function (e) {
            let state = $('#tk-states').select2("val");
            @this.set('state_id', state, true);
        });

        $(document).on('change','#use-wallet-bal', function (e) {
            if ( $(this).prop('checked') ){
                @this.set('use_wallet_bal', true, true);
                use_wallet = true;
            }else{
                @this.set('use_wallet_bal', false, true);
                use_wallet = false;
            }
        });

        window.addEventListener('initStateDropdown', event => { 
            $('#tk-states').select2( { allowClear: true, });
        });

        function initializeStripe(id){
            stripe_client_secret = id;
            stripe = Stripe("{{ config('app.stripe_key') }}")
            let elements = stripe.elements();
            let style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
            card = elements.create('card', {style: style})
            card.mount('#card-element');
        }
        
        window.addEventListener('initializeStripe', event => { 
            initializeStripe(event.detail.client_secret);
        });
        

        $(document).on('click', '.checkout', function(event) {

            event.stopPropagation();
            let _this = $(this);
            method =  $("input:radio.selected_payment_method:checked").val();

            let wallet_balance  = Number('{{ $wallet_balance }}');
            let total           = Number('{{ $total }}');
            if(use_wallet && wallet_balance >= total ){
                method = 'wallet';
            }
            if( method == 'stripe' ){

                $('.preloader-outer').css('display','block');
                _this.attr('disabled', true);

                stripe.confirmCardSetup(
                    stripe_client_secret,
                    {
                        payment_method: {
                            card: card,
                            billing_details: {name: $('.card_holder_name').val()}
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        $('.card-errors span').text(result.error.message)
                        $('.card-errors').removeClass('d-none');
                        _this.removeAttr('disabled')
                        $('.preloader-outer').css('display','none');
                    }else{
                        $('.card-errors').addClass('d-none');
                        StripePaymentMethod = result.setupIntent.payment_method
                        @this.set('stripe_payment_method', StripePaymentMethod, true);
                        @this.call('checkout');
                    }
                });
            }else{
                @this.call('checkout');
            }
        });
       
    });
</script>
@endpush