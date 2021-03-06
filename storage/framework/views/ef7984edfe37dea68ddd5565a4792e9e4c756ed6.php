<?php $__env->startSection('title', 'コンテンツ詳細'); ?>

<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/lib/toastr/toastr.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/jquery-ui.min.css'); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php $__currentLoopData = $tour; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">コンテンツ詳細</h2>
		<a class="ot-page-title-btn" href="/admincp/house/list">一覧に戻る</a>
		<a class="ot-page-title-btn ot-page-title-btn-right" href="/admincp/house/edit/<?php echo e($tour->id); ?>">編集</a>
	</div>
	<div class="ot-image-detail-content">
		<div class="pano-area">
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
		<form class="form-content clearfix" action="<?php echo e(url('/admincp/house/delete')); ?>" method="POST" role="form">
			<div class="ot-content">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" value="<?php echo e($tour->id); ?>" class="tour_id" name="tour_key">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">コンテンツタイトル</div>
						<div class="ot-image-detail-value"><?php echo e($tour->title); ?></div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">View URL</div>
						<a href="/house/full/<?php echo e($tour->id); ?>" target="_blank" class="ot-image-detail-value js-view-url"></a>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">説明</div>
						<div class="ot-image-detail-value"><?php echo e($tour->description); ?></div>
					</div>
					<div class="ot-image-detail-row">
						<!-- <div class="ot-image-detail-label"><a href="javascript:void(0)" class="embed-code js-embed-code ot-embed-link">Embeded</a></div> -->
						<div class="ot-image-detail-label">埋め込みリンク</div>
						<div class="ot-image-detail-value">
							<textarea rows="4" readonly class="js-embed-code select"></textarea>
						</div>
					</div>
					<input type="text" name="tour_id" value="<?php echo e($tour->id); ?>" style="display:none">
					<div class="ot-btn-area clearfix">
						<div class="ot-btn-edit">
							<a href="/admincp/house/edit/<?php echo e($tour->id); ?>">編集</a>
						</div>
						<div class="ot-btn-delete">
							<a class="ot-link-delete js-delete-tour">このコンテンツを削除</a>
						</div>
					</div>
			</div>
			<!-- <div class="ot-content-right">
				<div class="ot-btn-edit-image">
					<a href="/admincp/house/edit/<?php echo e($tour->id); ?>">編集</a>
				</div>
				<div>
					<a class="ot-link-delete js-delete-tour">このコンテンツを削除</a>
				</div>
			</div> -->
		</form>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
	<script type="text/javascript" src="<?php echo asset('vtour/tour.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/toastr/toastr.min.js'); ?>"></script>
	<script type="text/javascript">
	 	$(document).ready(function() {
			embedpano({swf:"/vtour/tour.swf", xml:"/<?php echo e($tour->xml_url); ?>", target:"pano", consolelog: "true"});
			var width = 600;
			var height = 400;
			var krpano = document.getElementById("krpanoSWFObject");
			var scene = krpano.get("xml.scene");
			var link = "&start_scene=" + scene;
			link = window.location.href.replace("admincp/house", "house/full").replace("detail/", "") + link;
			var leftPosition, topPosition;
			leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
			topPosition = (window.screen.height / 2) - ((height / 2) + 50);
			var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
			u = link;
			t = document.title;
			var embed_code = '<iframe src="' + link + '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" frameborder="0" width="100%" height="100%"></iframe>';
			$(".js-embed-code").text(embed_code);
			$(".js-view-url").text(link);

			// delete tour

			$('.js-delete-tour').on('click', function() {
				var check = confirm("このコンテンツを削除します。よろしいですか？");
				if (check == true) {
					$.ajax({
						url: "/admincp/house/delete/" + $('.tour_id').val(),
						type: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: $('.tour_id').val(),
						success: function (data) {
							if (data['row'] > 0) {
								toastr.success(data['success']);
							} else if (data['row'] == 0) {
								toastr.error('このコンテンツが削除されません。');
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