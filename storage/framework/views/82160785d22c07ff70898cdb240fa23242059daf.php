<?php $__env->startSection('title', '360画像一覧'); ?>

<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/lib/toastr/toastr.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/jquery-ui.min.css'); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">360画像一覧</h2>
	</div>
	<!-- <form>
		<select class="ot-input-select">
			<option value="id">360画像ID</option>
			<option value="url">View URL</option>
			<option value="time">投稿日</option>
			<option value="public">公開/非公開</option>
		</select>
		<span><input class="ot-input-search" type="text" placeholder="360画像IDを入力"></span>
	</form> -->
	<div class="ot-image-list-table-area">
		<div class="ot-list-table-headline">
			<span>一括操作  </span><button data-url="<?php echo e(url('/admincp/image/deleteAll')); ?>" class="ot-btn-delete js-delete-all">削除</button>
			<?php if($images->count() > 0): ?>
				<span class="ot-list-row-quantity"><?php echo e($images->count()); ?> 件中 1-<?php echo e($images->count()); ?> 件目</span>
			<?php endif; ?>
		</div>
		<table class="ot-image-list-table" id="table_image">
			<thead>
				<th class="no-sort"><input type="checkbox" id="chk-master"></th>
				<!-- <th class="ot-th-private">非公開</th> -->
				<th class="no-sort">サムネイル</th>
				<th>360画像ID</th>
				<th>コンテンツID</th>
				<th>View URL</th>
				<th>所有者</th>
				<th>登録日時</th>
			</thead>
			<tbody>
			<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
				<tr>
					<td><input type="checkbox" class="sub-chk" data-id="<?php echo e($image->id); ?>"></td>
					<!-- <?php if($image->is_public === 0): ?>
						<td class="ot-ic-private"><img src="<?php echo e(asset('resource/img/padlock.png')); ?>"></td>
					<?php else: ?>
						<td class="ot-ic-private"></td>
					<?php endif; ?> -->
					<td><a href="/admincp/image/detail/<?php echo e($image->id); ?>"><img class="ot-img-thumbnail" src="<?php echo e(URL::asset('uploads/images/thumb/' . $image->image_url)); ?>"></a></td>
					<td><a href="/admincp/image/detail/<?php echo e($image->id); ?>" class="ot-list-link"><?php echo e($image->spherical_id); ?></a></td>
					<td><?php echo e($image->tour_id); ?></td>
					<td><?php echo e($image->view_url); ?></td>
					<td><?php echo e($image->created_by); ?></td>
					<td><?php echo e($image->created_at); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			</tbody>
		</table>
		<div class="ot-list-table-headline clearfix">
			<?php if($images->count() > 0): ?>
				<span class="ot-list-row-quantity"><?php echo e($images->count()); ?> 件中 1-<?php echo e($images->count()); ?> 件目</span>
			<?php endif; ?>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/toastr/toastr.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/spin/spin.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo asset('resource/js/lib/jquery-ui.min.js'); ?>"></script>
	<script>
		$(document).ready(function() {
			$('#table_image').DataTable({
				"ordering": true,
				"paging": true,
				"searching": false,
				"bFilter": false,
				iDisplayLength: 10,
				columnDefs: [{
					orderable: false,
					targets: "no-sort"
				}],
				language: {
					emptyTable: "360画像はありません",
					paginate: {
						previous: "<",
						next: ">",
						first: "|<",
						last: ">|"
					}
				}
			});
			$('#chk-master').on('click', function(e) {
				if($(this).is(':checked',true))  
				{
					$(".sub-chk").prop('checked', true);
				} else {
					$(".sub-chk").prop('checked', false);
				}
			});
			$('.js-delete-all').on('click', function(e) {
				var allVals = [];  
				$(".sub-chk:checked").each(function() {
					allVals.push($(this).attr('data-id'));
				});
				if(allVals.length <= 0) {
					toastr.info('行を選択してください');
				}
				else {
					var check = confirm("選択された360画像を削除しますか？");
					if (check == true) {
						var join_selected_values = allVals.join(",");
						$.ajax({
							url: $(this).data('url'),
							type: 'DELETE',
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							data: 'ids=' + join_selected_values,
							success: function (data) {
								if (data['success'] && data['row'] > 0) {
									$(".sub-chk:checked").each(function() {  
										$(this).parents("tr").remove();
									});
									if (data['imageCount'] > 0) {
										$(".ot-list-row-quantity").text(data['imageCount'] + " 件中 " + "1-" + data['imageCount'] + " 件目");
									}
									else {
										$(".ot-list-row-quantity").text("");
									}
									toastr.success(data['success']);

								} else if (data['error']) {
									toastr.error(data['error']);
								} else {
									toastr.error('この360画像が削除されません。');
								}
							},
							error: function (data) {
								toastr.error(data.responseText);
							}
						});
						$.each(allVals, function( index, value ) {
							$('table tr').filter("[data-row-id='" + value + "']").remove();
						});
					}
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>