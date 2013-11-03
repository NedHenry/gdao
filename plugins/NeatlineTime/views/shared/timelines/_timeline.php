<?php
/**
 * Timeline display partial.
 */
?>

<!-- Container. -->
<img id="timeline-left-arrow" src="/themes/gdao-theme/images/timeline-prev-horizontal.png"/>
<img id="timeline-right-arrow" src="/themes/gdao-theme/images/timeline-next-horizontal.png"/>
<div id="<?php echo neatlinetime_timeline_id(); ?>" class="neatlinetime-timeline"></div>

<?php neatlinetime_get_startdate(); ?>
<script>
    jQuery(document).ready(function($) {
        NeatlineTime.loadTimeline(
            '<?php echo neatlinetime_timeline_id(); ?>',
            '<?php echo neatlinetime_json_uri_for_timeline(); ?>',
            '<?php echo neatlinetime_get_startdate(); ?>'

        );
    });
</script>

