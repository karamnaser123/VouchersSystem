<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/bootstrap.min.css')); ?>" />
    <?php echo $__env->yieldPushContent('css-lib'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/animate.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/owl.carousel.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/owl.theme.default.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/skitter.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/aos.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/ion.range-slider.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/style.css')); ?>" />
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body>
    <!-- prelaoder -->
    <div id="preloader" class="preloader">
        <div id="loader" class="wrapper-triangle">
            <div class="pen">
                <div class="line-triangle">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
                <div class="line-triangle">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
                <div class="line-triangle">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            

            <a class="navbar-brand" href="<?php echo e(url('/shop?sortByCategory=voucher')); ?>">
                <img style="width: 150px" src="<?php echo e(asset('storage/image/logo.png')); ?>" alt="Your Image Alt Text">
            </a>
            <?php if(auth()->guard()->check()): ?>
                <span class="navbar-text">
                    <?php echo $__env->make($theme . 'partials.pushNotify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <!-- user panel -->
                    <div class="user-panel">
                        <button class="user-icon">
                            <img src="<?php echo e(asset($themeTrue . '/images/icon/user2.png')); ?>" alt="..." />
                        </button>
                        <div class="user-drop-dropdown">
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('user.profile')); ?>"><img class="me-2"
                                            src="<?php echo e(asset($themeTrue . '/images/icon/editing.png')); ?>" alt="..." />
                                        <?php echo app('translator')->get('My Profile'); ?></a>
                                </li>

                                <li>
                                    <a href="<?php echo e(route('user.twostep.security')); ?>"><img class="me-2"
                                            src="<?php echo e(asset($themeTrue . '/images/icon/block.png')); ?>" alt="..." />
                                        <?php echo app('translator')->get('2FA Security'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.ticket.list')); ?>"><img class="me-2"
                                            src="<?php echo e(asset($themeTrue . '/images/icon/editing.png')); ?>" alt="..." />
                                        <?php echo app('translator')->get('Support Ticket'); ?></a>
                                </li>


                                <li>
                                    <a href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img
                                            class="me-2" src="<?php echo e(asset($themeTrue . '/images/icon/logout.png')); ?>"
                                            alt="..." />
                                        <?php echo app('translator')->get('Sign out'); ?></a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </span>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <img src="<?php echo e(asset($themeTrue . '/images/icon/menu.png')); ?>" alt="..." />
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(menuActive('home')); ?>" aria-current="page"
                            href="<?php echo e(url('shop?sortByCategory=voucher')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(menuActive('user.home')); ?>"
                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                    </li>


                    

                    <?php if(config('basic.top_up') || config('basic.voucher') || config('basic.gift_card') || config('basic.sell_post')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link <?php echo e(menuActive('user.topUpOrder')); ?> <?php echo e(menuActive('user.voucherOrder')); ?> <?php echo e(menuActive('user.giftCardOrder')); ?> <?php echo e(menuActive('user.sellPostOrder')); ?>

                        <?php echo e(menuActive('user.sellPostMyOffer')); ?> dropdown-toggle"
                                href="javascript:void(0)" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo app('translator')->get('My Orders'); ?>
                                <i class="fas fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if(config('basic.top_up')): ?>
                                    <li>
                                        <a class="dropdown-item <?php echo e(menuActive('user.topUpOrder')); ?>"
                                            href="<?php echo e(route('user.topUpOrder')); ?>"><?php echo app('translator')->get('Top Up'); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if(config('basic.voucher')): ?>
                                    <li>
                                        <a class="dropdown-item <?php echo e(menuActive('user.voucherOrder')); ?>"
                                            href="<?php echo e(route('user.voucherOrder')); ?>"><?php echo app('translator')->get('Voucher'); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(config('basic.gift_card')): ?>
                                    <li>
                                        <a class="dropdown-item <?php echo e(menuActive('user.giftCardOrder')); ?>"
                                            href="<?php echo e(route('user.giftCardOrder')); ?>"><?php echo app('translator')->get('Gift Card'); ?></a>
                                    </li>
                                <?php endif; ?>
                                
                                
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link <?php echo e(menuActive('user.transaction')); ?> <?php echo e(menuActive('user.fund-history')); ?> <?php echo e(menuActive('user.payout.history')); ?> dropdown-toggle"
                            href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php echo app('translator')->get('History'); ?>

                            <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                            <li>
                                <a class="dropdown-item <?php echo e(menuActive('user.transaction')); ?>"
                                    href="<?php echo e(route('user.transaction')); ?>"><?php echo app('translator')->get('Transaction'); ?></a>
                            </li>
                            

                        </ul>
                    </li>


                </ul>
            </div>
        </div>
    </nav>

    <?php echo $__env->make($theme . 'partials.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make($theme . 'partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('loadModal'); ?>
    <?php echo $__env->yieldPushContent('extra-content'); ?>

    <script src="<?php echo e(asset($themeTrue . 'js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/bootstrap.bundle.min.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('extra-js'); ?>

    <script src="<?php echo e(asset($themeTrue . 'js/fontawesome.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/jquery.waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/jquery.counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/jquery.easing.1.3.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/jquery.skitter.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/aos.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/ion.range-slider.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue . 'js/script.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/notiflix-aio-2.7.0.min.js')); ?>"></script>
    <?php echo $__env->make('plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make($theme . 'partials.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('script'); ?>


</body>

</html>
<?php /**PATH /home/gameemif/vouchersystem.gamebrio.store/resources/views/themes/gameshop/layouts/user.blade.php ENDPATH**/ ?>