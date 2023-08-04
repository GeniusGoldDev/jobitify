
@props(['data','enableEdit' => false])
@php 
    
    $portfolio_image      = 'images/default-img-285x216.png';
    if(!empty($data['attachments']) ){
        $files  = @unserialize($data['attachments']);
        if( $files == 'b:0;' || $files !== false ){
            $images = $files['files'];
            $latest = current($images);
            if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                if(!empty($latest->sizes['285x216'])){
                    $portfolio_image = 'storage/'.$latest->sizes['285x216'];
                } elseif(!empty($latest->file_path)){
                    $portfolio_image = 'storage/'.$latest->file_path;
                }
            }
        }
    }
@endphp
<div class="tk-potfolioitem">
    <figure>
        <img src="{{ asset($portfolio_image) }}"  alt="{{ $data['title'] }}">
    </figure>
    <div class="tk-portinfo">
        <a target="_blank" href="{{url($data['url'])}}">{{$data['url']}}</a>
        <h6>{{$data['title']}}</h6>
        @if(!empty($data['description']))
            <p>{!! nl2br($data['description']) !!}</p>
        @endif
    </div>
    @if($enableEdit)
        <div class="tk-detail__icon">
            <a href="javascript:void(0);" class="tk-edit" wire:click.stop="showPortfolioPopup({{$data['id']}})"><i class="icon-edit-2"></i></a>
            <a href="javascript:void(0);" class="tk-delete tk-delete-portfolio" data-id="{{$data['id']}}"><i class="icon-trash-2"></i></a>
        </div>
    @endif
</div>