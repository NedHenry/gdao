<?php
  $id = htmlspecialchars($_GET["id"]);
  $ark = htmlspecialchars($_GET["ark"]);
  $width = htmlspecialchars($_GET["w"]);
  $height = htmlspecialchars($_GET["h"]);
  $count = htmlspecialchars($_GET["c"]);
  $isIE = htmlspecialchars($_GET["ie"]);

  if (!empty($id)) {
    $title = item('Dublin Core', 'Title', array(), get_item_by_id($id));
  }
?>

  <div id="zoom_title"><?php echo empty($title) ? 'Zoom Image Navigator' : $title; ?></div>

  <?php if (!empty($id)): ?>
    <div id="zoom_return"><a href="/items/show/<?php echo $id; ?>">Return to item page</a></div>
  <?php endif; ?>

  <?php if (empty($height)): ?>
  <script type="text/javascript">
    function init() {
      OpenSeadragon.DEFAULT_SETTINGS.autoHideControls = false;
      var viewer;
      var ts;

      <?php if ($isIE): ?>
        OpenSeadragon.DEFAULT_SETTINGS.prefixUrl = '<?php echo GDAO_WEB_SERVER; ?>';
        ts = new OpenSeadragon.DjTileSource('<?php echo GDAO_WEB_SERVER; ?>/view/', encodeURIComponent('<?php echo $ark; ?>'));
      <?php else: ?>
        OpenSeadragon.DEFAULT_SETTINGS.prefixUrl = '<?php echo JP2_IMAGE_SERVER; ?>';
        ts = new OpenSeadragon.DjTileSource('<?php echo JP2_IMAGE_SERVER; ?>/view/', encodeURIComponent('<?php echo $ark; ?>'));
      <?php endif; ?>

      viewer = new OpenSeadragon.Viewer("zoom_image");
      viewer.openTileSource(ts);
    }

    OpenSeadragon.addEvent(window, "load", init);
  </script>
  <?php endif; ?>

  <div style="<?php
    if (empty($height)) { echo 'width: 940px; height: 550px;'; }
  ?>" id="zoom_image"><?php if ($height):?>
    <img src="<?php echo JP2_IMAGE_SERVER; ?>/view/fullSize/<?php echo urlencode($ark); ?>"
    alt="<?php echo empty($title) ? 'Zoom Image Navigator' : $title; ?>" width="<?php
    echo $width; ?>" height="<?php echo $height; ?>"/>
  </div>

  <?php if (!empty($count) && $count > 1) {
    $index = strpos($ark, '/is/');

    if ($index !== false) {
      $position = substr($ark, $index + 4);
      $arkbase = substr($ark, 0, $index + 4);
    }

    if (!empty($position) && $position > 1 && empty($height)) {
      echo '<a href="/zoom?id=' . $id . '&c=' . $count . '&ark=' . $arkbase . ($position - 1) . '">';
      echo '<img src="/themes/gdao-theme/images/timeline-prev-horizontal.png"/>';
      echo '</a>';
    }

    if (!empty($position) && $position < $count && empty($height)) {
      echo '<a href="/zoom?id=' . $id . '&c=' . $count . '&ark=' . $arkbase . ($position + 1) . '">';
      echo '<img style="float:right;" src="/themes/gdao-theme/images/timeline-next-horizontal.png"/>';
      echo '</a>';
    }
  } ?>

  <?php endif; ?>
