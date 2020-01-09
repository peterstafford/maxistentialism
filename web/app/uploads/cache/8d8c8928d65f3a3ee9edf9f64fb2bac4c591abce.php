<section class="latest-tabs position-relative">
	<?php echo App\Controllers\FrontPage::sectionLogo('latest', $logo); ?>

	<div class="tab-content" id="nav-tabContent">
		<?php
			$tabs = ['podcast', 'video', 'aricle', 'faq'];
		?>
		<?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="tab-pane fade <?php echo e($i == 0 ? 'show active' : ''); ?>" id="<?php echo e($tabs[$i]); ?>" role="tabpanel" aria-labelledby="<?php echo e($tabs[$i]); ?>-tab">

				<div class="card bg-dark text-white rounded-0 text-center">
					<img src="<?php echo e($slide['image']); ?>" class="card-img object-cover w-full h-full" alt="<?php echo $slide['title']; ?>">
					<div class="card-img-overlay overflow-hidden">
						<div class="position-absolute w-100">
							<h2 class="card-title"><?php echo $slide['title']; ?></h2>
							<div class="card-text mb-5">
								<?php if(!empty($slide['podcast'])): ?>
									<?php
										// $feed =  new SimpleXmlElement(file_get_contents($slide['podcast']), null, true);
										// $podcast = $feed['channel']->item;
									?>

									
								<?php endif; ?>
								<?php echo wpautop($slide['body']); ?>

							</div>
						</div>
					</div>
				</div>

			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
	<nav>
		<div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active p-2 p-sm-3 p-md-4" id="podcast-tab" data-toggle="tab" href="#podcast" role="tab" aria-controls="podcast" aria-selected="true">
				<img src="<?= App\asset_path('/images/podcast ico@1x.png'); ?>" alt="" class="mx-auto img-responsive">
				<h2>Podcast</h2>
			</a>
			<a class="nav-item nav-link p-2 p-sm-3 p-md-4 border-left-0" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">
				<img src="<?= App\asset_path('/images/video ico@1x.png'); ?>" alt="" class="mx-auto img-responsive mb-3">
				<h2>Video</h2>
			</a>
			<a class="nav-item nav-link p-2 p-sm-3 p-md-4 border-left-0" id="faq-tab" data-toggle="tab" href="#faq" role="tab" aria-controls="faq" aria-selected="false">
				<img src="<?= App\asset_path('/images/faq ico@1x.png'); ?>" alt="" class="mx-auto img-responsive">
				<h2>FAQ</h2>
			</a>
			<a class="nav-item nav-link p-2 p-sm-3 p-md-4 border-left-0" id="aricle-tab" data-toggle="tab" href="#aricle" role="tab" aria-controls="aricle" aria-selected="false">
				<img src="<?= App\asset_path('/images/article ico@1x.png'); ?>" alt="" class="mx-auto img-responsive">
				<h2>Article</h2>
			</a>
		</div>
	</nav>
</section>