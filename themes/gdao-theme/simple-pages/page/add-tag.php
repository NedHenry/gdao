<?php

$id = htmlspecialchars($_GET["id"]);
$tag = htmlspecialchars($_GET["tag"]);

if (empty($id)) { ?>
  <div>
    <span style="font-weight: bold;">Error (failed to find record ID) </span><br/><br/>
    <a href="mailto:gdao-technical@ucsc.edu" title="Record for add-tag lacked ID"
    >Please let us know you encountered this error</a>
  </div><?php
}
else if (empty($tag)) { ?>
  <div>
    <span style="font-weight: bold;">Error (failed to find tag) </span><br/><br/>
    <a href="mailto:gdao-technical@ucsc.edu" title="Failed to tag submit on
    <?php echo $id; ?>">Please let us know you encountered this error</a>
  </div><?php
}
else {
//  $host = substr(GDAO_WEB_SERVER, 7);
//   // Our workaround for our prod machines not being able to POST to themselves
//   if (strpos(gethostname(), 'library') === false) {
//     $serverip = $_SERVER['SERVER_ADDRESS']; // check which machine we're on...

//     // Get a different IP for www.gdao.org
//     for ($index = 0; $index <= 15; $index++) {
//       $host = gethostbyname('www03.gdao.org');
//       if ($host !== $serverip) break;
//     }
//   }
//   else {
//  $host = $_SERVER['SERVER_NAME'];
//  }

  $client = new Zend_Http_Client();
  $client->setCookieJar();
  $client->setUri(GDAO_WEB_SERVER . '/admin/users/login');
//  $client->setUri('http://' . $host . '/admin/users/login');
  $client->setConfig(array('timeout'=>60));

  // authenticate with locked down Apache (delete when we go live)
  //$client->setAuth('gdao', 'gd4oh3ad', Zend_Http_Client::AUTH_BASIC);

  // authenticate with our limited access (i.e., tagging) account
  $client->setParameterPost('username', 'tagger');
  $client->setParameterPost('password', $_ENV['GDAO_TAGGING_USER']);

  $response = $client->request('POST');

  if ($response->isSuccessful()) {
//    $client->setUri('http://' . $host . '/admin/items/modify-tags/');
  	$client->setUri(GDAO_WEB_SERVER . '/admin/items/modify-tags/');
    $client->setConfig(array('timeout'=>60));

    // authenticate with locked down Apache (delete when we go live)
    //$client->setAuth('gdao', 'gd4oh3ad', Zend_Http_Client::AUTH_BASIC);

    set_current_item(get_item_by_id($id));
    $client->setParameterPost('id', $id);
    $tags = item_tags_as_string(',', 'most', false);

    if (strpos($tags, $tag) === FALSE) {
      $client->setParameterPost('tags', $tags . ',' . $tag);
    }
    else {
      $client->setParameterPost('tags', $tags);
    }

    $response = $client->request('POST');

    if ($response->isSuccessful()) {?>
      <script language="JavaScript">
        self.location="<?php echo '/items/show/' . $id; ?>";
      </script>
      <div>It seems your browser did not redirect back to the item page like it should have.</div>
      <div><a href="/items/show/<?php echo $id; ?>">Return to the item record</a> to see your tags.</div><?php
    }
    else { ?>
      <div>
        <span style="font-weight: bold;">Error (HTTP response): </span>
        <a href="mailto:gdao-technical@ucsc.edu" title="<?php echo
        $response->getMessage(); ?>">Please let us know you encountered this error</a>
      </div><?php
    }
  }
  else { ?>
      <div>
        <span style="font-weight: bold;">Error (HTTP response): </span>
        <a href="mailto:gdao-technical@ucsc.edu" title="<?php echo
        $response->getMessage(); ?>">Please let us know you encountered this error</a>
      </div><?php
  }
}

?>
