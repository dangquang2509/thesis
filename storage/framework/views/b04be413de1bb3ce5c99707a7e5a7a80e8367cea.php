<?php $__env->startSection('title', 'コンテンツ作成'); ?>

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
			<h2 class="ot-page-title">コンテンツ作成</h2>
			<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('tour', '<?php echo e($tour->id); ?>'); return false;">保存</a>
			<a class="ot-page-title-btn" href="/admincp/house/detail/<?php echo e($tour->id); ?>">キャンセル</a>
		</div>
		<form id="postTour" action="#" method="post" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<div class="ot-form-row">
				<label class="ot-form-row-label">コンテンツタイトル</label>
				<span class="ot-form-require-label">必須</span>
				<input type="text" id="tour-title" class="ot-form-row-input js-tour-title" name="tour_title" value="<?php echo e($tour->title); ?>">
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">コンテンツ説明</label>
				<span class="ot-form-require-label" style="visibility:hidden">必須</span>
				<input type="text" class="ot-form-row-input" name="tour_description" value="<?php echo e($tour->description); ?>" >
				<input id="tour-key" name="tour_key" type="text" class="js-tour-key ot-form-row-input" style="display:none">
				<input id="floormapImage" name="floormapImage" value="" style="display:none" type="text">
				<input class="ot-xml-url" type="hidden" value="<?php echo e($tour->xml_url); ?>" name="xml_url">
				<!-- <input type="text" class="ot-form-row-input" value="<?php echo e($tour->description); ?>"> -->
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">カテゴリー</label>
				<span class="ot-form-require-label" style="visibility:hidden">必須</span>
				<select class="ot-input-category" name="tour_category">
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
						<?php if($tour->category_id === $index + 1): ?>
							<option value="<?php echo e($index + 1); ?>" selected><?php echo e($category->name); ?></option>
						<?php else: ?>
							<option value="<?php echo e($index + 1); ?>"><?php echo e($category->name); ?></option>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				</select>
			</div>
			<input class="ot-tour-config" type="hidden" value="<?php echo e($tour->config); ?>">
			<input class="ot-floormap-id" type="hidden" value="<?php echo e($tour->plan_image_id); ?>">
			<input class="ot-floormap-url" type="hidden" value="<?php echo e($floorMapUrl); ?>">

			<input id="tour-published-param" name="tour_published" class="js-tour-published-param" type="hidden" value="true" />
			<input id="tour-param" name="tour_param" class="js-tour-param" type="hidden" value="" />
			<input id="tour-map" name="tour_map" class="js-tour-map" type="hidden" value="">
		</form>
		<div class="ot-floormap-view clearfix">
			<div class="ot-floormap-label">
				<input id="file_floormap" name="file[floormap]" onchange="uploadFloorMap(this.files[0])" style="display:none" type="file">
				<span>間取り図</span>
				<button class="btn-create-tour" onclick="openFileDialog('file_floormap');">インポート</button>
				<button class="btn-create-tour js-delete-floormap" onclick="confirm_delete_floormap();">削除</button>
				<button class="btn-create-tour js-move-mode">移動</button>
				<button class="btn-create-tour btn-create-tour-active js-link-mode">リンク</button>
				<button class="btn-create-tour js-remove-mode">リンク削除</button>
			</div>
			<div class="ot-view-label ot-form-row" style="margin-top: 0;">
				<span>360ビュー</span>
				<input id="scene-telop" class="scene-telop ot-form-row-input" type="text" maxlength="255" name="scene[telop]" placeholder="キャプションの詳細">
			</div>
			<div class="js-round-floor-plan ot-drop-floormap">
				<div class="floormap-overlay"></div>
				<div class="js-drop-floormap drop-floormap drop-area">
					<p class="ot-message">
						「インポート」ボタンから間取り図を選択してください。
					</p>
					
				</div>
				<div class="js-img-minimap img-minimap">
					
				</div>
				<div class="js-wrap-floor-plan" style="position: absolute; top: 0; left: 0;">
					<canvas id="floor-plan" class="js-floor-plan" ></canvas>
				</div>
			</div>
			<div class="ot-right-column">
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
		</div>
		<div class="ot-sphere-area">
			<div class="ot-sphere-label">
				<span>360画像</span>
				<button class="btn-create-tour" onclick="openFileDialog('file_spheres');">インポート</button>
				<input id="file_spheres" multiple="multiple" name="file[spheres][]" onchange="uploadSpheres(this.files)" style="display:none" type="file">
			</div>
			<div class="ot-drop-sphere js-drop-spheres">
				<p class="ot-message">
					ここに360度画像をドラッグ & ドロップしてください。<br>もしくは<br>「インポート」ボタンから360度画像を選択してください。
				</p>
				<div class="js-scroll-area sortable ui-sortable clearfix">
				</div>
			</div>
		</div>
		<div class="js-replace-floormap-dialog" title="間取り図の差し替えと共にマーカー・リンクの情報も失われます。よろしいですか？" style="text-align:center"></div>
		<div class="js-delete-floormap-dialog" title="間取り図を削除しますか？" style="text-align:center"></div>
		<div class="ot-page-title-area-bottom">
			<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('tour', '<?php echo e($tour->id); ?>'); return false;">保存</a>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script type="text/javascript">
		var during_restore = true;
	</script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/toastr/toastr.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/spin/spin.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('vtour/tour.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/common.js'); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>