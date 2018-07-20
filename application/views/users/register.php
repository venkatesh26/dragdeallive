
<style>
   .required{
   color:red;
   }
   .single-form input{
   height:45px;
   }
   .checkbox-section label,input 
   {
	float:left;   
   }
   .is-vendor{
	    margin-top: 16px;
    margin-left: 10px;   
   }
   .cursor{
	   cursor:pointer;
   }
</style>
<div class="td-main-content-wrap td-main-page-wrap" style="background:#fcfcfc;">

   <div class="container single-form">
      <?php 
		/************ Bread Crumb *****************/ 
		echo $this->load->view('bread_crumb',array(),true); 
		?>
      <div class="col-sm-9">
         <form class="form-horizontal" action="<?php echo base_url().'users/register';?>" method="post" id="login_form_url">
            <h3>&nbsp;</h3>
            <div class="form-group">
               <label for="firstName" class="col-sm-3 control-label">First Name<span class="required"> *</span></label>
               <div class="col-sm-9">
                  <input type="text" name="first_name" id="firstName" placeholder="Enter Your First Name" class="form-control" autofocus="">
               </div>
            </div>
            <div class="form-group">
               <label for="firstName" class="col-sm-3 control-label">Last Name </label>
               <div class="col-sm-9">
                  <input type="text" id="last_name" name="last_name" placeholder="Enter Your Last Name" class="form-control" autofocus="">
               </div>
            </div>
            <div class="form-group">
               <label for="email" class="col-sm-3 control-label">Email<span class="required"> *</span></label>
               <div class="col-sm-9">
                  <input type="email" name="email" id="email" placeholder="Enter Your Email-ID" class="form-control">
               </div>
            </div>
            <div class="form-group">
               <label for="email" class="col-sm-3 control-label">Mobile Number<span class="required"> *</span></label>
               <div class="col-sm-9">
                  <input type="contact_number" name="contact_number" id="contact_number" placeholder="Enter Your Mobile Number" class="form-control" autocomplete="off">
               </div>
            </div>
            <div class="form-group">
               <label for="password" class="col-sm-3 control-label">Password<span class="required"> *</span></label>
               <div class="col-sm-9">
                  <input type="password" name="password" id="password" placeholder="Enter Your Password" class="form-control" autocomplete="off">
               </div>
            </div>
			<div class="form-group checkbox-section">
				 <label for="is_vendor" class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<input type="checkbox" name="is_vendor" id="is_vendor" value="1"  autocomplete="off"><label for="is_vendor" class="is-vendor cursor">I would like register as vendor</label>
				</div>
			 </div>
			
            <div class="form-group">
               <div class="col-sm-3 col-sm-offset-3 pull-right">
			
                  <input type="submit" value="Register" class="register-submit-button" style="float:right;">
               </div>
			   <div class="col-sm-3 col-sm-offset-3 pull-right">
			      <a class="td-login-modal-js menu-item" href="#login-form" data-effect="mpf-td-login-effect">Already Have an account ?</a>
				  </div>
            </div>
         </form>
         <!-- /form -->
      </div>
      <div class="col-sm-3">
         <h3>&nbsp;</h3>
         <div class="form-group">
            OR  Fill my details from
         </div>
         <div class="td-default-sharing">
            <a href="https://www.dragdeal.com/facebook" class="td-social-sharing-buttons td-social-facebook">
               <i class="fa fa-facebook"></i>
               <div class="td-social-but-text">Register Using Facebook</div>
            </a>
            <br/>
            <br/>
            <a href="https://www.dragdeal.com/twitter" class="td-social-sharing-buttons td-social-twitter">
               <i class="fa fa-twitter"></i>
               <div class="td-social-but-text">Register Using Twitter</div>
            </a>
            <br/>
            <br/>
            <a href="https://www.dragdeal.com/googleplus" target="_blank" class="td-social-sharing-buttons td-social-pinterest">
               <i class="fa fa-google-plus"></i>
               <div class="td-social-but-text">Register Using G+</div>
            </a>
         </div>
      </div>
   </div>
</div>