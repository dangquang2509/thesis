<?php $__env->startSection('title', '360画像 編集'); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php $__currentLoopData = $image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">360画像 編集</h2>
		<a class="ot-page-title-btn" href="/admincp/image/detail/<?php echo e($image->id); ?>">キャンセル</a>
		<a class="ot-page-title-btn ot-page-title-btn-right submit" href="#">更新</a>
	</div>
	<div class="ot-image-detail-content">
		<form class="form-content clearfix form-edit-image" action="<?php echo e(url('/admincp/image/update')); ?>" method="POST" role="form">
			<div class="ot-content">
				<div class="pano-area">
					<div id="pano" style="width:100%;height:100%;">
						<noscript>
							<table style="width:100%;height:100%;">
								<tr style="vertical-align:middle;">
									<td>
										<div style="text-align:center;">ERROR:
											<br/>
											<br/>
											Javascript not activated
											<br/>
											<br/>
										</div>
									</td>
								</tr>
							</table>
						</noscript>
					</div>
					<!-- <blockquote data-width="900" data-height="375" class="ricoh-theta-spherical-image" ><a href="https://onetech.theta360.biz/s/e453497a-a1a1-11e7-bb38-06b35f615bf5-1"></a></blockquote><script async src="https://onetech.theta360.biz/widgets.js" charset="utf-8"></script> -->
				</div>
				<?php echo e(csrf_field()); ?>

				<!-- <div class="checkbox ot-upload-checkbox">
					<label>
						<?php if($image->is_public === 1): ?>
						<input name="is_public" type="checkbox" checked> 公開
						<?php else: ?>
						<input name="is_public" type="checkbox"> 公開
						<?php endif; ?>
					</label>
				</div> -->
				<input type="hidden" value="<?php echo e($image->id); ?>" name="id">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">360画像ID</div>
					<div class="ot-image-detail-value"><?php echo e($image->spherical_id); ?></div>
				</div>
				<input type="hidden" value="<?php echo e($image->image_url); ?>" class="js-image-url">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">タイトル</div>
					<div class="ot-image-detail-value">
						<input type="text" value="<?php echo e($image->title); ?>" name="title">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">サムネイル</div>
					<div class="ot-image-detail-value">
						<img src="<?php echo e(URL::asset('uploads/images/thumb/' . $image->image_url)); ?>" alt="image_thumbnail">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">View URL</div>
					<div class="ot-image-detail-value">uploads/images/<?php echo e($image->image_url); ?></div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">備考</div>
					<div class="ot-image-detail-value">
						<input type="text" value="<?php echo e($image->description); ?>" name="description">
					</div>
				</div>
				<div class="ot-btn-area clearfix">
					<div class="ot-btn-edit">
						<a class="submit" href="#">更新</a>
					</div>
				</div>
			</div>
			<!-- <div class="ot-content-right">
				<div class="ot-btn-edit-image">
					<button type="submit">更新</button>
				</div>
				<div class="ot-btn-cancel">
					<a href="/admincp/image/detail/<?php echo e($image->id); ?>">キャンセル</a>
				</div>
			</div> -->
		</form>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script type="text/javascript" src="<?php echo asset('vtour/tour.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var image_url = $('.js-image-url').val();
			console.log(image_url);
			var viewer = createPanoViewer({
				swf: "/vtour/tour.swf",
				target: "pano",
				html5: "auto",
				mobilescale: 1.0,
				passQueryParameters: true,
				bgcolor: "#ffffff",
				consolelog: true
			});
			viewer.addVariable("xml", null);
			viewer.embed();

			var pano_dom = document.getElementById("krpanoSWFObject");
			pano_dom.call("loadpano(null,image.sphere.url=/uploads/images/" + image_url + ",keepbase,blend(1))");

			$('.submit').click(function(){
				$('.form-edit-image').submit();
			});
		});
			

	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>