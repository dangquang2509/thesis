<?php $__env->startSection('title', 'コンテンツ一覧'); ?>

<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/lib/toastr/toastr.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo asset('resource/css/jquery-ui.min.css'); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">コンテンツ一覧</h2>
	</div>
	<!-- <form>
		<select class="ot-input-select">
			<option value="id">コンテンツID</option>
			<option value="title">コンテンツタイトル</option>
			<option value="date_pre">作成日</option>
			<option value="date_up">更新日</option>
			<option value="public">公開/非公開</option>
		</select>
		<span><input class="ot-input-search" type="text" placeholder="コンテンツIDを入力"></span>
	</form> -->
	<div class="ot-image-list-table-area">
		<div class="ot-list-table-headline">
			<span>一括操作  </span><button class="ot-btn-delete js-delete-all" data-url="<?php echo e(url('/admincp/house/deleteAll')); ?>">削除</button>
			<?php if($tours->count() > 0): ?>
				<span class="ot-list-row-quantity"><?php echo e($tours->count()); ?> 件中 1-<?php echo e($tours->count()); ?> 件目</span>
			<?php endif; ?>
		</div>
		<table class="ot-image-list-table" id="table_tour">
			<thead>
				<th class="no-sort"><input type="checkbox" id="chk-master"></th>
				<!-- <th>非公開</th> -->
				<th class="ot-th-tour-title">コンテンツタイトル</th>
				<th>カテゴリー</th>
				<th>所有者</th>
				<th>登録日時</th>
				<th>更新日時</th>
			</thead>
			<tbody>
			<?php $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
				<tr>
					<td><input type="checkbox" class="sub-chk" data-id="<?php echo e($tour->id); ?>"></td>
					<!-- <?php if($tour->is_public === 0): ?>
						<td class="ot-ic-private"><img src="<?php echo e(asset('resource/img/padlock.png')); ?>"></td>
					<?php else: ?>
						<td class="ot-ic-private"></td>
					<?php endif; ?> -->
					<td>
						<a href="/admincp/house/detail/<?php echo e($tour->id); ?>" class="ot-list-link">
						<?php if(trim($tour->title) != ""): ?>
							<?php echo e($tour->title); ?>

						<?php else: ?>
							[not have title]
						<?php endif; ?>
						</a>
					</td>
					<?php if($tour->category_id === 1): ?>
						<td>モデルハウス</td>
					<?php else: ?>
						<td>物件</td>
					<?php endif; ?>
					<td><?php echo e($tour->created_by); ?></td>
					<td><?php echo e($tour->created_at); ?></td>
					<td><?php echo e($tour->updated_at); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			<tbody>
		</table>
		<div class="ot-list-table-headline clearfix">
			<?php if($tours->count() > 0): ?>
				<span class="ot-list-row-quantity"><?php echo e($tours->count()); ?> 件中 1-<?php echo e($tours->count()); ?> 件目</span>
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
			$(document).ready(function() {
				$('#table_tour').DataTable({
					"ordering": true,
					"paging": true,
					"searching": true,
					iDisplayLength: 10,
					columnDefs: [
						{orderable: false, targets: "no-sort"},
						{searchable: false, targets: [0,2,3,4,5]}
					],
					language: {
						emptyTable: "コンテンツはありません",
						search: "検索",
						searchPlaceholder: "タイトルを入力",
						paginate: {
							previous: "<",
							next: ">",
							first: "|<",
							last: ">|"
						}
					}
				});
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
					var check = confirm("選択されたコンテンツを削除しますか？");
					if (check == true) {
						var join_selected_values = allVals.join(",");
						$.ajax({
							url: $(this).data('url'),
							type: 'DELETE',
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							data: 'ids=' + join_selected_values,
							success: function (data) {
								if (data['success']) {
									$(".sub-chk:checked").each(function() {
										$(this).parents("tr").remove();
									});
									if (data['tourCount'] > 0) {
										$(".ot-list-row-quantity").text(data['tourCount'] + " 件中 " + "1-" + data['tourCount'] + " 件目");
									}
									else {
										$(".ot-list-row-quantity").text("");
									}
									toastr.success(data['success']);
								} else if (data['error']) {
									toastr.error(data['error']);
								} else {
									toastr.error('エラーが発生しました。もう一度お試しください。');
									//toastr.error(data['test']);
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