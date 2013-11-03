<?php

$queryParams = SolrSearch_QueryHelpers::getParams();
$queryParams['fl'] = 'id,140_s,sortedTitle';
$queryParams['sort'] = 'sortedTitle asc';
$letter = $_GET['letter'];
$field = ' AND sortedTitle:';

$solr = new Apache_Solr_Service(SOLR_SERVER, SOLR_PORT, SOLR_CORE);
$query = '114_s:"MS 332. Grateful Dead Records, Series 11: Decorated Envelopes"';
$query = !empty($letter) ? $query . $field . substr($letter, 0, 1) . '*' : $query;
$json = $solr->search($query, 0, 100000, $queryParams)->getRawResponse();
$result = json_decode($json, TRUE);

echo '<div id="fancarousel" class="jcarousel-skin-tango"><ul></ul></div>';
echo '<div style="display:none;" id="carousel_contents">';

foreach ($result['response']['docs'] as $index => $values) {
	echo '<li class="solr_item">';

	echo '<div>' . 'items/show/' . $values['id'] . '</div>';
	echo '<div>' . $values['sortedTitle'] . '</div>';

	if (!empty($values['140_s'])) {
		echo '<div>' . JP2_IMAGE_SERVER . '/view/carousel/' . urlencode($values['140_s'][0] . '/is/1') . '</div>';
		echo '<div>' . 'http://gdao.org/' . $values['140_s'][0] . '</div>';
	}

	echo '</li>';
}

echo '</div>';

echo '<div id="alphalist">';
echo '<a href="fan-art?letter=A">[A]</a>&nbsp; <a href="fan-art?letter=B">[B]</a>&nbsp; <a href="fan-art?letter=C">[C]</a>&nbsp; ';
echo '<a href="fan-art?letter=D">[D]</a>&nbsp; <a href="fan-art?letter=E">[E]</a>&nbsp; <a href="fan-art?letter=F">[F]</a>&nbsp; ';
echo '<a href="fan-art?letter=G">[G]</a>&nbsp; <a href="fan-art?letter=H">[H]</a>&nbsp; <a href="fan-art?letter=I">[I]</a>&nbsp; ';
echo '<a href="fan-art?letter=J">[J]</a>&nbsp; <a href="fan-art?letter=K">[K]</a>&nbsp; <a href="fan-art?letter=L">[L]</a>&nbsp; ';
echo '<a href="fan-art?letter=M">[M]</a>&nbsp; <a href="fan-art?letter=N">[N]</a>&nbsp; <a href="fan-art?letter=O">[O]</a>&nbsp; ';
echo '<a href="fan-art?letter=P">[P]</a>&nbsp; <a href="fan-art?letter=Q">[Q]</a>&nbsp; <a href="fan-art?letter=R">[R]</a>&nbsp; ';
echo '<a href="fan-art?letter=S">[S]</a>&nbsp; <a href="fan-art?letter=T">[T]</a>&nbsp; <a href="fan-art?letter=U">[U]</a>&nbsp; ';
echo '<a href="fan-art?letter=V">[V]</a>&nbsp; <a href="fan-art?letter=W">[W]</a>&nbsp; <a href="fan-art?letter=X">[X]</a>&nbsp; ';
echo '<a href="fan-art?letter=Y">[Y]</a>&nbsp; <a href="fan-art?letter=Z">[Z]</a>&nbsp; <a href="fan-art">[ALL]</a>';
echo '</div>';
