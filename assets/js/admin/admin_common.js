function setCookie(c_name, value, exdays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(value) +
		((exdays == null) ? "" : ("; expires=" + exdate.toUTCString()));
	document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var i, x, y, ARRcookies = document.cookie.split(";");
	for(i = 0; i < ARRcookies.length; i++)
	{
		x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
		y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
		x = x.replace(/^\s+|\s+$/g, "");
		if(x == c_name)
		{
			return unescape(y);
		}
	}
}
function __cfg(c) {
	 return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
$(document).ready(function() {
	/**
   * accept numeric values only in jquery
   * @()
  */
	$(".priority").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	$(".priority").keyup(function (e) {
		if($(this).val().length==1 && (e.keyCode==48 || e.keyCode==96)) {
			$(this).val('');
		}
	});
	/**
   * it is used to validate admin login
   * @()
  */
  
	$(".js-user-search").livequery('click',function(){
		
		$.ajax({
				url:__cfg('path_absolute')+"claim_mybussiness/seach_users",
				type:'post',
				data:{email:$("#search_email").val()},
				success:function(data) {
					var res=jQuery.parseJSON(data);
					if(typeof res.current_add_usersdetails!='undefined' && res.current_add_usersdetails.id!=''){
						$('.error_response').html('');
						$('.sucess_response').html('');
						$('.sucess_response').html('Sorry..! the users already exists.jsut map the users');
						$('#advertisment_id').val(res.add_usersdetails.id);
						$('#advertisment_user_id').val(res.add_usersdetails.user_id);
					}
					else{
						if(typeof res.add_usersdetails!='undefined' && typeof res.add_usersdetails.id!='undefined'){
							
							$('.error_response').html('');
							$('.sucess_response').html('');
							$('.error_response').html('Sorry..! User Already exist for this bussiness');
						}
						else {
							$('.error_response').html('');
							$('.sucess_response').html('');
							$('.sucess_response').html('No User Availble...! Create a New Account');
						}
					}
				}
		});
	});
  
	$("#type_reduction").livequery('change',function(){
		var type_val = $(this).val();
		if(type_val==1){
			var set_val = 15;
		} else if(type_val==2){
			var set_val = 23;
		} else if(type_val==3){
			var set_val = 59;
		} else {
			var set_val = 0;
		}
		if(set_val!=0) {
			$("[name=reduction_value]").html("<option value=''>Select</option>");
			for($i=1;$i<=set_val;$i++){
				$("[name=reduction_value]").append("<option value="+$i+">"+$i+"</option>");
			}	
		} else {
			$("[name=reduction_value]").html("<option value=''>Select</option>");
		}
		$("[name=reduction_value]").selectric('refresh');
	});
	$('#country-form').livequery(function() {
		jQuery("#country-form").validate({
			  rules: {
					add_country: {
						   required: true
					   },
					add_code: {
						   required: true
					   }
			 },
			  messages: {
					 add_country: {
						  required: "Please enter the Country Name"	
					   },
					add_code: {
					   required: "Please enter the Country Code",
					}
			   }
		   });
	 });
	 
	  $('#reply_message').livequery(function() {
		jQuery("#reply_message").validate({
			  rules: {
					subject: {
						   required: true
					   },
					   select_code: {
						   required: true
					   },					   
					add_state: {
						   required: true
					   },
					   add_lat: {
						   required: true,
							number:true
					   },
					   message: {
						   required: true,
					   },			
			 },
			  messages: {
					  subject: {
						    required: "Please enter the subject"	
					   },
					 message: {
						  required: "Please enter the message"	
					   },
			   },
			errorPlacement: function (error, element) {
				element.parents(".controls").find(".text-danger").append(error);
			}
		});
	 });
	 
	 
	 $('#state-form').livequery(function() {
		jQuery("#state-form").validate({
			  rules: {
					select_country: {
						   required: true
					   },
					   select_code: {
						   required: true
					   },					   
					add_state: {
						   required: true
					   },
					   add_lat: {
						   required: true,
							number:true
					   },
					   add_long: {
						   required: true,
							number:true
					   },			
			 },
			  messages: {
					  select_code: {
						    required: "Please Select the Country code"	
					   },
					 select_country: {
						  required: "Please Select the Country"	
					   },	
					add_state: {
					   required: "Please enter the state Name",
					},
					add_lat: {
					   required: "Please enter the state Latitude",
						number: "Please enter the valid Latitude"
					},
					add_long: {
					   required: "Please enter the state Longitude",
						number: "Please enter the valid Longitude"
					}
					
			   },
			errorPlacement: function (error, element) {
				element.parents(".controls").find(".text-danger").append(error);
			}
		});
	 });
	 
	 jQuery.validator.addMethod("dep", function(value, element) {
		var home_city_option=$('#is_home').is(':checked');
		if(home_city_option){ 
			if(value) 
			return true;
			else 
			return false;	
			}
			return true;
	 }, "dfdfdf");
	  jQuery.validator.addMethod("city_image", function(value, element) {
		var image=$('#js-image-id').val();
		var c_image=$('#images').val();
		if(image ==0 || c_image =='')
		{ 
		return true;
		}
		else 
		{
			return true;	
		}
			return true;
	 }, "test");

	 $('#city-form').livequery(function() {
		jQuery("#city-form").validate({
			  rules: {
					select_country: {
						   required: true
					   },
					   select_state: {
						   required: true
					   },
					add_city: {
						   required: true
					   },
					add_lat: {
						   required: true,
							number:true
					   },
					add_long: {
						   required: true,
							number:true
					   },
					currency: {
							dep : true
						},
					population: {
							dep : true
					},
					language: {
							dep : true
					},
                     images: {
				       city_image: true,
					   accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		                },				   
			 },
			  messages: {
					 select_country: {
						  required: "Please Select the Country"	
					   },
					   select_state: {
						  required: "Please Select the State"	
					   },
					add_city: {
					   required: "Please enter the city Name",
					},
					add_lat: {
					   required: "Please enter the city Latitude",
						number: "Please enter the valid Latitude"
					},
					add_long: {
					   required: "Please enter the city Longitude",
						number: "Please enter the valid Longitude"
					},
					currency: {
					   dep: "Please enter the currency",
					},
					population: {
					   dep: "Please enter the population",
					},
					language: {
					   dep: "Please enter the language",
					},
					images: {
					  city_image:"Please Select the Image",
			          accept: "Please upload valid Image."
		         },
					
			   },
			 errorPlacement: function (error, element) {
				element.parents(".controls").find(".text-danger").append(error);
			 }
		});
	 });
	 
	  $('#area-form').livequery(function() {
		jQuery("#area-form").validate({
			  rules: {
					select_country: {
						   required: true
					   },
					   select_state: {
						   required: true
					   },
					    select_city: {
						   required: true
					   },
					   add_area: {
						   required: true
					   },
					   add_lat: {
						   required: true,
							number:true
					   },
					   add_long: {
						   required: true,
							number:true
					   },			
			 },
			  messages: {
					 select_country: {
						  required: "Please Select the Country"	
					   },
					   select_state: {
						  required: "Please Select the State"	
					   },
					 select_city: {
						  required: "Please Select the City"	
					   },
					   
					add_area: {
					   required: "Please enter the area Name",
					},
					add_lat: {
					   required: "Please enter the area Latitude",
					   number: "Please enter the valid Latitude"
					},
					add_long: {
					   required: "Please enter the area Longitude",
					   number: "Please enter the valid Longitude"
					}
			   },
			 errorPlacement: function (error, element) {
				element.parents(".controls").find(".text-danger").append(error);
			 }
		   });
	 });
	 
	/**
   * it is used to validate admin login
   * @()
  */
	$('#loginform').livequery(function() {
		jQuery("#loginform").validate({
			  rules: {
					user_name: {
						   required: true,
						  email: true
					   },
					password: {
						   required: true,
					   }
			 },
			  messages: {
					 user_name: {
						  required: "Please enter the User Email",
						  email: "Please enter valid Email ID"				
					   },
					password: {
					   required: "Please enter the Password",
					}
			   }
		   });
	 });
	 /**
   * it is used to validate forgot password
   * @()
  */
	 $('#forgotpassword').livequery(function() {
		jQuery("#forgotpassword").validate({
			  rules: {
					email_address: {
							required: true,
							email: true
					   },
			 },
			  messages: {
					 email_address: {
						  required: "Please enter the Register Email",
						  email: "Please enter valid Email ID"				
					   },
			   }
		   });
	 });
	/**
   * it is used to validate reset password
   * @()
  */
	$('#resetpassword').livequery(function() {
     jQuery("#resetpassword").validate({ 
  	       rules: {
		         password: {
			           required: true,
			           minlength: 6
		         },
		       password2: {
			          required: true,
			          minlength: 6,
					  equalTo :  password  
		        }	
    	    },
	     messages: {
		       password: {
			          required: "Please enter New Password",
			          minlength: "Your password must have atleast 6 characters"
		         },
		      password2: {
			          required: "Please enter the Confirm Password",
			          minlength: "Your password must have atleast 6 characters",
					  equalTo :  "Password Mismatch"  
		        }		
	       }	   
      });
   });
   /**
   * it is used to validate Change password
   * @()
  */
	$('#change-password').livequery(function() {
     jQuery("#change-password").validate({ 
  	       rules: {
				old_password: {
			           required: true,
			           minlength: 6
		         },
		         password: {
			           required: true,
			           minlength: 6
		         },
		       password2: {
			          required: true,
			          minlength: 6,
					  equalTo :  password  
		        }	
    	    },
	     messages: {
				old_password: {
			           required: "Please enter New Password",
			           minlength: "Your password must have atleast 6 characters"
		         },
		       password: {
			          required: "Please enter New Password",
			          minlength: "Your password must have atleast 6 characters"
		         },
		      password2: {
			          required: "Please enter the Confirm Password",
			          minlength: "Your password must have atleast 6 characters",
					  equalTo :  "Password Mismatch"  
		        }		
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });   
   
   /**
   * it is used to validate Hotels
   * @()
  */
   $('#edit-admin-profile').livequery(function() {
		jQuery("#edit-admin-profile").validate({
			  rules: {
					first_name: {
						   required: true
					   },
					email: {
						   required: true,
						   email:true
					   },
					image: {
					   accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
					},
					password: {
							required:{
								depends: function(element){
									if( $('#old_password').val() != "" ){
										return true;
									}else{
										false;
									}
								}
							},
							minlength: 6
						},
					password2: {
						equalTo: "#password"
					}
			 },
			  messages: {
					 first_name: {
						  required: "Please enter the First Name"	
					   },
					email: {
					   required: "Please enter the Email ID",
					   email: "Please enter the valid Email ID"
					},
					image: {
					  accept: "Please upload valid Image."
					},
					password: {
						required: "The new password field is required.",
						minlength: "Your password must consist of at least 6 characters."
					},
					password2: {
						equalTo: "Password and Confirm Password Missmatch"
					}
			   },
			errorPlacement: function (error, element) {
				element.parents(".controls").find(".text-danger").append(error);
			}
		});
	 });
   
    /**
   * it is used to validate Hotels
   * @()
  */
  
     $('#add_users').livequery(function() {
     jQuery("#add_users").validate({ 
  	       rules: {
		         first_name: {
						required: true,
		         },
				 email: {
			           required: true,
					   email:true,
		         },
				 display_name: {
			           required: true,
		         },
				 password: {
			           required: true,
		         },
				 confirm_password: {
			           required: true,
		         },
				 image: {
					   accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		        },
    	    },
	     messages: {
		       first_name: {
			        required: "Please enter the First Name",
		         }	,
				 email: {
					required : "Please enter the Email",
					email: "Please enter the valid Email",
		         },
				 display_name: {
			        required: "Please enter the Display Name",
		         }	,
				 password: {
			        required: "Please enter the password",
		         },
				 confirm_password: {
			          required: "Please enter the confirm password",
		         },
				 image: {
			          accept: "Please upload valid Image."
		         },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });
   
   
      /**
   * it is used to validate Hotels
   * @()
  */
  
     $('#add_hotels').livequery(function() {
     jQuery("#add_hotels").validate({ 
  	       rules: {
		         hotel_name: {
			           required: true,
		         },
				 email: {
			           required: true,
					   email:true,
		         },
				 display_name: {
			           required: true,
		         },
				 password: {
			           required: true,
		         },
				 confirm_password: {
			           required: true,
		         },
				 hotel_class_type: {
			           required: true,
		         },
				 hotel_plan_type: {
			           required: true,
		         },
				 select_country: {
				     required: true,
				 },
				 select_state: {
				     required: true,
				 }, 
				 select_city: {
				     required: true,
				 }, 
				 image: {
			           accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		         },
    	    },
	     messages: {
		       hotel_name: {
					required: "Please enter the Name",
		         }	,
				 email: {
					required : "Please enter the Email",
					email: "Please enter the valid Email",
		         },
				 display_name: {
					required: "Please enter the Display Name",
		         },
				 password: {
			           required: "Please enter the password",
		         },
				 confirm_password: {
			          required: "Please enter the confirm password",
		         },
				 hotel_class_type: {
			          required: "Please select the hotel class type",
		         },
				 hotel_plan_type: {
			           required: "Please select the hotel plan type",
		         },	
		         select_country: {
			           required: "Please select the country",
		         },	
				 select_state: {
			           required: "Please select the state",
		         },	 
				 select_city: {
			           required: "Please select the city",
		         },	
				 image: {
			          accept: "Please upload valid Image."
		         },
		   },
		errorPlacement: function (error, element) {
				element.parents(".controls").find(".text-danger").append(error);
		}	   
      });
   });
   /**
   * it is used to validate add amenties
   * @()
  */
   $('#add_amenties').livequery(function() {
     jQuery("#add_amenties").validate({ 
  	       rules: {
		         name: {
			           required: true,
		         },
				iconic_code: {
			           required: true,
					  
		        },
    	    },
	     messages: {
		       name: {
			          required: "Please enter the Name",
		         },
				iconic_code: {
			          required: "Please enter the Iconic Class",
		        },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}   
      });
   });
    /**
   * it is used to validate edit amenties
   * @()
  */
   $('#edit_amenties').livequery(function() {
     jQuery("#edit_amenties").validate({ 
  	       rules: {
		         name: {
			           required: true,
		         },
				iconic_code: {
			           required:true,
		        },
    	    },
	     messages: {
		       name: {
			          required: "Please enter the Name",
		         },
				iconic_code: {
			          required: "Please enter the Iconic Class",
		        },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}   
      });
   });
   /**
   * it is used to validate edit plans
   * @()
  */
   $('#edit_plans').livequery(function() {
     jQuery("#edit_plans").validate({ 
		
  	       rules: {
		         name: {
			           required: true,
		         },
				price: {
						required: true,
						number:true
		         },
				plan_valid_days: {
						required: true,
						number:true
		        },
				auction_limit: {
						required: true,
						number:true
		        },
				commision: {
						required: true,
						number:true
		        },
    	    },
	     messages: {
		       name: {
			          required: "Please enter the Name",
		        },
				price: {
			          required: "Please enter the Price",
					  number:"Please enter the valid Price"
		        },
				plan_valid_days: {
			          required: "Please enter the Days",
					  number:"Please enter the valid Price"
		        },
				auction_limit: {
			          required: "Please enter the Auction Limit",
					  number:"Please enter the valid Auction Limit"
		        },
				commision: {
			          required: "Please enter the Commision",
					  number:"Please enter the valid Commision"
		        },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });
   /**
   * it is used to validate edit CMS Pages
   * @()
  */
    $('#pages_edit').livequery(function() {
     jQuery("#pages_edit").validate({ 
  	       rules: {
		         title: {
			           required: true,
		         },
				content: {
			           required: true,
		        },
    	    },
	     messages: {
		       title: {
			          required: "Please enter the Name",
		         },
				content: {
			          required: "Please enter the Content",
		         }
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });
   
   /**
   * it is used to validate add banner
   * @()
  */
    $('#add_banners').livequery(function() {
     jQuery("#add_banners").validate({ 
  	       rules: {
		         name: {
			           required: true,
		         },
				images: {
			           required: true,
					   accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		        },
				priority: {
			           required: true,
					   number:true
		        },
    	    },
	     messages: {
		       name: {
			          required: "Please enter the Name",
		        },
				images: {
			          required: "Please Select the Image",
					  accept: "Please upload valid Image."
		        },
				priority: {
			          required: "Please enter the Priority",
					  number: "Please enter the valid Priority"
		        },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });
   
   $('#add_testimonials').livequery(function() {
     jQuery("#add_testimonials").validate({ 
  	       rules: {
		         name: {
			           required: true,
		         },
		         images: {
					   accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		        },
		        description: {
			           required: true,
		        },
    	    },
	     messages: {
		       name: {
			          required: "Please enter the Name",
		        },
		        images: {
					  accept: "Please upload valid Image."
		        },
		        description: {
			          required: "Please enter the Description",
		        },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });
   
   $('#edit_testimonials').livequery(function() {
  
    jQuery("#edit_testimonials").validate({ 
  	        rules: {
		         name: {
			           required: true,
		         },
		          images: {
					   accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		        },
		         description: {
			           required: true,
		        },
		      },
			
	     messages: {
		       name: {
			          required: "Please enter the Name",
		        },
		        images: {
					  accept: "Please upload valid Image."
		        },
		        description: {
			          required: "Please enter the Description",
		        },
		       },
			
	        
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		} 
      }); 
   });
   
   $('#edit_banners').livequery(function() {
     jQuery("#edit_banners").validate({ 
  	       rules: {
		         name: {
			           required: true,
		         },
				images: {
			           accept:"jpg|JPG|png|PNG|bmp|BMP|gif|GIF|jpeg|JPEG"
		        },
				priority: {
			           required: true,
					   number:true
		        },
    	    },
	     messages: {
		       name: {
			          required: "Please enter the Name",
		        },
				images: {
			          accept: "Please upload valid Image."
		        },
				priority: {
			          required: "Please enter the Priority",
					  number: "Please enter the valid Priority"
		        },
	       },
		errorPlacement: function (error, element) {
            element.parents(".controls").find(".text-danger").append(error);
		}
      });
   });
   /**
   * it is used to autocomplete amenities and selected
   * @()
  */
    $('#f_amenities').livequery('keyup',function() { 
	  var values = $('input[name="amenities_id[]"]').map(function(){
						return this.value
				}).get();
		$("#f_amenities").autocomplete({ 
		source: "auctions/f_aminities_list?amentity_id="+values,
		minLength: 1,
		select: function(data,html) { 
			var suits = html.item.value; 
			var findme = "&";
			if (suits.indexOf(findme) > -1 ) {
				var amenities = suits.replace('&', '%26');
			}else{
				var amenities = suits;
			} 
			jQuery.ajax({
				type: "POST",
				url: "auctions/save_amenities_id",
				data: "name="+amenities,
				success: function(arr){ 
					if(arr!='') { 
					  	if($('#f_amenities_'+arr).val()==arr) {
							$('#f_amenities').val('');
							return false;
						}else{ 
							$('#f_amenties_div').prepend("<input type='hidden' name='f_amenities_id[]' value='"+ arr + "' id='f_amenities_"+arr+"' class='txtoption'>");
							$('.f-carousel').prepend("<li id='f_amen_"+arr+"'><span class='auctionadd'>"+suits+"<a href='#' id='close_"+arr+"' class='f_amenties_close' rel='"+arr+"' title='close'>close</a></span></li>");
							$('#f_amenities').val('');
						}
					}else{
						$('#f_amenities').val('');
					}
				}
				
			});		
		}
	  });
	});
  
  
   $('#amenities').livequery(function() { 
   var amenty_type=$('#amenty_request_type').val();
   var hotel_id=$('#js_hotel_id').val();
   if(typeof  hotel_id == "undefined")
   {
   hotel_id=0;
   }
	$("#amenities").autocomplete({ 
		source: "auctions/aminities_list/"+amenty_type+'/'+hotel_id,
		minLength: 1,
		select: function(data,html) { 
			var suits = html.item.value; 
			
			var findme = "&";

			if (suits.indexOf(findme) > -1 ) {
				var amenities = suits.replace('&', '%26');
			}else{
				var amenities = suits;
			} 
			jQuery.ajax({
				type: "POST",
				url: "auctions/save_amenities_id",
				data: "name="+amenities,
				success: function(arr){ 
					if(arr!='') { 
					  	if($('#amenities_'+arr).val()==arr) 
						{
							$('#amenities').val('');
							return false;
						}
						else
						{ 
							$('#amenties_div').prepend("<input type='hidden' name='amenities_id[]' value='"+ arr + "' id='amenities_"+arr+"' class='txtoption'>");
							$('#carousel').prepend("<li><span class='auctionadd'>"+suits+"<a href='#' id='close_"+arr+"' class='amenties_close' rel='"+arr+"' title='close'>close</a></span></li>");
							$('#amenities').val('');
						}
					}else{
						$('#amenities').val('');
					}
				}
				
			});		
		}
	});
		/**
		   * it is used to selected close amenities
		   * @()
		*/
		$(".amenties_close").livequery("click",function(evt){ 
		    var rel_amenties = this.rel;
			$("#amenities_" + rel_amenties).remove();
			$(this).closest('li').remove();
			$("#f_amenities_" + rel_amenties).remove();
			$("#f_amen_" + rel_amenties).remove();
			evt.preventDefault();
		});
			$(".f_amenties_close").livequery("click",function(evt){ 
		    var rel_amenties = this.rel;
			$("#f_amenities_" + rel_amenties).remove();
			$(this).closest('li').remove();
			evt.preventDefault();
		});
		
	});
	
	/**
   * it is used to autocomplete suitables and selected
   * @()
  */
   $('#suitables').livequery(function() { 
     var amenty_type=$('#amenty_request_type').val();
     var hotel_id=$('#js_hotel_id').val();
     if(typeof  hotel_id == "undefined")
     {
      hotel_id=0;
      }
		$("#suitables").autocomplete({ 
			source: "auctions/suitables_list/"+amenty_type+'/'+hotel_id,
			minLength: 1,
			select: function(data,html) { 
				var ament = html.item.value; 
				
				var findme = "&";

				if (ament.indexOf(findme) > -1 ) {
					var suitables = ament.replace('&', '%26');
				}else{
					var suitables = ament;
				} 
				jQuery.ajax({
					type: "POST",
					url: "auctions/save_suitables_id",
					data: "name="+suitables,
					success: function(arr){ 
						if(arr!='') { 
							if($('#suitables_'+arr).val()==arr) {
								$('#suitables').val('');
								return false;
							}else{ 
								$('#suitables_div').prepend("<input type='hidden' name='suitables_id[]' value='"+ arr + "' id='suitables_"+arr+"' class='txtoption'>");
								$('#carousel2').prepend("<li><span class='auctionadd'>"+ament+"<a href='#' id='close_"+arr+"' class='suitables_close' rel='"+arr+"' title='close'>close</a></span></li>");
								$('#suitables').val('');
							}
						}else{
							$('#suitables').val('');
						}
					}
					
				});		
			}
		});
		/**
		   * it is used to close selected suitables
		   * @()
		*/
		$(".suitables_close").livequery("click",function(evt){ 
		    var rel_genre = this.rel;
			$("#suitables_" + rel_genre).remove();
			$(this).closest('li').remove();
					evt.preventDefault();
		});
		
	});
	
	
	
	$("#auto_username").autocomplete({ 
		source: function(request, response) {
			$.getJSON("messages/users_list", { term : request.term,user_type: $("[name='user_type']:checked").val() }, 
					  response);
		 },
		minLength: 1,
		select: function(data,html) { 
			var ament = html.item.value; 
			
			var findme = "&";

			if (ament.indexOf(findme) > -1 ) {
				var suitables = ament.replace('&', '%26');
			}else{
				var suitables = ament;
			} 
			jQuery.ajax({
				type: "POST",
				url: "messages/save_users_id",
				data: "name="+suitables,
				success: function(arr){ 
					if(arr!='') { 
						if($('#users_'+arr).val()==arr) {
							$('#auto_username').val('');
							return false;
						}else{ 
							$('#users_div').prepend("<input type='hidden' name='users_id[]' value='"+ arr + "' id='users_"+arr+"' class='txtoption'>");
							$('#carousel2').prepend("<li><span class='auctionadd'>"+ament+"<a href='#' id='close_"+arr+"' class='users_close' rel='"+arr+"' title='close'>close</a></span></li>");
							$('#auto_username').val('');
						}
					}else{
						$('#auto_username').val('');
					}
				}
				
			});		
		}
	});
	/**
	   * it is used to close selected suitables
	   * @()
	*/
	$(".users_close").livequery("click",function(evt){ 
		var rel_genre = this.rel;
		$("#users_" + rel_genre).remove();
		$(this).closest('li').remove();
				evt.preventDefault();
	});
	
	
	
	
	/**
		* it is used to Advanced search toggle
		* @()
	*/
	jQuery.fn.visible = function() {
	return this.css('visibility', 'visible');
	};

	jQuery.fn.invisible = function() {
		return this.css('visibility', 'hidden');
	};

	jQuery.fn.visibilityToggle = function() {
		return this.css('visibility', function(i, visibility) {
			return (visibility == 'visible') ? 'hidden' : 'visible';
		});
	};
	
	$('#module-search input[name="search"]').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			$('#module-search').find('input[name="submit-search"]').trigger('click');
		}
	});

	$('a.advanced-search-toggle'+module).on('click', function(ev) {
		ev.preventDefault();

		$('div.advenced_search_container').slideToggle();
		$('div.quick-search-containers').visibilityToggle();

		if (getCookie('advanced_search'+module) == 1)
		{
			$('a.advanced-search-toggle'+module).text('+ Advanced Search');
			setCookie('advanced_search'+module, 0);
		}
		else
		{
			$('a.advanced-search-toggle'+module).text('- Advanced Search');
			setCookie('advanced_search'+module, 1);
		}
	});

	if (getCookie('advanced_search'+module) == 1)
	{
		$('a.advanced-search-toggle'+module).text('- Advanced Search');
		$('div.advenced_search_container').slideDown();
		$('div.quick-search-containers').invisible();
	}

	$('div#advenced_search_container').on('keypress', '.form-control', function(ev) {
		var code = (ev.keyCode ? ev.keyCode : ev.which);
		if (code == 13) {
			ev.preventDefault();
			$('input[name="submit-advanced-search"]').click();
		}
	});
	
	/**
	   * it is used to Bulk data's more action performed
	   * @()
	*/
	$('#selecctall').click(function(event) {  //on click
		$('.js-checkbox-all').attr('checked',false);
        if(this.checked) { // check select status
            $('.js-checkbox-all').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "js-checkbox" 
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });
        }else{
            $('.js-checkbox-all').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "js-checkbox"
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });        
        }
    });
	
	$('.js-more-action').live('change',function(){
		var flag = 0;
		var job=document.getElementsByName('checkall_box[]');
		for(var i=0;i<job.length;i++) {
			 if(job[i].checked == true){
				flag++;
			}
		}
		if ( $("#MoreActionId").val() == "") {
			return false;
		} else if (flag == 0) {
            alert('Please select atleast one record!');
            return false;
        } else{
            if (window.confirm('Are you sure you want to do this action?')) {
				//console.log($(this).parents('form').submit());
                //$(this).parents('form').submit();
				//console.log(document.forms[0]);
				document.forms[1].submit();
            }else{			
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').trigger('click');			
				$('#selecctall').attr('checked',false);		
				$('#MoreActionId').val('');	
						
			}
        }
	});
	
	/**
	   * it is used to single data's more action confirmation
	   * @()
	*/
	$('.td-actions a.btn-success').livequery('click', function() {
		if($(this).hasClass("js-alertsuccess")) {
			if (window.confirm("Do you really want to unfeatured this city?")) {
			return true;
			} else {
			return false;
			}
		} else if($(this).hasClass("js-alerthome")){
			if (window.confirm("Are you sure you want to remove it from home offer ?")) {
			return true;
			} else {
			return false;
			}
		}
		else{
			if (window.confirm("Are you sure want to inactivate this record?")) {
				return true;
			} else {
				return false;
			}
		}
	});
	
	$('.td-actions a.btn-danger').livequery('click', function() {
		if($(this).hasClass("js-alertdanger")){
			if (window.confirm("Do you really want to feature this city?")) {
				return true;
			} else {
				return false;
			}
		} else if($(this).hasClass("js-alertunhome")){
			if (window.confirm("Are you sure to set it to home offer ?")) {
				return true;
			} else {
				return false;
			}
		}
		else{
			if (window.confirm("Are you sure want to activate this record?")) {
				return true;
			} else {
				return false;
			}
		}
		
	});
	
	$('.td-actions a.btn-warning').livequery('click', function() {
		if($(this).hasClass("approve_hotel")){
			if (window.confirm("Please view the Hotel Details before Approve!!!")) {
				
				if (window.confirm("Proceed anyway to approve this hotel?")) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			if(window.confirm("Are you sure want to approved this hotel?")) {
				return true;
			} else {
				return false;
			}
		}
	});
	
	$(".rep_msg").livequery('click',function(){
		var idval = $(this).attr('id').substr(10);
		$(".replay_hide").empty();
		//$('.replay_txt_'+idval).show();
		$('.replay_txt_'+idval).html("<textarea id='txtbox_"+idval+"' style='height:80px;' class='span4'></textarea>&nbsp;&nbsp;<input type='submit' rel='"+idval+"' class='btn btn-primary reply_sent' value='Reply' style='margin-top:60px;'>");
		//alert(idval);
	});
	$(".reply_sent").livequery('click',function(e){
		$(".text-danger").hide();
		var rel_id = $(this).attr('rel');
		//alert(rel_id);
		//console.log($("#txtbox_"+rel_id).value);
		if($("#txtbox_"+rel_id).val()==""){
			$("#shw_"+rel_id).show();
		} else{
			$.ajax({
				type: "POST",
				url: __cfg('admin_path_absolute')+'messages/reply',
				dataType:'json',
				data:{message:$("#txtbox_"+rel_id).val(),reply_user_id:$("#to_user_"+rel_id).val(),message_id:rel_id},
				success: function(data){
					console.log(data);
					if(data.status=="success"){
						$(".replay_txt_"+rel_id).hide();
						$("#shw_suc_"+rel_id).show();
					}
				}
			});
		}
	});
	$(".num_accept").livequery('keydown',function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	$(".num_accept").livequery('keyup',function (e) {
		var old_val = this.defaultValue;
		if($(this).val().length==1 && (e.keyCode==48 || e.keyCode==96)) {
			$(this).val(old_val);
		}
	}); 
	$('.place-of-intrest .js-file-add').livequery('click', function() {
		var $par = $(this).parents('.place-of-intrest');
		if($('.js-clone-count').val()==8) {
			alert('Maximum 8 images are allowed to add');
			return false;
		}
		$clone = clone_file($par);
		$clone.find(':input').val('');
		var rel=parseInt($('.js-clone-count').val())+1;
		$clone.find('span').attr('rel',rel);
		$clone.find('.text-danger p').empty();
		$clone.find(':input.int-name').each(function(i){
			$clone.find(':input.int-name').attr('name','interset_name'+rel);
		});
		$clone.find(':input.image_file_name').each(function(i){
			$clone.find(':input.image_file_name').attr('name','interset_image'+rel);
			$('.js-clone-count').val(rel);
		});
		$clone.find('.js-file-remove').addClass('file-remove-button');
		$clone.find('.js-file-remove').css('display','block');
		$par.after($clone);
		return false;
	});
	$('.place-of-intrest .js-file-remove').livequery('click', function() {
		$(this).parents('.place-of-intrest').remove();
		if($('.js-clone-count').val() != 1) {
			var rel=parseInt($('.js-clone-count').val() -1);
			$('.js-clone-count').val(rel);
		}
		return false;
	});
	$('.js-city-img-remove').livequery('click', function() {
		var $this=$(this);
		var id=$(this).attr('rel');
		$.ajax({
			type: "POST",
			url: __cfg('path_absolute')+'cities/remove_images/'+id,
			dataType:'json',
			data:{id:id},
			success: function(data){
				if(data) {
					$('.js-remove-image-'+id).remove();
					$(".place-of-intrest").css('display','inline-block');
					$(".js-file-add").css('display','inline-block');
					$(".js-clone-count").val($(".js-clone-count").val()-1);
				}
			}
		});
		return false;
	});
	$('.td-actions a.delete-con').livequery('click', function() {
		if (window.confirm("Are you sure want to delete this record?")) {
			if (window.confirm("if you continue to delete, all the child records were also deleted")) {
				return true;
			}else {
				return false;
			}
		} else {
			return false;
		}
	});
	
	$("input[name=last_name]").livequery('blur',function() {
		if( $.trim($("#first_name").val())!="" && $("#display_name").val()=="" ){
			$.ajax({
				url:__cfg('path_absolute')+"home/auto_displayname",
				type:'post',
				data:{first_name:$("#first_name").val(),last_name:$("#last_name").val()},
				success:function(data) {
					var res=jQuery.parseJSON(data);
					//console.log(res);
					if(res.status=="success") {
						$("#display_name").val(res.username);
					}
				}
			});
		}
	});
	
	$("input[name=hotel_name]").livequery('blur',function() {
		if( $.trim($("#hotel_name").val())!="" && $("#display_name").val()=="" ){
			$.ajax({
				url:__cfg('path_absolute')+"home/auto_displayname",
				type:'post',
				data:{hotel_name:$("#hotel_name").val()},
				success:function(data) {
					var res=jQuery.parseJSON(data);
					//console.log(res);
					if(res.status=="success") {
						$("#display_name").val(res.username);
					}
				}
			});
		}
	});
	
	$("input[name=display_name]").livequery('keypress',function(key) {
	    if(key.charCode == 32) return false;
    });
	
});
	function clone_file($par){
		return $par.clone();
	}
$.fn.sel = function(){
$(document).ready(function() {
      $('#rowclick1 tr.check-select')
        .filter(':has(:checkbox:checked)')
        .addClass('selectrow')
        .end()
      .click(function(event) { 
		if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
        }
      })
        .find(':checkbox')
        .click(function(event) {
          $(this).parents('tr:first.check-select').toggleClass('selectrow');
        });    
    });
}
$.fn.sel();