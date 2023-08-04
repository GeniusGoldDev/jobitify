<div class="col-lg-8 col-xl-9" wire:key="seller-portfolio-setting">
	<div class="tb-dhb-profile-settings">
		<div class="tb-dhb-mainheading">
			<h2>{{ __('profile_settings.portfolio_settings') }}</h2>
		</div>
		@if( $allowSocialLinks == 'enable' && !empty(availableSocialLinks()) )
			<div class="tk-project-wrapper">
				<div class="tb-tabtasktitle">
					<h5>{{ __('profile_settings.social_links_heading') }}</h5>
				</div>
				<div class="tk-profile-form">
					<form class="tk-themeform">
						<fieldset>
							<div class="tk-themeform__wrap">
								@foreach(availableSocialLinks() as $key => $links )
									<div class="form-group-half form-group_vertical">
										<label class="tk-label">{{$links['name']}}</label>
										<input type="text" class="form-control @error('socialLinks.'.$key) tk-invalid @enderror " wire:model.defer="socialLinks.{{$key}}" placeholder="{{ $links['placeholder'] }}" />
										@error('socialLinks.'.$key)
											<div class="tk-errormsg">
												<span>{{$message}}</span> 
											</div>
										@enderror
									</div>
								@endforeach
							</div>
						</fieldset>
					</form>
				</div>
				<div class="tk-profileform__holder">
					<div class="tk-dhbbtnarea">
						<em>{!! __('profile_settings.button_desc') !!}</em>
						<a href="javascript:void(0);" wire:click.prevent="updateSocialLinks" class="tk-btn-solid-lg">{!! __('profile_settings.save_button') !!}</a>
					</div>
				</div>
			</div>
		@endif
		
		<div class="tk-project-wrapper">
			<div class="tb-tabtasktitle tb-tabtasktitletwo">
				<h5>{{ __('profile_settings.portfolio_settings') }}
					<a href="javascript:void(0);" data-type="add" class="tk_show_education" wire:click.prevent="showPortfolioPopup"> {{ __('profile_settings.add_education') }} </a>
				</h5>
			</div>
			@if(! $portfolios->isEmpty() )
				<div class="tk-project-box">
						<div class="tk-portfolios-list">
							@foreach( $portfolios as $portfolio)
								<x-portfolio-item :data="$portfolio" :enableEdit="true" />
							@endforeach
						</div>
				</div>
			@else
				<div class="tk-submitreview">
					<figure>
						<img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
					</figure>
					<h4>{{ __('general.no_record') }}</h4>
				</div>
			@endif
		</div>

		<div wire:ignore.self class="modal fade tb-addonpopup" id="tk_portfolio_detail" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="tb-popuptitle">
						<h4> {{ $isEdit ? __('profile_settings.edit_protfolio_title') : __('profile_settings.add_protfolio_title') }} </h4>
						<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
					</div>

					<div class="modal-body" id="tk_add_education_frm">
						<form class="tk-themeform" id="tb_update_education">
							<fieldset>
								<div class="form-group">
									<label class="tk-label tk-required">{{ __('profile_settings.portfolio_title_label') }}</label>
									<input type="text" wire:model.defer="portfolio.title" class="form-control @error('portfolio.title') tk-invalid @enderror" placeholder="{{__('profile_settings.portfolio_title_placeholder')}}" autocomplete="off">
									@error('portfolio.title')
										<div class="tk-errormsg">
											<span>{{$message}}</span> 
										</div>
									@enderror
								</div>
								<div class="form-group">
									<label class="tk-label tk-required">{{ __('profile_settings.portfolio_url_label') }}</label>
									<input type="text" wire:model.defer="portfolio.url" class="form-control @error('portfolio.url') tk-invalid @enderror" placeholder="{{__('profile_settings.portfolio_url_placeholder')}}" autocomplete="off">
									@error('portfolio.url')
										<div class="tk-errormsg">
											<span>{{$message}}</span> 
										</div>
									@enderror
								</div>
								
								<div class="form-group">
									<label class="tk-label">{{ __('profile_settings.portfolio_desc_label') }}</label>
									<textarea class="form-control" wire:model.defer="portfolio.description" placeholder="{{ __('profile_settings.portfolio_desc_placeholder') }}"></textarea>
								</div>

								<div class="form-group">
									<div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
										<div class="tk-draganddrop"
										x-bind:class="dropFile ? 'tk-opacity' : ''"
											x-on:drop="dropFile = false"
											wire:drop.prevent="$emit('portfolio-dropped-file', $event)"
											x-on:dragover.prevent="dropFile = true"
											x-on:dragleave.prevent="dropFile = false">
											<svg><rect width="100%" height="100%"></rect></svg>
											<input class="tk-drag-imagearea" type="file" id="at_prtf_upload_files" accept="{{ !empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*'  }}" wire:change="$emit('portfolio-dropped-file', {'dataTransfer' : { files :  $event.target.files}})" />
											<div class="tk-dragfile">
												<div class="tk-fileareaitem">
													<img src="{{ asset('images/image-uploader.jpg') }}" alt="">
												</div>
												<div class="tk-filearea">
													<div class="text-center" wire:loading wire:target="portfolioFiles" ><span class="fw-normal">{{__('general.uploading')}}</span></div>
													<div class="tk-text-flex" wire:loading.remove  wire:target="portfolioFiles" ><span>{{__('general.upload_portfolio_photo')}}</span>
													<label class="tk-drag-label" for="at_prtf_upload_files"> <em>{{__('general.click_here')}}</em></label>
												</div>
											</div>
										</div>
									</div>

									@error('portfolioFiles.*')
										<div class="tk-errormsg">
											<span>{{ $message }}</span>
										</div>
									@enderror
									@if($prtExistingFiles)
										<ul class="tk-uploadlist">
											@foreach($prtExistingFiles as $key => $single)
													<li>
														<div class="tk-uploaditem">
															<div class="tk-uploaddetail">
																@if(method_exists($single,'getMimeType'))
																	<img src="{{ substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $single->getClientOriginalName() }}">
																@else
																	<img src="{{ substr($single->mime_type, 0, 5) == 'image' ? asset('storage/'.$single->file_path) : asset('images/file-preview.png') }}" alt="{{ $single->file_name }}">
																@endif
																<span>{{ method_exists($single,'getClientOriginalName') ? $single->getClientOriginalName() : $single->file_name }}</span>
															</div>
															<a href="javascript:;" wire:click.prevent="removePortfolioFile('{{ $key }}')"><i class="icon-trash-2"></i></a>
														</div>
													</li>
											@endforeach
										</ul>
									@endif
								</div>
								<div class="form-group">
									<div class="tk-savebtn">
										<a href="javascript:void(0);" id="edit_education" wire:click.prevent="updatePortFolio" class="tb-btn">{{__('profile_settings.save_degree_btn')}}</a>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

