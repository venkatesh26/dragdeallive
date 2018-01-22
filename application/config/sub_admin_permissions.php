<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['sub_admin_roles']	= array(
								   'user'		=> array('dashboard','edit_profile'),
								   'webusers'	=> array('index','add'),
								   'pages'		=> array('index','edit'),
								   'countries'	=> array('index'),
								   'states'		=> array('index'),
								   'cities'		=> array('index'),
								   'areas'		=> array('index'),
								   'pages'		=> array('index','add','edit'),
								);
$config['master_menus'] 	= array('plans'=>'Packages','countries'=>'Countries','states'=>'States','cities'=>'Cities',
								'areas'=>'Areas','main_category'=>'Main Category','categories'=>'Sub Category','blog_category'=>'Blog Category','notificationtype'=>'Notification Type','pages'=>'Pages');