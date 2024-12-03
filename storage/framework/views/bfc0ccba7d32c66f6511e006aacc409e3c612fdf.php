<?php $__env->startSection('title',__($page_title)); ?>

<?php $__env->startSection('content'); ?>

        <div class="container login-section">
            <div class="row justify-content-center bg-gradient">
                <div class="col-md-12">
                    <div class="contact-box mt-3 mx-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-3"><?php echo app('translator')->get($page_title); ?></h4>

                            <a href="<?php echo e(route('user.ticket.create')); ?>" class="btn btn-success btn-sm"> <i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Create Ticket'); ?></a>
                        </div>

                            <div class="table-responsive">
                                <table class="table table-bordered transection__table mt-5" id="service-table">
                                    <thead class="">
                                    <tr>
                                        <th scope="col"><?php echo app('translator')->get('Subject'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Last Reply'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo app('translator')->get('Subject'); ?>">
                                                    <span
                                                        class="font-weight-bold"> [<?php echo e(trans('Ticket#').$ticket->ticket); ?>

                                                        ] <?php echo e($ticket->subject); ?> </span>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                                <?php if($ticket->status == 0): ?>
                                                    <span
                                                        class="badge rounded-pill bg-success"><?php echo app('translator')->get('Open'); ?></span>
                                                <?php elseif($ticket->status == 1): ?>
                                                    <span
                                                        class="badge rounded-pill bg-primary"><?php echo app('translator')->get('Answered'); ?></span>
                                                <?php elseif($ticket->status == 2): ?>
                                                    <span
                                                        class="badge rounded-pill bg-warning"><?php echo app('translator')->get('Replied'); ?></span>
                                                <?php elseif($ticket->status == 3): ?>
                                                    <span class="badge rounded-pill bg-dark"><?php echo app('translator')->get('Closed'); ?></span>
                                                <?php endif; ?>
                                            </td>

                                            <td data-label="<?php echo app('translator')->get('Last Reply'); ?>">
                                                <?php echo e(diffForHumans($ticket->last_reply)); ?>

                                            </td>

                                            <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                                <a href="<?php echo e(route('user.ticket.view', $ticket->ticket)); ?>"
                                                   class="btn btn-sm btn-custom"
                                                   data-toggle="tooltip" title="" data-original-title="Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
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

                            <?php echo e($tickets->appends($_GET)->links($theme.'partials.pagination')); ?>


                    </div>

                </div>

            </div>
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gameemif/vouchersystem.gamebrio.store/resources/views/themes/gameshop/user/support/index.blade.php ENDPATH**/ ?>