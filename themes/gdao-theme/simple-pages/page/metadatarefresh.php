<?php
/*
function query($ark) {
  $solr = new Apache_Solr_Service(SOLR_SERVER, SOLR_PORT, SOLR_CORE);
  $queryParams = SolrSearch_QueryHelpers::getParams();
  $query = '140_s:"' . $ark  . '"';
  $json = $solr->search($query, 0, 100000, $queryParams)->getRawResponse();
  $result = json_decode($json, TRUE);

  foreach ($result['response']['docs'] as $index => $values) {
    echo '<div>' . 'items/show/' . $values['id'] . '</div>';

    if (!empty($values['140_s'])) {
      echo '<div>' . 'http://images.gdao.org/view/carousel/' . urlencode($values['140_s'][0] . '/is/1') . '</div>';
      echo '<div>' . 'http://gdao.org/' . $values['140_s'][0] . '</div>';
    }
  }
}
*/

function lastIndexOf($string, $item) {
  $index = strpos(strrev($string), strrev($item));

  if ($index) {
    return strlen($string) - strlen($item) - $index;
  }

  else return -1;
}

?>
<html>
<head>
<body>

<?php if (empty($_POST)): ?>
  <form action="<?php print $PHP_SELF?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    <span style="font-weight: bold;">Choose a CONTENTdm CSV file to upload:</span> <input name="upload_file" type="file" />
    <br/><br/>
    <input type="submit" value="Upload" />
  </form>
<?php else: ?>
  <?php
    if (($fHandle = fopen($_FILES['upload_file']['tmp_name'], "r")) != FALSE) {
      $fields = array();
      $idIndex = -1;

      if (($data = fgetcsv($fHandle)) != FALSE) {
        for ($index = 0; $index < count($data); $index++) {
          //$pos = lastIndexOf($data[$index], '_');
          //$fields[$index] = substr($data[$index], 0, $pos);
          //echo '<div>' . $fields[$index] . '</div>';
          //if ($data[$index] = 'ARK_0') {
          //  $idIndex = $index;
          //}
        }
      }
/*
      echo '<div>' . $idIndex . '</div><table>';
      while (($data = fgetcsv($fileHandle)) != FALSE) {
        echo '<tr><th>' . $data  . '</th>';
        for ($index = 0; $index < count($data); $index++) {
          echo '<td>' . $data[$index]  . '<td>';
        }
        echo '</tr>';
      }
      echo '</table>';
*/
      fclose($fileHandle);
    }
    else {
      echo '<span style="font-weight: bold;">Error: </span>Could not open the local (temporary) copy of ' . $_FILES['upload_file']['name'];
    }
  ?>
<?php endif; ?>

</body>
</html>
