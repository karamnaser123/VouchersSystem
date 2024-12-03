
<?php $__env->startSection('title', trans('Dashboard')); ?>
<?php $__env->startSection('content'); ?>
    <div class="dashboard-section ">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard__card dashboard__card-1">
                        <div class="dashboard__card-content">
                            <h2 class="price"><sup><?php echo e(config('basic.currency_symbol')); ?></sup><?php echo e(auth()->user()->balance); ?>

                            </h2>
                            <p class="info"><?php echo app('translator')->get('Wallet Balance'); ?></p>
                        </div>
                        <div class="dashboard__card-icon dashboard__card-icon-1">
                            <img src="<?php echo e(asset($themeTrue . 'images/icon2/1.png')); ?>" alt="...">
                        </div>
                    </div>
                </div>

                <?php if(config('basic.top_up')): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="dashboard__card dashboard__card-2">
                            <div class="dashboard__card-content">
                                <h2 class="price"><?php echo e($topUp); ?></h2>
                                <p class="info"><?php echo app('translator')->get('Top Up'); ?></p>
                            </div>
                            <div class="dashboard__card-icon dashboard__card-icon-2">
                                <img src="<?php echo e(asset($themeTrue . 'images/icon2/2.png')); ?>" alt="...">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(config('basic.voucher')): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="dashboard__card dashboard__card-3">
                            <div class="dashboard__card-content">
                                <h2 class="price"><?php echo e($voucher); ?></h2>
                                <p class="info"><?php echo app('translator')->get('Voucher'); ?></p>
                            </div>
                            <div class="dashboard__card-icon dashboard__card-icon-3">
                                <img src="<?php echo e(asset($themeTrue . 'images/icon2/3.png')); ?>" alt="...">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(config('basic.gift_card')): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="dashboard__card dashboard__card-4">
                            <div class="dashboard__card-content">
                                <h2 class="price"><?php echo e($giftCard); ?></h2>
                                <p class="info"><?php echo app('translator')->get('Gift Card'); ?></p>
                            </div>
                            <div class="dashboard__card-icon dashboard__card-icon-4">
                                <img src="<?php echo e(asset($themeTrue . 'images/icon2/4.png')); ?>" alt="...">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(config('basic.sell_post')): ?>
                    
                    

                    
                    

                    

                    
                <?php endif; ?>

                

                

            </div>


            <?php if(0 < count($paymentLog)): ?>
                <?php if(config('basic.sell_post')): ?>
                    <div class="row justify-content-between bg-gradient mt-5">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered transection__table mt-2" id="service-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th><?php echo app('translator')->get('SL No.'); ?></th>
                                            <th><?php echo app('translator')->get('Sell Post'); ?></th>
                                            <th><?php echo app('translator')->get('Amount'); ?></th>
                                            <th><?php echo app('translator')->get('Status'); ?></th>
                                            <th><?php echo app('translator')->get('Released At'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $paymentLog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td data-label="<?php echo app('translator')->get('SL No.'); ?>"><?php echo e(++$key); ?></td>
                                                <td data-label="<?php echo app('translator')->get('Sell Post'); ?>"><?php echo e($item->title); ?></td>
                                                <td data-label="<?php echo app('translator')->get('Amount'); ?>"><?php echo e(config('basic.currency_symbol')); ?>

                                                    <?php echo e(getAmount($item->sellPostPayment->price)); ?></td>
                                                <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                                    <?php if($item->sellPostPayment->status == 3): ?>
                                                        <span class="badge bg-warning"><?php echo app('translator')->get('Pending'); ?></span>
                                                    <?php else: ?>
                                                        <?php if($item->sellPostPayment->payment_release == 1): ?>
                                                            <span class="badge bg-success"><?php echo app('translator')->get('Released'); ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary"><?php echo app('translator')->get('Upcoming'); ?></span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="<?php echo app('translator')->get('Released At'); ?>">
                                                    <?php if($item->sellPostPayment->status == 3): ?>
                                                        -
                                                    <?php else: ?>
                                                        <?php if($item->sellPostPayment->payment_release == 1): ?>
                                                            <?php echo e(Carbon\Carbon::parse($item->released_at)->format('d M, Y H:i')); ?>

                                                        <?php elseif($item->sellPostPayment->payment_release == 0): ?>
                                                            <?php echo e(Carbon\Carbon::parse($item->created_at)->addDays(config('basic.payment_released'))->format('d M, Y H:i')); ?>

                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                            <tr class="text-center">
                                                <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="row justify-content-between bg-gradient mt-5">
                    <div class="col-md-12">
                        <div class="mt-4">
                            <h5><?php echo app('translator')->get('Last 5 Transactions'); ?></h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered transection__table mt-2" id="service-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th><?php echo app('translator')->get('SL No.'); ?></th>
                                        <th><?php echo app('translator')->get('Transaction ID'); ?></th>
                                        <th><?php echo app('translator')->get('Amount'); ?></th>
                                        <th><?php echo app('translator')->get('Remarks'); ?></th>
                                        <th><?php echo app('translator')->get('Time'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo app('translator')->get('SL No.'); ?>"><?php echo e(++$key); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Transaction ID'); ?>"><?php echo app('translator')->get($transaction->trx_id); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Amount'); ?>">
                                                <span
                                                    class="font-weight-bold text-<?php echo e($transaction->trx_type == '+' ? trans('success') : trans('danger')); ?>"><?php echo e($transaction->trx_type == '+' ? '+' : '-'); ?><?php echo e(getAmount($transaction->amount, config('basic.fraction_number')) . ' ' . trans(config('basic.currency'))); ?></span>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Remarks'); ?>"> <?php echo app('translator')->get($transaction->remarks); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Time'); ?>">
                                                <?php echo e(dateTime($transaction->created_at, 'd M Y h:i A')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <tr class="text-center">
                                            <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme . 'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gameemif/vouchersystem.gamebrio.store/resources/views/themes/gameshop/user/dashboard.blade.php ENDPATH**/ ?>