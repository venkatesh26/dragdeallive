<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo base_url(); ?>">
    <meta charset="utf-8">
    <title><?php echo admin_settings_initialize('sitename').' - '.$title; ?></title>
	<?php $this->load->view('includes/scripts'); ?>
</head>
<body>
<div class="main-wrapper">
<?php $this->load->view('includes/header'); 
	if(!isset($hide_menu)) { 
		$this->load->view('includes/menu'); 
	}
$this->load->view($main_content);
$this->load->view('includes/footer'); 
 ?>
 </div>
</body>
</html>