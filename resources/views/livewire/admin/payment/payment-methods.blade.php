<main class="tb-main tb-mainbg tk-paymentsection">
    <div class="row">
        <div class="col-lg-4 col-md-12 tb-md-40">
            <div class="tb-dbholder tb-package-settings">
                <div class="tb-payment-methods_title">
                    <h6>{{__('settings.checkout_method')}}</h6>
                </div>
                <form class="tb-todobox">
                    <fieldset>
                        <div class="form-group-wrap">
                            <div class="form-group">
                                <label class="tk-label">{{__('settings.method_placeholder')}}</label>
                                <div class="tk-settingarea @error('method_type') tk-invalid @enderror">
                                    <div wire:ignore class="tb-select">
                                        <select id="tk_checkout_method" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.method_placeholder')}}" class="form-control tk-select2">
                                            <option></option>
                                            <option value="escrow" {{ $method_type == 'escrow' ? 'selected' : '' }} >{{ __('settings.method_escrow') }}</option>
                                            <option value="others" {{ $method_type == 'others' ? 'selected' : '' }} >{{ __('settings.others') }}</option>
                                        </select>
                                    </div>
                                </div>
                                @error('method_type')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group tb-updatesave-btn">
                                <a href="javascript:void(0);" wire:click.prevent="saveMethod" class="tb-btn ">
                                    {{ __('settings.save_method') }}
                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            @if(!empty($available_methods))
                <div class="tb-dbholder tb-package-settings">
                    <div class="tb-payment-methods_title">
                        <h6>{{__('settings.payment_methods')}}</h6>
                    </div>
                    <ul class="tb-payment-methods_list">
                        @foreach($available_methods as $method_key => $method)
                            <li>
                                <div class="tb-payment-items">
                                    <div class="tb-paymethod-items">
                                        <img src="{{$method['image']}}" alt="{{$method['name']}}">
                                        <h6>{{$method['name']}}</h6>
                                    </div>
                                    <div class="tb-paymethod-items">
                                        @if($method_key != 'escrow')
                                            <div class="checkbox">
                                                <input type="checkbox" id="{{$method_key.'_method'}}" wire:model="available_methods.{{$method_key}}.status">
                                                <label for="{{$method_key.'_method'}}" class="text"></label>
                                            </div>
                                        @endif
                                        <div class="tb-paymethodedit">
                                            <a href="javascript:void(0);" wire:click.prevent="editMethod('{{$method_key}}')" >{{__('settings.edit')}} <i class="icon-edit-3"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-lg-8 col-md-12 tb-md-60" wire:loading.class="tk-section-preloader" wire:target="editMethod">
            <div class="preloader-outer" wire:loading wire:target="editMethod">
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
            @if($edit_method == 'escrow')
                <div class="tb-payment-methods">
                    <div class="tb-payment-methods_title">
                        <h6>{{__('settings.escrow_payment_title')}}</h6>
                    </div>
                    <form class="tb-themeform tb-payment-settings">
                        <fieldset>
                            <div class="form-group-wrap">
                                <div class="form-group form-group-half">
                                    <label class="tk-label">{{__('settings.escrow_email')}}</label>
                                    <input type="text" class="form-control @error('escrow.email') tk-invalid @enderror" wire:model.defer="escrow.email" placeholder="{{__('settings.escrow_email_placeholer')}}">
                                    @error('escrow.email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                    <span class="tb-form-span"> {!! __('settings.escrow_email_desc', ['escrow_site_link' => '<a target="_blank" href="https://www.escrow.com/login-page">'. __("settings.escrow_site").' </a>']) !!}</span>
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label">{{__('settings.escrow_api_key')}}</label>
                                    <input type="text" wire:model.defer="escrow.api_key" class="form-control @error('escrow.api_key') tk-invalid @enderror" placeholder="{{__('settings.escrow_api_key_placeholer')}}">
                                    @error('escrow.api_key')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                    <span class="tb-form-span">{!!__('settings.api_key_desc',['get_api_key'=> '<a target="_blank" href="https://www.escrow.com/">'. __("checkout.escrow_site_title").' </a>' ]) !!}</span>
                                </div>
                                <div class="form-group ">
                                    <label class="tk-label">{{__('settings.escrow_url')}}</label>
                                    <input type="text" wire:model.defer="escrow.api_url" class="form-control" placeholder="{{__('settings.escrow_url_placeholer')}}">
                                    @error('escrow.api_url')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror 
                                    <span class="tb-form-span">
                                        {!!
                                            __('settings.escrow_url_desc',
                                            [
                                                'production_url'   => '<a target="_blank" href="https://api.escrow.com/">'. __("settings.escrow_production_url").' </a>',
                                                'testing_url'      => '<a target="_blank" href=" https://api.escrow-sandbox.com/">'. __("settings.escrow_testing_url").' </a>'
                                            ]) 
                                        !!}
                                    </span>
                                </div>
                                <div class="form-group form-group-3half">
                                    <label class="tk-label">{{__('settings.currency')}}</label>
                                    <div wire:ignore class="tb-select border-0">
                                        <select id="tk_currency" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.currency')}}" class="form-control tk-select2">
                                            <option></option>
                                            @foreach( $currency_opt as $key => $currency )
                                                <option value="{{ $key }}" {{ $escrow['currency'] == $key ? 'selected' : '' }} >{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('escrow.currency')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div> 
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half">
                                    <label class="tk-label">{{__('settings.inspection_period')}}</label>
                                    <div wire:ignore class="tb-select">
                                        <select id="tk_insp_period" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.insp_period_placeholder')}}" class="form-control tk-select2">
                                            <option></option>
                                            @foreach( $inspection_day_opt as $key => $day )
                                                <option value="{{ $key }}" {{ $escrow['inspection_period'] == $key ? 'selected' : '' }} >{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('escrow.inspection_period')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group form-group-3half">
                                    <label class="tk-label">{{__('settings.fee_paid_by')}}</label>
                                    <div wire:ignore class="tb-select border-0">
                                        <select id="tk_fees_payer" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.fee_paid_by_placeholder')}}" class="form-control tk-select2">
                                            <option></option>
                                            @foreach( $fee_paid_by_opt as $key => $day )
                                                <option value="{{ $key }}" {{ $escrow['fees_payer'] == $key ? 'selected' : '' }} >{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('escrow.fees_payer')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="tb-updatesave-btn">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                        {{ __('settings.save_setting') }}
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    
                </div>
            @elseif($edit_method == 'stripe')
                <div class="tb-payment-methods">
                    <div class="tb-payment-methods_title">
                        <h6>{{__('settings.stipe_payment_title')}}</h6>
                    </div>
                    <form class="tb-themeform tb-payment-settings">
                        <fieldset>
                            <div class="form-group-wrap">
                                <div class="form-group form-group-half">
                                    <label class="tk-label">{{__('settings.stripe_id')}}</label>
                                    <input type="text" class="form-control @error('stripe.stripe_key') tk-invalid @enderror" wire:model.defer="stripe.stripe_key" placeholder="{{__('settings.stipe_id_placeholer')}}">
                                    @error('stripe.stripe_key')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label">{{__('settings.stripe_key')}}</label>
                                    <input type="text" class="form-control @error('stripe.stripe_secret') tk-invalid @enderror" wire:model.defer="stripe.stripe_secret" placeholder="{{__('settings.stipe_key_placeholer')}}">
                                    @error('stripe.stripe_secret')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label">{{__('settings.stripe_webook')}}</label>
                                    <input type="text" class="form-control" wire:model.defer="stripe.stripe_webhook_secret" placeholder="{{__('settings.stripe_webook_placeholer')}}">
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label">{{__('settings.stripe_currency')}}</label>
                                    <input type="text" class="form-control @error('stripe.cashier_currency') tk-invalid @enderror" wire:model.defer="stripe.cashier_currency" placeholder="{{__('settings.currency_placeholder')}}">
                                    <span class="tb-form-span">{{__('settings.srtipe_currency_desc')}} </span>
                                </div>
                                <div class="tb-updatesave-btn">
                                    <a href="javascript:void(0);" wire:click.prevent="updateStripeSetting" class="tb-btn ">
                                        {{ __('settings.save_setting') }}
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            @else
                <div class="tb-payment-methods tb-emptypaysetting"> 
                    <img class="tb-empty-img" src="{{asset('images/empty.png')}}" alt="images">
                    <h2 class="tb-empty">{!! __('settings.empty_setting_desc', ['edit_btn_txt' => '<a href="javascript:;">'. __("settings.edit_txt").' <i class="icon-edit-3"></i></a>']) !!}</h2>
                </div>
            @endif

        </div>
    </div>
</main>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        iniliazeSelect2Scrollbar();
        jQuery('#tk_checkout_method').on('change', function (e) {
            let method = jQuery('#tk_checkout_method').select2("val");
            @this.set('method_type', method);
        });
        window.addEventListener('editMethod', function (event){
            iniliazeSelect2Scrollbar();

            

            jQuery('#tk_currency').on('change', function (e) {
                let currency = jQuery('#tk_currency').select2("val");
                @this.set('escrow.currency', currency, true);
            });

            jQuery('#tk_insp_period').on('change', function (e) {
                let value = jQuery('#tk_insp_period').select2("val");
                @this.set('escrow.inspection_period', value, true);
            });

            jQuery('#tk_fees_payer').on('change', function (e) {
                let value = jQuery('#tk_fees_payer').select2("val");
                @this.set('escrow.fees_payer', value, true);
            });
        });

    });
</script>
@endpush