<main class="tb-main">
    <div class="row">
        <div class="col-md-12">
            <div class="tb-dbholder tb-dbholdervtwoa">
                <div class="tb-sectiontitle">
                    <h5> {{__('settings.commission_settings')}}</h5>
                </div>
        
                <div class="tb-dbsettingbox">
                    <form class="tb-comiisionform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-commisionarea">
                                    <span class="tb-titleinput">{{__('settings.project_commission_free')}}</span>
                                    <div class="tb-radiotabwrap">
                                        <div class="tb-radiowrap">
                                            <label for="free">
                                                <input type="radio" wire:model.lazy="commission_type" id="free" value="free" {{ $commission_type == 'free' ? 'checked' : '' }}/>
                                                <span>{{__('settings.no_commission')}}</span>
                                            </label>
                                        </div>
                                        <div class="tb-radiowrap">
                                            <label for="fixed">
                                                <input type="radio" wire:model.lazy="commission_type" id="fixed" value="fixed" {{ $commission_type == 'fixed' ? 'checked' : '' }} />
                                                <span>{{__('settings.fixed_commission')}}</span>
                                            </label>
                                        </div>
                                        <div class="tb-radiowrap">
                                            <label for="percentage">
                                                <input type="radio" wire:model.lazy="commission_type" id="percentage" value="percentage" {{ $commission_type == 'percentage' ? 'checked' : '' }} />
                                                <span>{{__('settings.percentage_commission')}}</span>
                                            </label>
                                        </div>
                                        <div class="tb-radiowrap">
                                            <label for="commission_tier">
                                                <input type="radio" wire:model.lazy="commission_type" id="commission_tier" value="commission_tier" {{ $commission_type == 'commission_tier' ? 'checked' : '' }}/>
                                                <span>{{__('settings.commission_tiers')}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="tb-nocommision @if( $commission_type == 'free' ) d-flex @else d-none @endif">
                                        <img src="{{asset('images/empty.png')}}" alt="">
                                        <span>{{__('settings.no_commission_desc')}}</span>
                                    </div>
                               
                                    <div class="tb-commision @if( in_array( $commission_type, ['fixed', 'percentage']) ) d-block @else d-none @endif">
                                        <div class="tb-formcomision">
                                            <div class="form-group form-vertical">
                                                <label class="tb-titleinput tk-required">{{__('settings.fixed_commission_price')}}</label>
                                                @if( $commission_type == 'fixed' )
                                                    <input type="number" wire:model.defer="fix_fixed_price" class="form-control @error('fix_fixed_price') tk-invalid @enderror" placeholder="{{__('settings.fixed_price_placeholder')}}">
                                                    @error('fix_fixed_price') 
                                                        <div class="tk-errormsg">
                                                            <span>{{$message}}</span> 
                                                        </div>
                                                    @enderror
                                                @else 
                                                    <div class="form-group form-vertical tb-inputiconleft">
                                                        <input type="number" wire:model.defer="per_fixed_price" class="form-control @error('per_fixed_price') tk-invalid @enderror" placeholder="{{__('settings.percentage_amount_placeholder')}}">
                                                        <i class="icon-percent"></i>
                                                    </div>
                                                    @error('per_fixed_price') 
                                                        <div class="tk-errormsg">
                                                            <span>{{$message}}</span> 
                                                        </div>
                                                    @enderror
                                                @endif
                                                <span>{{__('settings.fixed_price_desc')}}</span> 
                                            </div>
                                            <div class="form-group form-vertical">
                                                <label class="tb-titleinput tk-required">{{__('settings.hourly_commission_price')}}</label>
                                                    @if( $commission_type == 'fixed' )
                                                        <input type="number" wire:model.defer="fix_hourly_price" class="form-control @error('fix_hourly_price') tk-invalid @enderror" placeholder="{{__('settings.hourly_price_placeholder')}}">
                                                        @error('fix_hourly_price') 
                                                            <div class="tk-errormsg">
                                                                <span>{{$message}}</span> 
                                                            </div>
                                                        @enderror
                                                    @else 
                                                        <div class="form-group form-vertical tb-inputiconleft">
                                                            <input type="number" wire:model.defer="per_hourly_price" class="form-control @error('per_hourly_price') tk-invalid @enderror" placeholder="{{__('settings.percentage_amount_placeholder')}}">
                                                            <i class="icon-percent"></i>
                                                        </div>
                                                        @error('per_hourly_price') 
                                                            <div class="tk-errormsg">
                                                                <span>{{$message}}</span> 
                                                            </div>
                                                        @enderror
                                                    @endif
                                                    <span>{{__('settings.hourly_price_desc')}}</span> 
                                            </div>
                                        </div>
                                    </div>
                                
                               
                                    <div class="tb-addmore @if( $commission_type == 'commission_tier' ) d-flex @else d-none @endif">
                                        <div class="tb-dbholder tb-dbholderbg">
                                            <div class="tb-sectiontitle">
                                                <h6> {{__('settings.fixed_commission_price')}}</h6>
                                            </div>
                                            <div class="tb-dbsetcommision">
                                                @if( !empty($commission_tiers['fixed']) )
                                                    @foreach($commission_tiers['fixed'] as $tier_key => $tier)
                                                        <div id="{{'fix_tier_'.$tier_key}}" class="tb-selectrange">
                                                            <div class="tb-selecttype">
                                                                <h6>{{__('settings.project_price_range')}}</h6>
                                                                <div class="@error('commission_tiers.fixed.'.$tier_key.'.price_range') tk-invalid @enderror">
                                                                    <div class="tb-select" wire:ignore>
                                                                        <select id="{{'fix_price_range_'.$tier_key }}" data-type="fixed" data-record_no="{{$tier_key}}" data-key="price_range" class="{{'tk-select2-'.$tier_key }} form-control" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.price_range_placeholder')}}" >
                                                                            <option label="{{__('settings.price_range_placeholder')}}"></option>
                                                                            @foreach( $fix_comm_range as $key => $value)
                                                                                <option value="{{$key}}" @if($key == $commission_tiers['fixed'][$tier_key]['price_range']) selected @endif >{{$value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6>{{__('settings.commission_type')}}</h6>
                                                                <div class="@error('commission_tiers.fixed.'.$tier_key.'.type') tk-invalid @enderror">
                                                                    <div wire:ignore class="tb-select">
                                                                        <select id="{{'fix_commission_type_'.$tier_key }}" data-type="fixed" data-record_no="{{$tier_key}}" data-key="type" class="{{'tk-select2-'.$tier_key }} form-control" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.price_range_placeholder')}}" >
                                                                            <option label="{{__('settings.comm_type_placeholder')}}"></option>
                                                                            @foreach( $comm_type_opt as $type_key => $option )
                                                                                <option value="{{$type_key}}" @if( $type_key == $commission_tiers['fixed'][$tier_key]['type']) selected @endif>{{ $option }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6>{{__('settings.project_commission')}}</h6>
                                                                <div class="form-group">
                                                                    <input type="number" wire:model.defer="commission_tiers.fixed.{{$tier_key}}.value" class="form-control @error('commission_tiers.fixed.'.$tier_key.'.value') tk-invalid @enderror" placeholder="{{__('settings.comm_placeholder')}}">
                                                                </div>
                                                            </div>
                                                            <div class="tb-removeiron">
                                                                <a href="javascript:void(0);" wire:click.prevent="removeCommission('fixed',{{$tier_key}})"><i class="icon-trash-2"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="tb-addmorecom">
                                                        <img src="{{asset('images/empty.png')}}" alt="">
                                                        <span>{!! __('settings.add_more_desc') !!}</span> 
                                                    </div>
                                                @endif
                                                <div class="tb-addmoreclick">
                                                    <a href="javascript:void(0);" wire:click.prevent="addMoreCommission('fixed')">{{ __('settings.add_more') }} <span class="icon-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-dbholder tb-dbholderbg">
                                            <div class="tb-sectiontitle">
                                                <h6> {{ __('settings.hourly_commission_price') }} </h6>
                                            </div>
                                            <div class="tb-dbsetcommision">
                                                @if( !empty($commission_tiers['hourly']) )
                                                    @foreach($commission_tiers['hourly'] as $hr_tier_key => $tier)
                                                        <div id="{{'hr_tier_'.$hr_tier_key}}" class="tb-selectrange">
                                                            <div class="tb-selecttype">
                                                                <h6>{{__('settings.project_price_range')}}</h6>
                                                                <div class="@error('commission_tiers.hourly.'.$hr_tier_key.'.price_range') tk-invalid @enderror">
                                                                    <div class="tb-select" wire:ignore >
                                                                        <select id="{{'hr_price_range_'.$hr_tier_key }}" data-type="hourly" data-record_no="{{$hr_tier_key}}" data-key="price_range" class="{{'tk-select2-'.$hr_tier_key }} form-control @error('package.type') tk-invalid @enderror" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.price_range_placeholder')}}" >
                                                                            <option label="{{__('settings.price_range_placeholder')}}"></option>
                                                                            @foreach( $hr_comm_range as $range_key => $value)
                                                                                <option value="{{$range_key}}" @if($range_key == $commission_tiers['hourly'][$hr_tier_key]['price_range']) selected @endif >{{$value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6>{{__('settings.commission_type')}}</h6>
                                                                <div class="@error('commission_tiers.hourly.'.$hr_tier_key.'.type') tk-invalid @enderror">
                                                                    <div wire:ignore class="tb-select" >
                                                                        <select id="{{'hr_commission_type_'.$hr_tier_key }}" data-type="hourly" data-record_no="{{$hr_tier_key}}" data-key="type" class="{{'tk-select2-'.$hr_tier_key }} form-control" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.price_range_placeholder')}}" >
                                                                            <option label="{{__('settings.comm_type_placeholder')}}"></option>
                                                                            @foreach( $comm_type_opt as $type_key => $option )
                                                                                <option value="{{$type_key}}" @if( $type_key == $commission_tiers['hourly'][$hr_tier_key]['type']) selected @endif>{{ $option }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6>{{__('settings.project_commission')}}</h6>
                                                                <div class="form-group">
                                                                    <input type="number" wire:model.defer="commission_tiers.hourly.{{$hr_tier_key}}.value" class="form-control @error('commission_tiers.hourly.'.$hr_tier_key.'.value') tk-invalid @enderror" placeholder="{{__('settings.comm_placeholder')}}">
                                                                </div>
                                                            </div>
                                                            <div class="tb-removeiron">
                                                                <a href="javascript:void(0);" wire:click.prevent="removeCommission('hourly',{{$hr_tier_key}})"><i class="icon-trash-2"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="tb-addmorecom">
                                                        <img src="{{asset('images/empty.png')}}" alt="">
                                                        <span>{!! __('settings.add_more_desc') !!}</span> 
                                                    </div>
                                                @endif
                                                <div class="tb-addmoreclick">
                                                    <a href="javascript:void(0);" wire:click.prevent="addMoreCommission('hourly')"> {{ __('settings.add_more') }} <span class="icon-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
        
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                        {{ __('settings.save_setting') }}
                                    </a>
                                </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            setTimeout(() => {
                jQuery("select[class^='tk-select2-']").each(function(index, item) {
                    let _this       = jQuery(this);
                    let type        = _this.data('type');
                    let selectId    = _this.attr('id');
                    let recordNo    = _this.data('record_no');
                    let key         = _this.data('key');

                    _this.select2( { 
                        minimumResultsForSearch: -1,
                        allowClear: true 
                    });
                    setValue( selectId, type, recordNo, key)
                });
                iniliazeSelect2Scrollbar();
            },500);

            window.addEventListener('addTier', event => {
                setTimeout(() => {
                    let recNo = Number(event.detail.record_no);
                    let price_range     = event.detail.type == 'fixed' ? 'fix_price_range_'+recNo : 'hr_price_range_'+recNo;  
                    let commission_type = event.detail.type == 'fixed' ? 'fix_commission_type_'+recNo : 'hr_commission_type_'+recNo;  
                    let recType         = event.detail.type;
                    
                    jQuery('.tk-select2-'+recNo).select2({ 
                        allowClear: true,
                        minimumResultsForSearch: -1
                    });
                    
                    setValue( price_range, recType, recNo, 'price_range')
                    setValue( commission_type, recType, recNo, 'type');

                    iniliazeSelect2Scrollbar();
                },500);
            });

            function setValue( selectId, type, recordNo, key){
                $('#'+selectId).on('change', function (e) {
                    let value = $('#'+selectId).select2("val");
                    @this.set('commission_tiers.'+type.toString() +'.'+ recordNo.toString() +'.'+key.toString(), value, true);
                });
            }
        });
    </script>
@endpush