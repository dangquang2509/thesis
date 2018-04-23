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
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/common.css'); ?>"/>

	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/top.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/datatables.min.css'); ?>"/>
	<?php echo $__env->yieldContent('css'); ?>
</head>
<body>
	<?php echo $__env->yieldContent('header'); ?>

	<!-- Content  START -->
	<div class="ot-container">
			<?php echo $__env->yieldContent('content'); ?>

			<?php echo $__env->make('layout.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</div>
	<!-- Content END -->

	<?php echo $__env->yieldContent('popup'); ?>

	<?php echo $__env->make('layout.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
	<script src="<?php echo asset('resource/js/lib/jquery-1.12.4.min.js'); ?>"></script>
	<script src="<?php echo asset('resource/js/lib/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo asset('resource/js/lib/datatables/datatables.min.js'); ?>"></script>
	<?php echo $__env->yieldContent('js'); ?>
	
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
</html>

