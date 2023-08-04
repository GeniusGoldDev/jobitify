<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5> {{ $editMode ? __('skill.update_skill') : __('skill.add_skill')}}</h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label">{{ __('skill.title') }}</label>
                            <input type="text" class="form-control @error('name') tk-invalid @enderror"  wire:model.defer="name" required placeholder="{{ __('skill.title') }}">
                            @error('name')
                                <div class="tk-errormsg">
                                    <span>{{ $message }}</span> 
                                </div>
                            @enderror
                        </div>
                        @if(!empty($skills_tree) && $skills_tree->count() > 0)
                        <div class="form-group">
                            <div class="tb-themeselect-wrapper">
                                <div class="tb-themeselect">
                                    <label class="tb-label">{{ __('skill.parent_skill') }}</label>
                                    <div class="tb-select border-0">
                                        <span class="form-control tb-themeselect_value {{ !empty($isSelectedSkill) ? 'tk-selected' : ''}}">{{ !empty( $parent_skill_name ) ? $parent_skill_name : __('general.select') }}</span>
                                    </div>
                                    <ul class="tb-categorytree-dropdown tb-themeselect_options tk-custom-scrollbar ">
                                        @foreach($skills_tree as $skill)
                                                <x-admin.skill-item :skill="$skill" />
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="tb-label">{{ __('general.description') }}</label>
                            <textarea class="form-control" placeholder="{{ __('general.description') }}" wire:model.defer="description" id=""></textarea>
                        </div>
                        @if($editMode)
                            <div class="form-group">
                                <label class="tb-label">{{ __('general.status') }}:</label>
                                <div class="tb-email-status">
                                    <span>{{__('skill.skill_status')}}</span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{$status == 'active' ? __('general.active') : __('general.deactive')}}</span></label>
                                        <input class="tb-checkaction" {{ $status == 'active' ? 'checked' : '' }} type="checkbox" id="tb-emailstatus">
                                    </div>
                                </div>
                                @error('status')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span> 
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="tb-label">{{ __('skill.upload_photo') }} ({{ __('skill.optional') }}):</label>
                            <div class="tb-uploadarea tb-uploadbartwo">
                                <ul class="tb-uploadbar">
                                    <li wire:loading wire:target="image" style="display: none" class="tb-uploading">
                                        <span>{{ __('settings.uploading') }}</span>
                                    </li>
                                    @if (!empty($image) && method_exists($image,'temporaryUrl'))
                                        <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                            <img src="{{ substr($image->getMimeType(), 0, 5) == 'image' ? $image->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $image->getClientOriginalName() }}">
                                            <span><p>{{$image->getClientOriginalName()}} </p><a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a> </span>
                                        </div>
                                    @elseif(!empty($old_image))
                                        @php 
                                            $image_path = $old_image['file_path'];
                                            $image_name = $old_image['file_name'];
                                       @endphp
                                        <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                            <img src="{{  asset('storage/'.$image_path) }}" alt="{{$image_name}}">
                                            <span><p>{{ $image_name }}</p><a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a></span>
                                        </div>
                                    @endif
                                  
                                </ul>
                                <em> {{ __('skill.image_option',['extension'=> join(',', $allow_image_ext), 'size'=> $allow_image_size.'MB']) }}
                                    <label for="file2">
                                        <span>
                                            <input id="file2" type="file" accept="{{ !empty($allow_image_ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allow_image_ext)) : '*' }}"  wire:model="image">
                                            {{ __('skill.click_here_to_upload') }}
                                        </span>
                                    </label>
                                    @error('image')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </em>
                            </div>
                        </div>
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                {{ $editMode ? __('skill.update_skill') : __('skill.add_skill') }}
                            </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.tb-themeselect .tb-select', function(event) {
                $(this).next(".tb-themeselect_options").slideToggle();
                event.stopPropagation();
            });

            $(document).on('click', '.tb-themeselect_options li label', function(event) {
                let listText = jQuery(this).text();
                $('.tb-themeselect_value').text(listText);
                $(this).parents(".tb-themeselect_options").slideUp();
                $('.tb-categorytree-dropdown').mCustomScrollbar('destroy');
            });
            
            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("{{__('general.active')}}");
                    status = 'active';
                } else {
                    _this.parent().find('#tb-textdes').html( "{{__('general.deactive')}}");
                    status = 'deactive';
                }
                @this.set('status', status, true);
            });

        });
    </script>
@endpush