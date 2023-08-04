
    <?php $__env->startSection('content'); ?>
        <main class="tk-main-bg">
            <section class="tk-main-section tk-gigcheckout">
                <div class="preloader-outer d-none">
                    <div class="tk-preloader">
                        <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                    </div>
                </div>
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-xl-8">
                            <?php if( !empty($dispute_detail['disputed']) ): ?>
                                <div class="tk-notify <?php echo e($dispute_detail['dispute_class']); ?>">
                                    <div class="tk-notify_title">
                                        <figure>
                                            <img src="<?php echo e($dispute_detail['status_icon']); ?>"/>
                                        </figure>
                                        <div class="tk-notify-content">
                                            <h5><?php echo e($dispute_detail['dispute_status_txt']); ?></h5>
                                            <p><?php echo e($dispute_detail['dispute_desc_txt']); ?></p>
                                        </div>
                                    </div>
                                    <div class="tk-btnholder">
                                        <?php if($dispute_detail['dispute_status'] == 'declined'): ?>
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                <a class="tk-redbtn"  href="<?php echo e(url('raise-admin-dispute',['id' => $dispute_detail['dispute_id']])); ?>" href="javascript:void(0)"><?php echo e(__('disputes.acknowledge_admin')); ?></a>
                                            <?php endif; ?>
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                <a class="tk-redbtn" href="<?php echo e(route('dispute-detail',['id' => $dispute_detail['dispute_id']])); ?>"><?php echo e(__('proposal.view_detail')); ?></a>
                                            <?php endif; ?>    
                                        <?php else: ?>
                                            <a class="tk-redbtn" href="<?php echo e(route('dispute-detail',['id' => $dispute_detail['dispute_id']])); ?>"><?php echo e(__('proposal.view_detail')); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="tk-gigactivitywrap <?php echo e(!empty($dispute_detail['disputed']) ? 'mt-4' : ''); ?>">
                                <div class="tk-checkoutinfo">
                                    <div class="tk-projectsstatus_name">
                                        <?php    
                                            $status =  getTag( $gig->gig_orders[0]->status);
                                        ?>
                                        <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span>
                                    </div>
                                    <div class="tk-checkoutdetail">
                                        <h6>
                                            <?php $__currentLoopData = $gig->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(route('search-gigs', ['category_id' => $single->category_id])); ?>">
                                                    <?php echo e($single->name); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </h6>
                                        <h5><?php echo $gig->title; ?></h5>
                                    </div>
                                    <div class="tb-extras tb-extrascompleted">
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                    <?php
                                                        if( !empty($gig->gigAuthor->image) ){
                                                            $image_path     = getProfileImageURL( $gig->gigAuthor->image, '80x80' );
               									            $seller_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-80x80.png';
                                                        }else{
                                                            $seller_image = '/images/default-user-80x80.png';
                                                        }
                                                    ?>
                                                    <figure>
                                                        <img src="<?php echo e(asset($seller_image)); ?>" alt="<?php echo e($gig->gigAuthor->full_name); ?>" >
                                                    </figure>
                                                    <div class="tb-taskinfo">
                                                        <span><?php echo e(__('gig.gig_by')); ?></span>
                                                        <h6><?php echo e($gig->gigAuthor->full_name); ?></h6>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                    <?php
                                                        if( !empty($gig->gig_orders[0]->orderAuthor->image) ){
                                                            $image_path     = getProfileImageURL( $gig->gig_orders[0]->orderAuthor->image, '38x38' );
               									            $buyer_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                                        }else{
                                                            $buyer_image = '/images/default-user-38x38.png';
                                                        }
                                                    ?>  
                                                    <figure>
                                                    <img src="<?php echo e(asset($buyer_image)); ?>" alt="<?php echo e($gig->gig_orders[0]->orderAuthor->full_name); ?>" >
                                                    </figure>
                                                    <div class="tb-taskinfo">
                                                        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                            <span><?php echo e(__('gig.order_by')); ?></span>
                                                            <h6><?php echo e($gig->gig_orders[0]->orderAuthor->full_name); ?></h6>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.deadline')); ?></span>
                                                    <h6><?php echo e(date('M d, Y', strtotime('+'.$gig->gig_orders[0]->gig_delivery_days.'days', strtotime($gig->gig_orders[0]->gig_start_time)))); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.plan_type')); ?></span>
                                                    <h6><?php echo e($gig->gig_orders[0]->plan_type); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.order_id')); ?></span>
                                                    <h6>#<a href="#" target="_blank"><?php echo e($gig->gig_orders[0]->id); ?></a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if( !empty($gig->gig_orders[0]->gig_addons) ): ?>
                                    <?php
                                        $addons =  unserialize($gig->gig_orders[0]->gig_addons);
                                    ?>      
                                    <div class="tk-box">
                                        <div class="tk-boxtittle">
                                            <h4><?php echo e(__('gig.additional_service')); ?></h4>
                                        </div>
                                        <ul class="tk-additionalservices tk-additionalservicesvtwo">
                                            <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="tk-form-checkbox gig-addons">
                                                        <label class="tk-additionolinfo" for="addon-<?php echo e($single['id']); ?>">
                                                            <span><?php echo e($single['title']); ?></span>
                                                            <em><?php echo $single['description']; ?> </em>
                                                        </label>
                                                        <div class="tk-addcartinfoprice">
                                                            <h6><?php echo e(getPriceFormat($currency_symbol, $single['price'])); ?></h6>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="tk-giguploadfile">
                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('gig.gig-activity-conversation', ['gigId' => $gig->id,'gigAuthorId' => $gig->author_id,'orderAuthorId' => $gig->gig_orders[0]->author_id,'orderId' => $gig->gig_orders[0]->id,'gig_id' => $gig->id,'gig_author_id' => $gig->author_id,'order_author_id' => $gig->gig_orders[0]->author_id,'order_id' => $gig->gig_orders[0]->id])->html();
} elseif ($_instance->childHasBeenRendered('bXbNIpY')) {
    $componentId = $_instance->getRenderedChildComponentId('bXbNIpY');
    $componentTag = $_instance->getRenderedChildComponentTagName('bXbNIpY');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('bXbNIpY');
} else {
    $response = \Livewire\Livewire::mount('gig.gig-activity-conversation', ['gigId' => $gig->id,'gigAuthorId' => $gig->author_id,'orderAuthorId' => $gig->gig_orders[0]->author_id,'orderId' => $gig->gig_orders[0]->id,'gig_id' => $gig->id,'gig_author_id' => $gig->author_id,'order_author_id' => $gig->gig_orders[0]->author_id,'order_id' => $gig->gig_orders[0]->id]);
    $html = $response->html();
    $_instance->logRenderedChild('bXbNIpY', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                <?php if( $gig->gig_orders[0]->status == 'hired' ): ?>
                                    <?php
                                        $author_info = array(
                                            'gig_title'     => $gig->title,
                                            'gig_author'    => $gig->gigAuthor->full_name,
                                            'gig_user_id'   => $gig->gigAuthor->user_id,
                                            'order_author'  => $gig->gig_orders[0]->orderAuthor->full_name,
                                            'order_user_id' => $gig->gig_orders[0]->orderAuthor->user_id,
                                            'gig_slug'      => $slug,
                                        )
                                    ?>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('gig.gig-activity-conversation-form', ['gigId' => $gig->id,'gigAuthorId' => $gig->author_id,'orderAuthorId' => $gig->gig_orders[0]->author_id,'orderId' => $gig->gig_orders[0]->id,'authorInfo' => $author_info,'gig_id' => $gig->id,'gig_author_id' => $gig->author_id,'order_author_id' => $gig->gig_orders[0]->author_id,'order_id' => $gig->gig_orders[0]->id,'author_info' => $author_info])->html();
} elseif ($_instance->childHasBeenRendered('G6FiikK')) {
    $componentId = $_instance->getRenderedChildComponentId('G6FiikK');
    $componentTag = $_instance->getRenderedChildComponentTagName('G6FiikK');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('G6FiikK');
} else {
    $response = \Livewire\Livewire::mount('gig.gig-activity-conversation-form', ['gigId' => $gig->id,'gigAuthorId' => $gig->author_id,'orderAuthorId' => $gig->gig_orders[0]->author_id,'orderId' => $gig->gig_orders[0]->id,'authorInfo' => $author_info,'gig_id' => $gig->id,'gig_author_id' => $gig->author_id,'order_author_id' => $gig->gig_orders[0]->author_id,'order_id' => $gig->gig_orders[0]->id,'author_info' => $author_info]);
    $html = $response->html();
    $_instance->logRenderedChild('G6FiikK', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                <?php endif; ?>            
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <aside>
                                <div class="tk-asideholder">
                                    <div class='tk-asideboxsm'>
                                        <h5><?php echo e(__('gig.plan_detail')); ?></h5>
                                    </div>
                                    <div class="tk-collapsepanel">
                                        <ul class="tk-pakagelist">
                                            <li>
                                                <h6><?php echo e(__('checkout.gig_plan_type')); ?></h6>
                                                <span><?php echo e($gig->gig_orders[0]->plan_type); ?></span>
                                            </li>
                                            <li>
                                                <h6><?php echo e(__('checkout.gig_order_price')); ?></h6>
                                                <span><?php echo e(getPriceFormat($currency_symbol, $gig->gig_orders[0]->plan_amount)); ?></span>
                                            </li>
                                            <?php
                                                $total = $gig->gig_orders[0]->plan_amount;
                                            ?>
                                            <?php if( !empty($gig->gig_orders[0]->gig_addons) ): ?>
                                                <?php
                                                    $addons =  unserialize($gig->gig_orders[0]->gig_addons);
                                                ?> 
                                                <li class="tk-adservices">
                                                    <h6><?php echo e(__('checkout.gig_addons')); ?></h6>
                                                </li>
                                                <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <h6><?php echo e($single['title']); ?></h6>
                                                        <span><?php echo e(getPriceFormat($currency_symbol, $single['price'])); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                            <?php endif; ?>      
                                            <li class="tk-plantotalprice">
                                                <h5><?php echo e(__('checkout.total')); ?></h5>
                                                <span><?php echo e(getPriceFormat($currency_symbol, $gig->gig_orders[0]->plan_amount)); ?></span>
                                            </li>
                                            <?php if( $gig->gig_orders[0]->status == 'hired' ): ?>
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                    <li class="tk-planfooter">
                                                        <label class="tk-label"> <?php echo e(__('gig.update_order')); ?></label>
                                                        <span class="tk-select">
                                                            <select name="order_status" id="order_status">
                                                                <option value="complete"><?php echo e(__('gig.complete_order')); ?></option>         
                                                                <option value="dispute"><?php echo e(__('proposal.create_dispute')); ?></option>         
                                                            </select>
                                                        </span>
                                                        <a href="javascript:;" class="tk-btn update-order-status" ><?php echo e(__('general.update')); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                    <li class="tk-planfooter">
                                                        <a href="javascript:;" class="tk-btn create-dispute" ><?php echo e(__('proposal.create_dispute')); ?></a> 
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
                <?php if( $gig->gig_orders[0]->status == 'hired' ): ?>
                    <div class="modal fade tk-addonpopup" id="tk_add_review" tabindex="-1" role="dialog" aria-hidden="true">
                        <div  class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="tk-popuptitle">
                                    <h4> <?php echo e(__('project.add_review_heading')); ?> </h4>
                                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                                </div>

                                <div class="modal-body">
                                    <form class="tk-themeform" id="tb_update_review">
                                        <fieldset>
                                            <div class="alert alert-danger d-none"><ul></ul></div>
                                            <div class="form-group">
                                                <label class="tk-label tk-required"><?php echo e(__('project.rating_title')); ?></label>
                                                <input type="text" name="rating_title" id="rating_title" required class="form-control" placeholder="<?php echo e(__('project.rating_title')); ?>" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="tk-label tk-required"><?php echo e(__('project.seller_rating')); ?></label>
                                                <div class="tk-my-ratingholder">
                                                    <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                                        <li class='tk-star' data-value='1'>
                                                            <i class="fas fa-star"></i>
                                                        </li>
                                                        <li class='tk-star' data-value='2' >
                                                            <i class="fas fa-star"></i>
                                                        </li>
                                                        <li class='tk-star' data-value='3' >
                                                            <i class="fas fa-star"></i>
                                                        </li>
                                                        <li class='tk-star' data-value='4' >
                                                            <i class="fas fa-star"></i>
                                                        </li>
                                                        <li class='tk-star' data-value='5' >
                                                            <i class="fas fa-star"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="tk-label"><?php echo e(__('project.add_feedback')); ?></label>
                                                <textarea class="form-control" id="rating_desc" name="rating_desc" placeholder="<?php echo e(__('project.add_feedback')); ?>"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="tk-savebtn">
                                                    <a href="javascript:void(0);" class="tb-btn add_review">
                                                        <b class="d-none tx-sending"> <?php echo e(__('general.sending')); ?> </b>
                                                        <b class="tx-save"><?php echo e(__('project.save')); ?> </b>
                                                    </a>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal fade" id="dispute_popup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="tb-popuptitle">
                                <h4><?php echo e(__('disputes.create_refund_req')); ?></h4>
                                <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                            </div>
                            <div class="modal-body tk-popup-content">
                                <div class="dispute-validation-err alert alert-danger d-none"><ul></ul></div>
                                <form class="tk-themeform">
                                    <fieldset>
                                        <div class="form-group">
                                            <h5><?php echo e(__('disputes.choose_issue')); ?></h5>
                                            <div class="tk-disputelist">
                                                <?php if(!empty($disputeIssues)): ?>
                                                    <ul class="tk-categoriesfilter">
                                                        <?php $__currentLoopData = $disputeIssues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm" name="dispute_issue"  type="radio" id="distpute-issue-<?php echo e($key); ?>" value="<?php echo e($issue); ?>" >
                                                                    <label class="form-check-label" for="distpute-issue-<?php echo e($key); ?>"><span><?php echo e($issue); ?></span></label>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="tk-label"><?php echo e(__('disputes.add_dispute_detail')); ?></label>
                                            <textarea name="dispute_detail" id="dispute_detail" class="form-control" placeholder="<?php echo e(__('disputes.dispute_placeholder')); ?>"></textarea>
                                        
                                        </div>
                                        <div class="form-group">
                                            <div class="tk-termscondition">
                                                <div class="tk-checkterm">
                                                    <div class="tk-form-checkbox">
                                                        <input class="form-check-input tk-form-check-input-sm" name="agree_term_condtion" id="check-term-condition" value="1" type="checkbox">
                                                        <label for="check-term-condition"><span><?php echo e(__('disputes.accept_agreement')); ?></span></label>
                                                    </div>
                                                    <a href="javascript:void(0);"><?php echo __('disputes.terms_condition'); ?> </a>
                                                </div>
                                                <a href="javascript:void(0);" class="tb-btn creat-dispute-request">
                                                    <b class="d-none tx-sending"> <?php echo e(__('general.sending')); ?> </b>
                                                    <b class="tx-submit"><?php echo e(__('general.submit')); ?> </b>
                                                </a>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </section>   
        </main>
    <?php $__env->stopSection(); ?>

 <?php $__env->startPush('scripts'); ?> 
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script>
        window.onload = (event) => {
            jQuery(document).ready(function() {

                $('#order_status').select2(
                    { allowClear: true, minimumResultsForSearch: Infinity  }
                );

                $('.update-order-status').on('click', function() {
                let order_status = $('#order_status').val();
                    if( order_status == 'complete' ){
                        $('#tk_add_review').modal('show');
                    }else if(order_status == 'dispute'){
                        $('#dispute_popup').modal('show');
                    }
                });

                $('.create-dispute').on('click', function() {
                    $('#dispute_popup').modal('show');
                });
                
                let ratingValue = 0;
                $(document).on('click', '.tk_stars li', function(){
                    let _this       = $(this);
                    let onStar      = parseInt(_this.data('value'), 10) > 0 ? parseInt(_this.data('value'), 10) : 5;
                    let stars       = _this.parent().children('li.tk-star');

                    for (let i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('active');
                    }

                    for (let i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('active');
                    }
                    ratingValue = parseInt($('#tk_seller_ratings li.active').length, 10);
                });

                $('.add_review').on('click', function(e){
                    e.preventDefault();
                    let _this = $(this);
                    _this.css('pointer-events', 'none');
                    _this.find('.tx-sending').removeClass('d-none');
                    _this.find('.tx-save').addClass('d-none');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        url: "<?php echo e(url('/gig-order-complete')); ?>",
                        method: 'post',
                        data: {
                            title          : $('#rating_title').val(),
                            description    : $('#rating_desc').val(),
                            rating         : ratingValue,
                            order_id       : '<?php echo e($gig->gig_orders[0]->id); ?>',
                        },
                        success: function(data){
                            _this.find('.tx-sending').addClass('d-none');
                            _this.find('.tx-save').removeClass('d-none');
                            _this.removeAttr('style');
                            $('.alert-danger').addClass('d-none');
                            $('.alert-danger ul').html('');

                            if( data.validation_errors ){
                                $.each(data.validation_errors, function(key, value){
                                    $('.alert-danger').removeClass('d-none');
                                    $('.alert-danger ul').append('<li>'+value+'</li>');
                                });
                            }else if(data.error){
                                showAlert({
                                    message     : data.error.message,
                                    type        : data.error.type,
                                    title       : data.error.title        ? data.error.title : '' ,
                                    autoclose   : data.error.autoClose    ? data.error.autoClose : 2000,
                                    redirectUrl : data.error.redirectUrl  ? data.error.redirectUrl : ''
                                });
                            }else if( data.success ){
                                $('#tk_add_review').modal('hide');
                                showAlert({
                                    message     : data.success.message,
                                    type        : data.success.type,
                                    title       : data.success.title        ? data.success.title : '' ,
                                    autoclose   : data.success.autoClose    ? data.success.autoClose : 2000,
                                    redirectUrl : data.success.redirectUrl  ? data.success.redirectUrl : ''
                                });
                            }
                        }
                    });
                });

                $('.creat-dispute-request').on('click', function(e){
                
                    e.preventDefault();
                    let _this = $(this);
                    _this.css('pointer-events', 'none');
                    _this.find('.tx-sending').removeClass('d-none');
                    _this.find('.tx-submit').addClass('d-none');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    
                    $.ajax({
                    url: "<?php echo e(url('/gig-order-dispute')); ?>",
                    method: 'post',
                    data: {
                        dispute_issue   : $('input[name="dispute_issue"]:checked').val(),
                        term_conditions : $('input[name="agree_term_condtion"]:checked').val(),
                        dispute_detail  : $('#dispute_detail').val(),
                        order_id       : '<?php echo e($gig->gig_orders[0]->id); ?>',
                    },
                    success: function(data){
                            _this.find('.tx-sending').addClass('d-none');
                            _this.find('.tx-submit').removeClass('d-none');
                            _this.removeAttr('style');
                            $('.dispute-validation-err').addClass('d-none');
                            $('.dispute-validation-err ul').html('');

                            if( data.validation_errors ){
                                $.each(data.validation_errors, function(key, value){
                                    $('.dispute-validation-err').removeClass('d-none');
                                    $('.dispute-validation-err ul').append('<li>'+value+'</li>');
                                });
                            }else if(data.error){
                                showAlert({
                                    message     : data.error.message,
                                    type        : data.error.type,
                                    title       : data.error.title        ? data.error.title : '' ,
                                    autoclose   : data.error.autoClose    ? data.error.autoClose : 2000,
                                    redirectUrl : data.error.redirectUrl  ? data.error.redirectUrl : ''
                                });
                            }else if( data.success ){
                                $('#dispute_popup').modal('hide');
                                showAlert({
                                    message     : data.success.message,
                                    type        : data.success.type,
                                    title       : data.success.title        ? data.success.title : '' ,
                                    autoclose   : data.success.autoClose    ? data.success.autoClose : 2000,
                                    redirectUrl : data.success.redirectUrl  ? data.success.redirectUrl : ''
                                });
                            }
                        }
                    });
                });
            });
        }
    </script>
 <?php $__env->stopPush(); ?>   





<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/gig/gig-activity.blade.php ENDPATH**/ ?>