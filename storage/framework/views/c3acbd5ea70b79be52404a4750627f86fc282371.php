
<?php $__env->startSection('title', trans('Product Details')); ?>

<?php $__env->startSection('content'); ?>

    <!-- DETAILS SECTION -->
    <section class="details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 pe-lg-5 mb-5 mb-md-0">
                    <div class="img-box">
                        <img class="img-fluid" src="<?php echo e(getFile(config('location.category.path') . @$topUpDetails->image)); ?>"
                            alt="..." />
                    </div>
                    <div class="text-box">
                        <h4><?php echo app('translator')->get(@$topUpDetails->details->name); ?></h4>
                        <p>
                            <?php echo app('translator')->get(@$topUpDetails->details->details); ?>
                        </p>
                        <?php if($topUpDetails->playStoreLink): ?>
                            <a href="<?php echo e($topUpDetails->playStoreLink); ?>">
                                <img class="img-fluid" src="<?php echo e(asset($themeTrue) . '/images/google.png'); ?>"
                                    alt="..." />
                            </a>
                        <?php endif; ?>
                        
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <form action="<?php echo e(route('user.topUp.payment')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if($topUpDetails->form_field): ?>
                            <!-- PLAYER ID -->
                            <div class="order-box">
                                <h5><?php echo app('translator')->get('Enter Information'); ?></h5>
                                <div class="input-box d-flex">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <?php $__currentLoopData = $topUpDetails->form_field; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($v->type == 'text'): ?>
                                                <div>
                                                    <input name="<?php echo e($k); ?>" type="text" class="form-control"
                                                        value="<?php echo e(old($k)); ?>"
                                                        placeholder="<?php echo e(trans($v->field_level)); ?>"
                                                        <?php if($v->validation == 'required'): ?> required <?php endif; ?> />

                                                    <?php if($errors->has($k)): ?>
                                                        <br><span class="text-danger"><?php echo e(trans($errors->first($k))); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif($v->type == 'textarea'): ?>
                                                <div>
                                                    <textarea name="<?php echo e($k); ?>" class="form-control" <?php if($v->validation == 'required'): ?> required <?php endif; ?>><?php echo e(old($k)); ?></textarea>
                                                    <?php if($errors->has($k)): ?>
                                                        <span class="text-danger"><?php echo e(trans($errors->first($k))); ?></span>
                                                    <?php endif; ?>

                                                </div>
                                            <?php elseif($v->type == 'file'): ?>
                                                <div>
                                                    <input name="<?php echo e($k); ?>" type="file" class="form-control"
                                                        placeholder="<?php echo e(trans($v->field_level)); ?>"
                                                        <?php if($v->validation == 'required'): ?> required <?php endif; ?> />
                                                    <?php if($errors->has($k)): ?>
                                                        <span class="text-danger"><?php echo e(trans($errors->first($k))); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </div>
                                    <?php if($topUpDetails->instruction_image): ?>
                                        <span class="info">
                                            <img class="info-icon" src="<?php echo e(asset($themeTrue) . '/images/icon/info.png'); ?>"
                                                alt="..." />
                                            <img class="hovered img-fluid"
                                                src="<?php echo e(getFile(config('location.category.path') . @$topUpDetails->instruction_image)); ?>"
                                                alt="..." />
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p>
                                    <?php echo app('translator')->get(@$topUpDetails->details->instruction); ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if($topUpDetails->activeServices): ?>
                            <div class="payment-box">
                                <div class="d-flex justify-content-between">
                                    <h5><?php echo app('translator')->get('SELECT RECHARGE'); ?></h5>
                                    <?php $__errorArgs = ['service'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="d-flex flex-wrap justify-content-start">
                                    <?php $__empty_1 = true; $__currentLoopData = $topUpDetails->activeServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="m-1 package-list ">
                                            <input type="radio" class="btn-check recharge-check" name="service" required
                                                id="option<?php echo e($item->id); ?>" autocomplete="off"
                                                value="<?php echo e($item->id); ?>"
                                                <?php if(old('service') == $item->id): ?> checked <?php endif; ?>
                                                data-price="<?php echo e($item->price); ?>" data-discount="">

                                            <label class="btn btn-primary" for="option<?php echo e($item->id); ?>">
                                                <?php echo e($item->name); ?>

                                                <img src="<?php echo e(asset($themeTrue) . '/images/icon/check.png'); ?>"
                                                    alt="..." class="check" />
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endif; ?>

                        

                        <div class="payment-box">
                            <div class="d-flex justify-content-between">
                                <h5><?php echo app('translator')->get('SELECT PAYMENT OPTION'); ?></h5>
                                <?php $__errorArgs = ['gateway'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="payment-options">
                                <div class="d-flex flex-wrap justify-content-start ">
                                    <div class="m-1 package-list gateway">
                                        <input type="radio" class="btn-check gateway-check" name="gateway" required
                                            id="gateway0" value="0" <?php if(old('gateway') == '0'): ?> checked <?php endif; ?>
                                            autocomplete="off" />
                                        <label class="btn btn-primary" for="gateway0">
                                            <img class="img-fluid"
                                                src="<?php echo e(asset($themeTrue . 'images/icon/wallet1.png')); ?>"
                                                alt="<?php echo e(config('basic.site_title')); ?>" />
                                            <img src="<?php echo e(asset($themeTrue . 'images/icon/check.png')); ?>" alt="..."
                                                class="check" /></label>
                                    </div>

                                    <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="m-1 package-list gateway">
                                            <input type="radio" class="btn-check gateway-check" name="gateway" required
                                                id="gateway<?php echo e($gateway->id); ?>" value="<?php echo e($gateway->id); ?>"
                                                <?php if(old('gateway') == $gateway->id): ?> checked <?php endif; ?> autocomplete="off" />
                                            <label class="btn btn-primary" for="gateway<?php echo e($gateway->id); ?>">
                                                <img class="img-fluid"
                                                    src="<?php echo e(getFile(config('location.gateway.path') . $gateway->image)); ?>"
                                                    alt="<?php echo e($gateway->name); ?>" />
                                                <img src="<?php echo e(asset($themeTrue . '/images/icon/check.png')); ?>"
                                                    alt="..." class="check" /></label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>
                        </div>

                        <div class="payment-box estimate-box">
                            <div class="payment-info">
                                <div id="loading" class="text-center">
                                    <img src="<?php echo e(asset('assets/admin/images/loading.gif')); ?>" alt="..."
                                        class="w-15" />
                                </div>


                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="game-btn-sm" type="submit">
                                    <img src="<?php echo e(asset($themeTrue . '/images/icon/credit-card.png')); ?>" alt=".." />
                                    <?php echo app('translator')->get('Buy now'); ?>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="package-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-5 mb-md-0">
                    <div class="description-box">
                        <div class="navigator">
                            <button class="navigate active" id="descriptionBtn">
                                <?php echo app('translator')->get('Description'); ?>
                            </button>
                            <button class="navigate" id="instructionBtn">
                                <?php echo app('translator')->get('Instruction'); ?>
                            </button>
                        </div>
                        <div id="description" class="mb-5">
                            <h4><?php echo app('translator')->get('Description Area'); ?></h4>
                            <p>
                                <?php echo app('translator')->get(@$topUpDetails->details->details); ?>
                            </p>
                        </div>
                        <div id="instruction" class="mb-5">
                            <h4><?php echo app('translator')->get('Instruction'); ?></h4>
                            <p>
                                <?php echo app('translator')->get(@$topUpDetails->details->instruction); ?>
                            </p>
                            <img class="img-fluid mb-4"
                                src="<?php echo e(getFile(config('location.category.path') . @$topUpDetails->instruction_image)); ?>"
                                alt="..." />
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        'use strict';
        $('#loading').hide();

        var serviceId, gatewayId;

        $(document).on('click', '.recharge-check', function() {

            $('#loading').hide();
            $('.recharge-check').attr('checked', false);
            $(this).attr('checked', true);
            serviceId = $(this).val();
            checkCalc(serviceId, gatewayId);
        });


        $(document).on('click', '.gateway-check', function() {

            $('#loading').hide();
            $('.gateway-check').attr('checked', false);
            $(this).attr('checked', true);
            gatewayId = $(this).val();
            checkCalc(serviceId, gatewayId);
        });

        function checkCalc(serviceId, gatewayId) {
            if (serviceId == undefined || gatewayId == undefined) {
                return 0;
            }
            $('#loading').show();
            $.ajax({
                url: "<?php echo e(route('ajaxCheckTopUpCalc')); ?>",
                type: 'POST',
                data: {
                    serviceId,
                    gatewayId
                },
                success(data) {

                    var htmlData = `
                    <h5><?php echo app('translator')->get('PURCHASE'); ?></h5>
                                <ul>

                                    <li>
                                        <?php echo app('translator')->get('Subtotal'); ?>:
                                        <span>${data.subtotal}</span>
                                    </li>

                                    <li>
                                        <?php echo app('translator')->get('Discount'); ?>:
                                        <span>${data.discount}</span>
                                    </li>

                                    <li>
                                        <?php echo app('translator')->get('Payable'); ?>:
                                        <span>${data.payable}</span>
                                    </li>
                                    ${(data.isCrypto == false) ? `
                                                            <li class="text-center">
                                                                ${data.in}
                                                            </li>
                                                            ` : ``}


                                </ul>`;

                    $('.payment-info').html(htmlData)
                },
                complete: function() {
                    $('#loading').hide();
                },
                error(err) {
                    var errors = err.responseJSON;
                    for (var obj in errors) {
                        Notiflix.Notify.Failure(`${errors[obj]}`);
                    }

                }
            });
        }

        $(document).on('click', '.recharge-check', function() {
            var price = $(this).data('price');
            var discount = $(this).data('discount');
            console.log(discount);
        })

        $(document).on('click', '#instructionBtn', function() {
            $('#instruction').removeClass('d-none');
            $('#instruction').addClass('d-block');
            $('#description').addClass('d-none');

        })
        $(document).on('click', '#descriptionBtn', function() {
            $('#description').removeClass('d-none');
            $('#description').addClass('d-block');
            $('#instruction').addClass('d-none');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme . 'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gameemif/vouchersystem.gamebrio.store/resources/views/themes/gameshop/top-up-details.blade.php ENDPATH**/ ?>