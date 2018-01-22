<style>
.overlay{
 position: realative;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    filter:alpha(opacity=50);
    -moz-opacity:0.5;
    -khtml-opacity: 0.5;
    opacity: 0.5;
    z-index: 10000;
	pointer-events:none; 
	z-index:999999 !important;
}
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
}
</style>
<?php 
$checkUserPlan = get_my_addId($this->session->userdata('user_id'));
if($checkUserPlan<=0):
?>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';"></span> 
  <strong><i class="fa fa-info-circle"></i> Sorry !</strong> “Please <a href="<?php echo base_url().'/business-profile'?>" style="color:yellow;"> click here </a> Complete your Profile to use this feature”.
</div>	
<script>
$(document).ready(function() {
$('.overlay-section').addClass('overlay');
$('.white-bg').addClass('overlay');
});
</script>
<?php endif;?> 