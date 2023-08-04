<main class="tb-main">
    <div class ="row">
        @include('livewire.admin.taxonomies.languages.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('languages.text') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedLanguages ? '' : 'd-none' }}" onClick="confirmation()">{{ __('general.delete_selected') }}</a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" class="form-control">
                                            @foreach($per_page_opt as $opt ){
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('languages.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if(!empty($languages) && $languages->count() > 0)
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>
                                    <div class="tb-checkbox">
                                        <input id="checkAll" wire:model.lazy="selectAll"  type="checkbox">
                                        <label for="checkAll">{{ __('languages.name') }}</label>
                                    </div>
                                </th>
                                <th>{{__('general.description')}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($languages as $single)
                                <tr>
                                    <td data-label="{{ __('languages.name') }}">
                                        <div class="tb-checkboxwithimg">
                                            <div class="tb-checkbox">
                                                <input id="language_id{{ $single->id }}" wire:model.lazy="selectedLanguages" value="{{ $single->id }}" type="checkbox">
                                                <label for="language_id{{ $single->id }}">
                                                    <span> 
                                                        {!! $single->name !!}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="{{__('general.description')}}"><span>{!! $single->description !!}</span></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" onClick="confirmation({{ $single->id }})" class="tb-delete"><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        {{ $languages->links('pagination.custom') }}  
                    @else
                        @include('admin.no-record')
                    @endif  
                
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
    <script>
        function confirmation( id = '' ){
            let title           = '{{ __("general.confirm") }}';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deleteConfirmRecord';
            let type_color      = 'red';
            let btn_class       = 'success';
            ConfirmationBox({title, content, action, id, type_color, btn_class})
        }
        document.addEventListener('livewire:load', function () {
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

