<main class="tb-main">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('gig.all_gigs') .' ('. $gigs->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">         
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_gig" class="form-control tk-selectprice">
                                            <option value =""> {{ __('gig.all_gigs') }} </option>
                                            <option value ="draft"> {{ __('general.draft') }} </option>
                                            <option value ="publish"> {{ __('general.publish') }} </option>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_gig"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-dballgigs">
                @if( !$gigs->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('gig.title' )}}</th>
                                <th>{{ __('gig.categories' )}}</th>
                                <th>{{ __('gig.gig_author' )}}</th>
                                <th>{{ __('gig.created_date' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gigs as $single)
                                @php
                                $tag = getTag( $single->status );
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __('gig.title' )}}"><span>{!! $single->title !!}</span></td>
                                    <td data-label="{{ __('gig.categories' )}}">
                                        <h6>
                                            @foreach($single->categories as $cat )
                                                <a target="_blank" href="{{ route('search-gigs', ['category_id' => $cat->category_id])}}">
                                                    <span>{{ $cat->name }}</span>
                                                </a>
                                            @endforeach
                                        </h6>
                                    </td>
                                    <td data-label="{{ __('gig.gig_author' )}}"><span>{{ $single->gigAuthor->full_name }}</span></td>
                                    <td data-label="{{ __('gig.created_date' )}}"><span>{{ date($date_format, strtotime( $single->created_at )) }}</span></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="{{ $tag['class'] }}">{{ $tag['text'] }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-status">
                                            <li>
                                                <a href="{{ route('gig-detail', ['slug'=> $single->slug] ) }}" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                            <li> <a href="javascript:void(0);" onClick="deleteGig({{ $single->id }})" class="tb-delete" ><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                        {{ $gigs->links('pagination.custom') }}  
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

            $('#filter_gig').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_gig').on('change', function (e) {
                let filter_gig = $('#filter_gig').select2("val");
                @this.set('filter_gig', filter_gig);
            });

            iniliazeSelect2Scrollbar();
            
        }, 200);
    });
    
    function deleteGig( id ){

        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'deleteGig';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
@endpush
