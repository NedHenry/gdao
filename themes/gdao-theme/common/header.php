<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#">
<head>
<title><?php echo settings('site_title'); echo $title ? ' | ' . $title : ''; ?></title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo settings('description'); ?>" />
<!-- the following meta element is from: https://developer.mozilla.org/en/Mobile/Viewport_meta_tag#Viewport_basics -->
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta name="date" content="<?php echo date('Y-m-d\TG:i:s\Z'); ?>"/>

<?php if ($item = __v()->item): ?>
    <?php $itemtype = item('item type name'); ?>
    <?php $ark = item('Item Type Metadata', 'ARK'); ?>
    <?php $restricted = item('Item Type Metadata', 'AccessRestricted'); ?>

<meta property="og:title" content="<?php echo gdao_show_untitled_items(item('Dublin Core', 'Title')); ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" />

<?php if ($restricted != 'true' || gdao_is_authorized()): ?>
  <?php if (item_has_thumbnail()): ?>
    <?php $iLink = simplexml_load_string(item_square_thumbnail()); ?>
<meta property="og:image" content="<?php echo $iLink['src'];?>" />
<meta property="og:description" content="GDAO Contributed Image" />
  <?php elseif ($itemtype == 'Sound'): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/itemtype-sound.png" />
<meta property="og:description" content="GDAO Sound" />
  <?php elseif ($itemtype == 'Video'): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/itemtype-video.png" />
<meta property="og:description" content="GDAO Video" />
  <?php elseif ($itemtype == 'Article' && empty($ark)): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/itemtype-article.png" />
<meta property="og:description" content="GDAO Article" />
  <?php elseif ($itemtype == 'Website'): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/itemtype-website.png" />
<meta property="og:description" content="GDAO Website" />
  <?php elseif ($itemtype == 'Story'): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/itemtype-oralhistory.png" />
<meta property="og:description" content="GDAO Story/Oral History" />
  <?php elseif ($itemtype == 'Fan Tape'): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/ia-logo-sm.png" />
<meta property="og:description" content="GDAO/Internet Archive Fan Tape" />
  <?php elseif ($ark): ?>
<meta property="og:image" content="<?php echo JP2_IMAGE_SERVER ?>/view/carousel/<?php echo urlencode($ark . '/is/1'); ?>" />
<meta property="og:description" content="GDAO Image" />
  <?php else: ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/logo-gdao.png" />
<meta property="og:description" content="GDAO Object" />
  <?php endif; ?>
<?php elseif ($restricted == 'true' && !gdao_is_authorized()): ?>
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/content-not-available.png" />
<?php endif; ?>

<?php else: ?>

<meta property="og:title" content="The Grateful Dead Archive Online" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo GDAO_WEB_SERVER; ?>/" />
<meta property="og:image" content="<?php echo GDAO_WEB_SERVER; ?>/themes/gdao-theme/images/logo-gdao.png" />
<meta property="og:description" content="The Grateful Dead Archive Online (GDAO) is a socially constructed collection comprised of over 45,000 digitized items drawn from the UCSC Library&#039;s extensive Grateful Dead Archive (GDA) and from digital content submitted by the community and global network of Grateful Dead fans." />

<?php endif; ?>

<meta name="google-site-verification" content="xe9V2u3rPSMSV6Hbd3qQ0DS26D01-8YDS2n_4yTX430" />

<!-- new items / harvestable feed -->
<link rel="alternate" type="application/atom+xml" title="GDAO New Items Feed" href="<?php echo GDAO_WEB_SERVER; ?>/items/browse?output=atom" />

<!-- favicon -->
<link rel="icon" type="image/gif" href="/themes/gdao-theme/images/favicon.gif" />

<!-- Stylesheets -->
<link rel="stylesheet" media="screen" href="<?php echo html_escape(css('screen')); ?>" />
<link rel="stylesheet" media="print" href="<?php echo html_escape(css('print')); ?>" />
<link rel="stylesheet" href="<?php echo html_escape(css('jcarousel-skin-tango')); ?>" />
<link rel="stylesheet" href="<?php echo html_escape(css('timeline')); ?>" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css"/>

<!-- Plugin Stuff -->
<?php echo plugin_header(); ?>

<!-- JavaScripts -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php queue_js(array('form-images', 'theme-scripts', 'jquery.jcarousel.min', 'gdao-carousel', 'openseadragon', 'djtilesource', 'neatline-customizations')); ?>

<?php display_js(); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32396465-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body<?php echo $bodyid ? ' id="'.$bodyid.'"' : ''; ?><?php echo $bodyclass ? ' class="'.$bodyclass.'"' : ''; ?>>
  <div id="banner"><!--begin #banner -->
    <div class="content"><!--begin #banner .content -->
      <h1><?php echo link_to_home_page(); ?></h1>
      <div id="banner-top"><!--begin #banner-top -->
        <ul id="nav-site">
        <?php echo nav(
             array(
               'home' => uri('/'),
               'about' => uri('about'),
			   'dead news' => uri('deadnews/'),
			   'online exhibits' => uri('exhibits'),
			   'help' => uri('help')
             )
           );
        ?>
        </ul>
        <ul id="nav-contribute">
          <?php echo nav(
             array(
			   'Contribute' => uri('contribution')
             )
           );
          ?>
        </ul>
      </div><!--end #banner-top -->
      <div id="banner-bottom"><!--begin #banner-bottom -->
        <ul id="nav-collection">
          <?php echo nav(
             array(
		'Shows' => uri('shows'),
		'Milestones' => uri('milestones'),
		'Artists' => uri('artists'),
		'Media' => uri('media'),
		'Fan Art' => uri('fan-art')
             )
           );
          ?>
        </ul>
        <div id="search-collection"><!--begin #search-collection -->
          <div id="searchwrapper"><!--begin #searchwrapper -->
            <form id="simple-search" action="/solr-search/results/" method="get">
              <fieldset>
		<?php $solrq = $_REQUEST['solrq']; ?>
                <input type="text" name="solrq" id="solrq" value='<?php
		echo empty($solrq) ? 'Search the Collection...' : $solrq;
		?>' class="searchbox default-value"/>
                <input type="hidden" name="solrfacet" value="" id="solrfacet"/>
                <input type="image" name="submit_search" id="submit_search"
                  src="/themes/gdao-theme/images/search-collection-transparent.png"
                  class="searchbox_submit" value=""/>
              </fieldset>
            </form>
          </div><!-- end #searchwrapper -->
          <p><a href="/advanced-search">Advanced Search</a></p>
        </div><!--end #search-collection -->
      </div><!--end #banner-bottom -->
    </div><!-- end #banner .content -->
  </div><!--end #banner -->
  <div id="main">
