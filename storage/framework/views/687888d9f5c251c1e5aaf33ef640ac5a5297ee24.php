
<?php $__env->startSection('content'); ?>
    <section class="tk-scetiondb">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-12">
                    <div class="tk-seller-counter">
                        <ul class="tk-seller-counter-list" id="tk-counter-two">
                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                <li>
                                    <div class="tk-counter-contant">
                                        <div class="tk-counter-icon-button">
                                            <div class="tk-icon-blue">
                                                <i class="icon-navigation"></i>
                                            </div>
                                            <div class="tk-counter-button">
                                                <a href="<?php echo e(route('project-listing')); ?>" target="_blank" class="tk-counter-button-active"><?php echo e(__('general.view')); ?></a>
                                            </div>
                                        </div>
                                        <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($posted_project); ?>"></span></h3>
                                        <strong><?php echo e(__('general.posted_projects')); ?></strong>
                                        <div class="tk-icon-watermark">
                                            <i class="icon-navigation"></i>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li>
                                <div class="tk-counter-contant">
                                    <div class="tk-counter-icon-button">
                                        <div class="tk-icon-green">
                                            <i class="icon-check-square"></i>
                                        </div>
                                        <div class="tk-counter-button">
                                            <a href="<?php echo e(route('project-listing', ['status' => 'completed'])); ?>" target="_blank" class="tk-counter-button-active"><?php echo e(__('general.view')); ?></a>
                                        </div>
                                    </div>
                                    <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($completed_projects); ?>"></span></h3>
                                    <strong><?php echo e(__('general.completed_projects')); ?></strong>
                                    <div class="tk-icon-watermark">
                                        <i class="icon-check-square"></i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tk-counter-contant">
                                    <div class="tk-counter-icon-button">
                                        <div class="tk-icon-yellow">
                                            <i class="icon-watch"></i>
                                        </div>
                                        <div class="tk-counter-button">
                                            <a class="tk-counter-button-active" target="_blank" href="<?php echo e(route('project-listing', ['status' => 'hired'])); ?>"><?php echo e(__('general.view')); ?></a>
                                        </div>
                                    </div>
                                    <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($ongoing_projects); ?>"></span></h3>
                                    <strong><?php echo e(__('general.ongoing_projects')); ?></strong>
                                    <div class="tk-icon-watermark">
                                        <i class="icon-watch"></i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tk-counter-contant">
                                    <div class="tk-counter-icon-button">
                                        <div class="tk-icon-red">
                                            <i class="icon-x-square"></i>
                                        </div>
                                        <div class="tk-counter-button">
                                            <a class="tk-counter-button-active" target="_blank" href="<?php echo e(route('project-listing', ['status' => 'cancelled'])); ?>"><?php echo e(__('general.view')); ?></a>
                                        </div>
                                    </div>
                                    <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($cancelled_projects); ?>"></span></h3>
                                    <strong><?php echo e(__('general.cancelled_projects')); ?></strong>
                                    <div class="tk-icon-watermark">
                                        <i class="icon-x-square"></i>
                                    </div>
                                </div>
                            </li>
                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                <li>
                                    <div class="tk-counter-contant">
                                        <div class="tk-counter-icon-button">
                                            <div class="tk-icon-purple">
                                                <i class="icon-briefcase"></i>
                                            </div>
                                            <div class="tk-counter-button">
                                                <a class="tk-counter-button-active" target="_blank" href="<?php echo e(route('gig-orders', ['status' => 'completed'])); ?>"><?php echo e(__('general.view')); ?></a>
                                            </div>
                                        </div>
                                        <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($sold_gigs); ?>"></span></h3>
                                        <strong><?php echo e(__('general.gigs_sold')); ?> </strong>
                                        <div class="tk-icon-watermark">
                                            <i class="icon-briefcase"></i>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li>
                                <div class="tk-counter-contant">
                                    <div class="tk-counter-icon-button">
                                        <div class="tk-icon-orange">
                                            <i class="icon-clock"></i>
                                        </div>
                                        <div class="tk-counter-button">
                                            <a class="tk-counter-button-active" target="_blank" href="<?php echo e(route('gig-orders', ['status' => 'hired'])); ?>"><?php echo e(__('general.view')); ?></a>
                                        </div>
                                    </div>
                                    <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($ongoing_gigs); ?>"></span></h3>
                                    <strong><?php echo e(__('general.ongoing_gigs')); ?></strong>
                                    <div class="tk-icon-watermark">
                                        <i class="icon-clock"></i>
                                    </div>
                                </div>
                            </li>
                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                <li>
                                    <div class="tk-counter-contant">
                                        <div class="tk-counter-icon-button">
                                            <div class="tk-icon-purple">
                                                <i class="icon-shopping-bag"></i>
                                            </div>
                                            <div class="tk-counter-button">
                                                <a class="tk-counter-button-active" target="_blank" href="<?php echo e(route('gig-orders')); ?>"><?php echo e(__('general.view')); ?></a>
                                            </div>
                                        </div>
                                        <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($buyed_gigs); ?>"></span></h3>
                                        <strong><?php echo e(__('general.buyed_gigs')); ?></strong>
                                        <div class="tk-icon-watermark">
                                            <i class="icon-shopping-bag"></i>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                <li>
                                    <div class="tk-counter-contant">
                                        <div class="tk-counter-icon-button">
                                            <div class="tk-icon-red">
                                                <i class="icon-x-octagon"></i>
                                            </div>
                                            <div class="tk-counter-button">
                                                <a class="tk-counter-button-active" target="_blank" href="<?php echo e(route('gig-orders', ['status' => 'cancelled'])); ?>"><?php echo e(__('general.view')); ?></a>
                                            </div>
                                        </div>
                                        <h3 class="tk-counter-value"><span class="counter-value" data-count="<?php echo e($cancelled_gigs); ?>"></span></h3>
                                        <strong><?php echo e(__('general.cancelled_gigs')); ?></strong>
                                        <div class="tk-icon-watermark">
                                            <i class="icon-x-octagon"></i>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="tk-seller-aside">
                        <ul class="tk-aside-list">
                            <li>
                                <div class="tk-list-detail">
                                    <div class="tk-list-name">
                                        <div class="tk-list-icon tk-list-icon-blue">
                                            <i class="icon-dollar-sign"></i>
                                        </div>
                                        <div class="tk-list-heading" id="total_earning">
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                <h5> <?php echo e($currency_symbol); ?><?php echo e(number_format($total_earning, 2)); ?></h5>
                                                <div class="tk-income-detail">
                                                    <p><?php echo e(__('transaction.total_earned_income')); ?></p>
                                                </div>
                                            <?php else: ?> 
                                                <h5><?php echo e($currency_symbol); ?><?php echo e(number_format($project_spend_amount, 2)); ?></h5>
                                                <div class="tk-income-detail">
                                                    <p><?php echo e(__('transaction.project_spent_amt')); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tk-list-detail tk-bglightgreen">
                                    <div class="tk-list-name">
                                        <div class="tk-list-icon tk-list-icon-green">
                                            <i class="icon-pocket"></i>
                                        </div>
                                        <div class="tk-list-heading" id="withdraw_amount">
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                <h5><?php echo e($currency_symbol); ?><?php echo e(number_format($withdraw_amount, 2)); ?></h5>
                                                <div class="tk-income-detail">
                                                    <p><?php echo e(__('transaction.funds_withdraw')); ?></p>
                                                </div>
                                            <?php else: ?>
                                                <h5> <?php echo e($currency_symbol); ?><?php echo e(number_format($ongoing_amount, 2)); ?></h5>
                                                <div class="tk-income-detail">
                                                    <p><?php echo e(__('transaction.total_ongoing_order_amt')); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tk-list-detail tk-bglightred">
                                    <div class="tk-list-name">
                                        <div class="tk-list-icon tk-list-icon-red">
                                            <i class="icon-clock"></i>
                                        </div>
                                        <div class="tk-list-heading" id="pending_income">
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                <h5><?php echo e($currency_symbol); ?><?php echo e(number_format($pending_income, 2)); ?></h5>
                                                <div class="tk-income-detail">
                                                    <p><?php echo e(__('transaction.onging_orders_amount')); ?></p>
                                                </div>
                                            <?php else: ?> 
                                                <h5><?php echo e($currency_symbol); ?><?php echo e(number_format($gig_spend_amount, 2)); ?></h5>
                                                <div class="tk-income-detail">
                                                    <p><?php echo e(__('transaction.gig_spend_amt')); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tk-list-detail tk-bglightwheat">
                                    <div class="tk-list-name">
                                        <div class="tk-list-icon tk-list-icon-yellow">
                                            <i class="icon-briefcase"></i>
                                        </div>
                                        <div class="tk-list-heading" id="available_balance">
                                            <h5><?php echo e($currency_symbol); ?><?php echo e(number_format($available_balance, 2)); ?></h5>
                                            <div class="tk-income-detail">
                                                <p><?php echo e(__('transaction.funds_in_wallet')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 gy-4">
                    <div class="tk-seller-graph">
                        <div class="tb-dhb-mainheading tk-emptyheading">
                            <div class="tb-tabfiltertitle">
                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                    <h5><?php echo e(__('transaction.earning_detail')); ?></h5>
                                <?php else: ?> 
                                    <h5><?php echo e(__('transaction.spend_amount_detail')); ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tk-themeschart">
                            <canvas id="canvaschart" class="tb-linechart"></canvas>
                        </div>
                    </div>
                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('earnings.payouts-history', ['profileId' => $profile_id,'profile_id' => $profile_id,'currency' => $currency_symbol])->html();
} elseif ($_instance->childHasBeenRendered('XFNFQuy')) {
    $componentId = $_instance->getRenderedChildComponentId('XFNFQuy');
    $componentTag = $_instance->getRenderedChildComponentTagName('XFNFQuy');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('XFNFQuy');
} else {
    $response = \Livewire\Livewire::mount('earnings.payouts-history', ['profileId' => $profile_id,'profile_id' => $profile_id,'currency' => $currency_symbol]);
    $html = $response->html();
    $_instance->logRenderedChild('XFNFQuy', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php else: ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('earnings.invoices', ['className' => 'tk-dbinvoice'])->html();
} elseif ($_instance->childHasBeenRendered('K2Cdtwo')) {
    $componentId = $_instance->getRenderedChildComponentId('K2Cdtwo');
    $componentTag = $_instance->getRenderedChildComponentTagName('K2Cdtwo');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('K2Cdtwo');
} else {
    $response = \Livewire\Livewire::mount('earnings.invoices', ['className' => 'tk-dbinvoice']);
    $html = $response->html();
    $_instance->logRenderedChild('K2Cdtwo', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 gy-4">
                    <?php if( ( $method_type == 'escrow' && $user_role == 'buyer' ) || $user_role == 'seller'): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.seller-payout-methods', ['profileId' => $profile_id,'profile_id' => $profile_id,'currency' => $currency_symbol])->html();
} elseif ($_instance->childHasBeenRendered('lAZw1xS')) {
    $componentId = $_instance->getRenderedChildComponentId('lAZw1xS');
    $componentTag = $_instance->getRenderedChildComponentTagName('lAZw1xS');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lAZw1xS');
} else {
    $response = \Livewire\Livewire::mount('components.seller-payout-methods', ['profileId' => $profile_id,'profile_id' => $profile_id,'currency' => $currency_symbol]);
    $html = $response->html();
    $_instance->logRenderedChild('lAZw1xS', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <div class="tk-advertisment-area">
                        <?php echo $adsense_code; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('js/vendor/chart.min.js')); ?>"></script>
<script>
    window.onload = (event) => {
        jQuery(document).ready(function() {
            var transaction_rec = window.transaction_values;
            function loadChart(labels, price_range){
                let chartColors = {
                    white: '#fff',
                    red: 'rgb(255, 99, 132)',
                    orange: 'rgb(255, 159, 64)',
                    yellow: 'rgb(255, 205, 86)',
                    green: 'rgb(75, 192, 192)',
                    blue: 'rgb(54, 162, 235)',
                    purple: 'rgb(153, 102, 255)',
                    grey: 'rgb(201, 203, 207)',
                    lightgrey: 'rgb(247 ,249, 255 , 0.4)',
                    dark_blue: '#3377FF',
                    
                };
                // Earning graph
                let earning_chart = document.getElementById("canvaschart");
                if (earning_chart !== null) {

                    let type    = 'linear';
                    let config  = {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {}, 
                                {
                                    pointBackgroundColor: chartColors.dark_blue,
                                    backgroundColor: chartColors.lightgrey,
                                    borderColor: chartColors.dark_blue,
                                    borderWidth: 1,
                                    fill: true,
                                    data: price_range,
                                }
                            ]
                        },
                        options: {
                            legend: false,
                            responsive: true,
                            maintainAspectRatio: true,
                            tittle:false,
                            position: "nearest",
                            tooltips: {
                                // Disable the on-canvas tooltip
                                enabled: false,
                                custom: function(tooltipModel) {
                                    // Tooltip Element
                                    var tooltipEl = document.getElementById('chartjs-tooltip');
                                    // Create element on first render
                                    if (!tooltipEl) {
                                        tooltipEl = document.createElement('div');
                                        tooltipEl.id = 'chartjs-tooltip';
                                        tooltipEl.innerHTML = '<table class="tb-tooltiptable"></table>';
                                        document.body.appendChild(tooltipEl);
                                    }
                                    // Hide if no tooltip
                                    if (tooltipModel.opacity === 0) {
                                        tooltipEl.style.opacity = 0;
                                        return;
                                    }
                                    // Set caret Position
                                    tooltipEl.classList.remove('above', 'below', 'no-transform');
                                    if (tooltipModel.yAlign) {
                                        tooltipEl.classList.add(tooltipModel.yAlign);
                                    } else {
                                        tooltipEl.classList.add('no-transform');
                                    }

                                    function getBody(bodyItem) {
                                        return bodyItem.lines;
                                    }

                                    // Set Text
                                    if (tooltipModel.body) {
                                        var titleLines = tooltipModel.title || [];
                                        var bodyLines = tooltipModel.body.map(getBody);
                                        var innerHtml = '<thead>';
                                        titleLines.forEach(function(title) {
                                            
                                            let rec = transaction_rec[Number(title)] !== undefined ? transaction_rec[ Number(title)] : [];
                                            innerHtml += '</thead><tbody>';
                                            bodyLines.forEach(function(body, i) {
                                                var colors = tooltipModel.labelColors[i];
                                                var style = 'background:' + "#fff";
                                                style += '; border-color:' + colors.borderColor;
                                                style += '; border-width: 0';
                                                var span = '<span style="' + style + '"></span>';
                                                if( window.user_role == 'buyer' ){
                                                    if( rec['gig'] != undefined || rec['project'] != undefined ){
                                                        if(rec['gig'] !== undefined){
                                                            innerHtml += '<tr class="tb-toolsummeryinfo"><td>' + '<?php echo e(__("transaction.gig_label")); ?>'+ " <?php echo e($currency_symbol); ?>" + rec['gig'] +'</td></tr>';
                                                        }
                                                        if( rec['project'] !== undefined){
                                                            innerHtml += '<tr class="tb-toolsummeryinfo"><td>' + '<?php echo e(__("transaction.project_label")); ?>'+ " <?php echo e($currency_symbol); ?>" + rec['project'] +'</td></tr>';
                                                        }
                                                    } else {
                                                        innerHtml += '<tr class="tb-toolsummeryinfo"><td>' + '<?php echo e(__("transaction.spend_amount")); ?>'+ " <?php echo e($currency_symbol); ?>" + body +'</td></tr>';
                                                    }
                                                } else if( window.user_role == 'seller' ){
                                                    innerHtml += '<tr class="tb-toolsummeryinfo"><td>' + '<?php echo e(__("transaction.earning_label")); ?>'+ " <?php echo e($currency_symbol); ?>" + body +'</td></tr>';
                                                }
                                            });
                                            innerHtml += '</tbody>';
                                            var tableRoot = tooltipEl.querySelector('table');
                                            tableRoot.innerHTML = innerHtml;
                                        });
                                    }
                                    // `this` will be the overall tooltip
                                    var position = this._chart.canvas.getBoundingClientRect();
                                    // Display, position, and set styles for font
                                    tooltipEl.style.opacity = 1;
                                    tooltipEl.style.position = 'absolute';
                                    tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                                    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                                    tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
                                    tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
                                    tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
                                    tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                                    tooltipEl.style.pointerEvents = 'none';
                                    tooltipEl.style.background = '#fff';
                                },
                            },
                            plugins: {
                                filler: {
                                    propagate: false,
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.2
                                },
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                }],
                                yAxes: [{
                                    display: true,
                                    type: type,
                                }]
                            }
                        }
                    };

                    let ctx = document.getElementById('canvaschart').getContext('2d');
                    window.myLine = new Chart(ctx, config);
                };
            }

            let labels      = "<?php echo e(implode(',', $date_intervals)); ?>";
            let price_range = "<?php echo e(implode(',', $price_intervals)); ?>";

            loadChart(labels.split(','), price_range.split(','));
            
            window.addEventListener('accountBalance', event => {
                let balanceInfo = event.detail;
                $('#total_earning h5').text(balanceInfo.total_earning);
                $('#available_balance h5').text(balanceInfo.available_balance);
                $('#withdraw_amount h5').text(balanceInfo.withdraw_amount);
                $('#pending_income h5').text(balanceInfo.pending_income);
            });
            initCounter();
        });

        function initCounter(){
            if( $('#tk-counter-two').length){
                let counted = 0;
                let oTop    = jQuery('.tk-counter-value').offset().top - window.innerHeight;
                if ( counted == 0 && jQuery(window).scrollTop() > oTop) {
                    jQuery('.counter-value').each(function() {
                        let _this       = jQuery(this);
                        let count_data  = _this.attr('data-count');
                        jQuery({ countNum: _this.text() })
                        .animate({
                            countNum: count_data
                        },{
                            duration: 500,
                            easing: 'swing',
                            step: function() {
                                _this.text(numberFormate(Math.floor(this.countNum)));
                            },
                            complete: function() {
                                _this.text(numberFormate(this.countNum));
                            }
                        });
                    });
                    counted = 1;
                }
            }
        }

        function numberFormate(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app',['include_menu' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/dashboard/dashboard.blade.php ENDPATH**/ ?>