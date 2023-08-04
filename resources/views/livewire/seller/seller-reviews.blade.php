<div id="reviews" wire:init="loadReviews" class="tk-profilebox">
    @if( $page_loaded )
        
            <div class="tk-content-box tk-review-box">
                <h4>
                    {{__('general.reviews')}}
                    <i class="fas fa-star tk-yellow"></i> 
                    <em>
                        {{ ratingFormat($reviews->avg('rating') ) }}
                        ({{__('general.user_reviews', ['count' => number_format( count($reviews))])}})
                    </em>
                </h4>
                @if(!$reviews->isEmpty())
                    @php  
                        $overallRatingPer = 0;
                        if(!empty($reviews->avg('rating'))){
                            $overallRatingPer = ($reviews->avg('rating')/5)*100;
                        }  
                        $counter = 0;
                    @endphp
                    @foreach($reviews as $single)
                        @php 
                            $counter++;
                            $hide = $counter > 5 ? true : false;
                        @endphp
                        <x-review-item :single="$single" :hide="$hide" :date_format="$date_format"/>
                    @endforeach

                    @if($counter > 5)
                        <div class="tk-readmore">
                            <a href="javascript:void(0)">{{__('general.load_more')}}</a>
                        </div>
                    @endif
                @else
                    <div class="tk-noskills">
                        <span>{{__('general.no_review_found')}}</span>
                    </div>
                @endif
            </div>
            
    @else
        <ul class="tk-frame">
            @for($i =1; $i<=3; $i++)
                <li>
                    <div class="tk-frame-items">
                        <div class="tk-imgarea">
                            <figure class="tk-skele"></figure>
                            <div class="tk-img-deatil">
                                <div class="tk-title">
                                    <span class="tk-review tk-skele"></span>
                                    <span class="tk-review tk-skele"></span>
                                </div>
                                <span class="tk-review tk-skele"></span>
                            </div>
                        </div>
                        <span class="tk-skele"></span>
                        <span class="tk-frame-para tk-skele"></span>
                    </div>
                </li>
            @endfor
        </ul>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            
            $(document).on('click','.tk-readmore', function(e){
                let _this = $(this);
                _this.remove()
                $('.tk-review-sec.d-none').removeClass('d-none');
            })
        });
    </script>
@endpush