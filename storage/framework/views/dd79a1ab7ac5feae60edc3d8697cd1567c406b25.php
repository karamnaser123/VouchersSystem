<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($title); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- POLICY -->
    <section class="padding-x-120">
        <div class="container">


            <div class="row">
                <div class="col-md-12">
                    <div class="custom-card p-3 bg-gradient">

                        <?php echo app('translator')->get(@$description); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /POLICY -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme . 'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gameemif/vouchersystem.gamebrio.store/resources/views/themes/gameshop/getLink.blade.php ENDPATH**/ ?>