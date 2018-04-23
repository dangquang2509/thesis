<?php $__env->startSection('css'); ?>
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/lib/toastr/toastr.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/jquery-ui.min.css'); ?>"> -->

	<style type="text/css">
		.ot-container {
			display: block;
			width: 100%;
			height: 100%;
			padding: 0;
		}
		html,body {
			margin: 0;
			padding: 0;
			height: 100%;
		}
		.ot-image-detail-content {
			height: 100%;
		}
		.pano-area-full {
			height: 100%;
			margin: 0;
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="ot-image-detail-content">
		<?php $__currentLoopData = $tour; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<div class="pano-area-full">
				<!-- <blockquote data-width="1000" data-height="400" class="ricoh-theta-tour-image" ><a href="https://onetech.theta360.biz/t/d15eca62-8895-11e7-bed7-0a4f4743bc83-1"></a></blockquote><script async src="https://onetech.theta360.biz/t_widgets.js" charset="utf-8"></script> -->
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
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
	<script type="text/javascript" src="<?php echo asset('vtour/tour.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript">
	 	$(document).ready(function() {
			embedpano({swf:"/vtour/tour.swf", xml:"/<?php echo e($tour->xml_url); ?>", target:"pano", consolelog: "true"});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main-portable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>