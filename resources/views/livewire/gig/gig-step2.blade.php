<div class="row" wire:key="{{time()}}">
    @include('livewire.gig.gig-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_2">
            <div class="tk-project-box tk-project-boxvtwo">
                <div class="tk-maintitle pb-0">
                    <h4>{{ __('gig.pricing_desc')}}</h4>
                </div>
                <div class="tk-attachments-hodler" id="gig-plans">
                    @foreach($gig_plans as $key => $single)
                        <div class="tk-attechment-wrapper">
                            <div class="tk-attechment-tittle">
                                <h6 data-bs-toggle="collapse" data-bs-target="#price-plan-{{$key}}" aria-expanded="{{ ($errors->has('gig_plans.'.$key.'.plan_title') || $errors->has('gig_plans.'.$key.'.plan_price') || $errors->has('gig_plans.'.$key.'.plan_delivery_time') || $errors->has('gig_plans.'.$key.'.plan_description')  ? 'true' : 'false') }}">{{ empty($single['plan_title']) ? __('gig.plan_title') : $single['plan_title'] }}</h6>
                                <div class="tk-accord-rightside">
                                    <div class="tk-switchbtn">
                                        <label for="is-featured-{{$key}}" class="tk-textdes"><span id="tk-textdes">{{ __('gig.featured')}}</span></label>
                                        <input class="tk-checkaction" wire:model.defer="gig_plans.{{$key}}.is_featured" type="checkbox" id="is-featured-{{$key}}" {{ $single['is_featured'] ? 'checked' : '' }}>
                                    </div>
                                    <i class="icon-chevron-right" role="button" data-bs-toggle="collapse" data-bs-target="#price-plan-{{$key}}" aria-expanded="{{ ($errors->has('gig_plans.'.$key.'.plan_title') || $errors->has('gig_plans.'.$key.'.plan_price') || $errors->has('gig_plans.'.$key.'.plan_delivery_time') || $errors->has('gig_plans.'.$key.'.plan_description')  ? 'true' : 'false') }}"></i>
                                </div>
                            </div>
                            <div id="price-plan-{{$key}}" class="tk-collapse-sort-conetnt collapse {{ ($errors->has('gig_plans.'.$key.'.plan_title') || $errors->has('gig_plans.'.$key.'.plan_price') || $errors->has('gig_plans.'.$key.'.plan_delivery_time') || $errors->has('gig_plans.'.$key.'.plan_description')  ? 'show' : '') }}" data-bs-parent="#gig-plans">
                                <form class="tk-themeform">
                                    <fieldset>
                                        <div class="tk-themeform__wrap">
                                            <div class="form-group form-group-3half">
                                                <label class="tk-label tk-required">{{ __('gig.package_title')}}</label>
                                                <div class="tk-placeholderholder">
                                                    <input type="text" wire:model.defer="gig_plans.{{$key}}.plan_title" placeholder="{{__('gig.plan_title')}}"  class="form-control tk-themeinput {{ ($errors->has('gig_plans.'.$key.'.plan_title') ? ' is-invalid' : '') }}" required>
                                                </div>
                                                @if($errors->has('gig_plans.'.$key.'.plan_title'))
                                                    <div class="tk-errormsg">
                                                        <span> {{ $errors->first('gig_plans.'.$key.'.plan_title') }}</span>
                                                    </div> 
                                                @endif
                                            </div>
                                            <div class="form-group form-group-3half">
                                                <label class="tk-label tk-required">{{ __('gig.plan_price')}}</label>
                                                <div class="tk-placeholderholder">
                                                    <input type="number" wire:model.defer="gig_plans.{{$key}}.plan_price" placeholder="{{__('gig.plan_price')}}" required class="form-control tk-themeinput {{ ($errors->has('gig_plans.'.$key.'.plan_price') ? ' is-invalid' : '') }}">
                                                </div>
                                                @if($errors->has('gig_plans.'.$key.'.plan_price'))
                                                    <div class="tk-errormsg">
                                                        <span> {{ $errors->first('gig_plans.'.$key.'.plan_price') }}</span>
                                                    </div> 
                                                @endif
                                            </div>
                                            <div class="form-group form-group-3half">
                                                <label class="tk-label tk-required">{{ __('gig.delivery_time')}}</label>
                                                <div class="{{ $errors->has('gig_plans.'.$key.'.plan_delivery_time') ? 'tk-invalid' : '' }}">
                                                    <div class="tk-select tk-project-select" wire:ignore> 
                                                        <select id="gig_plans.{{$key}}.plan_delivery_time" data-placeholderinput="{{ __('gig.delivery_time_placeholder')}}" data-placeholder="{{ __('gig.delivery_time_placeholder')}}" class="form-control delivery-time" required>
                                                            <option label="{{ __('general.search')}}"></option>
                                                            @if(!$delivery_time->isEmpty())
                                                                @foreach($delivery_time as $time)
                                                                    <option value="{{ $time->days }}" {{ $time->days == $single['plan_delivery_time'] ? 'selected' : '' }}  >{!! $time->name !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                @if($errors->has('gig_plans.'.$key.'.plan_delivery_time'))
                                                    <div class="tk-errormsg">
                                                        <span> {{ $errors->first('gig_plans.'.$key.'.plan_delivery_time') }}</span>
                                                    </div> 
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="tk-label tk-required">{{ __('gig.plan_description')}}</label>
                                                <div class="tk-placeholderholder">
                                                    <textarea class="form-control tk-themeinput {{ $errors->has('gig_plans.'.$key.'.plan_description') ? ' is-invalid' : '' }}" require wire:model.defer="gig_plans.{{$key}}.plan_description" placeholder="{{ __('gig.add_details')}}"></textarea>
                                                </div>
                                                @if($errors->has('gig_plans.'.$key.'.plan_description'))
                                                    <div class="tk-errormsg">
                                                        <span> {{ $errors->first('gig_plans.'.$key.'.plan_description') }}</span>
                                                    </div> 
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tk-project-box tk-project-boxvtwo">
                <div class="tk-maintitle pb-0">
                    <h4> {{ __('gig.add_gig_addon')}}</h4>
                </div>
                <a class="tk-add-more" href="javascript:;" wire:click.prevent="addNewAddon">
                    <h6>{{ __('gig.add_new')}} </h6>
                    <i class="icon-plus"></i>
                </a>
                @if( !empty($gig_addons) )
                    @foreach($gig_addons as $key=> $single)
                        <div class="tk-attachments-hodler" id="gigs-addon">
                            <div class="tk-attechment-wrapper">
                                <div class="tk-attechment-tittle">
                                    <div class="tk-form-checkbox">
                                        <input class="form-check-input tk-form-check-input-sm" {{ in_array( $key, $selected_addons ) ? 'checked' : ''}} type="checkbox" value="{{$key}}"  wire:model.defer="selected_addons"  >
                                        <h6 data-bs-toggle="collapse" data-bs-target="#gig-addon-{{$key}}" aria-expanded="{{ ($errors->has('gig_addons.'.$key.'.title') || $errors->has('gig_addons.'.$key.'.price')  ? 'true' : 'false') }}">{{ $single['title'] }}</h6>
                                    </div>
                                    <div class="tk-accord-rightside">
                                        <div class="tk-switchbtn">
                                            <span>{{ !empty($single['price']) ? getPriceFormat($currency_symbol, $single['price'] ) : '' }}</span>
                                        </div>
                                        <i class="icon-chevron-right" role="button" data-bs-toggle="collapse" data-bs-target="#gig-addon-{{$key}}" aria-expanded="{{ ($errors->has('gig_addons.'.$key.'.title') || $errors->has('gig_addons.'.$key.'.price')  ? 'true' : 'false') }}"></i>
                                    </div>
                                </div>
                                <div id="gig-addon-{{$key}}" class="tk-collapse-sort-conetnt collapse {{ ($errors->has('gig_addons.'.$key.'.title') || $errors->has('gig_addons.'.$key.'.price')  ? 'show' : '') }}" data-bs-parent="#gigs-addon">
                                    <form class="tk-themeform">
                                        <fieldset>
                                            <div class="tk-themeform__wrap">
                                                <div class="form-group form-group-half">
                                                    <label class="tk-label tk-required">{{ __('gig.addon_title')}}</label>
                                                    <div class="tk-placeholderholder">
                                                        <input type="text" wire:model.defer="gig_addons.{{$key}}.title" placeholder="{{ __('gig.addon_title')}}"  class="form-control tk-themeinput {{ $errors->has('gig_addons.'.$key.'.title') ? ' is-invalid' : '' }}" required>
                                                    </div>
                                                    @if($errors->has('gig_addons.'.$key.'.title'))
                                                        <div class="tk-errormsg">
                                                            <span> {{ $errors->first('gig_addons.'.$key.'.title') }}</span>
                                                        </div> 
                                                    @endif
                                                </div>
                                                <div class="form-group form-group-half">
                                                    <label class="tk-label tk-required">{{ __('gig.addon_price')}}</label>
                                                    <div class="tk-placeholderholder">
                                                        <input type="number" wire:model.defer="gig_addons.{{$key}}.price" placeholder="{{ __('gig.addon_price')}}"  class="form-control tk-themeinput {{ $errors->has('gig_addons.'.$key.'.price') ? ' is-invalid' : '' }}" required>
                                                    </div>
                                                    @if($errors->has('gig_addons.'.$key.'.price'))
                                                        <div class="tk-errormsg">
                                                            <span> {{ $errors->first('gig_addons.'.$key.'.price') }}</span>
                                                        </div> 
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="tk-label">{{ __('gig.addon_desc')}}</label>
                                                    <div class="tk-placeholderholder">
                                                        <textarea wire:model.defer="gig_addons.{{$key}}.description" placeholder="{{ __('gig.addon_desc')}}" class="form-control tk-themeinput"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <a class="tk-Remove-adon" href="javascript:;" wire:click.prevent="removeAddon({{ $key }})"><i class="icon-trash-2"></i><span>{{ __('gig.remove_addon')}}</span></a>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep(1)" class="tk-btnline"><i class=" icon-chevron-left"></i>{{ __('gig.go_back') }}</a>
                    <a href="javascript:;" wire:click.prevent="updateStep( {{ $step + 1 }} )"  class="tk-btn-solid-lg-lefticon">
                         {{__('gig.continue')}}
                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
