<main class="tb-main">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('gig.all_orders') .' ('. $gig_orders->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">         
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_gig" class="form-control tk-selectprice">
                                            <option value =""> {{ __('gig.all_orders') }} </option>
                                            <option value ="hired"> {{ __('general.hired') }} </option>
                                            <option value ="completed"> {{ __('general.completed') }} </option>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_gig"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-allgig-order">
                @if( !$gig_orders->isEmpty() )
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('gig.title' )}}</th>
                                <th>{{ __('gig.gig_order_author' )}}</th>
                                <th>{{ __('gig.plan_type' )}}</th>
                                <th>{{ __('gig.order_amount' )}}</th>
                                <th>{{ __('gig.delivery_days' )}}</th>
                                <th>{{ __('gig.order_start_time' )}}</th>
                                <th>{{ __('gig.deadline' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gig_orders as $single)
                                @php
                                $tag = getTag( $single->status );
                                @endphp
                                <tr> 
                                    <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                    <td data-label="{{ __('gig.title' )}}">
                                        <div class="tk-proposal-title">
                                            <a href="{{ route('gig-detail', ['slug'=> $single->gig->slug] ) }}" target="_blank">{!! $single->gig->title !!}</a> 
                                            <span>{{ $single->gig->gigAuthor->full_name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('gig.gig_order_author' )}}"><span>{{ $single->orderAuthor->full_name }}</span></td>
                                    <td data-label="{{ __('gig.plan_type' )}}"><span>{{ $single->plan_type }}</span></td>
                                    <td data-label="{{ __('gig.order_amount' )}}"><span>{{getPriceFormat($currency_symbol,$single->plan_amount)}}</span></td>
                                    <td data-label="{{ __('gig.delivery_days' )}}"><span>{{ $single->gig_delivery_days }}</span></td>
                                    <td data-label="{{ __('gig.order_start_time' )}}"><span>{{ date('M d, Y',  strtotime($single->gig_start_time)) }}</span></td>
                                    <td data-label="{{ __('gig.deadline' )}}"><span>{{ date('M d, Y', strtotime('+'.$single->gig_delivery_days.'days', strtotime($single->gig_start_time))) }}</span></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="{{ $tag['class'] }}">{{ $tag['text'] }}</em>
                                    </td>
                                    <td data-label="{{__('general.action')}}">
                                        <ul class="tb-action-status">
                                            <li> <a href="javascript:void(0);" onClick="deleteOrder({{ $single->id }})" class="tb-delete" ><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                        {{ $gig_orders->links('pagination.custom') }}  
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
        }, 50);
    });

    function deleteOrder( id ){
        
        let title           = '{{ __("general.confirm") }}';
        let content         = '{{ __("general.confirm_content") }}';
        let action          = 'deleteGigOrder';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }

</script>
@endpush
