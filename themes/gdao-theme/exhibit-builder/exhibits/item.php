<?php head(array('title' => item('Dublin Core', 'Title'),'bodyid'=>'items','bodyclass' => 'show item')); ?>

<?php $curated = item('Item Type Metadata', 'Curated'); ?>

<div id="primary" <?php echo strcmp($curated, 'no') == 0 ? 'class="new-item"' : ''; ?>>
  <h1><?php echo item('Dublin Core', 'Title'); ?></h1>

  <div id="fields-primary">
    <?php $itemtype = item('item type name'); ?>
    <?php $ark = item('Item Type Metadata', 'ARK'); ?>
    <?php $restricted = item('Item Type Metadata', 'AccessRestricted'); ?>
    <?php $source = item('Dublin Core', 'Source'); ?>

    <?php if ($restricted != 'true' || gdao_is_authorized()): ?>
      <?php if ($source == 'Internet Archive'): ?>
        <?php $iaID = item('Dublin Core', 'Identifier'); ?>
        <iframe src="http://archive.org/embed/<?php echo $iaID; ?>&playlist=1" width="400" height="400" frameborder="0"></iframe>
      <?php elseif ($itemtype == 'Sound' && !empty($ark)): ?>
        <?php $entryID = item('Item Type Metadata', 'KalturaEntryID'); ?>
        <?php $uiConfID = item('Item Type Metadata', 'KalturaUIConfID'); ?>
        <?php $playerID = item('Item Type Metadata', 'KalturaPlayerID'); ?>
        <?php echo gdao_display_kaltura('8129212', $entryID, '30', '320'); ?>
      <?php elseif ($itemtype == 'Video' && !empty($ark)): ?>
        <?php $entryID = item('Item Type Metadata', 'KalturaEntryID'); ?>
        <?php $uiConfID = item('Item Type Metadata', 'KalturaUIConfID'); ?>
        <?php $playerID = item('Item Type Metadata', 'KalturaPlayerID'); ?>
        <?php echo gdao_display_kaltura('8129222', $entryID, '400', '500'); ?>
      <?php elseif ($itemtype == 'Website'): ?>
        <?php $urls = item('Item Type Metadata', 'URL', array('all'=>true)); ?>
        <?php gdao_display_field($urls, 'URL', ''); ?>
        <?php $description = item('Dublin Core', 'Description', array('all'=>true)); ?>
        <?php gdao_display_field($description, 'Description', NULL); ?>
      <?php elseif ($itemtype == 'Story'): ?>
        <div class="oral-history">
          <?php $ohHow = item('Item Type Metadata', 'gdao-oh-how'); ?>
          <?php gdao_display_field($ohHow, 'How did you become a Deadhead?', NULL); ?>
          <?php $ohShow = item('Item Type Metadata', 'gdao-oh-show'); ?>
          <?php gdao_display_field($ohShow, 'What is your favorite Dead show, and why?', NULL); ?>
          <?php $ohSong = item('Item Type Metadata', 'gdao-oh-song'); ?>
          <?php gdao_display_field($ohSong, 'What is your favorite Dead song, and why?', NULL); ?>
          <?php $ohScene = item('Item Type Metadata', 'gdao-oh-scene'); ?>
          <?php gdao_display_field($ohScene, 'What is your favorite aspect of the Dead scene?', NULL); ?>
          <?php $ohPhenom = item('Item Type Metadata', 'gdao-oh-phenom'); ?>
          <?php gdao_display_field($ohPhenom, 'What, if anything, do you think is important about the Dead, and about the Dead phenomenon?', NULL); ?>
          <?php if (item_has_files()): ?>
            <div id="item-files" class="item-field">
              <h3><?php echo __('Files'); ?></h3>
              <div><?php echo display_files_for_item(); ?></div>
            </div>
          <?php endif; ?>
        </div>
      <?php elseif ($itemtype == 'Article' && empty($ark)): ?>
        <?php if (item_has_files()): ?>
          <div id="item-files" class="item-field">
            <h3><?php echo __('Files'); ?></h3>
            <div><?php echo display_files_for_item(); ?></div>
          </div>
        <?php endif; ?>
      <?php elseif (!empty($ark)): ?>
        <?php echo item('Item Type Metadata', 'StructMap'); ?>
      <?php elseif (item_has_files()): ?>
        <div id="item-files" class="item-field">
          <?php if ($itemtype == 'Video' || $itemtype == 'Audio'): ?>
            <h3><?php echo __('Files'); ?></h3>
          <?php endif; ?>
          <?php echo display_files_for_item(); ?>
        </div>
      <?php endif; ?>
    <?php elseif ($restricted == 'true' && !gdao_is_authorized()): ?>
      <div id="restricted-item" class="item-field">
        <img src="/themes/gdao-theme/images/content-not-available.png"
        alt="Access is restricted to UCSC campus for copyright reasons"/>
      </div>
    <?php endif; ?>

  <div class="item-fields">
  <?php $creators = item('Dublin Core', 'Creator', array('all'=>true)); ?>
  <?php gdao_display_field($creators, 'Creator', '/solr-search/results/?solrq=39_s:'); ?>

  <?php $dates = item('Dublin Core', 'Date', array('all'=>true)); ?>
  <?php gdao_display_field($dates, 'Date', '/solr-search/results/?solrq=40_s:'); ?>

  <?php $coverages = item('Dublin Core', 'Coverage', array('all'=>true)); ?>
  <?php gdao_display_field($coverages, 'Related Show', '/solr-search/results/?solrq=38_s:'); ?>

  <?php $subjects = item('Item Type Metadata', 'AllSubjects', array('all'=>true)); ?>
  <?php gdao_display_field($subjects, 'Subject', '/solr-search/results/?solrq=260_s:'); ?>

  <?php if ($itemtype != 'Website'): ?>
    <?php $urls = item('Item Type Metadata', 'URL', array('all'=>true)); ?>
    <?php gdao_display_field($urls, 'URL', ''); ?>
  <?php endif; ?>

  <div id="item-citation" class="item-field citation">
    <h3>Citation:</h3>
    <p id="citation"><?php echo item_citation(); ?></p>
  </div>

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style item-field social-links">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4fcd594c19cdb40c"></script>
<!-- AddThis Button END -->

  </div>
  </div>
<!-- Below the fold -->

  <div id="fields-secondary">

    <?php $tocs = item('Dublin Core', 'Table Of Contents'); ?>
    <?php if ($tocs): ?>
      <div id="item-toc" class="item-field toc">
        <h3>Contents:</h3>
        <?php echo $tocs; ?>
      </div>
    <?php endif; ?>

    <?php $publishers = item('Dublin Core', 'Publisher', array('all'=>true)); ?>
    <?php gdao_display_field($publishers, 'Publisher/Printer', '/solr-search/results/?solrq=45_s:'); ?>

    <?php $promoters = item('Item Type Metadata', 'Promoter', array('all'=>true)); ?>
    <?php gdao_display_field($promoters, 'Promoter', '/solr-search/results/?solrq=141_s:'); ?>

    <?php if ($itemtype != 'Website'): ?>
      <?php $description = item('Dublin Core', 'Description', array('all'=>true)); ?>
      <?php gdao_display_field($description, 'Description', NULL); ?>
    <?php endif; ?>

    <?php $series = item('Dublin Core', 'Is Part Of', array('all'=>true)); ?>
    <?php gdao_display_field($series, 'Collection Title', '/solr-search/results/?solrq=114_s:'); ?>

    <?php $formats = item('Dublin Core', 'Format', array('all'=>true)); ?>
    <?php gdao_display_field($formats, 'Format', '/solr-search/results/?solrq=42_s:'); ?>

    <?php $extents = item('Dublin Core', 'Extent'); ?>
    <?php gdao_display_field($extents, 'Extent', NULL); ?>

    <?php $languages = item('Dublin Core', 'Language'); ?>
    <?php gdao_display_field($languages, 'Language', '/solr-search/results/?solrq=44_s:'); ?>

    <?php $types = item('Dublin Core', 'Type'); ?>
    <?php gdao_display_field($types, 'Type', '/solr-search/results/?solrq=51_s:'); ?>

    <?php $relatedResources = item('Dublin Core', 'Relation', array('all'=>true)); ?>
    <?php gdao_display_field($relatedResources, 'Related Resource', NULL); ?>

    <?php $owningInst = item('Item Type Metadata', 'OwningInstitution'); ?>
    <?php gdao_display_field($owningInst, 'Owning Institution and Contact Info', NULL); ?>

    <?php $owningInstURL = item('Item Type Metadata', 'OwningInstitutionURL'); ?>
    <?php gdao_display_field($owningInstURL, 'Owning Institution Homepage', ''); ?>

    <?php $provenance = item('Dublin Core', 'Provenance'); ?>
    <?php gdao_display_field($provenance, 'Donor and Provenance', NULL); ?>

    <?php $accession = item('Dublin Core', 'Identifier'); ?>
    <?php gdao_display_field($accession, 'Accession Number', NULL); ?>

    <?php if ($restricted != 'true' || gdao_is_authorized()): ?>
      <?php $ark = item('Item Type Metadata', 'ARK'); ?>
      <?php gdao_display_field($ark, 'Archival Resource Key', NULL); ?>
    <?php endif; ?>

    <?php $boxFolder = item('Item Type Metadata', 'BoxFolder'); ?>
    <?php gdao_display_field($boxFolder, 'Box-Folder', NULL); ?>

    <?php $callNumber = item('Item Type Metadata', 'CallNumber'); ?>
    <?php gdao_display_field($callNumber, 'Call Number', NULL); ?>

    <?php $archivedUrls = item('Item Type Metadata', 'ArchivedURL', array('all'=>true)); ?>
    <?php gdao_display_field($archivedUrls, ' Archived URL', ''); ?>

    <?php $rightsHolder = item('Dublin Core', 'Rights Holder'); ?>
    <?php // check to make sure there is no markup
      if (strpos($rightsHolder, '</') === false) {
        $holders = explode(';', $rightsHolder);
        $queryParams = SolrSearch_QueryHelpers::getParams();
        $solr = new Apache_Solr_Service(SOLR_SERVER, SOLR_PORT, SOLR_CORE);
        $copyright = 'Copyright Information';

        foreach ($holders as $holder) {
          $holder = trim($holder);
          $search = 'collection:"Copyright Clearance" AND (50_s:"' . $holder  . '" OR 418_s:"' . $holder . '")';
          $results = $solr->search($search, 0, 1, $queryParams);

          if ($results->getHttpStatus() == 200) {
            $found = $results->response->numFound;

            if ($found == 1) {
              // We need to handle these differently because their links differ
              // Even though we're using foreach, there's just one b/c solr limit
              foreach ($results->response->docs as $doc) {
                $email = $doc->getField('158_s');
                echo '<h3>' . $copyright . ':</h3><ul><li>';
                echo '<a href="/copyright-owners#' . $email['value'] . '">';
                echo $holder . '</a></li></ul>';
              }
            }
            else {
              gdao_display_field($holder, $copyright, NULL);
            }
          }
          else {
            gdao_display_field($holder, $copyright, NULL);
          }
        }
      }
      else {
        gdao_display_field($rightsHolder, 'Copyright Information', NULL);
      }
    ?>

    <?php $rights = item('Dublin Core', 'Rights'); ?>
    <?php gdao_display_field($rights, 'Copyright Statement', NULL); ?>

  </div>

  <div id="comment-fields">
    <div id="item-tags" class="item-field tags">
      <div id="tags-label">
      <h2>Tags</h2>
      </div>
      <?php if (item_has_tags()): ?>
        <p><?php echo item_tags_as_string(); ?></p>
      <?php endif; ?>
      <form name="add-tag-form" id="add-tag-form" method="get" action="/add-tag">
        <p>Add a new tag:
        <input type="text" name="tag" />
        <input type="hidden" name="id" value="<?php echo item('ID'); ?>"/>
        <input type="submit" value="Submit" /></p>
      </form>
    </div>
    <br/><br/><!-- know this less than ideal, but for now... -->

  <!-- Comments pulled in here -->
  <?php echo plugin_append_to_items_show(); ?>
  </div>

</div><!-- End of Primary -->

<?php foot(); ?>
