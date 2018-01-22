<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes"> 
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/fav.ico">
<link href="assets/css/admin/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/admin/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/admin/font-awesome.css" rel="stylesheet">
<link href="assets/css/admin/fonts/fonts.css" rel="stylesheet">
<link href="assets/css/admin/style.css" rel="stylesheet" type="text/css">
<link href="assets/css/admin/pages/dashboard.css" rel="stylesheet">
<link href="assets/css/admin/pages/signin.css" rel="stylesheet" type="text/css">
<link href="assets/css/admin/pages/plans.css" rel="stylesheet">
<link href="assets/css/admin/jquery-ui.css" rel="stylesheet">     <?php if(($this->uri->segment(2)=="auctions") || ($this->uri->segment(2)=="users" && $this->uri->segment(3)=="add") ) { ?>
<link href="assets/css/admin/jquery.datetimepicker.css" rel="stylesheet">
<?php } ?>
<script src="assets/js/admin/jquery-1.7.2.min.js"></script>
<script src="assets/js/admin/jquery.livequery.js" type="text/javascript"></script>
<script src="assets/js/admin/jquery.validate.js" type="text/javascript"></script>
<script>
var cfg = {"cfg":{"admin_path_absolute":"<?php echo base_url().ADMIN.'/'; ?>","path_absolute":"<?php echo base_url(); ?>"}}
</script>
<script src="assets/js/admin/admin_common.js" type="text/javascript"></script>
<?php if(($this->uri->segment(2)=="countries" || $this->uri->segment(2)=="states" || $this->uri->segment(2)=="cities" || $this->uri->segment(2)=="areas" || $this->uri->segment(2)=="users" || $this->uri->segment(2)=="advertisment_edit" )) { ?>
<script src="assets/js/admin/location.js" type="text/javascript"></script>
<?php } ?>
<script src="assets/js/admin/bootstrap.js"></script>
<script src="assets/js/admin/signin.js"></script>
<script src="assets/js/admin/jquery-ui.js"></script>
<?php if( ($this->router->fetch_class()=="hotelusers" || $this->router->fetch_class()=="cities" || $this->router->fetch_class()=="areas" || $this->router->fetch_class()=="states" ) && ($this->router->fetch_method()=="add" || $this->router->fetch_method()=="edit") ) {?>
 <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<?php } ?>