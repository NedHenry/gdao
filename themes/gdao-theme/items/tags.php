<?php head(array('title'=>'Browse Items','bodyid'=>'items','bodyclass'=>'tags')); ?>

<div id="primary">
	<h1>Browse Items by Tag</h1>
	<?php echo tag_cloud($tags, uri('items/browse')); ?>
</div>

<?php foot(); ?>
