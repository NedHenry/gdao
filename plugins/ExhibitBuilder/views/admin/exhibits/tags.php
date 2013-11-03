<?php
$title = __('Browse Exhibits by Tag');
$head_array = array('title' => $title, 'bodyclass' => 'exhibits');
head($head_array);
?>

<h1><?php echo $title; ?></h1>

<div id="primary">
<?php if (!empty($tags)): ?>
	<?php
	echo tag_cloud($tags, uri('exhibits/browse/'));
	?>
<?php else: ?>
	<h2><?php echo __('There are no tags to display. You must first tag some exhibits.'); ?></h2>
<?php endif; ?>
</div>
<?php foot(); ?>
