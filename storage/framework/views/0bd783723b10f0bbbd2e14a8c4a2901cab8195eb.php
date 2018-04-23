<?php $__env->startSection('title', 'ユーザー 詳細'); ?>

<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/lib/toastr/toastr.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/jquery-ui.min.css'); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="ot-page-title-area">
		 <h2 class="ot-page-title">ユーザー 詳細</h2>
		 <a class="ot-page-title-btn" href="/admincp/user/list">一覧に戻る</a>
	</div>
	<div class="ot-image-detail-content">
		<?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<form class="form-content clearfix" action="<?php echo e(url('/admincp/user/delete')); ?>" method="POST" role="form">
				<div class="ot-content-left">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">ユーザー名</div>
						<div class="ot-image-detail-value"><?php echo e($user->name); ?></div>
					</div>
					<?php echo e(csrf_field()); ?>

					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">メールアドレス</div>
						<div class="ot-image-detail-value"><?php echo e($user->email); ?></div>
					</div>
					<input type="hidden" value="<?php echo e($user->id); ?>" class="user_id" name="user_id">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">user_id</div>
						<div class="ot-image-detail-value"><?php echo e($user->id); ?></div>
					</div>
				</div>
				<div class="ot-content-right">
					<div class="ot-btn-edit-image">
						<a href="/admincp/user/edit/<?php echo e($user->id); ?>">編集</a>
					</div>
					<div> 
						<a class="ot-link-delete js-delete-user">このユーザーを削除</a>
					</div>
				</div>
			</form>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/toastr/toastr.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/spin/spin.min.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.js-delete-user').on('click', function() {
				var check = confirm("このユーザーを削除します。よろしいですか？");
				if (check == true) {
					$.ajax({
						url: "/admincp/user/delete/" + $('.user_id').val(),
						type: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: $('.user_id').val(),
						success: function (data) {
							if (data['row'] > 0) {
								toastr.success(data['success']);
							} else if (data['row'] == 0) {
								toastr.error('このユーザーが削除されません。');
							}
						},
						error: function (data) {
							toastr.error('エラーが発生しました。もう一度お試しください。');
						}
					});
				} else {
					
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>