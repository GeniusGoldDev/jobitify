<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5>
                 {{ $edit_id ? __('general.update_page') : __('general.add_page') }}
            </h5>
        </div>
        <div class="tb-dbbox">
            <form class="tb-themeform">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label">{{ __('general.page_name') }}</label>
                            <input type="text" class="form-control @error('name') tk-invalid @enderror"  wire:model.defer="name" required placeholder="{{ __('general.page_name') }}">
                            @error('name')
                                <div class="tk-errormsg">
                                    <span>{{ $message }}</span> 
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="tb-label">{{ __('general.page_title') }}</label>
                            <input type="text" class="form-control @error('title') tk-invalid @enderror"  wire:model.defer="title" required placeholder="{{ __('general.page_title') }}">
                            @error('title')
                                <div class="tk-errormsg">
                                    <span>{{ $message }}</span> 
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="tb-label">{{ __('general.page_description') }}</label>
                            <textarea class="form-control"  wire:model.defer="description" required placeholder="{{ __('general.page_description') }}"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="tb-label">{{ __('general.page_slug') }}</label>
                            <input type="text" class="form-control @error('slug') tk-invalid @enderror"  wire:model.defer="slug" required placeholder="{{ __('general.page_slug') }}">
                            @error('slug')
                                <div class="tk-errormsg">
                                    <span>{{ $message }}</span> 
                                </div>
                            @enderror
                        </div>
                        @if($edit_id)
                            <div class="form-group">
                                <label class="tb-label">{{ __('general.status') }}:</label>
                                <div class="tb-email-status">
                                    <span> {{__('pages.page_status')}} </span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-pagestatus" class="tb-textdes"><span id="tb-textdes">{{ $status == 'publish' ? __('general.active') : __('general.deactive') }}</span></label>
                                        <input {{ $status == 'publish' ? 'checked' : '' }} class="tb-checkaction" type="checkbox" id="tb-pagestatus">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn">
                                {{ $edit_id ? __('general.update_page') : __('general.add_page') }}
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
            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("{{__('general.active')}}");
                    status = 'publish';
                } else {
                    _this.parent().find('#tb-textdes').html( "{{__('general.deactive')}}");
                    status = 'draft';
                }
                @this.set('status', status, true);
            });

        });
    </script>
@endpush