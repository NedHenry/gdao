// JavaScript Document

jQuery(document).ready(function() {

  /* advanced search scripts */
  jQuery('#as-submit').click(function() {
    $url = '/solr-search/results/?solrq=';

    jQuery('.as-query').each(function() {
      $field = jQuery(this).find('select').val();
      $term = jQuery(this).find('input:text').val();

      if ($term != '') {
        if ($field != '') {
          $url += ($field + ':(' + $term + ')');
        }
        else {
          $url += ('(' + $term + ')');
        }

        $url += ' AND ';
      }
    });

    $itemtype = jQuery('#item-type').val();

    if ($itemtype != '') {
      $url += ('itemtype:%22' + $itemtype + '%22 AND ');
    }

    $date1 = jQuery("#datepicker1").val();
    $date2 = jQuery("#datepicker2").val();

    if ($date1 == '' && $date2 == '') {
      // do nothing
    }
    else if ($date1 != '' && $date2 == '') {
      $url += ('40_s:[' + $date1 + 'T00:00:00.000Z TO *]');
    }
    else if ($date2 != '' && $date1 == '') {
      $url += ('40_s:[* TO ' + $date2 + 'T00:00:00.000Z]');
    }
    else {
      $url += ('40_s:[' + $date1 + 'T00:00:00.000Z TO ' + $date2 + 'T00:00:00.000Z]');
    }

    if ($url.substr($url.length - 5) === ' AND ') {
      $url = $url.substr(0, $url.length - 5);
    }

    jQuery(location).attr('href', $url);
  });

  jQuery("#datepicker1").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    minDate: "1965-01-01",
    maxDate: "1996-01-01",
    yearRange: "1965:1996"
  });

  jQuery("#datepicker2").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    minDate: "1965-01-01",
    maxDate: "1996-01-01",
    yearRange: "1965:1996"
  });
  /* end of advanced search scripts */
  /* homepage scripts */

  jQuery('span#whatsnew-title').insertBefore('p.view-items-link span');

  /* end of homepage scripts */

  /* new contributions script */

  jQuery('#gdao_solr_results .new-item h3 a').each(function() {
    var itemUrl = jQuery(this).attr('href');
	var reviewUrl =jQuery('<p class="new-button"><a href="' + itemUrl + '">Newly Contributed. Please review.</a>');
	reviewUrl.insertAfter(this.parentNode);
  });

  if(jQuery('div#primary').hasClass('new-item')) {
  var reviewLink = jQuery('<p class="new-button"><a href="#flagthis">Newly Contributed. Please review.</a>');
  reviewLink.insertBefore('div#fields-primary');
  }

  /* end new contributions script */

  /* item page scripts */

  jQuery('.thumbnail_image > img').each(function() {
    jQuery(this).click(function() {
      $ark = jQuery(this).parent().attr('id');
      $image = jQuery('.main_image > img');
      jQuery($image).parent().attr('id', $ark);
      $is = jQuery($image).attr('src');
      $is = $is.split('ark%3A')[0] + encodeURIComponent($ark);
      jQuery($image).attr('src', $is);
    });
  });

  jQuery('.main_image > img').click(function() {
    $thumbCount = jQuery('.thumbnail_image').length;
    $id = jQuery(location).attr('href').split('/').pop();
    $ark = jQuery(this).parent().attr('id');
    $w = jQuery(this).width();
    $h = jQuery(this).height();
    $zoomURL = '/zoom?ark=' + encodeURIComponent($ark) + '&id=' + $id;

    if (document.title.indexOf('[album cover]') != -1) {
      $zoomURL = $zoomURL + '&h=' + $h + '&w=' + $w;
    }

    if (jQuery.browser.msie) {
      $zoomURL = $zoomURL + '&ie=true';
    }

    jQuery(location).attr('href', $zoomURL + '&c=' + $thumbCount);
  });

  // Puts the item title into the page's H1
  jQuery("h1:contains('Image Zoom')").text(function() {
    $titleDiv = jQuery('#zoom_title');
    jQuery($titleDiv).hide();
    return jQuery($titleDiv).text();
  });


  // Show/hide for item page fields
  jQuery('div#fields-secondary').addClass('hidden');
  jQuery('<p class="more">Show Details</p>').insertAfter('div#fields-primary');
  jQuery('p.more').toggle(
    function() {
        jQuery('#fields-secondary').slideDown();
        jQuery(this).html('Hide Details');
    },
    function() {
        jQuery('#fields-secondary').slideUp();
        jQuery(this).html('Show Details');
    }
  );

  // item page styles

  jQuery('#fields-primary div.url h3').addClass('hidden');
  jQuery('body#items p.comment-reply').addClass('more');
  jQuery('#fields-primary div.description h3').addClass('hidden');
  jQuery('body#items div#primary object').wrap('<div class="object" />');
  jQuery('body#items div#primary iframe').wrap('<div class="iframe" />');
  jQuery('body#items div.description').appendTo('body#items div.url');

  if (jQuery('div#fields-secondary div.format a:contains("Video recording")').length > 0) {
    jQuery("div#fields-primary div.object").addClass('video');
  }

  jQuery('form#comment-form label[for="author_url"]').addClass('hidden');
  jQuery('form#comment-form label[for="author_url"] + div').addClass('hidden');


  /* Comment form dialog */
  if (jQuery('div#comments-flash div.success').length > 0) {
    jQuery('div#comments-flash').addClass('hidden');
	alert ('Thanks. Your comments will be vetted and posted soon');
  }

  /* adding 'click to zoom' text to item page */

  jQuery('body#items div.main_image').append ('<p class="instructions">Click to Zoom</p>');

  /* Adding 'flag this' link and 'newly contributed, please review. */
  var pageUrl = jQuery(location).attr('href');
  var urlIndex = pageUrl.lastIndexOf('/');
  var itemNumber = pageUrl.substring(urlIndex + 1, pageUrl.length);


  var flagThis = jQuery('<div id="flagthis"><a href="mailto:grateful@ucsc.edu?subject=Flagged%20Item:' + itemNumber + '" title="Flagged Item!' + itemNumber + '" id="flag-image"><img src="/themes/gdao-theme/images/flagthis.png" /></a><p><a href="mailto:grateful@ucsc.edu?subject=Flagged%20Item:' + itemNumber + '" title="Flagged Item!' + itemNumber + '">Flag this item as inappropriate</a>. (<span class="whatsthis"><a href="/help#flagging">What\'s this?</a></span>)</p>');
  if(jQuery('body#items div#primary').hasClass('new-item')) {
    jQuery(flagThis).insertBefore('body#items div#comment-fields');
  }


  /* end of item page scripts */


  /* exhibit scripts */

  jQuery('body#exhibit ul.exhibit-page-nav')
    .insertAfter('body#exhibit div#primary div#nav-container');

  jQuery('body#exhibit #primary > h2')
    .next().addClass('exhibit-content');

  jQuery('body#exhibit div#primary > h2')
    .prependTo('body#exhibit div#primary div.exhibit-content');

  jQuery('body#exhibit div#primary div#exhibit-page-navigation')
    .insertAfter('body#exhibit div#primary div.exhibit-content');

  jQuery('body#exhibit ul.exhibit-page-nav li:first-child')
    .addClass('first');

  jQuery('body#exhibit h2:contains("Credits")')
    .addClass('hidden');

  jQuery('body#exhibit #primary p:empty')
    .addClass('hidden');

  jQuery('body#exhibit div#exhibit-sections')
    .addClass('hidden');


/* Modify img src on exhibit pages to point to desired image in record. */
  jQuery('body#exhibit div.exhibit-item').each(function(){
    if (jQuery(this).find('address').length > 0) {
      var imgNumber = jQuery(this).find('address').text();
	  var imgNumber = imgNumber.trim();
      var imgSrc = jQuery(this).find('img').attr('src');
      var imgSrc = imgSrc.slice(0,-1);
      jQuery(this).find('img').attr("src", imgSrc + imgNumber);
      jQuery(this).find('address').addClass('hidden');
    };
  });

 /* add image to /exhibits and main exhibit pages */

  if(jQuery('body.summary address').length > 0){
	jQuery('div#primary h2.hidden').remove();
	jQuery('div#primary h2').addClass('hidden');
    imgArk = jQuery('body.summary div#primary address').text();
	arkArray = imgArk.split('/');
	imgArk = arkArray[0];
	imgNumber = arkArray[1];
	itemNumber = arkArray[2];
	imgSrc = 'http://images03.gdao.org/view/image/ark%3A%2F38305%2F' + imgArk + '%2Fis%2F' + imgNumber;
	imgLink = '<div class="exhibit-image"><a href="http://www03.gdao.org/items/show/' + itemNumber + '"><img src="' + imgSrc + '"></a></div>';
	jQuery(imgLink).insertAfter('div#primary h2');
	jQuery('body.summary #primary address').addClass('hidden');
  }

  jQuery('body.browse div#exhibits div.exhibit').each(function(){
    if (jQuery(this).find('address').length > 0) {
      imgArk = jQuery(this).find('address').text();
	  arkArray = imgArk.split('/');
	  imgArk = arkArray[0];
	  imgNumber = arkArray[1];
	  exhibitLink = jQuery(this).find('h2 a').attr('href');
	  imgSrc = 'http://images03.gdao.org/view/thumbnail/ark%3A%2F38305%2F' + imgArk + '%2Fis%2F' + imgNumber;
	  imgLink = '<div class="exhibit-image"><a href="' + exhibitLink + '"><img src="' + imgSrc + '"></a></div>';
	  jQuery(imgLink).prependTo(jQuery(this));
	  jQuery('body.browse div#exhibits address').addClass('hidden');
    };
  });


  /* end of exhibit scripts */


  /* adding classes to put various content into columns. */
  jQuery('#fantapes_browse').addClass('three-1');
  jQuery('#audiorecs_browse').addClass('three-2');
  jQuery('#videorecs_browse').addClass('three-3');
  jQuery('#photographers').addClass('two-1');
  jQuery('#poster-artists').addClass('two-2');

  /* this is from: http://www.electrictoolbox.com/jquery-change-default-value-on-focus/ */
  jQuery('.default-value').each(function() {
	var default_value = 'Search the Collection...';
	jQuery(this).focus(function() {
	  if(this.value == default_value) {
		this.value = '';
	  }
	});

	jQuery(this).blur(function() {
	  if(this.value == '') {
		this.value = default_value;
	  }
	});
  });

  /* Show copyright and license radio buttons on contribution page. Also add instruction to Your Story form. */

var requiredFields = jQuery('<div id="required-fields"><p>Required fields are in red. Maximum allowed filesize is 30MB.</p></div>');

var audioFiletypes = jQuery('<div id="filetypes"><p>Allowed file types: aif, avi, mp3, wav. Maximum allowed filesize is 30MB.</p></div>');

var imageFiletypes = jQuery('<div id="filetypes"><p>Allowed file types: gif, jpg, png. Maximum allowed filesize is 30MB.</p></div>');

var videoFiletypes = jQuery('<div id="filetypes"><p>Allowed file types: aif, avi, mp3, wav. Maximum allowed filesize is 30MB.</p></div>');

var articleFiletypes = jQuery('<div id="filetypes"><p>Allowed file types: pdf, rtf, txt. Maximum allowed filesize is 30MB.</p></div>');


var ohInstructions = jQuery('<ul id="oh-instructions"><li>Welcome! Please tell Your Story in your own words by either typing your answers to the five questions below, or by leaving a voicemail.</li><li>Your Story will be searchable and browsable to the public as part of the GDAO collection available online. As you answer the questions, be mindful, thoughtful and reasonable about how your comments will reflect upon yourself and other people in your story. You are responsible for the content of your comments, including for any violations of the privacy rights of other individuals. Please consider de-identifying third parties mentioned in Your Story (for example, use "my friend" instead of your friend\'s actual name, or use only first names of non-famous people)</li><li>If you\'d like to orally record your answers by voicemail, please call 831 824 4163 (Please keep in mind that voicemails are limited to three minutes and plan accordingly)</li><li>If you leave a voicemail, you will not be required to type your answers below just write "recorded" in the title field below. We will transcribe your answers into written form for inclusion within GDAO. We will strive for accurate transcription but cannot guarantee complete accuracy</li><li>To submit for Tell Your Story, you are only required to provide your email, and it will never be shared (unless required by law) or displayed.</li><li>The University of California and UCSC Library will have the right to edit your submissions for length and content and also will have the right to decline to include your submissions within the GDAO collection, in the University\'s sole discretion.</li><li>If your have a "Big" Story to Tell, please contact us at <a href="mailto:grateful@ucsc.edu">grateful@ucsc.edu</a> to arrange a longer  interview with the Grateful Dead Archivist. Thanks!</li></ul>');

var copyrightMarkup = jQuery('<script type="text/javascript">jQuery(\'input:radio[name=copyright]\').change(function() {if (this.value == \'fair-use\') {jQuery(\'div#contrib-license\').hide(\'slow\');}else {jQuery(\'div#contrib-license\').show(\'slow\');}});</script><div id="copyright-license"><div class="field" id="contrib-copyright"><h2>Copyright</h2><div class="inputs"><div class="input"><p><input type="radio" class="checked" id="submitter-copyright" name="copyright" value="submitter-copyright" checked>I own the copyright to the item I am submitting.</p><p>This means you took the photo, drew the picture, wrote the story, etc., that the person who did died and you\'re their sole heir, or that you have become the copyright owner (not just the owner of the physical object) through some other means.<p><input type="radio" id="fair-use" name="copyright" value="fair-use">I don\'t own the copyright for the item I\'m submitting, but I believe my submission is fair use.</p><p>You can submit other items, like tickets or posters, but we require that you respect the copyright owner by only doing so consistent with Fair Use. For example, do not submit a scan of a poster that\'s such a large or high quality file that people would want to print copies from it. To learn more about Fair Use - the right, in some circumstances, to use copyrighted materials without first getting permission from the copyright holder - you can read more at <a href="http://owl.english.purdue.edu/owl/resource/731/1">Purdue\'s Online Writing Lab</a> and/or Stanford University Libraries <a href="http://fairuse.stanford.edu/Copyright_and_Fair_Use_Overview/chapter9/9-a.html">Copyright & Fair Use website</a> and/or the <a href="http://librarycopyright.net/fairuse/whatisfairuse.php">Fair Use Evaluator tool</a>.</p></div></div></div><div class="field" id="contrib-license"><h2>License</h2><div class="inputs"><div class="input"><p>Contributions to GDAO will be stored on our servers and publicly viewable to any user of the internet. At a minimum, we require that contributors grant a license to the University of California Regents so that the UC Santa Cruz Libraries can manage and preserve the items in accordance with their policies and best practices, as well as incorporate it into the Library\'s Grateful Dead Archive if it is particularly great.</p><p>Because the Deadhead community has typically been one of shared inspiration and adaptation, we encourage you to choose a broader license, described below. These <a href="http://creativecommons.org/licenses">Creative Commons licenses</a> grant others the permission to use your work in certain ways without contacting you. You can read more about Creative Commons licenses at the <a href="http://creativecommons.org/">Creative Commons site</a>. When you choose a Creative Commons license the name that you supply (above) will be displayed with your contributed item and this is how persons wanting to use your item will credit you. We do not require that you supply a name, therefore, if you do not supply a name, you will not receive attribution.</p><p>If you select the University of California-only option, persons wishing to use your work will legally only be able to do so as far as provisions of copyright law such as fair use allow.</p><p><input type="radio" name="license" value="regents" checked>I am contributing this work and irrevocably grant a non-exclusive, perpetual, royalty-free, worldwide license for this work to the University of California Regents to display, distribute, reproduce, perform, or create derivatives works based upon it.</p><p><input type="radio" id="ccby" name="license" value="Creative Commons Attribution">I am contributing this item under a <a href="http://creativecommons.org/licenses/by/3.0">Creative Commons Attribution (CC BY) License</a>. Others are free to share, remix, or make commercial use of the work as long as they credit me.</p><p><input type="radio" id="ccbync" name="license" value="Creative Commons Attribution Non-Commercial">I am contributing this item under a <a href="http://creativecommons.org/licenses/by-nc/3.0">Creative Commons Attribution-NonCommercial (CC BY_NC) License</a>. Others are free to share or remix the work noncommercially, as long as they credit me.</p></div></div></div></div>');


  jQuery('select#contribution-type').change(function() {
	if (jQuery('div#required-fields').length == 0) {
      jQuery(requiredFields).insertBefore('div#contribution-type-form');
	}
	if (jQuery('div#contrib-copyright').length == 0) {
      jQuery(copyrightMarkup).insertAfter('fieldset#contribution-contributor-metadata div.field:eq(1)');
	}
	if (jQuery(this).val() == '6') {
	  jQuery('#filetypes').remove();
      jQuery(audioFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '2') {
	  jQuery('#filetypes').remove();
      jQuery(imageFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '129') {
	  jQuery('#filetypes').remove();
      jQuery(videoFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '34') {
	  jQuery('#filetypes').remove();
      jQuery(imageFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '35') {
	  jQuery('#filetypes').remove();
      jQuery(imageFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '36') {
	  jQuery('#filetypes').remove();
      jQuery(imageFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '65') {
	  jQuery('#filetypes').remove();
      jQuery(imageFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '68') {
	  jQuery('#filetypes').remove();
      jQuery(articleFiletypes).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() == '5') {
	  jQuery('#filetypes').remove();
      jQuery(articleFiletypes).insertBefore('div#contribution-type-form');
      jQuery(ohInstructions).insertBefore('div#contribution-type-form');
    }
	if (jQuery(this).val() !== '5') {
      jQuery('ul#oh-instructions').remove();
	  jQuery('label[for="contributor-name"]').removeClass('optional');
    }
	if(!jQuery('label[for="contributor-name"]').hasClass('optional')) {
	  jQuery('label[for="contributor-name"]').addClass('optional');
    }
  });


    if (jQuery('div#required-fields').length == 0 && jQuery('body.contribution div#primary div.error').length > 0) {
      jQuery(requiredFields).insertBefore('div#contribution-type-form');
	}

	if (jQuery('select#contribution-type').val() == '5' && jQuery('body.contribution div#primary div.error').length > 0) {
      jQuery(ohInstructions).insertBefore('div#contribution-type-form');
	}

  if (jQuery('div#contrib-copyright').length == 0 && jQuery('body.contribution div#primary div.error').length > 0) {
      jQuery(copyrightMarkup).insertAfter('fieldset#contribution-contributor-metadata div.field:eq(1)');
	}

  /* Add value 'anonymous' to name field for oral history contribution form. Add copyright and licence values to rights holder and rights fields. Add value 'no' to curated field (#Elements-420-0-text). Validate title field. */







var titleError = jQuery('<div class="error" id="title-error">You must include a title.</div>');

  jQuery('body.contribution #primary form #form-submit').click(function(e) {
	var copyrightValue = 'I am the copyright owner. I believe my submission is fair use. This work is available from the UC Santa Cruz Library. This digital copy of the work is intended to support research, teaching, and private study. This work is protected by U.S. Copyright Law (Title 17, U.S.C.). Use of this work beyond that allowed by Fair Use requires written permission of the copyright holder(s). Responsibility for obtaining permission, and for any use or distribution of this work, rests exclusively with the user and not the UC Santa Cruz Library. If the work itself or our research has indicated that one or more individuals or entities is a current copyright holder, that information may be included in the Copyright Information field. Other sources for copyright information include the Creator field or copyright statements on the work. When available, contact information for requesting permission from copyright holder(s) will be linked from the Copyright Information field. If you have additional or conflicting information about ownership of rights in this work, please contact us at grateful@ucsc.edu.';

	var dateTime = jQuery('meta[name=date]').attr("content");
	var licenseType = jQuery('input[name=license]:checked', 'body.contribution #primary form').val();

	jQuery('#Elements-420-0-text').val('no');
    jQuery('textarea#Elements-135-0-text').val(copyrightValue);
	jQuery('#element-100 textarea').val(dateTime);
    if(!jQuery('input#contributor-name').val()) {
      jQuery('input#contributor-name').val('anonymous');
    }
	if(!jQuery('input#contributor-name').val()) {
      jQuery('#Elements-420-0-text').val('no');
    }
	if(licenseType != 'regents'){
	  var contribName = jQuery('input#contributor-name').val();
	  var licenseValue = licenseType + ': ' + contribName;
      jQuery('textarea#Elements-47-0-text').val(licenseValue);
	}
	if (jQuery('#element-50 textarea').val().length == 0) {
      jQuery(titleError).insertBefore('#primary h1');
	  window.scrollTo(0,0);
      e.preventDefault();
    }
  });


  /* Change 'terms and conditions' text, and contrib name text. */

  jQuery('fieldset#contribution-confirm-submit p').html('In order to contribute, you must read and agree to the <a target="_blank" href="/policies">GDAO Policies.</a>');
  jQuery('body.contribution label[for="terms-agree"]').text('I agree to the GDAO Policies.');
  jQuery('body.contribution label[for="contributor-name"]').text('Name (optional)');






  /* this is from: http://stackoverflow.com/questions/2544441/clearing-a-default-value-in-a-search-box-with-jquery */

  jQuery('#submit_search').click(function() {
	if(jQuery('#solrq').val() == 'Search the Collection...') {
		jQuery('#solrq').val('');
	}
	else {
		jQuery('#solrq').val(jQuery('#solrq').val().replace(': ', ' '));
	}
  });



  /* change text of pagination buttons */

  jQuery('li.pagination_first a').text('<<');
  jQuery('li.pagination_previous a').text('<');
  jQuery('li.pagination_next a').text('>');
  jQuery('li.pagination_last a').text('>>');


  /* toggle facet links. this is from http://jsbin.com/odire */

  jQuery('ul.gdao_facet_values').each(function(){
    var $this = jQuery(this), lis = $this.find('li:gt(9)').hide();
    if(lis.length>0){
      $this.append(jQuery('<li class="more">').text('More').click(function(){
        lis.toggle();
        jQuery(this).text(jQuery(this).text() === 'More' ? 'Less' : 'More');
      }));
    }
  });


  /* This is from: http://chipsandtv.com/articles/jquery-image-preload */
  var images = [
    '/themes/gdao-theme/images/bg-banner-320.png',
    '/themes/gdao-theme/images/bg-banner-home.jpg',
    '/themes/gdao-theme/images/bg-banner.png',
    '/themes/gdao-theme/images/bg-button-gray.png',
    '/themes/gdao-theme/images/bg-footer.png',
    '/themes/gdao-theme/images/bg-main.png',
    '/themes/gdao-theme/images/icon-artists-over.jpg',
    '/themes/gdao-theme/images/icon-artists.jpg',
    '/themes/gdao-theme/images/icon-fanart-over.jpg',
    '/themes/gdao-theme/images/icon-fanart.jpg',
    '/themes/gdao-theme/images/icon-media-over.jpg',
    '/themes/gdao-theme/images/icon-media.jpg',
    '/themes/gdao-theme/images/icon-milestones-over.jpg',
    '/themes/gdao-theme/images/icon-milestones.jpg',
    '/themes/gdao-theme/images/icon-shows-over.jpg',
    '/themes/gdao-theme/images/icon-shows.jpg',
    '/themes/gdao-theme/images/line-footer.png',
    '/themes/gdao-theme/images/logo-gdao-gray.png',
    '/themes/gdao-theme/images/logo-gdao-over.png',
    '/themes/gdao-theme/images/logo-gdao.png',
    '/themes/gdao-theme/images/ribbon.jpg',
    '/themes/gdao-theme/images/search-collection.png',
    '/themes/gdao-theme/images/site-nav-arrow.png'
  ];

  jQuery(images).each(function() {
    var image = jQuery('<img />').attr('src', this);
  });

});
