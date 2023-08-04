<main class="tb-main">
    <div class ="row">
            @include('livewire.admin.sitepages.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.pages') }}</h4>
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
                @if( !$pages->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__('general.name')}}</th>
                                <th>{{__('general.url')}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sr = 1;
                            @endphp                    
                            @foreach($pages as $single)
                                <tr>
                                    <td data-label=""><span>{{ $sr++ }}</span></td>
                                    <td data-label="{{__('general.name')}}"><span>{!! $single->name !!}</span></td>
                                    <td data-label="{{__('general.url')}}"><span>{{ url( !empty($single->route) ? $single->route : '/' ) }}</span></td>
                                    <td data-label="{{__('general.status')}}"><em class="{{ $single->status == 'publish' ? 'tk-project-tag tk-success-tag' : 'tk-project-tag' }}">{{ $single->status == 'draft' ? __('general.draft') : __('general.active') }}</em></td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="{{route('pagebuilder.build', ['id' => $single->id])}}" ><i class="icon-settings"></i></a> </li> 
                                            <li> <a href="{{ url( !empty($single->route) ? $single->route : '/' )}}" target="_blank" ><i class="icon-eye"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" onClick="confirmation({{ $single->id }})" class="tb-delete"><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table>
                        {{ $pages->links('pagination.custom') }}  
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
