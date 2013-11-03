<?php

$queryParams = SolrSearch_QueryHelpers::getParams();
$queryParams['facet.field'] = '39_s';
$queryParams['facet.limit'] = '10';
$queryParams['facet'] = 'true';

$search = '(114_s:"MS 332. Grateful Dead Records, Series 6: Photographs" OR 114_s:"MS 334. Herb Greene Photographs" OR 114_s:"MS 344. Susanna Millman Collection")';

$solr = new Apache_Solr_Service(SOLR_SERVER, SOLR_PORT, SOLR_CORE);
$json = $solr->search($search, 0, 0, $queryParams)->getRawResponse();
$result = json_decode($json, TRUE);

$client = new Zend_Http_Client();
$hostname = gethostname();

if (strpos($hostname, 'library') !== false) {
  $client->setUri('http://gdao-dev.library.ucsc.edu/themes/gdao-theme/meta/artists.xml');
}
else {
  $client->setUri('http://www.gdao.org/themes/gdao-theme/meta/artists.xml');
}

$client->setCookieJar();
// temporary u/p set up for the dev servers; remove once we're live
$client->setAuth('gdao', 'gd4oh3ad', Zend_Http_Client::AUTH_BASIC);
$client->setConfig(array('timeout' => 30));

$response = $client->request('GET');
$xml = simplexml_load_string('<artists/>');

if ($response->isSuccessful()) {
  $xml = simplexml_load_string($response->getBody());
}

echo '<div id="photographers"><h2>Photographers</h2>';

foreach ($result['facet_counts']['facet_fields']['39_s'] as $name => $count) {
	$ark = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name)  . '"]/ark');
	$restricted = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name) . '"]/restricted-access');
	$ark[0] = urlencode($ark[0] . '/is/1');

	echo '<div class="artists-browse">';
	echo '<div><h3><a href="/solr-search/results/?solrfacet=39_s:' . gdao_solr_escape($name) . '">' . htmlspecialchars($name) . '</a> ';
	echo '<span class="count">(' . $count . ')</span></h3></div>';
	echo '<div><a href="/solr-search/results/?solrfacet=39_s:' . gdao_solr_escape($name) . '">';
	if (count($restricted) > 0 && !gdao_is_authorized()) {
		echo '<img src="/themes/gdao-theme/images/content-not-available.png"/></a></div>';
	}
	else {
		echo '<img src="' . JP2_IMAGE_SERVER . '/view/carousel/' . $ark[0] . '"/></a></div>';
	}
	echo '</div>';
}

echo '<p class="browse-more"><a href="/solr-search/results/?solrq=' . urlencode($search) . '" class="more">View More Photographers</a></p>';
echo '</div>';

$search = '(114_s:"MS 332. Grateful Dead Records, Series 8: Posters" OR 114_s:"MS 340: David Singer Poster Collection, 1969-1971" OR 114_s:"MS 342. Nicholas G. Meriwether Poster Collection")';
$queryParams['facet.limit'] = '11'; // So we can skip Greene, he's a photographer mostly
$json = $solr->search($search, 0, 0, $queryParams)->getRawResponse();
$result = json_decode($json, TRUE);

echo '<div id="poster-artists"><h2>Poster Artists</h2>';

// get rid of this duplication with a js function
foreach ($result['facet_counts']['facet_fields']['39_s'] as $name => $count) {
	if (!startsWith($name, 'Greene, Herb, 1942-')) {
		$ark = $xml->xpath("/artists/artist[name='" . str_replace("'", '', str_replace('"', '', $name)) . "']/ark");
		$restricted = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name) . '"]/restricted-access');
        	$ark[0] = urlencode($ark[0] . '/is/1');

		echo '<div class="artists-browse">';
		echo '<div><h3><a href="/solr-search/results/?solrfacet=39_s:' . gdao_solr_escape($name) . '">' . htmlspecialchars($name) . '</a> ';
		echo '<span class="count">(' . $count . ')</span></h3></div>';
		echo '<div><a href="/solr-search/results/?solrfacet=39_s:' . gdao_solr_escape($name) . '">';
		if (count($restricted) > 0 && !gdao_is_authorized()) {
			echo '<img src="/themes/gdao-theme/images/content-not-available.png"/></a></div>';
		}
		else {
			echo '<img src="' . JP2_IMAGE_SERVER . '/view/carousel/' . $ark[0] . '"/></a></div>';
		}
		echo '</div>';
	}
}

echo '<p class="browse-more"><a href="/solr-search/results/?solrq=' . urlencode($search) . '" class="more">View More Poster Artists</a></p>';
echo '</div>';
