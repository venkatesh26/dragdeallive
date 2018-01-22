<script type="text/javascript">
$(document).ready(function(){
	initialize();
});
function initialize() { 
  var geocoder;
  var map;
  var address =$('#map_canvas').data('address');
  var title =$('#map_canvas').data('title');
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 15,
      center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

            var infowindow = new google.maps.InfoWindow(
                { content: '<p class="map_content">'+title+'</p>'+'<b>'+address+'</b>',
                  size: new google.maps.Size(100,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 
			google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
           });
           infowindow.open(map,marker);
          } else {
          }
        } else {
        }
      });
    }
  }
</script>
<?php
   $my_adress=$result['address_line'];
   if($result['address_line']!='')
   {
	 if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
	 {
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).','.ucwords($result['city_name']).'-'.$result['zip'];
	 }
	 else if(isset($result['area_name']) && $result['area_name']=='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
	 {
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['city_name']).'-'.$result['zip'];
	 }
	 else if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
	 {
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
	 }
	 else if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
	 {
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
	 }
	  else if(isset($result['area_name']) && $result['areas']=='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
	 {
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['areas']).'-'.$result['zip'];
	 }
  }
?>
<div class="map_canvas" id="map_canvas" style="height: 250px;width: 100%;margin-top: 20px;border: 1px solid #ccc;padding: 5px;"  data-lat="<?php echo $result['latitude'];?>" data-long="<?php echo $result['longitude'];?>" data-address="<?php echo $my_adress;?>"   data-title="<?php echo $result['name'];?>"></div>