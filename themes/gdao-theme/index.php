<?php head(array('bodyid'=>'home')); ?>

<div id="banner-home"><!--begin #banner-home -->
    <div class="content"><!--begin #banner-home .content -->
      <div class="six-1"></div>
      <div class="six-2"><a href="/milestones"><span>Milestones</span></a></div>
      <div class="six-3"><a href="/shows"><span>Shows</span></a></div>
      <div class="six-4"><a href="/artists"><span>Artists</span></a></div>
      <div class="six-5"><a href="/media"><span>Media</span></a></div>
      <div class="six-6"><a href="/fan-art"><span>Fan Art</span></a></div>
    </div><!-- end #banner .content -->
  </div><!-- end #banner-home -->

  <div id="primary"><!-- begin #primary -->
    <div class="content"><!-- begin #primary .content -->

      <div class="three-1">
        <h2>What's New</h2>
        <?php $recentItems = get_db()->getTable('Item')->findBy(array('recent'=>true,'collection'=>'Grateful Dead Archive'), 1); ?>
        <?php set_items_for_loop($recentItems); ?>
		<?php if (has_items_for_loop()): ?>

		<div class="items-list">
			<?php while (loop_items()): ?>
			<?php $title = gdao_shorten_text(item('Dublin Core', 'Title', array(), get_current_item())); ?>
			<div class="item">
				<span id="whatsnew-title"><?php echo link_to_item($title); ?></span>
		<?php $itemtype = item('item type name'); ?>
		<?php $ark = item('Item Type Metadata', 'ARK'); ?>

		<?php if (item_has_thumbnail()): ?>
                       <div class="image-item item-wrap">
                           <?php echo link_to_item(item_square_thumbnail()); ?>
                       </div>
                <?php elseif ($itemtype == 'Fan Tape'): ?>
                <div class="fantape-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="/themes/gdao-theme/images/ia-logo-sm.png"
                                alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
                </div>
                <?php elseif ($itemtype == 'Sound'): ?>
                <div class="sound-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="/themes/gdao-theme/images/itemtype-sound.png"
                          alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
                </div>
		<?php elseif ($itemtype == 'Video'): ?>
                <div class="video-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="/themes/gdao-theme/images/itemtype-video.png"
                          alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
                </div>
                <?php elseif ($itemtype == 'Story'): ?>
                <div class="oralhistory-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="/themes/gdao-theme/images/itemtype-oralhistory.png"
                          alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
                </div>
                <?php elseif ($itemtype == 'Website'): ?>
                <div class="website-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="/themes/gdao-theme/images/itemtype-website.png"
                          alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
                </div>
                <?php elseif ($itemtype == 'Article' && empty($ark)): ?>
                <div class="article-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="/themes/gdao-theme/images/itemtype-article.png"
                          alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
                </div>
		<?php elseif (!empty($ark)): ?>
                <div class="cdm-item item-wrap">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . item('ID'); ?>" alt="">
                        <img src="<?php echo JP2_IMAGE_SERVER; ?>/view/thumbnail/<?php echo urlencode($ark . '/is/1'); ?>"
                         alt="<?php echo (!empty($title) ? $title : ''); ?>"/>
                        </a>
                </div>
		<?php endif; ?>
			</div>
			<?php endwhile; ?>
		</div>

		<?php else: ?>
			<p>No recent items available.</p>
		<?php endif; ?>
        <p class="view-items-link"><span>
          |<a href="/solr-search/results/?sort=sortedCreateDate+desc" class="read-more" id="more-new">more recent items</a></span></p>
      </div>
      <div class="three-2">
        <h2>Contribute</h2>
        <p id="contrib-text">Help build GDAO: a socially-constructed archive. Please share your digital files or tell your Grateful Dead story.</p>
        <p class="contribute"><a href="/contribution">Contribute</a>
      </div>
      <div class="three-3">
        <?php
          $client = new Zend_Http_Client();
          $hostname = $_SERVER['SERVER_NAME'];
          $client->setUri('http://' . $hostname  . '/deadnews/?feed=rss2');
          $client->setCookieJar();
          $client->setConfig(array('timeout' => 30));

          //if (strpos($hostname, 'library') !== false) {
            $client->setAuth('gdao', 'gd4oh3ad', Zend_Http_Client::AUTH_BASIC);
          //}

          $response = $client->request('GET');
          $xml = simplexml_load_string('<empty/>');
        ?>
        <h2>Dead News</h2>
        <div id="deadnews">
          <?php
            if ($response->isSuccessful()) {
              $xml = simplexml_load_string(trim($response->getBody()));
              $iteration = 0;
              foreach ($xml->channel->item as $item) {
                $postID = substr($item->link, strpos($item->link, '?p=') + 3);
                $description = $item->description;
                $moreMarker = strpos($description, '&#8230;');

                if ($moreMarker !== false) {
                  $description = substr($description, 0, $moreMarker + 7);
                }

                $iteration++;
                if ($iteration == 3) break;

                echo '<ul id="deadnews-posts">';
                echo '<h3><a href="/deadnews/#post-' . $postID . '">' . $item->title  . '</a></h3>';
                echo '<p class="date">' . substr($item->pubDate, 0, 16) . '</p>';
                echo '<p class="post">' . $description . '</p>';
                echo '</ul>';
              }
            }
            else {
          ?>
            <ul id="deadnews-posts">
              <li><h3>No Posts Available</h3></li>
            </ul>
          <?php } ?>
        </div>
      </div>
      </div><!-- end #primary .content -->
  </div><!-- end #primary -->

<?php foot(); ?>
