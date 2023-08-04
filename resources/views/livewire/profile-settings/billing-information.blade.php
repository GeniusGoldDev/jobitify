<div class="col-lg-8 col-xl-9" wire:key="billing-information">
	<div class="tb-dhb-profile-settings">
		<div class="tb-dhb-mainheading">
			<h2>{{__('billing_info.heading')}}</h2>
		</div>
		<div class="tk-project-wrapper">
			<div class="tk-profile-form">
				<form class="tk-themeform" id="tb_billing_info">
					<fieldset>
						<div class="tk-themeform__wrap">
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.first_name')}}</label>
								<input type="text" class="form-control  @error('billing_info.first_name') tk-invalid @enderror" wire:model.defer="billing_info.first_name" name="first_name" placeholder="{{__('billing_info.first_name_placeholder')}}" />
								@error('billing_info.first_name')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.last_name')}}</label>
								<input type="text" class="form-control @error('billing_info.last_name') tk-invalid @enderror" wire:model.defer="billing_info.last_name" name="last_name" placeholder="{{__('billing_info.last_name_placeholder')}}" />
								@error('billing_info.last_name')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label">{{__('billing_info.company_title')}}</label>
								<input type="text" class="form-control" wire:model.defer="billing_info.company" name="company" placeholder="{{__('billing_info.company_placeholder')}}" />
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.country')}}</label>
								<div class="@error('billing_info.country_id') tk-invalid @enderror">
									<div class="tk-select" wire:ignore wire:key="{{ now()->timestamp.'_billing-country'}}">
										<select class="tk-select2" id="billing-country" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('billing_info.country_placeholder')}}" >
											<option label="{{__('billing_info.country_placeholder')}}"></option>
											@foreach( $countries as $country )
												<option {{$country['id'] == $billing_info['country_id'] ? 'selected' : ''}} value="{{$country['id']}}" >{{$country['name']}}</option>
											@endforeach 
										</select>
									</div>
								</div>
								@error('billing_info.country_id')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.state')}}</label>
								<div class="@error('billing_info.state_id') tk-invalid @enderror">
									<div class="tk-select">
										<select class="tk-select2" id="billing-state" data-placeholder="{{__('billing_info.states_placeholder')}}" data-placeholderinput="{{__('general.search')}}" >
											@if($has_states)
												<option label="{{__('billing_info.states_placeholder')}}"></option>
												@foreach( $states as $state )
													<option {{$state['id'] == $billing_info['state_id'] ? 'selected' : ''}} value="{{$state['id']}}" >{{$state['name']}}</option>
												@endforeach 
											@endif
										</select>
									</div>
								</div>
								@error('billing_info.state_id')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.address')}}</label>
								<input type="text" class="form-control  @error('billing_info.address') tk-invalid @enderror" wire:model.defer="billing_info.address" name="address" placeholder="{{__('billing_info.address_placeholder')}}" />
								@error('billing_info.address')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.city')}}</label>
								<input type="text" class="form-control  @error('billing_info.city') tk-invalid @enderror" wire:model.defer="billing_info.city" name="city" placeholder="{{__('billing_info.city_placeholder')}}" />
								@error('billing_info.city')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.postal_code')}}</label>
								<input type="text" class="form-control  @error('billing_info.postal_code') tk-invalid @enderror" wire:model.defer="billing_info.postal_code" name="postal_code" placeholder="{{__('billing_info.postal_code_placeholder')}}" />
								@error('billing_info.postal_code')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.phone')}}</label>
								<input type="text" class="form-control  @error('billing_info.phone') tk-invalid @enderror" wire:model.defer="billing_info.phone" name="phone" placeholder="{{__('billing_info.phone_placeholder')}}" />
								@error('billing_info.phone')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required">{{__('billing_info.email')}}</label>
								<input type="text" class="form-control  @error('billing_info.email') tk-invalid @enderror" wire:model.defer="billing_info.email" name="email" placeholder="{{__('billing_info.email_placeholder')}}" />
								@error('billing_info.email')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="tk-profileform__holder">
				<div class="tk-dhbbtnarea">
					<em>{!! __('billing_info.button_desc') !!}</em>
					<a href="javascript:void(0);" wire:click.prevent="updateBillingInfo()" class="tk-btn-solid-lg">{!! __('billing_info.save_button') !!}</a>
				</div>
			</div>
		</div>
	</div>
</div>