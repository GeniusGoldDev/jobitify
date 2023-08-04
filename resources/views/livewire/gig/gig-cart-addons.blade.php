<div class="tk-asideholder">
    @if( !empty($gig_addons) )
        <div class="tk-asideboxv2">
            <div class="tk-sidetitle">
                <h5>{{ __('gig.selected_additional_features')}}</h5>
            </div>
            <ul class="tk-exploremore">
                @php
                    $total = 0;
                @endphp
                @foreach($gig_addons as $single)
                    @php
                        $total +=$single['price']; 
                    @endphp
                    <li>
                        <span>{{ $single['title'] }}</span>
                        <em>{{getPriceFormat($currency_symbol, $single['price'])}}</em>
                    </li>
                @endforeach
            </ul>
        </div>
            @php
                $total +=!empty($gig_plan) ? $gig_plan[0]['price'] : 0; 
            @endphp
        <ul class="tk-featuredlisted tk-exploremore">
            <li>
                <span>{{ __('general.total') }}</span>
                <em>{{getPriceFormat($currency_symbol, $total)}}</em>
            </li>
        </ul>
    @endif
    <div class="tk-btnwallet">
        <a href="javascript:;" wire:click.prevent="checkout" class="tk-btn-solid-lg-lefticon"><i class="icon-lock"></i>{{ __('gig.proceed_to_checkout') }} </a>
    </div>
</div>