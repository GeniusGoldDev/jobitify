<div class="tb-main">
    <div class ="row">
        @include('livewire.admin.taxonomies.tags.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('taxonomy.tags') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" id="delete-record" class="tb-btn btnred d-none" onClick="confirmation()">{{ __('general.delete_selected') }}</a>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('taxonomy.search_tag') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if(!empty($tags) && $tags->count() > 0)
                    <table id="tag_table" class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>
                                <div class="tb-checkbox">
                                    <input id="checkAll" class="tb-tag" type="checkbox">
                                    <label for="checkAll"><span> {{ __('general.name') }} </span></label>
                                </div>
                                </th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $single)
                                <tr>
                                    <td data-label="{{ __('general.name') }}">
                                        <div class="tb-checkbox">
                                            <input id="tag_{{ $single->id }}" class="tb-tag" value="{{ $single->id }}" type="checkbox">
                                            <label for="tag_{{ $single->id }}">
                                                <span> 
                                                    {!! $single->name !!}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('general.status') }}">
                                        <div class="tb-bordertags">
                                            <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('general.actions') }}">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" onClick="confirmation({{ $single->id }})" class="tb-delete"><span class="icon-trash-2"></span></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    {{ $tags->links('pagination.custom') }}  
                @else
                    @include('admin.no-record')
                @endif  
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
         function confirmation( id = '' ){
            let title           = '{{ __("general.confirm") }}';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deleteConfirmRecord';
            let type_color      = 'green';
            let btn_class       = 'success';
            ConfirmationBox({title, content, action, id, type_color, btn_class})
        }
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

            $(document).on('change', '#tag_table input:checkbox', function(event){
                let isSelected = false;
                let ids = [];
                $('.tb-tag').each(function(e){
                    let _this = $(this);
                    if(_this.is(':checked')){
                        if(Number(_this.val())){
                            ids.push(Number(_this.val()));
                        }
                        isSelected = true;
                    }
                });
                @this.set('selectedTags', ids, true)
                if(isSelected){
                    $('#delete-record').removeClass('d-none');
                } else {
                    $('#delete-record').addClass('d-none');
                }
            });

            $(document).on('click', '#checkAll', function(event){
                let __this = $(this);
                if(__this.is(':checked')){
                    $('.tb-tag').prop('checked', true);
                    $('.tb-tag').each(function(e){
                        let _this = $(this);
                    });
                } else {
                    $('.tb-tag').prop('checked', false);
                }

            });
        });
    </script>
@endpush