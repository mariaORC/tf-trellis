<div class="row">
    <div class="col-xs-12 text-center">
        <div class="blog-page-header">
			<?php if (is_404()): ?>
				<h1 class="mainHeading">That link appears to be broken.</h1>
			<?php elseif ($post->ID == 36): ?>
            	<h1 class="mainHeading"><a href="/blog/"><?php echo get_the_title(36); ?></a></h1>
            <?php else: ?>
            	<h1 class="mainHeading"><?php echo get_the_title(36); ?></h1>
            <?php endif; ?>
        </div>
    </div>
</div>
