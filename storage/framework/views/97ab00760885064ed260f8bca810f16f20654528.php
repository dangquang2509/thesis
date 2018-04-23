<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="description" content="">
    <?php echo $__env->yieldContent('meta'); ?>
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Head CSS -->
    
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/ionicons.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/jquery.fancybox.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/jquery.bxslider.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/select2.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/user/style.css'); ?>">
    <script type="text/javascript" src="<?php echo asset('resource/js/user/jquery-3.2.1.min.js'); ?>"></script>
    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('header'); ?>

    <!-- Content  START -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- Content END -->

    <?php echo $__env->make('layout-user.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/jquery.SmoothScroll.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/select2.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/bootbox.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/jquery.fancybox.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/jquery.bxslider.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/owl.carousel.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('resource/js/user/script.js'); ?>"></script>
    <?php echo $__env->yieldContent('js'); ?>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</html>

