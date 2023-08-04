<div class="row" wire:key="{{time()}}">
    @include('livewire.gig.gig-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_1">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4> {{ __('gig.about_gig_info') }} </h4>
                </div>
                <form class="tk-themeform @if($errors->any()) tk-form-error @endif">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group">
                                <label class="tk-label tk-required">{{__('gig.add_gig_title')}}</label>
                                <div class="tk-placeholderholder">
                                    <input type="text" wire:model.defer="title" placeholder="{{__('gig.gig_title_placeholder')}}" class="form-control tk-themeinput @error('title') tk-invalid @enderror" required="required">
                                </div>
                                @error('title')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span> 
                                    </div>
                                @enderror
                            </div>
                            @php
                                $style_class = '';
                                if(!empty($gig_types) && $gig_types->count() > 0){
                                    $style_class = 'form-group-3half'; 
                                }elseif(!empty($sub_categories) && $sub_categories->count() > 0){
                                    $style_class = 'form-group-half';
                                }
                            @endphp
                            <div class="from-group-wrapper">
                                <div class="form-group {{ $style_class }}">
                                    <label class="tk-label tk-required">{{ __('gig.category')}} </label>
                                    <div class="@error('category') tk-invalid @enderror">
                                        <div class="tk-select" wire:ignore>
                                            <select id="category" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('gig.category_placeholder')}}"  class="form-control @error('category') tk-invalid @enderror">
                                                <option label="{{__('gig.category_placeholder')}}"></option>
                                                @if(!$categories->isEmpty() )
                                                    @foreach($categories as $single)
                                                        <option value="{{ $single->id }}" {{ $single->id == $category ? 'selected' : '' }} >{!! $single->name !!}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    @error('category')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                @if(!empty($sub_categories) && $sub_categories->count() > 0)
                                    <div class="form-group {{ $style_class }}">
                                        <label class="tk-label tk-required">{{ __('gig.sub_category')}} </label>
                                        <div class="@error('sub_category') tk-invalid @enderror">
                                            <div class="tk-select" wire:ignore>
                                                <select id="sub_category" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('gig.sub_category_placeholder')}}"  class="form-control @error('sub_category') tk-invalid @enderror">
                                                    <option label="{{__('gig.sub_category_placeholder')}}"></option>
                                                    @if(!$sub_categories->isEmpty())
                                                        @foreach($sub_categories as $single)
                                                            <option value="{{ $single->id }}" {{ $single->id == $sub_category ? 'selected' : '' }} >{!! $single->name !!}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        @error('sub_category')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                @endif
                                @if(!empty($gig_types) && $gig_types->count() > 0)
                                    <div class="form-group form-group-3half">
                                        <label class="tk-label tk-required">{{ __('gig.gig_type')}} </label>
                                        <div class="tk-select" wire:ignore>
                                            <select id="selected_gig_types" multiple data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('gig.gig_type_placeholder')}}"  class="form-control">
                                                <option label="{{__('gig.gig_type_placeholder')}}"></option>
                                                @if( !$gig_types->isEmpty() )
                                                    @foreach($gig_types as $single)
                                                        <option value="{{ $single->id }}" {{ in_array($single->id, $selected_gig_types) ? 'selected' : '' }} >{!! $single->name !!}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label tk-required">{{__('gig.country')}} </label>
                                <div class="@error('country') tk-invalid @enderror">
                                    <div class="tk-select" wire:ignore>
                                        <select id="country" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('gig.country_placeholder')}}"  class="form-control @error('country') tk-invalid @enderror">
                                            <option label="{{__('gig.country_placeholder')}}"></option>
                                            @if(!$countries->isEmpty())
                                                @foreach($countries as $single)
                                                    <option value="{{ $single->name }}" {{ $single->name == $country ? 'selected' : '' }} >{{ $single->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('country')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label tk-required">{{__('gig.zipcode')}} </label>
                                <div class="tk-placeholderholder">
                                    <input type="text" wire:model.defer="zipcode" placeholder="{{__('gig.zipcode_placeholder')}}" class="form-control tk-themeinput @error('zipcode') tk-invalid @enderror" required="required">
                                </div>
                                @error('zipcode')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div wire:ignore class="form-group">
                                <label class="tk-label tk-required" for="gig_description"> {{__('gig.gig_intro')}}  </label>
                                <x-tinymce-input wire:model.defer="description"/>
                                @error('description')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span> 
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep( {{ $step + 1 }} )" id="continue_btn" class="tk-btn-solid-lg-lefticon">
                         {{__('gig.continue')}}
                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
