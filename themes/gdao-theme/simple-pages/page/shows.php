<script type='text/javascript' src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type='text/javascript'>
        $(function(){
            var myOptions = {
                center: new google.maps.LatLng(42.811522,47.285156),
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };
            gMap = new google.maps.Map(document.getElementById('gdao_map_canvas'), myOptions);

            var kmlLayer = new google.maps.KmlLayer('https://maps.google.com/maps/ms?ie=UTF8&t=m&authuser=0&msa=0&output=kml&msid=206723407710575786600.0004c32c00381f43c5bba');
            kmlLayer.setMap(gMap);
        });
</script>

<div id="gdao_map_canvas" style="width: 400px; height: 400px;"></div>
