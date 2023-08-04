<main class="tb-main">
    <div class ="row">
        @include('livewire.admin.email-templates.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('email_template.all_templates') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$listed_templated->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('email_template.email_title') }} </th>
                                <th>{{__('email_template.role_type')}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listed_templated as $single)
                                <tr>  
                                    <td data-label="{{ __('email_template.email_title') }}"><span>{!! $single->title !!}</span></td>
                                    <td data-label="{{__('email_template.role_type')}}"><span>{{ ucfirst($single->role) }}</span></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status == 'active' ? __('general.active') : __('general.deactive') }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:;" onClick="confirmation({{ $single->id }})" class="tb-delete"><i class="ti-trash"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    {{ $listed_templated->links('pagination.custom') }}  
                @else
                    @include('admin.no-record')
                @endif  
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        initSelect2();

        window.addEventListener('initSelect2', event => {
            initSelect2();
        });

        function initSelect2(){
            $('#template_key').select2(
                { allowClear: true}
            );

            $(document).on('change', '#template_key', function (e) {
                let template_key = $('#template_key').select2("val");
                @this.set('template_key', template_key);
            });

            iniliazeSelect2Scrollbar();
        }
    });


    function confirmation( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'deleteConfirmRecord';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class}) 
    }
</script>
@endpush
