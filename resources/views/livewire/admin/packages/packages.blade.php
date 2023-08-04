<main class="tb-main tb-mainbg">
    <div class="row">
        <div class="col-xl-4">
            <div class="tb-dbholder tb-package-settings">
                <div class="tb-dbbox tb-dbboxtitle">
                    <h5> {{__('settings.packege_option_settings')}}</h5>
                </div>
                <div class="tb-dbbox tb-todobox">
                    <form class="tb-themeform tb-loginform">
                        <fieldset>
                            <div class="form-group-wrap">
                                <div class="form-group">
                                    <label class="tb-label">{{__('settings.packege_option')}}</label>
                                    <div class="tk-settingarea">
                                        <div wire:ignore class="tb-select">
                                            <select id="package_option" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.select_packege_option')}}" class="form-control tk-select2">
                                                <option label="{{__('settings.select_packege_option')}}"></option>
                                                @foreach( $package_opt as $key => $option )
                                                    <option value="{{ $key }}" {{ $settings['package_option'] == $key ? 'selected' : '' }} >{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="tb-label">{{__('settings.single_project_credits')}}</label>
                                    <div class="tb-increasevalue">
                                        <input type="number" class="form-control" wire:model.defer="settings.single_project_credits" required="" placeholder="{{__('settings.sngl_proj_cred_placeholder')}}">
                                    </div>
                                </div>
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="updateSetting" class="tb-btn">
                                        {{ __('settings.save_setting') }}
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-dbholder tb-package-settings">
                <div class="tb-dbbox tb-dbboxtitle">
                    <h5>{{ $editMode ? __('settings.update_package') : __('settings.add_package') }}</h5>
                </div>
                <div class="tb-dbbox tb-todobox">
                    <form class="tb-themeform tb-loginform">
                        <fieldset>
                            <div class="form-group-wrap">
                                <!-- for both -->
                                <div class="form-group tb-packagesfor">
                                    <h6>{{ __('settings.package_for') }}</h6>
                                    <ul class="tb-payoutmethod tb-packagestype">
                                        <li class="tb-radiobox">
                                            <input wire:model.lazy="package_for" type="radio" id="radio-buyer" {{ $package_for == 'buyer' ? 'checked' : '' }} value="buyer">
                                            <div class="tb-radio">
                                                <label for="radio-buyer" class="tb-radiolist">
                                                    <span class="tb-wininginfo">
                                                       <i>{{ __('settings.buyer') }}</i>
                                                    </span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="tb-radiobox">
                                            <input wire:model.lazy="package_for"  type="radio" id="radio-seller" {{ $package_for == 'seller' ? 'checked' : '' }} value="seller">
                                            <div class="tb-radio">
                                                <label for="radio-seller" class="tb-radiolist">
                                                    <span class="tb-wininginfo">
                                                        <i>{{ __('settings.seller') }}</i>
                                                    </span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                    @error('package_for')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="tb-label">{{__('settings.package_name')}}</label>
                                    <input type="text" class="form-control @error('package.title') tk-invalid @enderror" wire:model.defer="package.title" placeholder="{{__('settings.package_name_placeholder')}}">
                                    @error('package.title')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <!-- for both -->
                                <div class="form-group">
                                    <label class="tb-label">{{__('settings.package_type')}}</label>
                                    <div class="tk-settingarea @error('package.type') tk-invalid @enderror">
                                        <div wire:ignore class="tb-select border-0">
                                            {{$package['type']}}
                                            <select id="package_type" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.select_packege_option')}}" class="form-control tk-select2">
                                                <option label="{{__('settings.select_packege_option')}}"></option>
                                                @foreach($package_type as $key => $type)
                                                    <option value="{{ $key }}" {{ $package['type'] == $key ? 'selected' : '' }} >{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('package.type')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- for both -->
                                <div class="form-group">
                                    <label class="tb-label tk-required">{{__('settings.package_duration')}}</label>
                                    <div class="tb-tippy-input">
                                        <input type="number" class="form-control @error('package.duration') tk-invalid @enderror" wire:model.defer="package.duration" placeholder="{{__('settings.package_duration_placeholder')}}">
                                        <em data-tippy-content="{{__('settings.duration_info')}}" class="tippy"><i class="icon-alert-circle"></i></em>
                                        @error('package.duration')
                                            <div class="tk-errormsg"> 
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="tb-label tk-required">{{__('settings.package_price')}}</label>
                                    <input type="text" class="form-control @error('package.price') tk-invalid @enderror" wire:model.defer="package.price" placeholder="{{__('settings.price_placeholder')}}">
                                    @error('package.price')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <!-- for buyer -->
                                @if( $package_for == 'buyer' )
                                    <div class="form-group">
                                        <label class="tb-label tk-required">{{__('settings.posted_projects')}}</label>
                                        <input type="text" class="form-control @error('package.posted_projects') tk-invalid @enderror" wire:model.defer="package.posted_projects" placeholder="{{__('settings.posted_projects')}}">
                                        @error('package.posted_projects')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tk-required">{{__('settings.feature_project')}}</label>
                                        <input type="text" class="form-control @error('package.featured_projects') tk-invalid @enderror" wire:model.defer="package.featured_projects" placeholder="{{__('settings.feature_project')}}">
                                        @error('package.featured_projects')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tk-required">{{__('settings.feature_project_duration')}}</label>
                                        <div class="tb-tippy-input">
                                            <input type="number" class="form-control @error('package.project_featured_days') tk-invalid @enderror" wire:model.defer="package.project_featured_days" placeholder="{{__('settings.feature_project_duration')}}">
                                            <em data-tippy-content="Duration should be in numbers of days" class="tippy"><i class="icon-alert-circle"></i></em>
                                            @error('package.project_featured_days')
                                                <div class="tk-errormsg">
                                                    <span>{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                @if( $package_for == 'seller' )
                                    <div class="form-group">
                                        <label class="tb-label tk-required">{{__('settings.credits')}}</label>
                                        <input type="number" class="form-control @error('package.credits') tk-invalid @enderror" wire:model.defer="package.credits" placeholder="{{__('settings.credits_placeholder')}}">
                                        @error('package.credits') 
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tk-required">{{__('settings.profile_featured_days')}}</label>
                                        <input type="number" class="form-control @error('package.profile_featured_days') tk-invalid @enderror" wire:model.defer="package.profile_featured_days" placeholder="{{__('settings.ftr_duration_placeholder')}}">
                                        @error('package.profile_featured_days')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                @endif
                                @if($editMode)
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.status') }}:</label>
                                        <div class="tb-email-status">
                                            <span>{{__('settings.set_package_status')}}</span>
                                            <div class="tb-switchbtn">
                                                <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{ $package['status'] == 'active' ? __('general.active') : __('general.deactive') }} </span></label>
                                                <input {{ $package['status'] == 'active' ? 'checked' : '' }} class="tb-checkaction" type="checkbox" id="tb-emailstatus">
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
                                    <label class="tb-label">{{__('settings.upload_image')}}</label>
                                    <div class="tb-uploadarea tb-uploadbartwo">
                                        <ul class="tb-uploadbar">
                                            <li wire:loading wire:target="package.image" style="display: none" class="tb-uploading">
                                                <span>{{ __('settings.uploading') }}</span>
                                            </li>
                                            @if (!empty($package['image']) && method_exists($package['image'],'temporaryUrl'))
                                                <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                                    <img src="{{ substr($package['image']->getMimeType(), 0, 5) == 'image' ? $package['image']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $package['image']->getClientOriginalName() }}">
                                                    <span>{{$package['image']->getClientOriginalName()}} <a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a> </span>
                                                </div>
                                            @elseif(!empty($old_image))
                                                @php 
                                                    $image_path = $old_image['file_path'];
                                                    $image_name = $old_image['file_name'];
                                                @endphp
                                                <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                                    <img src="{{ asset('storage/'.$image_path) }}" alt="{{$image_name}}">
                                                    <span>{{ $image_name }}<a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a></span>
                                                </div>
                                            @endif
                                        </ul>
                                        <span class="tb-upload-limit">{{ __('settings.image_option',['extension'=> join(',', $allow_image_ext), 'size'=> $allow_image_size.'MB']) }}</span>
                                        <em>
                                            <label for="file2">
                                                <span>
                                                    <input id="file2" type="file" accept="{{ !empty($allow_image_ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allow_image_ext)) : '*' }}"  wire:model.lazy="package.image">
                                                    {{ __('settings.click_here_to_upload') }}
                                                </span>
                                            </label>
                                        </em>
                                        @error('package.image') 
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn" >{{ __('settings.update_save_btn') }}<span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('settings.package_heading') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc"> {{ __('general.asc') }}</option>
                                            <option value="desc">{{ __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" id="tb-selection1" class="form-control">
                                            @foreach($per_page_opt as $opt ){
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('settings.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-dbholder border-0 tb-todolist">
                @if(!empty($packages) && $packages->count() > 0)
                <table class="table tb-table tb-dbholder tb-packages-table">
                    <thead>
                        <tr>
                            <th> {{ __('settings.name') }}</th>
                            <th>{{__('settings.package_for')}}</th>
                            <th>{{__('settings.price')}}</th>
                            <th>{{__('general.status')}}</th>
                            <th>{{__('general.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $single)

                            @php   
                                $statusTag = getTag($single->status);
                            @endphp
                            <tr>
                                <td data-label="{{ __('settings.name') }}">
                                    <span>
                                        @if(!empty($single->image))
                                            @php  
                                                $image      = unserialize($single->image);
                                                $image_path = $image['file_path'];
                                                $image_name = $image['file_name'];
                                            @endphp
                                            <img src="{{ asset('storage/'.$image_path) }}" alt="{{ $image_name }}">
                                        @endif
                                        {{ ucfirst($single->title) }}
                                    </span>
                                </td>
                                <td data-label="{{__('settings.package_for')}}"><span class="tb-table-data">{{ ucfirst(getRoleById($single->role_id)) }}</span></td>
                                <td data-label="{{__('settings.price')}}"><span class="tb-table-data">{{ getPriceFormat($currency, $single->price) }}</span></td>
                                <td data-label="{{__('settings.status')}}">
                                    <em class="{{$statusTag['class']}}">{{$statusTag['text']}}</em>
                                </td>
                                <td data-label="{{__('settings.actions')}}">
                                    <ul class="tb-action-icon">
                                    <li> 
                                        <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})">
                                            <i class="icon-edit-3"></i>
                                        </a> 
                                    </li>
                                    <li> <a href="javascript:void(0);">
                                        <span wire:click.prevent="previewPackage({{$single->id}})" data-bs-target="#viewpackages">
                                            <i class="icon-eye tb-blue"></i>
                                        </span>
                                    </a> 
                                </li>
                                </ul>
                                </td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
                {{ $packages->links('pagination.custom') }}
                @else
                    @include('admin.no-record')
                @endif
            </div>
        </div>
    </div>                                            
    @if(!empty($viewPackage))
        <div class="modal fade tb-taskdetailtitle" tabindex="-1" role="dialog" id="viewpackages-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="tb-modalcontent modal-content viewpackages">
                    <div class="tb-popuptitle">
                        <h4>{{__('settings.package_detail')}}</h4>
                        <a href="javascript:void(0);" class="close"><i class="ti-close" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <div class="tb-viewpackages-content">
                            <div class="tb-view-imgarea">
                                @if(!empty($viewPackage['image']))
                                    @php  
                                        $image      = unserialize($viewPackage['image']);
                                        $image_path = $image['file_path'];
                                        $image_name = $image['file_name'];
                                    @endphp
                                    <img src="{{ asset('storage/'.$image_path) }}" alt="{{ $image_name }}">
                                @endif
                                <div class="tb-img-description">
                                    <a href="javascript:void(0);" class="tk-project-tag tk-active">{{$viewPackage['status']}}</a>
                                    <span>{{$viewPackage['title']}}</span>
                                </div>
                            </div>
                            <h4>{{getPriceFormat($currency, $viewPackage['price'])}}</h4>
                        </div>
                        <ul class="tb-packege-list">
                            <li>
                                <div class="tb-view-pac-item">
                                    <span>{{__('settings.package_type')}}</span>
                                    <h6>{{ $viewPackage['type'] == 'day' ? __('settings.package_type_daily') : ( $viewPackage['type'] == 'month' ? __('settings.package_type_monthly') : __('settings.package_type_yearly') )}}</h6>
                                </div>
                            </li>
                            <li>
                                <div class="tb-view-pac-item">
                                    <span>{{__('settings.package_duration')}}</span>
                                    <h6>{{$viewPackage['duration']}}</h6>
                                </div>
                            </li>
                            @if( $viewPackage['package_for'] == 'buyer')
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span>{{__('settings.featured_project_durtation')}}</span>
                                        <h6>{{ $viewPackage['project_featured_days'] > 1 ? __('settings.feature_days_lable',['days' => $viewPackage['project_featured_days']]): __('settings.feature_day_lable')}}</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span>{{__('settings.posted_projects')}}</span>
                                        <h6>{{$viewPackage['posted_projects']}}</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span>{{__('settings.feature_project')}}</span>
                                        <h6>{{$viewPackage['featured_projects']}}</h6>
                                    </div>
                                </li>
                            @elseif($viewPackage['package_for'] == 'seller')
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span>{{__('settings.credits')}}</span>
                                        <h6>{{$viewPackage['credits']}}</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span>{{__('settings.profile_featured_days')}}</span>
                                        <h6>{{$viewPackage['profile_featured_days']}}</h6>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        iniliazeSelect2Scrollbar();
        window.addEventListener('editPackage', event => {
            let package_type = event.detail.package_type;
            $('#package_type').select2().val(package_type).trigger("change");
        });
        
        $('#package_type').on('change', function (e) {
            let type = $('#package_type').select2("val");
            @this.set('package.type', type, true);
        });

        $('#package_option').on('change', function (e) {
            let option = $('#package_option').select2("val");
            @this.set('settings.package_option', option, true);
        });

        $(document).on('click', '.tb-checkaction', function(event){
            let _this   = $(this);
            let status  = '';
            if(_this.is(':checked')){
                _this.parent().find('#tb-textdes').html("{{__('general.active')}}");
                status = 'active';
            } else {
                _this.parent().find('#tb-textdes').html( "{{__('general.deactive')}}");
                status = 'deactive';
            }
            @this.set('package.status', status, true);
        });

        window.addEventListener('previewPackage', event => {
            var $target = $('#viewpackages-modal').modal(event.detail.modal);
        });
    });
</script>
@endpush