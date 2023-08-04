<div class="col-lg-8 col-xl-9" wire:key="profile-settings">
	<div class="tk-dhb-mainheading">
		<h2>{{ __('profile_settings.profile_settings') }}</h2>
	</div>
	<div class="tk-project-wrapper">
		<div class="tk-project-box">
			<div class="tk-employerproject-title">
				<div class="tk-uploadprofilepic">
					<figure>
						<div wire:loading wire:target="profile_settings.image">{{ __('general.uploading') }} </div>
						@if (!empty($cropImageUrl))
							<img src="{{ $cropImageUrl }}" alit="" > 
						@elseif(!empty($old_image))
							@php 
								$file_url = getProfileImageURL($old_image, '120x120');
							@endphp
							<img src="{{ asset('storage/'.$file_url)  }}" alt="">
						@else 
							<img src="{{ asset('images/default-user-120x120.png')  }}" alt="">
						@endif
					</figure>
					<div wire:ignore class="tk-freelancer-content-two">
						<h4>{{__('profile_settings.upload_photo')}}</h4>
						<p>{!! __('profile_settings.upload_photo_desc', ['image_ext'=> join(', ', $allowImageExt), 'image_size'=> $allowImageSize.'MB']) !!}</p>
						<div class="tk-uploadbtnpic">
							<div class="tk-uploadbtn">
								<label for="upload_image" class="tk-btn tk-btn-small">
										<input id="upload_image" type="file" accept="{{ !empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*'  }}" >
										{!! __('profile_settings.upload_photo_btn') !!}
								</label>
							</div>
							<a href="javascript:void(0);" wire:click.prevent="removePhoto" class="tk-btn tk-btn-small tk-btnlight">{{__('settings.remove')}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if( $userRole == 'seller' )
			<div class="tk-project-box">
				<div class="tk-employerproject-title">
					<div class="tk-uploadprofilepic">
						<figure>
							<div class="tk-hasloader d-none"  wire:loading.class.remove="d-none" wire:loading.flex wire:target="banner">
								<div class="spinner-border" role="status">
									<span class="visually-hidden">{{ __('general.uploading') }}</span>
								</div>
							</div>
							@if (!empty($banner) && method_exists($banner,'temporaryUrl'))
								<img src="{{ substr($banner->getMimeType(), 0, 5) == 'image' ? $banner->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $banner->getClientOriginalName() }}">
							@elseif(!empty($old_banner))
								@php 
										$banner_path = $old_banner['file_path'] ?? '';
										$banner_name = $old_banner['file_name'] ?? '';
								@endphp
								<img src="{{ asset('storage/'.$banner_path) }}" alt="{{$banner_name}}">
							@else 
								<img src="{{ asset('images/default-img.jpg')  }}" alt="">
							@endif
						</figure>
						<div class="tk-freelancer-content-two">
							<h4>{{__('profile_settings.profile_banner')}}</h4>
							<p>{!! __('profile_settings.profile_banner_desc', ['image_ext'=> join(', ', $allowImageExt), 'image_size'=> $allowImageSize.'MB']) !!}</p>
							<div class="tk-uploadbtnpic">
								<div class="tk-uploadbtn">
									<label for="upload_banner" class="tk-btn tk-btn-small">
											<input id="upload_banner" wire:model="banner" type="file" accept="{{ !empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*' }}" >
											{!! __('profile_settings.upload_photo_btn') !!}
									</label>
								</div>

								@if( ( !empty($banner) && method_exists($banner,'temporaryUrl') ) || !empty($old_banner) )
									<a href="javascript:void(0);" wire:click.prevent="removeBanner" class="tk-btn tk-btn-small tk-btnlight">{{__('settings.remove')}}</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		<div class="tk-profile-form">
			<form class="tk-themeform" id="tb_save_settings">
				<fieldset>
					<div class="tk-themeform__wrap">
						<div class="form-group-half form-group_vertical">
							<label class="tk-label tk-required">{{__('profile_settings.first_name')}}</label>
							<input type="text" class="form-control @error('profile_settings.first_name') tk-invalid @enderror " wire:model.defer="profile_settings.first_name" name="first_name" placeholder="{{__('profile_settings.first_name_palceholder')}}" />
							@error('profile_settings.first_name')
								<div class="tk-errormsg">
									<span>{{$message}}</span> 
								</div>
							@enderror
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="tk-label tk-required">{{__('profile_settings.last_name')}}</label>
							<input type="text" class="form-control @error('profile_settings.last_name') tk-invalid @enderror" wire:model.defer="profile_settings.last_name" name="last_name" placeholder="{{__('profile_settings.last_name_palceholder')}}" />
							@error('profile_settings.last_name')
								<div class="tk-errormsg">
									<span>{{$message}}</span> 
								</div>
							@enderror
						</div>
						<div class="form-group form-group_vertical">
							<label class="tk-label">{{__('profile_settings.tagline')}}</label>
							<input type="text" class="form-control" wire:model.defer="profile_settings.tagline" name="tagline" />
						</div>						
						<div class="form-group-half form-group_vertical">
							<label class="tk-label tk-required">{{__('profile_settings.country')}}</label>
							<div class="@error('profile_settings.country') tk-invalid @enderror">
								<div class="tk-select" wire:ignore wire:key="{{ now()->timestamp.'_profile_country'}}">
									<select name="pro-country" class="tk-select2" id="tk-country" data-placeholder="{{__('profile_settings.country_palceholder')}}" data-placeholderinput="{{__('general.search')}}">
										<option label="{{__('profile_settings.country_palceholder')}}"></option>
										@foreach( $countries as $country )
											<option {{$country['name'] == $profile_settings['country'] ? 'selected' : ''}} value="{{$country['name']}}" >{{$country['name']}}</option>
										@endforeach 
									</select>
								</div>
							</div>
							@error('profile_settings.country')
								<div class="tk-errormsg">
									<span>{{$message}}</span> 
								</div>
							@enderror
						</div>
						
						<div class="form-group-half form-group_vertical">
							<label class="tk-label tk-required">{{__('profile_settings.zipcode')}}</label>
							<input type="text" class="form-control @error('profile_settings.zipcode') tk-invalid @enderror" wire:model.defer="profile_settings.zipcode" name="zipcode" placeholder="{{__('profile_settings.zipcode_palceholder')}}" />
							@error('profile_settings.zipcode')
								<div class="tk-errormsg">
									<span>{{$message}}</span> 
								</div>
							@enderror
						</div>
						@if( $userRole == 'seller' )
							<div class="form-group-half form-group_vertical">
								<label class="tk-label tk-required">{{__('general.seller_type')}}</label>
								<div class="@error('profile_settings.seller_type') tk-invalid @enderror">
									<div class="tk-select" wire:ignore wire:key="pro-sellertype_id">
										<select name="seller_type" data-placeholder="{{__('profile_settings.seller_type_placeholder')}}" data-placeholderinput="{{__('general.search')}}" class="tk-select2" id="pro_sellertype">
											<option label="{{__('profile_settings.seller_type_placeholder')}}"></option>
											@foreach( $seller_types as $type_key => $seller_type )
												<option {{ $seller_type == $profile_settings['seller_type'] ? 'selected' : ''}} value="{{$seller_type}}" >{{$seller_type}}</option>
											@endforeach 
										</select>
									</div>
								</div>
								@error('profile_settings.seller_type')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
						
							<div class="form-group-half form-group_vertical">
								<label class="tk-label tk-required">{{__('general.english_level')}}</label>
								<div class="@error('profile_settings.english_level') tk-invalid @enderror">
									<div class="tk-select" wire:ignore wire:key="profile_english_level">
										<select name="pro-english_level" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('profile_settings.english_level_placeholder')}}" class="tk-select2" id="pro_english_level">
											<option label="{{__('profile_settings.english_level_placeholder')}}"></option>
											@foreach( $english_levels as $key => $level )
												<option @if($profile_settings['english_level'] == $key ) selected @endif value="{{$key}}" > {{ $level }} </option>
											@endforeach
										</select>
									</div>
								</div>
								@error('profile_settings.english_level')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
						@endif
	
						@if($userRole == 'seller' )
							<div class="form-group form-group_vertical">
								<label class="tk-label">{{__('profile_settings.skills')}}</label>
								<div class="tk-select" wire:ignore wire:key="profile_skill" >
									<select data-placeholder="{{__('profile_settings.skills_placeholder')}}" data-placeholderinput="{{__('general.search')}}" name="skills" class="tk-select2 " id="pro_skill" data-autoclose="false" multiple>
										<option label="{{__('profile_settings.skills_placeholder')}}"></option>
										@foreach( $skills as $skill )
											<option {{ in_array( $skill['id'], $profile_settings['skill_ids'] )  ? 'selected' : ''}} value="{{$skill['id']}}" >{{$skill['name']}}</option>
										@endforeach 
									</select>
								</div>
							</div>
							<div class="form-group form-group_vertical">
								<label class="tk-label">{{__('profile_settings.languages')}}</label>
								<div class="tk-select" wire:ignore wire:key="profile_language">
									<select name="languages" data-placeholder="{{__('profile_settings.languages_placeholder')}}" class="tk-select2" id="pro_languages" data-autoclose="false" multiple>
										@foreach( $languages as $language )
											<option {{in_array($language['id'], $profile_settings['language_ids']) ? 'selected' : ''}} value="{{$language['id']}}" >{{$language['name']}}</option>
										@endforeach 
									</select>
								</div>
							</div>
						@endif
						<div class="form-group form-group_vertical">
							<label class="tk-label">{{__('profile_settings.description')}}</label>
							<div class="tk-placeholderholder">
								<x-tinymce-input wire:model.defer="profile_settings.description" placeholder="{{__('profile_settings.desc_palceholder')}}"/>
							</div>
							@error('profile_settings.description')
								<div class="tk-errormsg">
									<span>{{ $message }}</span>
								</div>
							@enderror
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="tk-profileform__holder">
			<div class="tk-dhbbtnarea">
				<em>{!! __('profile_settings.button_desc') !!}</em>
				<a href="javascript:void(0);" wire:click.prevent="update" class="tk-btn-solid-lg">{!! __('profile_settings.save_button') !!}</a>
			</div>
		</div>
	</div>
	@if($userRole == 'seller' )
		<!-- education list -->
		<div class="tk-project-wrapper">
			<div class="tk-project-box">
				<h5>{{ __('profile_settings.education_detail') }}
					<a href="javascript:void(0);" data-type="add" class="tk_show_education" wire:click.prevent="addEducation"> {{ __('profile_settings.add_education') }} </a>
				</h5>
				@if(! empty($educationList) )
					<div class="tk-acordian-wrapper">
						<ul id="tk-accordioneditedu" class="tk-qualification tk-qualificationvtwo">
							@foreach( $educationList as $education)
								@php  
									$disable_toggle = empty($education['deg_description']) ? true : false;
								@endphp
								<li>
									<div class="tk-accordion_title">
										<div class="tk-qualification-title  @if($disable_toggle) tk-education-title @endif collapsed"  @if(!$disable_toggle)  data-bs-toggle="collapse"  data-bs-target="#collapse-{{$education['id']}}" role="button" aria-expanded="false" @endif>
											<span>{!! $education['deg_institue_name'] !!}</span>
											<h5>{!! $education['deg_title'] !!}</h5>
											<div class="tk-ongoing-date">
												<span>{!! date('F d, Y', strtotime($education['deg_start_date'])) !!}</span>
												<i>-</i>
												@if( empty($education['is_ongoing']) )
													<span class="pl-1"> {!! date('F d, Y', strtotime($education['deg_end_date'])) !!}</span>
												@else 
												<span>{{__('general.continue')}}</span>
												@endif
											</div>
										</div>
										<a href="javascript:void(0);" class="collapsed" @if(!$disable_toggle)  data-bs-toggle="collapse"  data-bs-target="#collapse-{{$education['id']}}" role="button" aria-expanded="false" @endif><i class="icon-plus"></i></a>
										<div class="tk-detail__icon">
											<a href="javascript:void(0);" class="tk-edit tb_show_education" wire:click.stop="editEducation({{$education['id']}})"><i class="icon-edit-2"></i></a>
											<a href="javascript:void(0);" class="tk-delete tb_remove_edu" wire:click.prevent="deleteEducationConfirm({{$education['id']}})" ><i class="icon-trash-2"></i></a>
										</div>
									</div>
									<div class="collapse" id="collapse-{{$education['id']}}" data-bs-parent="#tk-accordioneditedu">
										<div class="tk-accordion_info">
											<p>{{$education['deg_description']}}</p>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
		</div>

		<div wire:ignore.self class="modal fade tk-addonpopup" id="tb_educationaldetail" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="tk-popuptitle">
						<h4> {{ __('profile_settings.update_education_detail') }} </h4>
						<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
					</div>

					<div class="modal-body" id="tk_add_education_frm">
					<form class="tk-themeform" id="tb_update_education">
						<fieldset>
							<div class="form-group">
								<label class="tk-label tk-required">{{ __('profile_settings.add_degree_title') }}</label>
								<input type="text" name="education-title" wire:model.defer="education_detail.deg_title" class="form-control @error('education_detail.deg_title') tk-invalid @enderror" placeholder="{{__('profile_settings.deg_title_placeholder')}}" autocomplete="off">
								@error('education_detail.deg_title')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group">
								<label class="tk-label">{{ __('profile_settings.add_institue_name') }}</label>
								<input type="text" name="education-institure" wire:model.defer="education_detail.deg_institue_name" class="form-control" placeholder="{{__('profile_settings.institue_placeholder')}}" autocomplete="off">
							</div>
							<div class="form-group">
								<label class="tk-label tk-required">{{ __('profile_settings.address') }}</label>
								<input type="text" name="education-institure" wire:model.defer="education_detail.address" class="form-control" placeholder="{{__('profile_settings.address_placeholder')}}" autocomplete="off">
								@error('education_detail.address')
									<div class="tk-errormsg">
										<span>{{$message}}</span> 
									</div>
								@enderror
							</div>
							<div class="form-group-wrap">
								<div class="form-group pb-0">
									<label class="tk-label mb-0">{{ __('profile_settings.choose_date') }}</label>
								</div>
								<div class="form-group form-group-half">
									<div class="tk-calendar">
										<input id="edu_start_date_{{$dynamic_id}}" value="{{$education_detail['deg_start_date']}}" name="education_start_date" type="text" class="form-control @error('education_detail.deg_start_date') tk-invalid @enderror tk-datepicker" placeholder="{{__('profile_settings.date_from')}}">
									</div>
									@error('education_detail.deg_start_date')
										<div class="tk-errormsg">
											<span>{{$message}}</span> 
										</div>
									@enderror
								</div>
								<div class="form-group form-group-half">
									<div class="tk-calendar">
										<input id="edu_end_date_{{$dynamic_id}}" value="{{ $education_detail['deg_end_date']}}" name="education_end_date" type="text" class="form-control @error('education_detail.deg_end_date') tk-invalid @enderror tk-datepicker" placeholder="{{__('profile_settings.date_to')}}">
									</div>
									@error('education_detail.deg_end_date')
										<div class="tk-errormsg">
											<span>{{$message}}</span> 
										</div>
									@enderror
								</div>
								<div class="form-group">
									<div class="tk-form-checkbox">
										<input id="education_is_going" wire:model.defer="education_detail.is_ongoing" name="education_is_going" type="checkbox" class="form-check-input" placeholder="{{__('profile_settings.isgoing')}}">
										<label for="education_is_going" class="form-check-label"><span>{{__('profile_settings.ongoing_txt')}}</span></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="tk-label">{{ __('profile_settings.degree_desc') }}</label>
								<textarea class="form-control" wire:model.defer="education_detail.deg_description" name="education_description" placeholder="{{ __('profile_settings.degree_desc_placeholder') }}"></textarea>
							</div>
							<div class="form-group">
								<div class="tk-savebtn">
									<a href="javascript:void(0);" id="edit_education" wire:click.prevent="updateEducation" class="tk-btn">{{__('profile_settings.save_degree_btn')}}</a>
								</div>
							</div>
						</fieldset>
					</form>
					</div>
				</div>
			</div>
		</div>
	@endif

	<div wire:ignore class="modal fade tk-addonpopup" id="tk_phrofile_photo" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="tk-popuptitle">
					<h4> {{ __('profile_settings.crop_profile_photo') }} </h4>
					<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
				</div>
				<div class="modal-body" id="tk_add_education_frm">
					<div id="crop_img_area">
						<div class="preloader-outer" wire:loading="">
							<div class="tk-preloader">
								<img class="fa-spin" src="{{ asset('images/loader.png') }}">
							</div>
						</div>
					</div>
					<div class="tk-form-btn">
						<div class="tk-savebtn tk-dhbbtnarea ">
							<a href="javascript:void(0);" id="croppedImage" class="tk-btn">{{__('general.save_update')}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>