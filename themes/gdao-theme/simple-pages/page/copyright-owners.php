<?php

   $collId = '3'; // 'Copyright Clearance' collection

   set_current_collection(get_collection_by_id($collId));
   $limit = total_items_in_collection();
   $items = get_items(array('collection'=>$collId, 'sort_field'=>'Dublin Core,Title'), $limit);
   set_items_for_loop($items);
   $number = 0;

   while(loop_items()):
      $sortTitle = item('Dublin Core', 'Title');
      $email = item('Item Type Metadata', 'Email');
      $website = item('Item Type Metadata', 'Website');
      $address = item('Item Type Metadata', 'StreetAddress');
      $city = item('Item Type Metadata', 'City');
      $state = item('Item Type Metadata', 'State');
      $zip = item('Item Type Metadata', 'Zip');
      $country = item('Item Type Metadata', 'Country');
      $phone = item('Item Type Metadata', 'Phone');
?>

<div class="copyright-owner <?php echo ($number++ % 2) ? 'even' : 'odd';  ?>" id="<?php echo $email; ?>">
   <div><?php echo $sortTitle?> (<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>)</div>
<?php if ($address != '' || $phone != '' || $website != '') { ?>
   <div class="copyright-owner-contact-info">
      <?php if ($address != ''): ?>
         <div><?php echo $address ?></div>
         <div><?php echo $city . ', ' . $state . ' ' . $zip; ?></div>
         <div><?php echo $country; ?></div>
      <?php endif; ?>
      <?php if ($phone != ''): ?>
         <div><?php echo $phone; ?></div>
      <?php endif; ?>
      <?php if ($website != ''): ?>
         <div><a href="http://<?php echo $website; ?>" alt="website"><?php echo $website; ?></a></div>
      <?php endif; ?>
   </div>
<?php } ?>
</div>

<?php endwhile; ?>
