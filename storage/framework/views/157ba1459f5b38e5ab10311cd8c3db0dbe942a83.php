<?php $__env->startSection('title', 'トップ'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="ot-panel-area">
		<div class="ot-title is-bg is-left"><a class="ot-title-link" href="<?php echo e(url('/admincp/house/list')); ?>">モデルハウス</a></div>
		<?php $__currentLoopData = $toursModelHouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tour): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<div class="ot-house-panel">
				<a class="ot-house-panel-image" href="/admincp/house/detail/<?php echo e($tour->id); ?>">
					<img src="/uploads/images/<?php echo e($imagesModelHouse[$index]); ?>" class="img-responsive" alt="">
					<div class="overlay">
						<img class="ot-house-panel-image-overlay" src="/resource/img/globe360.png" alt="">
					</div>
				</a>
				<div class="ot-house-panel-content">
					<div class="ot-house-panel-title"><?php echo e($tour->title); ?></div>
					<div class="ot-house-panel-time"><?php echo e($tour->created_at); ?></div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	</div>
	<div class="ot-panel-area">
		<div class="ot-title is-bg is-left"><a class="ot-title-link" href="<?php echo e(url('/admincp/house/list')); ?>">物件</a></div>
		<?php $__currentLoopData = $toursProperty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tour): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<div class="ot-house-panel">
				<a class="ot-house-panel-image" href="/admincp/house/detail/<?php echo e($tour->id); ?>">
					<img src="/uploads/images/<?php echo e($imagesProperty[$index]); ?>" class="img-responsive" alt="">
					<div class="overlay">
						<img class="ot-house-panel-image-overlay" src="/resource/img/globe360.png" alt="">
					</div>
				</a>
				<div class="ot-house-panel-content">
					<div class="ot-house-panel-title"><?php echo e($tour->title); ?></div>
					<div class="ot-house-panel-time"><?php echo e($tour->created_at); ?></div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>