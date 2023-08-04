<div class="tb-main">
    <div class ="row">
        @include('livewire.admin.taxonomies.project-location.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('project_location.text') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">

                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('project_location.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if(!empty($locations) && $locations->count() > 0)
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('project_location.id') }}</th>
                                <th>{{ __('project_location.name') }}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $single)
                                <tr>
                                    <td data-label="{{ __('project_location.id') }}">
                                        {{$single->id}}
                                    </td>
                                    <td data-label="{{ __('project_location.name') }}">
                                        <span> 
                                            {!! $single->name !!}
                                        </span>
                                    </td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li> 
                                        </ul>
                                    </td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    @else
                        @include('admin.no-record')
                    @endif  
                </div>
            </div>
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