
<?php $__env->startSection('content'); ?>
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tk-serviesbann">
                            <div class="tk-serviesbann__content">
                                <?php if($gig->is_featured): ?>
                                    <span data-tippy-content="<?php echo e(__('gig.featured_gig')); ?>" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                <?php endif; ?>
                                <div class="tk-contentleft">
                                    <h3><?php echo e($gig->title); ?></h3>
                                    <div class="tk-contenthasfig">
                                        <ul class="tk-blogviewdates tk-blogviewdatessm">
                                            <li>
                                                <?php 
                                                $perRating = 0;
                                                    if(!empty($gig->ratings_avg_rating)){
                                                        $perRating = ($gig->ratings_avg_rating/5)*100;
                                                    }
                                                ?>
                                                <span class="tk-featureRating__stars"><span style="width:<?php echo e($perRating); ?>%;"></span></span>
                                                <span><?php echo e(ratingFormat($gig->ratings_avg_rating)); ?> <em>/5.0</em> <em> <?php echo e(__('gig.user_review')); ?> </em></span>
                                            </li>
                                            <li>
                                                <span>
                                                    <i class="icon-shopping-cart"></i> 
                                                    <em>
                                                        <?php echo e($gig->order_count == 1 ? __('gig.gig_sale', ['count' => number_format($gig->order_count)]) : __('gig.gig_sales', ['count' => number_format($gig->order_count)])); ?></em> 
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    <i class="icon-eye"></i> 
                                                    <em>
                                                        <?php echo e($gig->gig_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($gig->gig_visits_count) ] )); ?>

                                                    </em> 
                                                </span>
                                            </li>
                                            <?php if( $user_role == 'buyer' || Auth::guest()): ?>
                                                <li>
                                                    <span class="tk-save-btn tk-fav-item <?php echo e($is_favourite_gig ? 'tk-favourite' : ''); ?>" data-type="gig">
                                                        <i class="icon-heart"></i> 
                                                        <em><?php echo e($is_favourite_gig ? __('general.saved') : __('general.save')); ?></em>
                                                    </span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $attachments = [];
                        $gig_images = null;
                        $video_url = '';
                        if(!empty($gig->attachments) ){
                            $files = unserialize($gig->attachments);
                            $video_url  = !empty($files['video_url']) ? $files['video_url'] : '';
                            $images     = $files['files'];
                            $gig_images = $images;
                        }
                    ?>
                    <div class="col-lg-7 col-xl-8">
                        <div class="tk-servicedetail tk-task-detail">
                            <?php if(!empty($gig_images) || !empty($video_url)): ?>
                                <div id="tk_splide" class="tk-sync splide tk_splide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <?php if(!empty($video_url)): ?>
                                                <li class="splide__slide">
                                                    <figure class="tk-sync__content">
                                                        <a class="tk-themegallery" data-vbtype="video" data-gall="gall" href="<?php echo e($video_url); ?>" data-autoplay="true">
                                                        <?php
                                                            $width		= 780;
                                                            $height		= 402;
                                                            $url 			= parse_url( $video_url );
                                                            $video_html		= '';
                                                            if ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com') {
                                                                $video_html	.= '<figure class="tk-projectdetail-img">';
                                                                $content_exp  = explode("/" , $video_url);
                                                                $content_vimo = array_pop($content_exp);
                                                                $video_html	.= '<iframe width="' . $width . '" height="' . $height  . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
                                                            ></iframe>';
                                                                $video_html	.= '</figure>';
                                                            } else if($url['host'] == 'youtu.be') {
                                                                $video_html	.= '<figure class="tk-projectdetail-img">';
                                                                $video_html	.= preg_replace(
                                                                    "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                                                                    "<iframe width='" . $width ."' height='" . $height  . "' src=\"//www.youtube.com/embed/$2\" frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
                                                                    $video_url
                                                                );
                                                                $video_html	.= '</figure>';
                                                            } else if($url['host'] == 'dai.ly') {
                                                                $path		= str_replace('/','',$url['path']);
                                                                $content	= str_replace('dai.ly','dailymotion.com/embed/video/',$video_url);
                                                                $video_html	.= '<figure class="tk-projectdetail-img">';
                                                                    $video_html	.= '<iframe width="' . $width . '" height="' . $height  . '" src="' . $content  . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                                                                $video_html	.= '</figure>';
                                                            }else {
                                                                $video_html	.= '<figure class="tk-projectdetail-img">';
                                                                $content = str_replace(array (
                                                                    'watch?v=' ,
                                                                    'http://www.dailymotion.com/' ) , array (
                                                                    'embed/' ,
                                                                    '//www.dailymotion.com/embed/' ) , $video_url);
                                                                $content	= str_replace('.com/video/','.com/embed/video/',$content);
                                                                $video_html	.= '<iframe width="' . $width . '" height="' . $height  . '" src="' . $content  . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                                                                $video_html	.= '</figure>';
                                                            }
                                                            
                                                        ?>
                                                            <?php if( !empty($video_html) ): ?>
                                                                <?php echo $video_html; ?> 
                                                            <?php endif; ?>    
                                                        </a>
                                                    </figure>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(!empty($gig_images)): ?>
                                                <?php $__currentLoopData = $gig_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $gig_image = 'images/default-img-814x400.png';
                                                        if( !empty($image) && substr($image->mime_type, 0, 5) == 'image'){
                                                            if(!empty($image->sizes['814x400'])){
                                                                $gig_image = 'storage/'.$image->sizes['814x400'];
                                                            } elseif(!empty($image->file_path)){
                                                                $gig_image = 'storage/'.$image->file_path;
                                                            }
                                                        }
                                                    ?>
                                                    <li class="splide__slide" id="image-<?php echo e($key); ?>">
                                                        <figure class="tk-sync__content">
                                                            <a class="tk-themegallery" data-gall="gall" href="<?php echo e(asset($gig_image)); ?>">
                                                                <img src="<?php echo e(asset($gig_image)); ?>" alt="Image Description">
                                                            </a>
                                                        </figure>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div id="tk_splidev2" class="tk-syncthumbnail splide tk_splidev-two">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <?php if(!empty($video_url)): ?>
                                                <li class="splide__slide">
                                                    <figure class="tk-syncthumbnail__content">
                                                        <img src="<?php echo e(asset('images/video_thumbnail.jpg')); ?>" alt="">
                                                    </figure>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(!empty($gig_images)): ?>
                                                <?php $__currentLoopData = $gig_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $gig_image = 'images/default-img-82x82.png';
                                                        if( !empty($image) && substr($image->mime_type, 0, 5) == 'image'){
                                                            if(!empty($image->sizes['82x82'])){
                                                                $gig_image = 'storage/'.$image->sizes['82x82'];
                                                            } elseif(!empty($image->file_path)){
                                                                $gig_image = 'storage/'.$image->file_path;
                                                            }
                                                        }
                                                    ?>
                                                    <li class="splide__slide">
                                                        <figure class="tk-syncthumbnail__content">
                                                            <img src="<?php echo e(asset($gig_image)); ?>" alt="">
                                                        </figure>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if(!empty($gig->description)): ?>
                                <div class="tk-text-wrapper">
                                    <div class="tk-main-title-holder">
                                        <div class="tk-main-description">
                                            <div class="tk-project-title">
                                                <h4><?php echo e(__('gig.gig_description')); ?></h4>
                                            </div>
                                            <?php echo json_decode($gig->description); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <?php if(!$gig->addons->isEmpty()): ?>
                                <div class="tk-addtionalservices-wrapper tk-addtionalservices-wrapper-two">
                                    <div class="tk-sectiontitle">
                                        <h4><?php echo e(__('gig.additional_service')); ?></h4>
                                    </div>
                                    <ul class="tk-additionalservices term-list" id="menu2">
                                        <?php $__currentLoopData = $gig->addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="term-item ">
                                                <div class="tk-additionalservices__content">
                                                    <div class="tk-additionalservices-title">
                                                        <h6><?php echo e($addon->title); ?></h6>
                                                        <p><?php echo e($addon->description); ?></p>
                                                    </div>
                                                    <div class="tk-additionalservice-price">
                                                        <h5><?php echo e(getPriceFormat($currency_symbol, $addon->price)); ?></h5>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if(!$gig->faqs->isEmpty()): ?>
                                <div class="tk-faq-acordian tk-faq-acordian-two">
                                    <div class="tk-sectiontitle">
                                        <h4><?php echo e(__('gig.ask_question_label')); ?></h4>
                                    </div>
                                    <div class="tk-acordian">
                                        <ul id="tk-accordion" class="tk-accordion">
                                            <?php $__currentLoopData = $gig->faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="tk-accordion_title collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#faq-<?php echo e($faq->id); ?>" aria-expanded="false">
                                                        <h6><?php echo e($faq->question); ?></h6>
                                                    </div>
                                                    <div class="collapse tk-task-collapse" id="faq-<?php echo e($faq->id); ?>" data-bs-parent="#tk-accordion">
                                                        <div class="tk-accordion_info">
                                                        <p><?php echo json_decode($faq->answer); ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty($gig->ratings) && $gig->ratings->count() > 0): ?>
                            <div class="tk-reviewvtwo">
                                <div class="tk-reviews_holder">
                                    <div class="tk-features-reviews">
                                        <div class="tk-box tk-comments-reviews">
                                            <div class="tk-sectiontitle">
                                                <div class="tk-featureRating">
                                                    <h4><?php echo e(__('general.client_reviews', ['count' => number_format($gig->ratings->count())])); ?></h4>
                                                    <h5>( </h5>
                                                    <span class="tk-featureRating__stars"><span style="width:<?php echo e($perRating); ?>%;"></span></span>
                                                    <h6> <?php echo e(__('general.overall_ratings',['count' => number_format($gig->ratings_avg_rating,1)] )); ?> )</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $__currentLoopData = $gig->ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $image      = '';
                                                $percentage = 0;

                                                if(!empty($rating->gig_orders->orderAuthor->image)){
                                                    $image_path = getProfileImageURL($rating->gig_orders->orderAuthor->image, '50x50');
                                                    $image      = !empty($image_path) ? asset('storage/' . $image_path) :  asset('images/default-user-50x50.png');
                                                }else{
                                                    $image      = asset('images/default-user-50x50.png');
                                                }

                                                if(!empty($rating->rating)){
                                                    $percentage = ($rating->rating/5)*100;
                                                }

                                            ?>
                                            <div class="tk-review-boxs">
                                                <figure>
                                                        <img src="<?php echo e(asset($image)); ?>">
                                                </figure>
                                                <div class="tk-featurerating-details">
                                                    <div class="tk-featureratings">
                                                        <span class="tk-featureRating__stars"><span style="width:<?php echo e($percentage); ?>%;"></span></span>
                                                        <h6><?php echo e(number_format($rating->rating,1)); ?></h6>
                                                        <span class="tk-reviews-time">
                                                             <?php echo e(__('general.posted_time',['diff_time'=> getTimeDiff( $rating->created_at )])); ?> 
                                                        </span>
                                                    </div>
                                                    <div class="tk-reviews-details">
                                                        <a href="javascript:;">
                                                            <h5><?php echo $rating->rating_title; ?></h5>
                                                            <div class="tk-descriptions">
                                                                <p><?php echo nl2br($rating->rating_description); ?></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <aside>
                            <?php if(!$gig->gig_plans->isEmpty()): ?>
                            <?php
                                $plan_images = ['images/plan-icon-basic.jpg', 'images/plan-icon-popular.jpg', 'images/plan-icon-premium.jpg'];
                            ?>
                            
                                <div class="tk-asideholder tk-sideholder">
                                    <div>
                                        <ul class="nav nav-tabs tk-sidebartabs__pkgtitle" id="myTab" role="tablist">
                                            <?php $__currentLoopData = $gig->gig_plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="nav-item tk-sideactive" role="presentation">
                                                    <a class="nav-link <?php echo e($key == 0 ? 'active' : ''); ?>" id="plan_<?php echo e($plan->id); ?>-tab" data-bs-toggle="tab" href="#plan_<?php echo e($plan->id); ?>" role="tab" aria-controls="plan_<?php echo e($plan->id); ?>" aria-selected="<?php echo e($key == 0 ? 'true' : 'false'); ?>"><?php echo e($plan->title); ?></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <?php $__currentLoopData = $gig->gig_plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="tab-pane fade <?php echo e($key == 0 ? 'show active' : ''); ?>" id="plan_<?php echo e($plan->id); ?>" role="tabpanel">
                                                    <div class="tk-sidebarpkg tk-sidebarpkg-two">
                                                        <div class="tk-sectiontitle">
                                                            <img src="<?php echo e(asset($plan_images[$key])); ?>" >
                                                            <div class="tk-packegeplan">
                                                                <h6><?php echo e($plan->title); ?></h6>
                                                                <h3 class="tk-theme-color"><?php echo e(getPriceFormat($currency_symbol, $plan->price)); ?></h3>
                                                            </div>
                                                            <?php if(!empty($plan->description)): ?> <p><?php echo e($plan->description); ?></p> <?php endif; ?>
                                                            <div class="tk-delivery-time">
                                                                <span class="tk-icon-box"><i class="icon-box"></i></span>
                                                                <h5><?php echo e(__('gig.delivery_time')); ?></h5>
                                                                <span class="tk-delivery-days"><?php echo e(!empty($plan->deliveryTime->name) ? $plan->deliveryTime->name : ''); ?></span>
                                                            </div>
                                                        </div>
                                                        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                        <div class="tk-sidebarpkg__btn">
                                                            <a href="<?php echo e(route('gig-cart',['slug' => $gig->slug, 'plan_id' => $plan->id ])); ?>" class="tk-btn-solid-lg"><?php echo e(__('gig.hire_for_gig')); ?> <i class="icon-arrow-right"></i></a>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="tk-asideholder">
                                <div class="tk-aboutseller">
                                    <div class="tk-seller-title">
                                        <h6><?php echo e(__('gig.about_seller')); ?></h6>
                                    </div>
                                    <div class="tb-seller_detail">
                                        <div class="tk-topservicetask__content">
                                            <div class="tb-freeprostatus">
                                                <figure>
                                                    <?php
                                                        $user_image = '';
                                                        if(!empty($gig->gigAuthor->image)){
                                                            $image_url    = getProfileImageURL($gig->gigAuthor->image, '80x80');
                                                            $user_image   = !empty($image_url) ? 'storage/'.$image_url : '/images/default-user-80x80.png';
                                                        }else{
                                                            $user_image   = 'images/default-user-80x80.png';
                                                        }
                                                    ?>
                                                    <img src="<?php echo e(asset($user_image)); ?>" alt="<?php echo e($gig->gigAuthor->full_name); ?>">
                                                
                                                </figure>
                                                <div class="tk-project-price tk-project-price-two">
                                                    <span><?php echo e(__('general.starting_from')); ?></span>
                                                        <h4><?php echo e(__('general.per_hour_rate', ['rate' => number_format($gig->gigAuthor->user->userAccountSetting->hourly_rate, 2), 'currency_symbol' => $currency_symbol])); ?></h4>
                                                </div>
                                            </div>
                                            <div class="tk-title-wrapper">
                                                <div class="tk-verified-info">
                                                    <strong>
                                                        <?php echo e($gig->gigAuthor->full_name); ?> 
                                                        <?php if($gig->gigAuthor->user->userAccountSetting->verification == 'approved'): ?>
                                                            <i data-tippy-content="<?php echo e(__('general.verified_user')); ?>" class="tippy icon-check-circle"></i> 
                                                        <?php endif; ?>
                                                    </strong>
                                                    <h5><a href="javascript:;"><?php echo $gig->gigAuthor->tagline; ?></a></h5>
                                                </div>
                                            </div>

                                            <ul class="tk-blogviewdates tk-blogviewdatesmd">
                                                <li>
                                                    <i class="fas fa-star tk-yellow"></i>
                                                    <em> <?php echo e(number_format($gig->gigAuthor->ratings_avg_rating)); ?> </em>
                                                    <span>( <?php echo e($gig->gigAuthor->profile_visits_count == 1 ? __('general.user_review') :  __('general.user_reviews', ['count' => number_format($gig->gigAuthor->ratings_count) ])); ?> )</span>
                                                </li>
                                                <li>
                                                    <span>
                                                        <i class="icon-eye"></i> 
                                                        <em>                                                        
                                                            <?php echo e($gig->gigAuthor->profile_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($gig->gigAuthor->profile_visits_count) ] )); ?>

                                                        </em> 
                                                    </span>
                                                </li>
                                            </ul>

                                            <div class="tk-btnviewpro">
                                                <a href="<?php echo e(route('seller-profile',['slug' => $gig->gigAuthor->slug ])); ?>" class="tk-btn-plain tk-btn-solid-lg"> <?php echo e(ucwords( __('proposal.view_profile') )); ?></a>
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                    <a href="javascript:void(0);" data-type="profile" class="tk-fav-item <?php echo e($is_favourite ? 'tk-favourite' : ''); ?>">
                                                        <i class="icon-heart"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($adsense_code)): ?>
                                <div class="tk-advertisment-area">
                                    <?php echo $adsense_code; ?>

                                </div>
                            <?php endif; ?>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
        <?php echo app('Illuminate\Foundation\Vite')([
            'public/pagebuilder/css/splide.min.css',
            'public/pagebuilder/css/venobox.min.css',
        ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/popper-core.js')); ?>"></script> 
    <script defer src="<?php echo e(asset('common/js/tippy.js')); ?>"></script>
    <script defer src="<?php echo e(asset('pagebuilder/js/splide.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('pagebuilder/js/venobox.min.js')); ?>"></script>
    <script>
        window.onload = (event) => {
        jQuery(document).ready(function() {
           
            // VenoBox Video Popup
            let venobox = document.querySelector(".tk-themegallery");
            if (venobox !== null) {
                jQuery(".tk-themegallery").venobox({
                    spinner : 'cube-grid',
                });
            }
            let isRTL = '<?php echo e($rtl); ?>';

            // Service detail sync slider
            var tk_splide = document.getElementById('tk_splide')
            if (tk_splide != null) {
                let settings = {
                    rewind: true,
                    fixedWidth: 70,
                    fixedHeight: 70,
                    isNavigation: true,
                    gap: 10,
                    pagination: false,
                    arrows: false,
                    focus: 'center',
                    updateOnMove: true,
                }
                if(isRTL == '1'){
                    settings['direction'] = 'rtl';
                }
                var secondarySlider = new Splide('#tk_splidev2', settings).mount();
                var primarySlider = new Splide('#tk_splide', {
                    type: 'fade',
                    pagination: false,
                    cover: true,
                })
                primarySlider.sync(secondarySlider).mount();
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $(document).on('click','.tk-fav-item', function(event){
                let _this = $(this);
                let type = _this.data('type');
                $.ajax({
                    type:'POST',
                    url:"<?php echo e(route('favourite-item')); ?>",
                    data:{ 
                        'seller_id'     : "<?php echo e($gig->gigAuthor->id); ?>",
                        'profile_slug'  : "<?php echo e($gig->gigAuthor->slug); ?>",
                        'gig_slug'      : "<?php echo e($gig->slug); ?>",
                        'type'          : type
                    },
                    success:function(response){
                        if(response.type == 'success'){
                            let isUpdate = response.data.isUpdate;
                            if(isUpdate){
                                if(type == 'gig'){
                                    $('.tk-fav-item').toggleClass('tk-favourite');
                                    let unsave = "<?php echo e(__('general.save')); ?>";
                                    let saved = "<?php echo e(__('general.saved')); ?>";
                                    if($('.tk-fav-item').hasClass('tk-favourite')){
                                        $('.tk-fav-item em').text(saved)
                                    } else {
                                        $('.tk-fav-item em').text(unsave)
                                    }
                                } else if ('profile'){
                                    $('.tk-fav-item').toggleClass('tk-favourite');
                                }
                            }
                        }else if(response.type == 'login_error'){
                            showAlert({
                                message     : response.data.message,
                                type        : 'error',
                                title       : response.data.title ,
                                autoclose   : 2000,
                                redirectUrl : ''
                            });
                        }
                    }
                });
            });
        });
    }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', ['title' =>$gig->title, 'include_menu' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/gig/gig-detail.blade.php ENDPATH**/ ?>