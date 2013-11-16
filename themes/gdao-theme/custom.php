<?php

add_filter(array('Display', 'Item', 'Dublin Core', 'Title'), 'gdao_show_untitled_items');

function gdao_is_authorized() {
  // Our production sits behind a cache so needs to check headers
  $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'], 1);
  $ip = trim($ip[0]);

  // Our development has no cache and needs to check client IP
  if ($ip == '') {
    $ip = $_SERVER['REMOTE_ADDR'];
  }

  if (startsWith($ip, '128.114.')
      || startsWith($ip, '169.233.')) {
    return true;
  }

  return false;
}

function gdao_show_untitled_items($title) {
    $prepTitle = trim(strip_formatting($title));

    if (empty($prepTitle)) {
        return '[Untitled]';
    }

    return $title;
}

  /**
   * Create a SolrFacetLink
   *
   * @param array   $current The current facet search.
   * @param string  $facet
   * @param string  $label
   * @param integer $count
   * @return string
   */
  function gdao_createFacetHtml($current, $facet, $label, $count) {
    $uri = SolrSearch_ViewHelpers::getBaseUrl();

    $escaped = str_replace('"', '\"', $label);
    $escaped = str_replace('&', '\%26', $escaped);
    $escaped = str_replace("'", "\'", $escaped);

    if (isset($current['q'])) {
      $q = 'solrq=' . html_escape($current['q']) . '&';
    }
    else {
      $q = '';
    }

    if (!empty($current['facet'])) {
      $facetq = "{$current['facet']}+AND+$facet:&#x022;$escaped&#x022;";
    }
    else {
      $facetq = "$facet:&#x022;$escaped&#x022;";
    }

    $link = $uri . '?' . $q . 'solrfacet=' . $facetq;

    return "<div class='fn'><a href='$uri?{$q}solrfacet=$facetq'>$label</a> &nbsp;"
        . "<span class='facet_hit_count'>($count)</span></div>";
  }

function gdao_shorten_text($text) {
  $words = explode(' ', $text, 16);

  if (count($words) == 16) {
    array_pop($words);
  }

  return implode(' ', $words) . (count($words) == 15 ? '... ' : '');
}

function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);

    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function gdao_display_field($fieldName, $fieldLabel, $uri) {
  if (!empty($fieldName)) {
    echo '<div class="item-field ' . str_replace(',', '', str_replace('?', '', str_replace(' ', '_', strtolower($fieldLabel)))) . '">';
      if (is_array($fieldName) && count($fieldName) > 1) {
        echo '<h3>' . $fieldLabel . 's:</h3>';
        echo '<ul>';
          foreach ($fieldName as $name) {
            echo '<li>';
              if (!is_null($uri) && startsWith($name, 'http')) {
                echo '<a href="' . urldecode($name) . '" target="_blank">' . gdao_format($name) . '</a>';
              }
              elseif (!is_null($uri)) {
                echo '<a href="' . $uri . gdao_solr_escape($name) . '">';
                echo gdao_format($name) . '</a>';
              }
              else {
                echo gdao_format($name);
              }
            echo '</li>';
          }
        echo '</ul>';
      }
      else {
        $name = '';

	if (is_array($fieldName)) {
	  $name = $fieldName[0];
	}
	else {
	  $name = $fieldName;
	}

        echo '<h3>' . $fieldLabel . ':</h3>';
        echo '<ul>';
          echo '<li>';
            if (!is_null($uri) && startsWith($name, 'http')) {
              echo '<a href="' . urldecode($name) . '" target="_blank">' . gdao_format($name) . '</a>';
            }
            elseif (!is_null($uri)) {
              echo '<a href="' . $uri . gdao_solr_escape($name) . '">' . gdao_format($name) . '</a>';
            }
            else {
              echo gdao_format($name);
            }
          echo '</li>';
        echo '</ul>';
      }
    echo '</div>';
  }
}

// + - & || ! ( ) { } [ ] ^ " ~ * ? : \
function gdao_solr_escape($query) {
	$query = str_replace('&quot;', '"', $query);
    $query = str_replace(':', '\%3A', $query);
    $query = str_replace('+', '\%2B', $query);
    $query = str_replace('-', '\-', $query);
    $query = str_replace('(', '\(', $query);
    $query = str_replace(')', '\)', $query);
    $query = str_replace('[', '\%5B', $query);
    $query = str_replace(']', '\%5D', $query);
    $query = str_replace('"', '\%22', $query);
    $query = str_replace('?', '\%3F', $query);
    $query = str_replace('^', '\%5E', $query);
    $query = str_replace('&#039;', "\'", $query);
    $query = str_replace('&', '\%26', $query);
    $query = str_replace('|', '\%7C', $query);
    $query = str_replace('!', '\!', $query);
    $query = str_replace('{', '\%7B', $query);
    $query = str_replace('}', '\%7D', $query);

    return '%22' . $query . '%22';
}

function gdao_create_sort_form() {
	$uri = SolrSearch_ViewHelpers::getBaseUrl();
	$sort = $_REQUEST['sort'];

	$html .= '<div id="gdao_search_sort_form">';
	$html .= '<form action="' . $uri . '" method="get">';
	$html .= '<input type="hidden" name="solrq" value="';
	$html .= $_REQUEST['solrq'] . '" id="solrq"/>';
	$html .= "<input type='hidden' name='solrfacet' value='";
	$html .= $_REQUEST['solrfacet'] . "' id='solrfacet'/>";
	$html .= '<span id="sort-label">';
	$html .= '<label for="sort" class="optional">Sort By</label>';
	$html .= '</span>';
	$html .= '<select name="sort" id="sort">';

	$html .= '<option value="" label="Relevancy"';
	$html .= ((empty($sort) ? ' selected="selected"' : ' ') . '>Relevancy</option>');

	$html .= '<option value="sortedDate asc" label="Date Ascending"';
	$html .= (($sort == 'sortedDate asc' ? ' selected="selected"' : ' ') . '>Date Ascending</option>');

	$html .= '<option value="sortedDate desc" label="Date Descending"';
	$html .= (($sort == 'sortedDate desc' ? ' selected="selected"' : ' ') . '>Date Descending</option>');
	$html .= '</select>';

	$html .= '<input type="submit" name="submit" id="submit" value="Go"/>';
	$html .= '</form>';
	$html .= '</div>';

	return $html;
}

function gdao_solr_search_element_lookup($facet) {
	$label;

	if ($facet == '39_s') {
		$label = 'Creator';
	}
	elseif ($facet == '38_s') {
		$label = 'Related Show';
	}
	elseif ($facet == '48_s') {
		$label = 'Source';
	}
	elseif ($facet == '40_s') {
		$label = 'Date';
	}
	elseif ($facet == '49_s') {
		$label = 'Subject';
	}
	elseif ($facet == '125_s') {
		$label = 'Venue';
	}
	elseif ($facet == '126_s') {
		$label = 'Show Date';
	}
	elseif ($facet == 'itemtype') {
		$label = 'Item Type';
	}
	elseif ($facet == '260_s') {
		$label = 'Subject';
	}
	elseif ($facet == '196_s') {
		$label = 'Year';
	}
	else {
		$label = $facet;
	}

	return $label;
}

function gdao_facet_is_displayable($facet) {
	if ($facet == 'Copyright Clearance') {}
	else {
		return true;
	}

	return false;
}

function gdao_format($string) {
	// strtotime() doesn't handle year/month designations; adding workaround
	// an example of this timestamp is: 2012-00-00T00:00:00Z
	if (endsWith($string, '-00-00T00:00:00Z')) {
		return substr($string, 0, 4);
        }
	else if (endsWith($string, '-00T00:00:00Z')) {
		return substr($string, 0, 7);
	}
	else if (endsWith($string, 'T00:00:00Z')) {
		return substr($string, 0, 10);
	}

	$time = strtotime($string);

	if ($time == true) {
		return date('Y-m-d', $time);
	}

	return $string;
}

function gdao_solr_search_facet_link($current, $facet, $label, $count) {
    $html = '';
    $uri = solr_search_base_url();

	// if the query contains one of the facets in the list
    if (isset($current['q']) && strpos($current['q'], "$facet:\"$label\"") !== false) {
        //generate remove facet link
        $removeFacetLink = solr_search_remove_facet($facet, $label);
        $html .= "<div class='fn'><b>$label</b></div> "
            . "<div class='fc'>$removeFacetLink</div>";
    }
    else {
        if (isset($current['q'])) {
            $q = 'solrq=' . html_escape($current['q']) . '&';
        }
        else {
            $q = '';
        }

        if (isset($current['facet']) && $current['facet'] != '') {
            $facetq = "{$current['facet']}+AND+$facet:&#x022;$label&#x022;";
        }
        else {
            $facetq = "$facet:&#x022;$label&#x022;";
        }

        //otherwise just display a link to a new query with the facet count
        $html .= "<div class='gdao_facet'><span class='gdao_facet_value'>"
            . "<a href='$uri?{$q}solrfacet=$facetq'>$label</a></span>&nbsp; ("
            . "<span class='gdao_facet_count'>$count</span>)</div>";
    }

    return $html;
}

function gdao_solr_search_remove_facets() {
	$uri = solr_search_base_url();
	$queryParams = solr_search_get_params();
	$html = '';

	if (empty($queryParams) || (isset($queryParams['q']) && $queryParams['q'] == '*:*'
			&& !isset($queryParams['facet']))) {
		$html .= '<li><b>ALL TERMS</b></li>';
	}
	else {
		if (isset($queryParams['q'])) {
			$html .= "<li><b>Keyword:</b> {$queryParams['q']} "
			. "[<a href='$uri?solrfacet={$queryParams['facet']}'>X</a>]"
			. "</li>";
		}

		if (isset($queryParams['facet'])) {
			foreach (explode(' AND ', $queryParams['facet']) as $param) {
				$paramSplit = explode(':', $param);
				$facet = $paramSplit[0];
				$label = trim($paramSplit[1], '"');

				if (strpos($param, '_') !== false) {
					$category = solr_search_element_lookup($facet);
                }
                else {
					$category = ucwords($facet);
				}

				if ($facet != '*') {
					$link = solr_search_remove_facet($facet, $label);
					$html .= "<li><b>$category:</b> $label $link</li>";
				}
			}
		}
	}

    return $html;
}

/**
  Displays Kaltura viewer; metadata has playerID, too, but we're ignoring?
*/
function gdao_display_kaltura($uiConfID, $entryID, $height, $width) {
  echo '<script type="text/javascript" src="http://www.kaltura.com/p/475671/sp/47567100/embedIframeJs/uiconf_id/';
  echo $uiConfID . '/partner_id/475671"></script><object id="kaltura_player_1337299051" name="kaltura_player_1337299051" ';
  echo 'type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" ';
  echo 'height="' . $height . '" width="' . $width . '" bgcolor="#FFFFFF" xmlns:dc="http://purl.org/dc/terms/" ';
  echo 'xmlns:media="http://search.yahoo.com/searchmonkey/media/" rel="media:video" ';
  echo 'resource="http://www.kaltura.com/index.php/kwidget/cache_st/1337299051/wid/_475671/uiconf_id/';
  echo $uiConfID . '/entry_id/' . $entryID . '" ';
  echo 'data="http://www.kaltura.com/index.php/kwidget/cache_st/1337299051/wid/_475671/uiconf_id/';
  echo $uiConfID . '/entry_id/' . $entryID . '"><param name="allowFullScreen" value="true" /><param name="allowNetworking" ';
  echo 'value="all" /><param name="allowScriptAccess" value="always" /><param name="bgcolor" value="#000000" />';
  echo '<param name="flashVars" value="&{FLAVOR}" /><span property="media:width" content="' . $width . '"></span><span ';
  echo 'property="media:height" content="' . $height . '"></span><span property="media:type" ';
  echo 'content="application/x-shockwave-flash"></span></object>';
}
