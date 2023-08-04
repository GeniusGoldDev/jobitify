
<section @if(!$site_view)  wire:click="$emit('getBlockSetting', '{{$block_key}}')" @endif class="tk-main-section-two tk-main-sectionv2 tk-categoriessection {{ $block_key }} {{$custom_class}}">
    @if( !empty($style_css) )
        <style>{{ '.'.$block_key.$style_css }}</style>
    @endif
    <div  class="container" wire:loading.class="tk-section-preloader">
        @if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            @if(!empty($title) || !empty($sub_title) || !empty($description))
                <div class="col-lg-10 col-xl-8">
                    <div class="tk-title-centerv2">
                        @if(!empty($title) || !empty($sub_title))
                            <div class="tk-maintitlev2">
                                @if(!empty($title))<span>{!! $title !!}</span> @endif
                                @if(!empty($sub_title))<h2>{!! $sub_title !!}</h2> @endif
                            </div>
                        @endif
                        @if(!empty($description))
                            <div class="tk-main-description">
                                <p>{!! $description !!}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if( !empty($categories) && !$categories->isEmpty() )
                <div class="col-lg-12">
                    <div class="tk-category_list">
                        <ul>
                            @foreach( $categories as $single )
                                <li class="tk-category_item">
                                    @php  
                                        $image_url  = 'images/default-img-306x200.png'; 
                                        if ( !empty($single->image) ){
                                            $image = @unserialize($single->image);
                                            if( $image == 'b:0;' || $image !== false ){
                                                $file_path      = $image['file_path'];
                                                $image_sizes    = !empty($image['sizes']) ? $image['sizes'] : null;
                                                $image_url      = !empty($image_sizes['306x200']) ? 'storage/'.$image_sizes['306x200'] : 'storage/'.$file_path;
                                            }
                                        }
                                    @endphp
                                 

                                    <figure class="tk-category_img">
                                        <img data-src="{{asset($image_url)}}" alt="{{$single->name}}" @if(!$site_view) src="{{asset($image_url)}}" @endif >
                                    </figure>
                                    <div class="tk-category_info">
                                        <h5><a href="javascript:;">{!! $single->name !!}</a></h5>
                                    </div>
                                    @if( !$single->children->isEmpty() )
                                        <ul class="tk-category_childlist">
                                            @foreach( $single->children as $child )
                                                <li>
                                                    <a href="{{ route('search-projects', ['category' => $child->slug])}}" target="_blank">
                                                        <span>{!! $child->name !!}</span>
                                                        <em>({{ $child->children_count }})</em>
                                                        <i class="icon-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="tk-explore-features">
                                                <strong>
                                                    <a href="{{ route('search-projects', ['category' => $single->slug])}}" target="_blank">{{ __('pages.explore_all')}}</a>
                                                </strong>
                                            </li>
                                        </ul>
                                    @endif 
                                </li>
                            @endforeach
                        </ul>
                        @if(!empty($explore_btn_txt))
                            <div class="tk-btn2-wrapper">
                                <a href="{{ route('search-projects')}}" target="_blank" class="tk-btn-solid-lg tk-btn-yellow">{{ $explore_btn_txt}} <i class="icon icon-grid"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
   