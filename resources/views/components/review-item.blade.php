@props(['single','date_format', 'hide'])
@php  
    $ratingPer = 0;
    if(!empty($single->rating)){
        $ratingPer = ($single->rating/5)*100;
    }

    if(!empty($single->buyerInfo->image)){
        $image_url      = getProfileImageURL($single->buyerInfo->image, '50x50');
        $buyer_image   = !empty($image_url) ? 'storage/'.$image_url : 'images/default-user-50x50.png';
    }else{
        $buyer_image   = 'images/default-user-50x50.png';
    }

@endphp

<div class="tk-reviewnew tk-review-sec {{$hide ? 'd-none' : ''}}">
    <div class="tk-reviewinfo">
        <figure>
            <img src="{{asset($buyer_image)}}" alt="Image Description">
        </figure>
        <div class="tk-reviwername">
            <h5>{{ $single->buyerInfo->fullName}}</h5>
            <div class="tk-featureratings">
                <span class="tk-featureRating__stars"><span style="width:{{$ratingPer}}%;"></span></span>
                <h6>{{number_format($single->rating,1)}}</h6>
            </div>
            <div class="tk-reviews-details">
                <ul class="tk-qualifinfo">
                    <li><span><i class="icon-calendar"></i> {{date($date_format, strtotime( $single->created_at ))}}</span></li>
                </ul>
            </div>
        </div>
    </div>
    @if(!empty($single->rating_description))
        <div class="tk-descriptions">
            <p>{{$single->rating_description}}</p>
        </div>
    @endif
</div>