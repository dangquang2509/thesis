<?php $__env->startSection('title', '360画像新規登録'); ?>

<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/lib/toastr/toastr.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/jquery-ui.min.css'); ?>">
<?php $__env->stopSection(); ?>

<script type="text/javascript">
	if (window.FileReader) {
		$image_url = document.getElementById("image_url");
		image_url.change(function() {
			var fileReader = new FileReader(), files = this.files, file;
			if (files.length) {
				file = files[0];
				if (/^image\/\w+$/.test(file.type)) {
					fileReader.readAsDataURL(file);
					fileReader.onload = function () {
						//$('#img-preview > img').attr('src', this.result);
					};
				} else {
					//showMessage("Please choose an image file.");
				}
			}
		});
	};
</script>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">360画像新規登録</h2>
	</div>
<?php echo Form::open(['url' => 'admincp/image/create', 'files' => true, 'class' => 'form-horizontal']); ?>

	<?php echo csrf_field(); ?>


	<div class="ot-form-row">
		<label class="ot-form-row-label">登録画像選択</label>
		<?php echo Form::file('image_url', array('id' => 'image_url', 'class' => 'ot-form-row-input')); ?>

	</div>
	<div class="ot-form-row">
		<label class="ot-form-row-label">タイトル</label>
		<input name="title" type="text" class="ot-form-row-input" value="<?php echo e(old('title')); ?>">
	</div>
	<div class="ot-form-row">
		<label class="ot-form-row-label">備考</label>
		<textarea name="description" rows="3" class="ot-form-row-input"><?php echo e(old('description')); ?></textarea>
	</div>
	<div class="checkbox ot-upload-checkbox">
		<label>
			<input name="is_public" type="checkbox" checked> 公開
		</label>
	</div>
	<div class="ot-btn-submit-area">
		<button type="submit" class="ot-form-btn-submit">登録</button>
	</div>
<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/toastr/toastr.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/spin/spin.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.ot-form-btn-submit').on('click', function(){
				var imgFile = $('#image_url').val(); 
				if (imgFile === '') {
					toastr.error('ファイルを選択してください');
					return false;
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>