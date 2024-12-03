<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($voucherService->name); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>



    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
                <div class="card  shadow">
                    <div class="card-body">
                        <h4 class="card-title">`<?php echo app('translator')->get(@optional($voucherService->voucher)->details->name); ?>
                            ` <?php echo app('translator')->get('Services'); ?></h4>


                        <div class="list-group ">
                            <?php if($voucherService->voucher): ?>
                                <?php $__currentLoopData = optional($voucherService->voucher)->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('admin.gameVoucher.serviceCode',[$data->id])); ?>"
                                       class="list-group-item  d-flex justify-content-between <?php if($voucherService->name == $data->name): ?> active <?php endif; ?>"
                                       title="<?php echo e($data->name); ?>"
                                    >
                                        <?php echo e(Str::limit($data->name,30)); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <a href="javascript:void(0)"
                                   class="list-group-item "><?php echo app('translator')->get('No Data Found'); ?></a>
                            <?php endif; ?>
                        </div>


                    </div>
                </div>


                <div class="card shadow my-3">
                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <h3 class="card-title"><?php echo app('translator')->get('Bulk Upload'); ?></h3>
                            <a href="<?php echo e(route('admin.VouchersampleFiles')); ?>" class="btn btn-sm btn-success btn-rounded"><i class="fa fa-download"></i> <?php echo app('translator')->get('Sample'); ?></a>
                        </div>

                        <form action="<?php echo e(route('admin.uploadBulkVoucherCode')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="serviceId"><?php echo app('translator')->get('Service'); ?></label>
                                <select name="serviceId" id="serviceId" class="form-control">
                                    <option value="" selected disabled><?php echo app('translator')->get('Select a Service'); ?></option>
                                    <?php if($voucherService->voucher): ?>
                                        <?php $__currentLoopData = optional($voucherService->voucher)->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($data->id); ?>" <?php if($serviceId == $data->id): ?> selected <?php endif; ?>><?php echo app('translator')->get($data->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                        <label class="custom-file-label" for="inputGroupFile01"></label>
                                    </div>
                                </div>

                                <span class="text-secondary"><?php echo app('translator')->get('Upload your .csv file'); ?></span>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo app('translator')->get('Upload'); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card  shadow">

                    <div class="card-body">


                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button class="btn btn-sm btn-primary mr-2" type="button" data-toggle="modal"
                                        data-target="#add_code"><i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add Code'); ?>
                                </button>


                            </div>


                            <div class="dropdown mb-2 text-right">


                                <button class="btn btn-sm  btn-dark dropdown-toggle" type="button"
                                        id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span><i class="fas fa-bars pr-2"></i> <?php echo app('translator')->get('Action'); ?></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item" type="button" data-toggle="modal"
                                            data-target="#all_active"><?php echo app('translator')->get('Active'); ?></button>
                                    <button class="dropdown-item" type="button" data-toggle="modal"
                                            data-target="#all_inactive"><?php echo app('translator')->get('Inactive'); ?></button>
                                    <button class="dropdown-item" type="button" data-toggle="modal"
                                            data-target="#all_delete"><?php echo app('translator')->get('Delete'); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">
                                    <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                           id="check-all">
                                    <label for="check-all"></label>
                                </th>
                                <th scope="col"><?php echo app('translator')->get('No.'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Voucher'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Service'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Code'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $voucherServiceCode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" id="chk-<?php echo e($item->id); ?>"
                                               class="form-check-input row-tic tic-check" name="check"
                                               value="<?php echo e($item->id); ?>"
                                               data-id="<?php echo e($item->id); ?>">
                                        <label for="chk-<?php echo e($item->id); ?>"></label>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('No.'); ?>"><?php echo e(++$key); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Voucher'); ?>"><?php echo e($item->gameVoucher->name); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Voucher'); ?>"><?php echo e($item->voucherService->name); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Code'); ?>"><?php echo e($item->code); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                        <?php echo $item->statusMessage; ?>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Action'); ?>">

                                        <div class="dropdown show dropup">
                                            <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink"
                                               data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">


                                                <button class="dropdown-item edit-button" data-toggle="modal"

                                                        data-target="#edit_code"
                                                        data-route="<?php echo e(route('admin.voucherServiceCodeUpdate',$item->id)); ?>"
                                                        data-resource="<?php echo e($item); ?>"
                                                >
                                                    <i class="fa fa-edit text-warning pr-2"
                                                       aria-hidden="true"></i> <?php echo app('translator')->get('Edit'); ?>
                                                </button>


                                                <a class="dropdown-item deleteBtn notiflix-confirm" href="javascript:void(0)"
                                                   data-target="#delete-modal"
                                                   data-route="<?php echo e(route('admin.voucherServiceCodeDelete', $item->id)); ?>"
                                                   data-toggle="modal"
                                                >
                                                    <i class="fa fa-trash-alt text-danger pr-2"
                                                       aria-hidden="true"></i> <?php echo app('translator')->get('Delete'); ?>
                                                </a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-center" colspan="8"><?php echo app('translator')->get('No Data Found'); ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Add Delete Modal Start -->
    <div class="modal fade" id="all_delete" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Code Delete Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to Delete Code"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary delete-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Code Active Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to active the Services"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary active-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Code DeActive Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to Deactive the Services"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary inactive-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Code Modal Start -->
    <div class="modal fade" id="add_code" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add New Code'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <form action="<?php echo e(route('admin.voucherServiceCodeStore',[$voucherId,$serviceId])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">


                        <div class="addedField">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="code[]" class="form-control " type="text" value="" required
                                           placeholder="<?php echo e(trans('Code')); ?>">

                                    <span class="input-group-btn">
                                            <button class="btn btn-primary" id="generate" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span>
                        </button>
                        <button type="submit" class="btn btn-primary"><span><?php echo app('translator')->get('Add'); ?></span></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Code Modal End -->

    <!-- Edit Code Modal Start -->
    <div class="modal fade" id="edit_code" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Update Code'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <form action="" method="post" class="update-action">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="modal-body">


                        <div class="form-group">
                            <label for="name" class="font-weight-bold"> <?php echo app('translator')->get('Code'); ?> </label>
                            <input type="text" name="code"
                                   class="form-control edit-name"
                                   value="" required>

                            <?php $__errorArgs = ['code'];
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

                        <div class="form-group">

                            <label for="edit-status"> <?php echo app('translator')->get('status'); ?> </label>
                            <input
                                data-toggle="toggle" id="edit-status" data-onstyle="success"
                                data-offstyle="info" data-on="Active" data-off="Deactive"
                                data-width="100%"
                                type="checkbox" name="status">
                            <?php $__errorArgs = ['status'];
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


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span>
                        </button>
                        <button type="submit" class="btn btn-primary"><span><?php echo app('translator')->get('Update'); ?></span></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Code Modal End -->

    <!-- Delete Modal Start -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Delete Confirmation'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to delete this?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Delete Modal End -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/admin/css/dataTables.bootstrap4.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/admin/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/datatable-basic.init.js')); ?>"></script>
    <script>
        "use strict";

        $(document).ready(function (e) {

            $("#generate").on('click', function () {
                var form = `
                <div class="form-group">
                    <div class="input-group">
                        <input name="code[]" class="form-control " type="text" value="" required placeholder="<?php echo e(trans('Code')); ?>">

                        <span class="input-group-btn">
                            <button class="btn btn-danger delete_desc" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </span>
                    </div>
                </div>
            `;

                $('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.form-group').remove();
            });

            $(document).on('click', '.edit-button', function () {
                $('.update-action').attr('action', $(this).data('route'))
                var obj = $(this).data('resource');
                $('.edit-name').val(obj.code);

                if (obj.status == 1) {
                    $('#edit-status').bootstrapToggle('on')
                } else {
                    $('#edit-status').bootstrapToggle('off')
                }


            });

            $(document).on('click', '#check-all', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });

            //dropdown menu is not working
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });


            //multiple active
            $(document).on('click', '.active-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "<?php echo e(route('admin.voucherServiceCode.active')); ?>",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    },
                });
            });

            //multiple deactive
            $(document).on('click', '.inactive-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "<?php echo e(route('admin.voucherServiceCode.inactive')); ?>",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    }
                });
            });

            //multiple Delete
            $(document).on('click', '.delete-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "<?php echo e(route('admin.voucherServiceCode.delete')); ?>",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    }
                });
            });

            $(document).on('click', '.deleteBtn', function (e) {
                $('.deleteRoute').attr('action', $(this).data('route'))
            })

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gameemif/vouchersystem.gamebrio.store/resources/views/admin/game_voucher/codeList.blade.php ENDPATH**/ ?>