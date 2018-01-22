$(document).ready(function(){	

		$( '<span><abbr title="13.060422000000000000"> &nbsp;Tips !!</abbr></span>' ).insertAfter( $( "#add_lat" ) );
		$( '<span><abbr title="80.249583000000030000"> &nbsp;Tips !!</abbr></span>' ).insertAfter( $( "#add_long" ) );
		
		$("[name=country_filter]").change(function(){
			  $.post(__cfg('admin_path_absolute')+"getstates/"+$(this).val(),
			  function(json){
					$("[name=state_filter]").empty().append("<option value=''>Select State</option>");
					$.each(json, function( key, value ) {
						if(key==search_state_id){	
							$("[name=state_filter]").append("<option value="+key+" selected>"+value+"</option>");
							if($("[name=state_filter]").val()!="" && $("[name=state_filter]").val()!=null  ){
									$("[name=state_filter]").trigger('change');
							}
						}else{
							$("[name=state_filter]").append("<option value="+key+">"+value+"</option>");
						}
					});
		  },"JSON");
		});
				
		if($("[name=country_filter]").val()!="" && $("[name=country_filter]").val()!=null  ){
			$("[name=country_filter]").trigger('change');
		}	
				
		$("[name=state_filter]").change(function(){ 
		  $.post(__cfg('admin_path_absolute')+"getcities/"+$(this).val(),
		  function(json){
				$("[name=city_filter]").empty().append("<option value=''>Select City</option>");
				$.each(json, function( key, value ) {	
					if(key==search_city_id){	
						$("[name=city_filter]").append("<option value="+key+" selected>"+value+"</option>");
					}else{
						$("[name=city_filter]").append("<option value="+key+">"+value+"</option>");
					}
					
				});
		  },"JSON");
		});	
		
		$("[name=select_country]").change(function(){
		  $.post(__cfg('admin_path_absolute')+"getstates/"+$(this).val(),
		  function(json){
				$("[name=select_state]").empty().append("<option value=''>Select State</option>");
				$("[name=select_city]").empty().append("<option value=''>Select City</option>");
				$("[name=select_area]").empty().append("<option value=''>Select Area</option>");
				$.each(json, function( key, value ) {								
					if(key==select_state_id){	
						$("[name=select_state]").append("<option value="+key+" selected>"+value+"</option>");
						if($("[name=select_state]").val()!="" && $("[name=select_state]").val()!=null  ){
							$("[name=select_state]").trigger('change');
						}
					}else{
						$("[name=select_state]").append("<option value="+key+">"+value+"</option>");
					}
				});
		  },"JSON");
		});
			
		if($("[name=select_country]").val()!="" && $("[name=select_country]").val()!=null  ){
			$("[name=select_country]").trigger('change');
		}
		
		$("[name=select_state]").change(function(){ 
		  $.post(__cfg('admin_path_absolute')+"getcities/"+$(this).val(),
		  function(json){
				$("[name=select_city]").empty().append("<option value=''>Select City</option>");
				$("[name=select_area]").empty().append("<option value=''>Select Area</option>");
				$.each(json, function( key, value ) {	
					if(key==select_city_id){	
						$("[name=select_city]").append("<option value="+key+" selected>"+value+"</option>");
						if($("[name=select_city]").val()!="" && $("[name=select_city]").val()!=null  ){
							$("[name=select_city]").trigger('change');
						}
					}else{
						$("[name=select_city]").append("<option value="+key+">"+value+"</option>");
					}
					
				});
		  },"JSON");
		});
		
		$("[name=select_city]").change(function(){ 
		  $.post(__cfg('admin_path_absolute')+"getareas/"+$(this).val(),
		  function(json){
				$("[name=select_area]").empty().append("<option value=''>Select Area</option>");
				$.each(json, function( key, value ) {	
					if(key==select_area_id){	
						$("[name=select_area]").append("<option value="+key+" selected>"+value+"</option>");
					}else{
						$("[name=select_area]").append("<option value="+key+">"+value+"</option>");
					}
					
				});
		  },"JSON");
		});
			$('#add_city').livequery('blur',function(){
			    codeAddress('city');
			});
		     $('#add_area').livequery('blur',function(){
			    codeAddress('area');
			});
			   $('#add_state').livequery('blur',function(){ 
			    codeAddress('state');
			});
});
function codeAddress(pass) {  
var map;
var marker;
var markersArray = [];
var marker_pos;
var marker_pos_new;
var mapOptions;
var geocoder;
var map;
geocoder = new google.maps.Geocoder();
   var street="";
   var country= $('#select_country').find(":selected").text();
   var state= $('#select_state').find(":selected").text();
   if(pass="")
   {
      var country= $('#select_country').text();
      var address =street.concat(country);
   }
   else if(pass=='city')
   {
   var city = $('#add_city').text();
   var address =street.concat(city," ",state," ",country);
   }
   else if(pass=='state')
   {
   var state= $('#select_state').text();
   var address =street.concat(state," ",country);
   }
   else
   {
      var city = $('#select_city').find(":selected").text();
      var area = $('#add_area').val();
      var address =street.concat(area," ",city," ",state," ",country);
   }
   geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) { 
           var lat=results[0].geometry.location.lat();
           var long=results[0].geometry.location.lng();
           document.getElementById('add_lat').value = '';
           document.getElementById('add_long').value = '';
           document.getElementById('add_lat').value = lat;
           document.getElementById('add_long').value = long;
    } 
    else {
    }
  });
}