<div class="row">
    @include('livewire.project.project-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-project-wrapper">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4> {{ __('project.about_project_info') }} </h4>
                </div>
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group">
                                <label class="tk-label tk-required">{{__('project.add_project_title')}}</label>
                                <div class="tk-placeholderholder">
                                    <input type="text" wire:model.defer="title" placeholder="{{__('project.project_title_placeholder')}}" class="form-control tk-themeinput @error('title') tk-invalid @enderror" required="required">
                                </div>
                                @error('title')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="tk-label tk-required">{{__('project.select_project_project')}}</label>
                                <ul class="nav nav-tabs tk-radio-tabs">
                                    <li class=" {{ $type == 'fixed' ? 'tk-active-option' : '' }}  tk-li-fixed">
                                        <input {{ $type == 'fixed' ? 'checked' : '' }} type="radio" id="fixed" wire:model="type" value="fixed">
                                        <label class="tk-project-type" for="fixed"> <i class="icon-bookmark tk-red-icon"></i>
                                            <div>
                                                <h6>{{__('project.fixed_type')}}</h6>
                                                <p> {{__('project.fixed_type_desc')}}</p>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="{{ $type == 'hourly' ? 'tk-active-option' : '' }} tk-li-hourly">
                                        <input {{ $type == 'hourly' ? 'checked' : '' }} type="radio" id="hourly" wire:model="type" value="hourly">
                                        <label class="tk-project-type" for="hourly"> <i class="icon-clock tk-purple-icon"></i>
                                            <div>
                                                <h6>{{__('project.hourly_type')}} </h6>
                                                <p> {{__('project.hourly_type_desc')}}</p>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                           <!-- hourly type -->
                            <div class="form-group form-group-half {{ $type == 'fixed' ? 'd-none' : '' }}">
                                <label class="tk-label"> {{ __('project.payment_mode') }}</label>
                                <div class="@error('payment_mode') tk-invalid @enderror">
                                    <div class="tk-select" wire:ignore>
                                        <select id="payment_mode" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('project.payment_mode_placeholder')}}" class="form-control @error('payment_mode') tk-invalid @enderror">
                                            <option label="{{__('project.payment_mode_placeholder')}}"></option>
                                            @if(!empty($payment_modes))
                                                @foreach($payment_modes as $key => $name)
                                                    <option value="{{ $key }}" {{ $key == $payment_mode ? 'selected' : '' }} >{!! $name !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('payment_mode')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half {{ $type == 'fixed' ? 'd-none' : '' }}">
                                <label class="tk-label tk-required">{{__('project.add_mx_hours')}}</label>
                                <div class="tk-placeholderholder">
                                    <input type="number" placeholder="{{__('project.add_mx_placeholder')}}" wire:model.defer="max_hours"  class="form-control tk-themeinput @error('max_hours') tk-invalid @enderror" required="required">
                                </div>
                                @error('max_hours')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half {{ $type == 'fixed' ? 'd-none' : '' }}">
                                <label class="tk-label tk-required"> {{__('project.add_min_hourly_rate')}} </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" wire:model.defer="min_price" placeholder="{{__('project.min_hourly_rate_placeholer')}}" class="form-control tk-themeinput @error('min_price') tk-invalid @enderror" required="required">
                                </div>
                                @error('min_price')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half {{ $type == 'fixed' ? 'd-none' : '' }}">
                                <label class="tk-label tk-required">{{__('project.add_max_hourly_rate')}} </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" placeholder="{{__('project.max_hourly_rate_placeholer')}}" wire:model.defer="max_price"  class="form-control tk-themeinput @error('max_price') tk-invalid @enderror" required="required">
                                </div>
                                @error('max_price')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                                <!-- fixed type -->
                            <div class=" form-group tb-fixed-type {{ $type == 'hourly' ? 'd-none' : '' }}">
                                <div class="tk-betaversion-wrap tk-milestone-wrapper">
                                    <figure>
                                        <img src="{{ asset('images/proposal/milestone.png') }}" alt="{{ __('project.milestone')}}">
                                    </figure>
                                    <div class="tk-betaversion-info">
                                        <h5> {{__('project.milesote_heading_txt')}}</h5>
                                        <p> {!! __('project.milesote_heading_desc',['safety_policy_url' => 'javascript:void(0)' ]) !!}</p>
                                    </div>
                                    <div class="tk-payment-methods">
                                        <ul class="tk-priorityradiov2">
                                            @foreach($payout_type_options as $key => $record)
                                                <li class="tk-form-checkbox">
                                                    <input class="form-check-input tk-form-check-input-sm tk-payout-opt" wire:model.defer="project_payout_type" type="radio" id="radio-{{$key}}" {{ $project_payout_type == 'key' ? 'checked' : '' }} value="{{$key}}" />
                                                    <label class="form-check-label" for="radio-{{$key}}" class="tb-radiolist">
                                                        <span>{{ $record }} </span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('project_payout_type')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-group form-group-half {{ $type == 'hourly' ? 'd-none' : '' }}">
                                <label class="tk-label tk-required"> {{__('project.add_min_fixed_budget')}}  </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" wire:model.defer="min_price" placeholder="{{__('project.min_fixed_budget_placeholder')}}" class="form-control tk-themeinput @error('min_price') tk-invalid @enderror" >
                                </div>
                                @error('min_price')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half {{ $type == 'hourly' ? 'd-none' : '' }}">
                                <label class="tk-label tk-required">{{__('project.add_max_fixed_budget')}} </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" wire:model.defer="max_price"  class="form-control tk-themeinput @error('max_price') tk-invalid @enderror" required="required" placeholder="{{__('project.max_fixed_budget_placeholder')}}" >
                                </div>
                                @error('max_price')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label @if($req_duration) tk-required @endif">{{__('project.project_duration')}} </label>
                                <div class="@error('project_duration') tk-invalid @enderror">
                                    <div class="tk-select" wire:ignore>
                                        <select id="project_duration" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('project.project_duration_placeholder')}}"  class="form-control @error('project_duration') tk-invalid @enderror">
                                            <option label="{{__('project.project_duration_placeholder')}}"></option>
                                            @if(!$durations->isEmpty())
                                                @foreach($durations as $single)
                                                    <option value="{{ $single->id }}" {{ $single->id == $project_duration ? 'selected' : '' }} >{!! $single->name !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('project_duration')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half">
                                <div>
                                    @livewire('components.category-dropdown',
                                    [ 
                                        'categroy_id'=> $project_category, 
                                        'label_text' => __('project.project_category'), 
                                        'is_required' => $req_category,
                                    ])
                                </div>
                                @error('project_category')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label tk-required">{{__('general.add_location')}}</label>
                                <div class="@error('project_location') tk-invalid @enderror">
                                    <div class="tk-select" wire:ignore>
                                        <select id="project_location" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('general.location_placeholder')}}" class="form-control">
                                            <option label="{{__('general.location_placeholder')}}"></option>
                                            @if(!$locations->isEmpty())
                                                @foreach($locations as $single)
                                                    <option value="{{ $single->id }}" {{ $single->id == $project_location ? 'selected' : '' }} >{!! $single->name !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('project_location')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group form-group-half {{ $project_location != 3 ? 'd-none' : '' }}">
                                <label class="tk-label">{{__('project.country')}} </label>
                                <div class="@error('project_country') tk-invalid @enderror">
                                    <div class="tk-select" wire:ignore>
                                        <select id="project_country" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('project.country_placeholder')}}"  class="form-control @error('project_country') tk-invalid @enderror">
                                            <option label="{{__('project.country_placeholder')}}"></option>
                                            @if(!$countries->isEmpty())
                                                @foreach($countries as $single)
                                                    <option value="{{ $single->name }}" {{ $single->name == $project_country ? 'selected' : '' }} >{{ $single->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('project_country') 
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            @if( $enable_zipcode == '1' )
                                <div class="form-group form-group-half {{ $project_location != 3 ? 'd-none' : '' }}">
                                    <label class="tk-label tk-required">{{__('project.zipcode')}} </label>
                                    <div class="tk-placeholderholder">
                                        <input type="text" wire:model.defer="zipcode" placeholder="{{__('project.zipcode_placeholder')}}" class="form-control tk-themeinput @error('zipcode') tk-invalid @enderror" required="required">
                                    </div>
                                    @error('zipcode')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="tk-label @if($req_project_desc) tk-required @endif"> {{__('project.pro_desc')}}  </label>
                                <div class="tk-placeholderholder">
                                    <x-tinymce-input wire:model.defer="description" placeholder="{{__('project.pro_desc_placeholder')}}"/>
                                </div>
                                @error('description')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="tk-attachments-hodler" id="attechmentacordian">
                    <div class="tk-attechment-wrapper">
                        <div class="tk-attechment-tittle">
                            <h6 wire:ignore.self data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="{{!empty($video_url) || !empty($existingFiles) ? 'true' : 'false'}}" {{empty($video_url) && empty($existingFiles) ? 'class=collapsed' : ''}} aria-controls="flush-collapseTwo">{{ __('project.media_attachment_title') }}</h6>
                            <i class="icon-plus {{empty($video_url) && empty($existingFiles) ? 'collapsed' : ''}}" role="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="{{!empty($video_url) || !empty($existingFiles) ? 'true' : 'false'}}" aria-controls="flush-collapseTwo"></i>
                        </div>
                        <div wire:ignore.self id="flush-collapseTwo" class="collapse {{empty($video_url) && empty($existingFiles) ? '' : 'show'}}" data-bs-parent="#attechmentacordian">
                            <div class="tk-attechment-content">
                                <div class="form-group">
                                    <label class="tk-label"> {{__('project.add_video_link')}}</label>
                                    <div class="tk-placeholderholder">
                                        <input type="url" wire:model.defer="video_url" placeholder="{{__('project.video_link_placeholder')}}" class="form-control tk-themeinput @error('video_url') tk-invalid @enderror">
                                    </div>
                                    @error('video_url')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                              
                                <div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
                                    <div class="tk-draganddrop"
                                    x-bind:class="dropFile ? 'tk-opacity' : ''"
                                    x-on:drop="dropFile = false"
                                    wire:drop.prevent="$emit('file-dropped', $event)"
                                    x-on:dragover.prevent="dropFile = true"
                                    x-on:dragleave.prevent="dropFile = false">
                                        
                                        <svg><rect width="100%" height="100%"></rect></svg>
                                        <input class="tk-drag-imagearea" type="file" id="at_upload_files" accept="{{ !empty($allowFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowFileExt))  : '*' }}" multiple wire:change="$emit('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                                        <div class="tk-dragfile">
                                            <div class="tk-fileareaitem">
                                                <img src="{{ asset('images/image-uploader.jpg') }}" alt="">
                                            </div>
                                            <div class="tk-filearea">
                                                <div class="text-center" wire:loading wire:target="files" ><span class="fw-normal">{{__('general.uploading')}}</span></div>
                                                <div class="tk-text-flex" wire:loading.remove  wire:target="files" ><span>{{__('general.uploading_desc')}}</span>
                                                <label class="tk-drag-label" for="at_upload_files"> <em>{{__('general.click_here')}}</em></label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('files.*')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                @if($existingFiles)
                                    <ul class="tk-uploadlist">
                                        @foreach($existingFiles as $key => $single)
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
                                                        <a href="javascript:;" wire:click.prevent="removeFile('{{ $key }}')"><i class="icon-trash-2"></i></a>
                                                    </div>
                                                </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep( {{ $step + 1 }} )" id="continue_btn" class="tk-btn-solid-lg-lefticon">
                         {{__('project.continue')}}
                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
