@extends('layouts.app')
    @section('content')
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="tk-servicedetail">
                            <div class="tk-checkoutinfo">
                                <figure>
                                    @php 
                                        $gig_image = 'images/default-img-100x100.png';
                                        if(!empty($gig->attachments) ){
                                            $files  = unserialize($gig->attachments);
                                            $images = $files['files'];
                                            $latest = current($images);
                                            if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                                                if(!empty($latest->sizes['100x100'])){
                                                    $gig_image = 'storage/'.$latest->sizes['100x100'];
                                                } elseif(!empty($latest->file_path)){
                                                    $gig_image = 'storage/'.$latest->file_path;
                                                }
                                            }
                                        }
                                    @endphp
                                    <img width="300" height="300" src="{{ asset($gig_image) }}" class="" alt="{{ __('gig.alt_image') }}">
                                </figure>
                                <div class="tk-checkoutdetail">
                                    <h6>
                                        @foreach($gig->categories as $single )
                                            <a href="{{ route('search-gigs', ['category_id' => $single->category_id])}}">
                                                {{ $single->name}}
                                            </a>
                                        @endforeach
                                    </h6>
                                    <h5>{{ $gig->title }}</h5>
                                    <ul class="tk-blogviewdates tk-blogviewdatessm">
                                        <li>
                                            <i class="fas fa-star tk-yellow"></i>
                                            <em> {{ ratingFormat($gig->ratings_avg_rating) }} </em>
                                            <span>({{ $gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count)]) }} ) </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if( !$gig->addons->isEmpty() )
                                <div class="tk-gigfeatures">
                                    <div class="tk-boxtittle">
                                        <h4>{{ __('gig.additional_features') }}</h4>
                                    </div>
                                    <ul class="tk-additionalservices tk-additionalservicesvtwo">
                                        @foreach($gig->addons as $single)
                                            <li>
                                                <div class="tk-form-checkbox gig-addons">
                                                    <input class="form-check-input tk-form-check-input-sm" type="checkbox" value="{{$single->id}}" id="addon-{{$single->id}}">
                                                    <label class="tk-additionolinfo" for="addon-{{$single->id}}">
                                                        <span>{{ $single->title }}</span>
                                                        <em>{!! nl2br($single->description) !!} </em>
                                                    </label>
                                                    <div class="tk-addcartinfoprice">
                                                        <h6>{{getPriceFormat($currency_symbol, $single->price)}}</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <aside>
                            <div class="tk-asideholder">
                                <div class='tk-asideboxsm'>
                                    <h5>{{ __('gig.price_plan') }}</h5>
                                </div>
                                <div class="tk-collapsepanel">
                                    <ul class="tk-pakagelist">
                                        @php
                                            $plan_images = [
                                                0 => 'basic',
                                                1 => 'popular',
                                                2 => 'premium',
                                            ];    
                                        @endphp
                                        @foreach($gig->gig_plans as $key=> $single)
                                        <li class="tk-pakagelist-item {{$gig_plan_id == $single['id'] ? 'tk-active' : ''}}" data-plan_id="{{$single['id']}}">
                                            <a href="javascript:;">
                                                <img src="{{asset('images/plan-icon-'.$plan_images[$key].'.jpg')}}">
                                                <span>{{ $single->title }}</span>
                                                <em>{{getPriceFormat($currency_symbol, $single->price)}} <i  class="fas fa-check {{$gig_plan_id == $single['id'] ? '' : 'd-none'}}"></i></em>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <livewire:gig.gig-cart-addons :plan_id="$gig_plan_id" :gig_author="$gig->author_id" :downloadable="$gig->downloadable" :gig_title="$gig->title" />
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </main>  
@endsection('content')

@push('scripts') 
    <script>
        setTimeout(function() {
            $(document).on("click",".tk-pakagelist-item",function(e){
                let _this = $(this);
                $('.tk-pakagelist-item').removeClass('tk-active');
                $('.fas fa-check').addClass('d-none');
                _this.addClass('tk-active');
                _this.find('i').removeClass('d-none');
                let plan_id = _this.data('plan_id');
                Livewire.emit('updatedPlanId', plan_id);
            });

            $('.tk-additionalservicesvtwo .tk-form-checkbox .form-check-input').change(function() {
                if ($(this).prop("checked")) {
                    $(this).parents("li").addClass("tk-active");
                }else{
                    $(this).parents("li").removeClass("tk-active");
                }
                let addon_ids = [];
                $(".tk-additionalservicesvtwo .tk-form-checkbox input[type='checkbox']:checked").each(function(){
                    addon_ids.push(this.value); 
                });

                Livewire.emit('gigCartAddonsIds', addon_ids);
            });
        }, 1000);
    </script>
@endpush('scripts')  




