function fancarousel_itemLoadCallback(carousel, state) {
    for (var i = carousel.first; i <= carousel.last; i++) {
	$list = jQuery('#carousel_contents > li');

        if (carousel.has(i)) {
            continue;
        }

        if (i > $list.length) {
            break;
        }

	$li = $list.eq(i);
	$url = '', $name = '', $itemURL = '';
	$li.children().each(function(index){
		if (index == 2) {
			$url = jQuery(this).text();
		}
		else if (index == 1) {
			$name = jQuery(this).text();
		}
		else if (index == 0) {
			$itemURL = jQuery(this).text();
		}
	});

	carousel.add(i, fancarousel_getImageHTML($itemURL, $url, $name));
    }
};

function fancarousel_getImageHTML($itemURL, $url, $name) {
    $html = '<a href="' + $itemURL  + '" target="_blank"><img src="' + $url + '" alt="' + $name + '" title="' + $name;
    $html = $html + '"/></a><p><a href="' + $itemURL + '">' + $name + '</a></p>';
    return $html;
};
	
jQuery(document).ready(function() {
    jQuery('#fancarousel').jcarousel({
        size: jQuery('#carousel_contents > li').length,
        itemVisibleOutCallback: {onAfterAnimation: function(carousel, item, i, state, evt) { carousel.remove(i); }},
        itemLoadCallback: {onBeforeAnimation: fancarousel_itemLoadCallback}
    });
});
