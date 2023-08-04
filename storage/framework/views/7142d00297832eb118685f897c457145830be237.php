<main>
    <section class="tk-main-section tk-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box">
                            <div class="tk-servicedetailtitle">
                                <?php if($project->is_featured): ?>
                                    <span wire:ignore data-tippy-content="<?php echo e(__('settings.featured_project')); ?>" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                <?php endif; ?>
                                <h3><?php echo e($project->project_title); ?></h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )])); ?></span></li>
                                    <li><span><i class="icon-map-pin"></i> <?php echo e($project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name); ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <?php
                                $video_url = '';
                                $files = '';
                                if(!empty($project->attachments)){
                                    $attachments = unserialize($project->attachments);
                                    if(!empty($attachments['video_url'])){
                                        $video_url = $attachments['video_url'];
                                    }
                                    if(!empty($attachments['files'])){
                                        $files = $attachments['files'];
                                    }
                                }
                            ?>
                            <?php if($video_url != ''): ?>
                                <div class="tk-project-holder">
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
                                </div>
                            <?php endif; ?>
                            <?php if($project->project_description !=''): ?>
                                <div class="tk-project-holder">
                                    <div class="tk-project-title">
                                        <h4><?php echo e(__('project.pro_desc')); ?></h4>
                                    </div>
                                    <div class="tk-jobdescription">
                                        <div class="tk-project-holder tk-project-description">
                                            <div class="tk-jobdescription">
                                                <?php echo json_decode($project->project_description); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(!$project->skills->isEmpty()): ?>
                                <div class="tk-project-holder">
                                    <div class="tk-project-title">
                                        <h4> <?php echo e(__('project.skills_required')); ?> </h4>
                                    </div>
                                    <div class="tk-blogtags tk-skillstags">
                                        <ul class="tk-tags_links">
                                            <?php $__currentLoopData = $project->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <span class="tk-blog-tags"><?php echo $single->name; ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty($files) && Auth::user() ): ?>
                                <div class="tk-project-holder">
                                    <div class="tk-betaversion-wrap">
                                        <div class="tk-betaversion-info">
                                            <h5><?php echo e(__('project.attachments_available')); ?> </h5>
                                            <p><?php echo e(__('project.attachments_available_txt',['buyer_name'=> $project->projectAuthor->full_name])); ?> </p>
                                        </div>
                                        <div class="tk-downloadbtn">
                                            <a href="javascript:;" wire:click.prevent="downloadAttachments('<?php echo e($project->id); ?>')" class="tk-btn-solid-lefticon"><?php echo e(__('project.download_files')); ?> <i class="icon-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">
                    <aside>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box tk-projectprice">
                                <div class="tk-sidebar-title">
                                    <span class="tk-project-tag <?php echo e($project->project_type == 'fixed' ? 'tk-ongoing-updated' :  'tk-success-tag-updated'); ?>"><?php echo e($project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></span>
                                    <h3><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h3>
                                    <?php if($project->project_type == 'hourly'): ?><em><?php echo e(__('project.estimated_hours', ['max_hours' => $project->project_max_hours, 'type' => $project->project_payment_mode])); ?></em><?php endif; ?>
                                </div>
                                          
                                <div class="tk-sidebarpkg__btn">
                                    <?php if( $userRole != 'buyer' && ( $edit_proposal || !$proposal_submitted ) ): ?>
                                        <a href="<?php echo e(route('submit-proposal', ['slug' => $project->slug] )); ?>" class="tk-btn-solid-lg"> <?php echo e($edit_proposal ?  __('proposal.edit_proposal')  : __('project.apply_to_project')); ?> </a>
                                    <?php endif; ?>
                                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>  
                                        <a href="javascript:void(0)" wire:click.prevent="saveProject(<?php echo e($project->id); ?>)" class="<?php echo e($save_project ? 'tk-btnline tk-liked tk-saved' : 'tk-btnline tk-save'); ?> "> 
                                            <i class="icon-heart"></i>
                                            <span><?php echo e($save_project ? __('general.saved') : __('project.add_to_save')); ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                   
                               
                            </div>
                            <div class="tk-project-box">
                                <div class="tk-sidebar-title">
                                    <h5><?php echo e(__('project.project_requirements')); ?> </h5>
                                </div>
                                <ul class="tk-project-requirement tk-projectdetail-req">
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <div class="tk-project-requirement_content">
                                            <em><?php echo e(__('project.project_category')); ?></em>
                                            <div class="tk-requirement-tags">
                                                <span><?php echo e(!empty($project->category) ? $project->category->name : ''); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="icon-users"></i>
                                        <div class="tk-project-requirement_content">
                                            <em> <?php echo e(__('project.hiring_capacity')); ?> </em>
                                            <div class="tk-requirement-tags">
                                                <span><?php echo e($project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php if( $project->project_type == 'hourly' ): ?>
                                        <li>
                                            <i class="icon-dollar-sign"></i>
                                            <div class="tk-project-requirement_content">
                                                <em> <?php echo e(__('project.payment_mode')); ?> </em>
                                                <div class="tk-requirement-tags">
                                                    <span><?php echo e(ucfirst($project->project_payment_mode)); ?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(!empty($project->expertiseLevel)): ?>
                                        <li>
                                            <i class="icon-briefcase"></i>
                                            <div class="tk-project-requirement_content">
                                                <em><?php echo e(__('project.expert_level')); ?></em>
                                                <div class="tk-requirement-tags">
                                                    <span><?php echo e($project->expertiseLevel->name); ?></span>
                                                </div>
                                            </div>
                                        </li> 
                                    <?php endif; ?>
                                    <?php if(!$project->languages->isEmpty()): ?>
                                        <li>
                                            <i class="icon-book-open"></i>
                                            <div class="tk-project-requirement_content">
                                                <em><?php echo e(__('project.languages')); ?> </em>
                                                <div class="tk-requirement-tags">
                                                    <?php $__currentLoopData = $project->languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span><?php echo $single->name; ?></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <div class="tk-project-requirement_content">
                                            <em><?php echo e(__('project.project_duration')); ?></em>
                                            <div class="tk-requirement-tags">
                                                <span><?php echo e(!empty($project->projectDuration) ? $project->projectDuration->name : ''); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php if($project->type == 'hourly' && !project->projectPaymentMode->isEmpty()): ?>
                                        <li>
                                            <i class="icon-clock"></i>
                                            <div class="tk-project-requirement_content">
                                                <em><?php echo e(__('project.payment_mode')); ?></em>
                                                <div class="tk-requirement-tags">
                                                    <span><?php echo e($project->projectPaymentMode->name); ?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-verified-title">
                                    <div class="tk-projectinfo_title">
                                        <?php
                                            if(!empty($project->projectAuthor->image)){
                                                $image_path     = getProfileImageURL($project->projectAuthor->image, '50x50');
                                                $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';
                                            }else{
                                                $author_image = 'images/default-user-50x50.png';
                                            }
                                        ?>
                                        <img src="<?php echo e(asset($author_image)); ?>" alt="<?php echo e($project->projectAuthor->full_name); ?>">
                                        <div class="tk-verified-info">
                                            <h5> <?php echo e($project->projectAuthor->full_name); ?> 
                                                <?php if($project->projectAuthor->user->userAccountSetting->verification == 'approved'): ?>
                                                    <i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="<?php echo e(__('general.verified_user')); ?>" ></i>
                                                <?php endif; ?>
                                            </h5>
                                            <em> <?php echo e(__('project.member_since',['date' => date( $date_format, strtotime($project->projectAuthor->created_at))])); ?></em>
                                        </div>
                                    </div>
                                    <div class="tk-projectinfo_description">
                                        <?php if(!empty($project->projectAuthor->description)): ?><p><?php echo $project->projectAuthor->description; ?></p><?php endif; ?>
                                    </div>
                                </div>
                                <ul class="tk-checkout-info">
                                    <?php if(!empty($project->projectAuthor->address)): ?>    
                                        <li>
                                            <div class="tk-total-title">
                                                <i class="icon-map-pin"></i>
                                                <em><?php echo e(__('project.located_in')); ?> </em>
                                            </div>
                                            <span><?php echo e(getUserAddress($project->projectAuthor->address, $address_format)); ?></span>
                                        </li>
                                    <?php endif; ?>    
                                    <li>
                                        <div class="tk-total-title">
                                            <i class="icon-bookmark"></i>
                                            <em><?php echo e(__('project.total_posted_projects')); ?></em>
                                        </div>
                                        <span><?php echo e($posted_projects); ?></span>
                                    </li>
                                    <li>
                                        <div class="tk-total-title">
                                            <i class="icon-clock"></i>
                                            <em><?php echo e(__('project.hired_projects')); ?></em>
                                        </div>
                                        <span><?php echo e($hired_projects); ?></span>
                                    </li>
                                </ul>
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
            <div class="row">
                <?php if(!$related_projects->isEmpty()): ?>
                    <div class="col-lg-12">
                        <div class="tk-relatedproject_title">
                            <h3><?php echo e(__('project.project_you_like')); ?> </h3>
                        </div>
                    </div>
                    <?php $__currentLoopData = $related_projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
                        <div class="col-lg-6 col-xl-4">
                            <div class="tk-project-wrapper tk-otherproject">
                                <?php if(!empty($single->is_featured)): ?>
                                    <span wire:ignore data-tippy-content="<?php echo e(__('settings.featured_project')); ?>" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                <?php endif; ?>
                                <span class="tk-project-tag-two <?php echo e($single->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated'); ?>"><?php echo e($single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></span>

                                <div class="tk-project-box">
                                    <div class="tk-verified-info">
                                        <a href="javascript:void(0)">
                                            <?php echo e($single->projectAuthor->full_name); ?>

                                            <?php if($single->projectAuthor->user->userAccountSetting->verification == 'approved'): ?>
                                                <i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="<?php echo e(__('general.verified_user')); ?>" ></i>
                                            <?php endif; ?>
                                        </a>
                                        <h5><a href="<?php echo e(route('project-detail', ['slug'=> $single->slug] )); ?>"><?php echo e($single->project_title); ?></a></h5>
                                    </div>
                                    <ul class="tk-projectinfo-list">
                                        <li><i class="icon-calendar"></i> <?php echo e(getTimeDiff( $single->updated_at )); ?></li>
                                        <li><i class="icon-map-pin"></i> <?php echo e($single->projectLocation->id == 3 ? (!empty($single->address) ? getUserAddress($single->address, $address_format) : $single->project_country ) : $single->projectLocation->name); ?></li>
                                        <?php if(!empty($single->expertiseLevel)): ?><li><i class="icon-briefcase"></i><?php echo e($single->expertiseLevel->name); ?></li><?php endif; ?>
                                        <li><i class="icon-users"></i> <?php echo e($single->project_hiring_seller .' '. ($single->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></li>
                                    </ul>
                                    <div class="tk-project-price">
                                        <h6><?php echo e(__('project.project_budget')); ?></h6>
                                        <h4><?php echo e(getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price)); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                <?php endif; ?>      
            </div>
        </div>
    </section>
</main>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/popper-core.js')); ?>"></script> 
    <script defer src="<?php echo e(asset('common/js/tippy.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            let tb_tippy = document.querySelector(".tippy");
                if (tb_tippy !== null) {
                    tippy(".tippy", {
                        animation: "scale",
                    });
                }
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-detail.blade.php ENDPATH**/ ?>