<?php if($paginator->hasPages()): ?>
    <div class="tk-pagiantion-holder">
        <div class="tk-pagination">
            <ul>
                <?php if($paginator->onFirstPage()): ?>    
                    <li class="d-none">
                        <span class="icon-chevron-left"></span>
                    </li>
                <?php else: ?>
                    <li class="tk-prevpage">
                        <a href="javascript:;" wire:click="previousPage('page')">
                            <i class="icon-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for($i = 1; $i <= $paginator->lastPage(); $i++): ?>
                    <li class="<?php echo e(($paginator->currentPage() == $i) ? ' active' : ''); ?>">
                        <?php if($paginator->currentPage() == $i): ?>
                            <span wire:key="paginator-page<?php echo e($i); ?>" wire:click="gotoPage(<?php echo e($i); ?>)"><?php echo e($i); ?></span>
                        <?php else: ?>
                            <a href="javascript:;" wire:key="paginator-page<?php echo e($i); ?>" wire:click="gotoPage(<?php echo e($i); ?>)"><?php echo e($i); ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>
            
                <?php if($paginator->hasMorePages()): ?>    
                    <li class="tk-nextpage">
                        <a href="javascript:;" wire:click="nextPage('page')">
                            <i class="icon-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="d-none" >
                        <span class="icon-chevron-right"></span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/pagination/custom.blade.php ENDPATH**/ ?>