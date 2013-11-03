<?php head(); ?>
<div id="primary">
	<h1>Thank You for Contributing!</h1>
	<p>Your contribution will show up in the archive once an administrator approves it.
	Meanwhile, feel free to <?php echo contribution_link_to_contribute('make another contribution'); 
	?> or <a href="/solr-search/results/?sort=sortedCreateDate+desc">browse the archive</a>.</p>
</div>
<?php foot(); ?>
