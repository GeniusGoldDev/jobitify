<main class="tb-main" wire:key="{{time()}}">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('project.all_projects') .' ('. $projects->total() .')' }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">         
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_project" class="form-control tk-selectprice">
                                            <option value =""> {{ __('project.all_projects') }} </option>
                                            <option value ="pending"> {{ __('general.pending') }} </option>
                                            <option value ="publish"> {{ __('general.publish') }} </option>
                                            <option value ="hired"> {{ __('general.hired') }} </option>
                                            <option value ="completed"> {{ __('general.completed') }} </option>
                                            <option value ="cancelled"> {{ __('general.cancelled') }} </option>
                                            <option value ="disputed"> {{ __('general.disputed') }} </option>
                                            <option value ="refunded"> {{ __('general.refunded') }} </option>
                                        </select>
                                    </div>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_project"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$projects->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('project.project_title' )}}</th>
                                <th>{{ __('project.project_author' )}}</th>
                                <th>{{ __('project.created_date' )}}</th>
                                <th>{{ __('project.project_budget' )}}</th>
                                <th>{{ __('project.project_type' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $single)
                                @php
                                $tag = getTag( $single->status );
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __('project.project_title' )}}"><span>{!! $single->project_title !!}</span></td>
                                    <td data-label="{{ __('project.project_author' )}}"><span>{{ $single->projectAuthor->full_name }}</span></td>
                                    <td data-label="{{ __('project.created_date' )}}"><span>{{ date($date_format, strtotime( $single->created_at )) }}</span></td>
                                    <td data-label="{{ __('project.project_budget' )}}"><span>{{ getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price) }}</span></td>
                                    <td data-label="{{ __('project.project_type' )}}"><em class="tk-project-tag {{ $single->project_type == 'fixed' ? 'tk-fixed-tag' : 'tk-hourly-tag' }}">{{ $single->project_type == 'fixed' ?  __('project.fixed') : __('project.hourly') }}</em></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="{{ $tag['class'] }}">{{ $tag['text'] }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-status">
                                            <li>
                                                @if( $single->status == 'pending' )
                                                <span>
                                                    <a href="javascript:;" onClick="confirmation({{ $single->id }})"  ><i class="fas fa-check"></i>{{ __('project.approve') }}</a>
                                                </span>
                                                @else
                                                    <span class="tb-approved"><i class="fas fa-check"></i>{{ __('project.approved') }}</span>     
                                                @endif
                                            </li>
                                            <li>
                                                <a href="{{ route('project-detail', ['slug'=> $single->slug] ) }}" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                            <li> <a href="javascript:void(0);" onClick="deleteProject({{ $single->id }})" class="tb-delete" ><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                        {{ $projects->links('pagination.custom') }}  
                    @else
                        @include('admin.no-record')
                    @endif  
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function () {
        
        setTimeout(function() {

            $('#filter_project').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_project').on('change', function (e) {
                let filter_project = $('#filter_project').select2("val");
                @this.set('filter_project', filter_project);
            });

            iniliazeSelect2Scrollbar();
        }, 50);
    });
  
    function confirmation( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'approveProjectConfirm';
        let type_color      = 'green';
        let btn_class      = 'success';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }

    function deleteProject( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'deleteProject';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
@endpush
