<?php
$title = __('Browse Exhibits');
head(array('title'=>$title, 'bodyid' => 'exhibit', 'bodyclass'=>'browse'));
?>
<div id="primary">
	<h1><?php echo $title; ?> <?php echo __('(%s total)', $total_records); ?></h1>
	<?php if (count($exhibits) > 0): ?>
		<div class="pagination"><?php echo pagination_links(); ?></div>
    		<div id="exhibits">
			<?php $exhibitCount = 0; ?>
			<?php while(loop_exhibits()): ?>
				<?php $exhibitCount++; ?>
				<div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
					<h2><?php echo link_to_exhibit(); ?></h2>
					<div class="description"><?php echo exhibit('description'); ?></div>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="pagination"><?php echo pagination_links(); ?></div>
	<?php else: ?>
		<p><?php echo __('There are no exhibits available yet.'); ?></p>
	<?php endif; ?>
</div>
<?php foot(); ?>
