<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5>{{ $edit_id ? __('email_template.update_email_template') : __('email_template.add_email_template') }}</h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            @if( !$edit_id )
                                <div class="tb-actionselect">
                                    <span>{{ __('email_template.select_template')  }}: </span>
                                </div>
                                <div class="tb-select border-0">
                                    <select id="template_key" class="form-control">
                                        <option value="">{{ __('email_template.select_template')  }}</option>
                                        @if( !empty($emailTemplates) )
                                            @foreach( $emailTemplates as $type => $template )
                                                @foreach($template['roles'] as $role => $single )
                                                    @php
                                                        $key = $type .'-'.$role;
                                                    @endphp
                                                    @if( !in_array($key, $exclude_templates) )
                                                        <option value="{{ $key }}">{{$template['title'] }} ( {{ $role}} )</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endif
                        </div>
                        @if( !empty($selected_template) )
                           @foreach( $selected_template as $key => $single )
                                @if( $key == 'subject' || $key == 'greeting' )

                                    <div class="form-group">
                                        <label class="tb-label">{{ $single['title'] }}</label>
                                        <input type="text" class="form-control @error('validated_fields.'.$single['id']) tk-invalid @enderror"  placeholder="{{ $single['title'] }}"  wire:model.defer="validated_fields.{{ $single['id'] }}" required>
                                        @error('validated_fields.'.$single['id'])
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>
                                @elseif( $key == 'info' ) 

                                    <div class="form-group">
                                        <label class="tb-label">{{ $single['title'] }}
                                            <i class="{{ $single['icon'] }}"></i>
                                        </label>
                                        <span class="tb-emailsubject-list">
                                            {!! $single['desc'] !!}
                                        </span>
                                    </div>
                                @elseif( $key == 'content' )  
                                  
                                    <div class="form-group">
                                        <label class="tb-label">{{ $single['title'] }}</label>
                                        <textarea class="form-control @error('validated_fields.'.$single['id']) tk-invalid @enderror" placeholder="{{ $single['title'] }}"  wire:model.defer="validated_fields.{{ $single['id'] }}" required></textarea>
                                        @error('validated_fields.'.$single['id'])
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span> 
                                            </div>
                                        @enderror
                                    </div>    
                                @endif
                           @endforeach
                           <div class="form-group">
                            <label class="tb-label">{{ __('general.status') }}:</label>
                            <div class="tb-email-status">
                                <span>{{__('email_template.set_email_status')}}</span>
                                <div class="tb-switchbtn">
                                    <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{ $status == 'active' ? __('general.active') : __('general.deactive') }}</span></label>
                                    <input class="tb-checkaction" {{ $status == 'active' ? 'checked' : '' }} type="checkbox" id="tb-emailstatus">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="saveEmailTemplate" class="tb-btn">
                                {{ $edit_id ?  __('email_template.update_email_template') : __('email_template.add_email_template') }}
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
                let _this   = $(this);
                let status  = '';
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