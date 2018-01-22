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
$checkUserPlan = checkUserPlan($this->session->userdata('user_id'));
if($checkUserPlan=='' || $checkUserPlan['plan_id']=='' || $checkUserPlan['plan_id'] ==1 ):
?>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';"></span> 
  <strong><i class="fa fa-info-circle"></i> Sorry !</strong> “Please upgrade your plan to use this feature”.
</div>	
<script>
$(document).ready(function() {
$('.white-bg').addClass('overlay');
});
</script>
<?php endif;?>