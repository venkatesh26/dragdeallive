<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

########### Jobs ###############
$route[ADMIN.'/jobs'] = 'jobs/admin_index';
$route[ADMIN.'/jobs/getReports'] = 'jobs/getReports';
$route[ADMIN.'/jobs/delete/(:any)'] = 'jobs/delete/$1';//1 deleted id
$route[ADMIN.'/jobs/bulkautions/(:any)/(:any)'] = 'jobs/bulkautions/$1/$2';
$route[ADMIN.'/jobs_view/view/(:any)'] = 'jobs/admin_view/$1';
$route[ADMIN.'/jobs_delete/delete/(:any)'] = 'jobs/delete/$1';
$route[ADMIN.'/jobs_enable/enable/(:any)/(:any)/(:any)'] = 'jobs/update_status/$1/enable/$2/$3';
$route[ADMIN.'/jobs_enable/disable/(:any)/(:any)/(:any)'] = 'jobs/update_status/$1/disable/$2/$3';
$route[ADMIN.'/jobs/add'] = 'jobs/add';
$route[ADMIN.'/jobs/edit/(:any)'] = 'jobs/edit/$1';
$route[ADMIN.'/jobs/(:any)'] = 'jobs/admin_index/$1';
$route[ADMIN.'/jobs/(:any)/(:any)/(:any)'] = 'jobs/admin_index/$1/$2/$3';
$route[ADMIN.'/jobs/(:any)/(:any)/(:any)/(:any)'] = 'jobs/admin_index/$1/$2/$3/$4';



###########Countries###############
$route[ADMIN.'/countries'] = 'countries/index';
$route[ADMIN.'/countries/add'] = 'countries/add';
$route[ADMIN.'/countries/edit/(:any)'] = 'countries/edit/$1';
$route[ADMIN.'/countries/delete/(:any)'] = 'countries/delete/$1';//1 deleted id
$route[ADMIN.'/countries/bulkautions/(:any)/(:any)'] = 'countries/bulkautions/$1/$2';
$route[ADMIN.'/countries/enable/(:any)/(:any)/(:any)'] = 'countries/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/countries/disable/(:any)/(:any)/(:any)'] = 'countries/update_status/$1/disable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/countries/(:any)'] = 'countries/index/$1';
$route[ADMIN.'/countries/(:any)/(:any)/(:any)'] = 'countries/location_list/$1/$2/$3';
$route[ADMIN.'/getcountries'] = 'countries/get';// Auto complete 
$route[ADMIN.'/countries/(:any)/(:any)'] = 'countries/index/$1/$2';
$route[ADMIN.'/countries/(:any)/(:any)/(:any)'] = 'countries/index/$1/$2/$3';
$route[ADMIN.'/countries/(:any)/(:any)/(:any)/(:any)'] = 'countries/index/$1/$2/$3/$4';

###############States################
$route[ADMIN.'/states'] = 'states/index';
$route[ADMIN.'/states/add'] = 'states/add';
$route[ADMIN.'/states/edit/(:any)'] = 'states/edit/$1';
$route[ADMIN.'/getstates'] = 'states/get'; // Auto complete 
$route[ADMIN.'/states/delete/(:any)'] = 'states/delete/$1';//1 deleted id
$route[ADMIN.'/getstates/(:any)'] = 'states/get_states_by_country/$1'; // Auto complete 
$route[ADMIN.'/states/bulkautions/(:any)/(:any)'] = 'states/bulkautions/$1/$2';
$route[ADMIN.'/states/enable/(:any)/(:any)/(:any)'] = 'states/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/states/disable/(:any)/(:any)/(:any)'] = 'states/update_status/$1/disable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/states/(:any)'] = 'states/index/$1';
$route[ADMIN.'/states/(:any)/(:any)'] = 'states/index/$1/$2';
$route[ADMIN.'/states/(:any)/(:any)/(:any)'] = 'states/index/$1/$2/$3';
$route[ADMIN.'/states/(:any)/(:any)/(:any)/(:any)'] = 'states/index/$1/$2/$3/$4';


################Cities#################
$route[ADMIN.'/cities'] = 'cities/index';
$route[ADMIN.'/cities/add'] = 'cities/add';
$route[ADMIN.'/cities/edit/(:any)'] = 'cities/edit/$1';
$route[ADMIN.'/getcities'] = 'cities/get';// Auto complete 
$route[ADMIN.'/cities/delete/(:any)'] = 'cities/delete/$1';//1 deleted id
$route[ADMIN.'/getcities/(:any)'] = 'cities/get_cities_by_state/$1'; // Auto complete 
$route[ADMIN.'/cities/bulkautions/(:any)/(:any)'] = 'cities/bulkautions/$1/$2';
$route[ADMIN.'/cities/enable/(:any)/(:any)/(:any)'] = 'cities/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/cities/disable/(:any)/(:any)/(:any)'] = 'cities/update_status/$1/disable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/cities/en_featured/(:any)/(:any)/(:any)'] = 'cities/update_featured/$1/featured/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/cities/en_unfeatured/(:any)/(:any)/(:any)'] = 'cities/update_featured/$1/unfeatured/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/cities/en_start_your/(:any)/(:any)/(:any)'] = 'cities/update_en_start_your/$1/featured/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/cities/en_unstart_your/(:any)/(:any)/(:any)'] = 'cities/update_en_start_your/$1/unfeatured/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/cities/(:any)'] = 'cities/index/$1';
$route[ADMIN.'/cities/(:any)/(:any)/(:any)'] = 'cities/location_list/$1/$2/$3';
$route[ADMIN.'/city_view/view/(:any)'] = 'cities/view/$1';
$route[ADMIN.'/cities/(:any)'] = 'cities/index/$1';
$route[ADMIN.'/cities/(:any)/(:any)'] = 'cities/index/$1/$2';
$route[ADMIN.'/cities/(:any)/(:any)/(:any)'] = 'cities/index/$1/$2/$3';
$route[ADMIN.'/cities/(:any)/(:any)/(:any)/(:any)'] = 'cities/index/$1/$2/$3/$4';

########################Areas###################
$route[ADMIN.'/areas'] = 'areas/index';
$route[ADMIN.'/areas/add'] = 'areas/add';
$route[ADMIN.'/areas/edit/(:any)'] = 'areas/edit/$1';
$route[ADMIN.'/areas/delete/(:any)'] = 'areas/delete/$1';//1 deleted id
$route[ADMIN.'/getareas/(:any)'] = 'areas/get_areas_by_city/$1'; // Auto complete 
$route[ADMIN.'/areas/bulkautions/(:any)/(:any)'] = 'areas/bulkautions/$1/$2';
$route[ADMIN.'/areas/enable/(:any)/(:any)/(:any)'] = 'areas/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/areas/disable/(:any)/(:any)/(:any)'] = 'areas/update_status/$1/disable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/areas/(:any)'] = 'areas/index/$1';
$route[ADMIN.'/areas/(:any)/(:any)/(:any)'] = 'areas/location_list/$1/$2/$3';/**/
$route[ADMIN.'/areas/(:any)'] = 'areas/index/$1';
$route[ADMIN.'/areas/(:any)/(:any)'] = 'areas/index/$1/$2';
$route[ADMIN.'/areas/(:any)/(:any)/(:any)'] = 'areas/index/$1/$2/$3';
$route[ADMIN.'/areas/(:any)/(:any)/(:any)/(:any)'] = 'areas/index/$1/$2/$3/$4';


#Admin user befor login
$route[ADMIN] = 'user/index';
$route[ADMIN.'/signup'] = 'user/signup';
$route[ADMIN.'/create_member'] = 'user/create_member';
$route[ADMIN.'/login'] = 'user/index';
$route[ADMIN.'/logout'] = 'user/logout';
$route[ADMIN.'/forgotpassword'] = 'user/forgotpassword_form';
$route[ADMIN.'/reset/(:any)'] = 'user/resetpassword/$1';
$route[ADMIN.'/resetpassword'] = 'user/updatepassword';


#Admin user general paths
$route[ADMIN.'/dashboard'] = 'user/dashboard';
$route[ADMIN.'/settings'] = 'user/settings';
$route[ADMIN.'/settings/update'] = 'user/settings_update';
$route[ADMIN.'/change_password'] = 'user/change_password';
$route[ADMIN.'/edit_profile'] = 'user/edit_profile';
$route[ADMIN.'/(:any)/change_password/(:any)'] = 'user/other_change_password/';


######web users##############
$route[ADMIN.'/users'] = 'webusers/index';
$route[ADMIN.'/users/add'] = 'webusers/add';
$route[ADMIN.'/users/update'] = 'webusers/update';
$route[ADMIN.'/users/update/(:any)'] = 'webusers/update/$1';
$route[ADMIN.'/users/delete/(:any)'] = 'webusers/delete/$1';
$route[ADMIN.'/users/edit/(:any)'] = 'webusers/edit/$1';
$route[ADMIN.'/users/view/(:any)'] = 'webusers/view/$1';
$route[ADMIN.'/users/bulkautions/(:any)/(:any)'] = 'webusers/bulkautions/$1/$2';
$route[ADMIN.'/users/enable/(:any)/(:any)/(:any)'] = 'webusers/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/users/disable/(:any)/(:any)/(:any)'] = 'webusers/update_status/$1/disable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/users/approve/(:any)/(:any)/(:any)'] = 'webusers/update_approve_status/$1/approve/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/users/disapprove/(:any)/(:any)/(:any)'] = 'webusers/update_approve_status/$1/disapprove/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/users/delete/(:any)'] = 'hotelusers/delete/$1';
$route[ADMIN.'/users/(:any)'] = 'webusers/index/$1';
$route[ADMIN.'/users/(:any)/(:any)'] = 'webusers/index/$1/$2';
$route[ADMIN.'/users/(:any)/(:any)/(:any)'] = 'webusers/index/$1/$2/$3';
$route[ADMIN.'/users/(:any)/(:any)/(:any)/(:any)'] = 'webusers/index/$1/$2/$3/$4';
$route[ADMIN.'/resendActivationLink/(:any)'] = 'webusers/resend_activation_mail/$1';
$route[ADMIN.'/users_send_mail/(:any)'] = 'webusers/send_email/$1';


#############Subadmin################
$route[ADMIN.'/subadmin'] = 'subadmin/index';
$route[ADMIN.'/subadmin/add'] = 'subadmin/add';
$route[ADMIN.'/subadmin/update'] = 'subadmin/update';
$route[ADMIN.'/subadmin/update/(:any)'] = 'subadmin/update/$1';
$route[ADMIN.'/subadmin/delete/(:any)'] = 'subadmin/delete/$1';
$route[ADMIN.'/subadmin/edit/(:any)'] = 'subadmin/edit/$1';
$route[ADMIN.'/subadmin/view/(:any)'] = 'subadmin/view/$1';
$route[ADMIN.'/subadmin/bulkautions/(:any)/(:any)'] = 'subadmin/bulkautions/$1/$2';
$route[ADMIN.'/subadmin/enable/(:any)/(:any)/(:any)'] = 'subadmin/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/subadmin/disable/(:any)/(:any)/(:any)'] = 'subadmin/update_status/$1/disable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/subadmin/approve/(:any)/(:any)/(:any)'] = 'subadmin/update_approve_status/$1/approve/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/subadmin/disapprove/(:any)/(:any)/(:any)'] = 'subadmin/update_approve_status/$1/disapprove/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/subadmin/delete/(:any)'] = 'hotelusers/delete/$1';
$route[ADMIN.'/subadmin/(:any)'] = 'subadmin/index/$1';


################Comments##################
$route[ADMIN.'/comments'] = 'comments/index';
$route[ADMIN.'/comments/getReports'] = 'comments/getReports';
$route[ADMIN.'/comments/delete/(:any)'] = 'comments/delete/$1';//1 deleted id
$route[ADMIN.'/comments/bulkautions/(:any)/(:any)'] = 'comments/bulkautions/$1/$2';
$route[ADMIN.'/comments/(:any)'] = 'comments/index/$1';
$route[ADMIN.'/comments/(:any)/(:any)/(:any)'] = 'comments/index/$1/$2/$3';
$route[ADMIN.'/comment_view/view/(:any)'] = 'comments/view/$1';
$route[ADMIN.'/comment_view/view/(:any)/(:any)'] = 'comments/view/$1/$2';
$route[ADMIN.'/comment_view/view/(:any)/(:any)/(:any)/(:any)'] = 'comments/view/$1/$2/$3/$4';
$route[ADMIN.'/comment_delete/delete/(:any)'] = 'comments/delete/$1';
$route[ADMIN.'/comments_enable/enable/(:any)/(:any)/(:any)'] = 'comments/update_status/$1/enable/$2/$3';
$route[ADMIN.'/comments_enable/disable/(:any)/(:any)/(:any)'] = 'comments/update_status/$1/disable/$2/$3';



################Sender Ids##################
$route[ADMIN.'/sender_ids'] = 'sender_ids/index';
$route[ADMIN.'/sender_ids/delete/(:any)'] = 'sender_ids/delete/$1';//1 deleted id
$route[ADMIN.'/sender_ids/bulkautions/(:any)/(:any)'] = 'sender_ids/bulkautions/$1/$2';
$route[ADMIN.'/sender_ids/(:any)'] = 'sender_ids/index/$1';
$route[ADMIN.'/sender_ids/(:any)/(:any)'] = 'sender_ids/index/$1/$2';
$route[ADMIN.'/sender_ids/(:any)/(:any)/(:any)'] = 'sender_ids/index/$1/$2/$3';
$route[ADMIN.'/sender_ids/(:any)/(:any)/(:any)/(:any)'] = 'sender_ids/index/$1/$2/$3/$4';
$route[ADMIN.'/sender_ids_enable/enable/(:any)/(:any)/(:any)'] = 'sender_ids/update_status/$1/enable/$2/$3';
$route[ADMIN.'/sender_ids_enable/disable/(:any)/(:any)/(:any)'] = 'sender_ids/update_status/$1/disable/$2/$3';

#Notification Type
$route[ADMIN.'/notificationtype'] = 'notification_type/index';
$route[ADMIN.'/notificationtype/delete/(:any)'] = 'notification_type/delete/$1';//1 deleted id
$route[ADMIN.'/notificationtype/bulkautions/(:any)/(:any)'] = 'notification_type/bulkautions/$1/$2';
$route[ADMIN.'/notificationtype/view/(:any)'] = 'notification_type/view/$1';
$route[ADMIN.'/notificationtype/delete/(:any)'] = 'notification_type/delete/$1';
$route[ADMIN.'/notificationtype/(:any)'] = 'notification_type/index/$1';
$route[ADMIN.'/notificationtype/(:any)/(:any)/(:any)'] = 'notification_type/index/$1/$2/$3';
$route[ADMIN.'/notificationtype/(:any)/(:any)/(:any)/(:any)'] = 'notification_type/index/$1/$2/$3/$4';
$route[ADMIN.'/notification_type/add'] = 'notification_type/add';
$route[ADMIN.'/notification_type/edit/(:any)'] = 'notification_type/edit/$1';

##########plans#######
$route[ADMIN.'/plans'] = 'plans/index';
$route[ADMIN.'/plans/edit/(:any)'] = 'plans/edit/$1';

##############pages#############
$route[ADMIN.'/site_maps'] = 'site_maps/index';
$route[ADMIN.'/site_maps/category'] = 'site_maps/category';
$route[ADMIN.'/site_maps/link_create'] = 'site_maps/link_create';

#site Maps
$route[ADMIN.'/pages'] = 'pages/index';
$route[ADMIN.'/pages/edit/(:any)'] = 'pages/edit/$1';
$route[ADMIN.'/pages/(:any)'] = 'pages/index/$1';
$route[ADMIN.'/pages/(:any)/(:any)/(:any)'] = 'pages/index/$1/$2/$3';
$route[ADMIN.'/users/(:any)/(:any)'] = 'webusers/index/$1/$2';
$route[ADMIN.'/users/(:any)/(:any)/(:any)'] = 'webusers/index/$1/$2/$3';
$route[ADMIN.'/users/(:any)/(:any)/(:any)/(:any)'] = 'webusers/index/$1/$2/$3/$4';



#User Logins
$route[ADMIN.'/user_logins'] = 'user_logins/index';
$route[ADMIN.'/user_logins/delete/(:any)'] = 'user_logins/delete/$1';//1 deleted id
$route[ADMIN.'/user_logins/bulkautions/(:any)/(:any)'] = 'user_logins/bulkautions/$1/$2';
$route[ADMIN.'/user_logins/(:any)'] = 'user_logins/index/$1';
$route[ADMIN.'/user_logins/(:any)/(:any)'] = 'user_logins/index/$1/$2';
$route[ADMIN.'/user_logins/(:any)/(:any)/(:any)'] = 'user_logins/index/$1/$2/$3';
$route[ADMIN.'/user_logins/(:any)/(:any)/(:any)/(:any)'] = 'user_logins/index/$1/$2/$3/$4';


#Advertisment
$route[ADMIN.'/advertisments'] = 'advertisments/index';
$route[ADMIN.'/advertisments/getReports'] = 'advertisments/getReports';
$route[ADMIN.'/advertisments/delete/(:any)'] = 'advertisments/delete/$1';//1 deleted id
$route[ADMIN.'/advertisments/bulkautions/(:any)/(:any)'] = 'advertisments/bulkautions/$1/$2';
$route[ADMIN.'/advertisment_view/view/(:any)'] = 'advertisments/view/$1';
$route[ADMIN.'/advertisment_enable/enable/(:any)/(:any)/(:any)'] = 'advertisments/update_status/$1/enable/$2/$3';
$route[ADMIN.'/advertisment_enable/disable/(:any)/(:any)/(:any)'] = 'advertisments/update_status/$1/disable/$2/$3';
$route[ADMIN.'/advertisment_edit/edit/(:any)'] = 'advertisments/edit/$1';
$route[ADMIN.'/advertisments/edit/(:any)'] = 'advertisments/edit/$1';
$route[ADMIN.'/advertisments/(:any)'] = 'advertisments/index/$1';
$route[ADMIN.'/advertisments/(:any)/(:any)/(:any)'] = 'advertisments/index/$1/$2/$3';
$route[ADMIN.'/advertisment_send_mail/(:any)'] = 'advertisments/send_add_email/$1';
$route[ADMIN.'/advertisment_profile_completion/(:any)'] = 'advertisments/send_profile_complete_mail/$1';
$route[ADMIN.'/advertisements/admin_add_or_update/(:any)'] = 'advertisments/admin_add_or_update/$1';
$route[ADMIN.'/advertisements/admin_add_or_update'] = 'advertisments/admin_add_or_update';
$route[ADMIN.'/advertisment_delete/delete/(:any)'] = 'advertisments/delete/$1';//1 deleted id

$route[ADMIN.'/advertisments/(:any)/(:any)'] = 'advertisments/index/$1/$2';
$route[ADMIN.'/advertisments/(:any)/(:any)/(:any)'] = 'advertisments/index/$1/$2/$3';
$route[ADMIN.'/advertisments/(:any)/(:any)/(:any)/(:any)'] = 'advertisments/index/$1/$2/$3/$4';


#Advertisment Enquiry
$route[ADMIN.'/advertisment_enquiry/delete/(:any)'] = 'advertisments_enquiry/delete/$1';//1 deleted id
$route[ADMIN.'/advertisment_enquiry/view/(:any)'] = 'advertisments_enquiry/view/$1';
$route[ADMIN.'/advertisment_enquiry'] = 'advertisments_enquiry/admin_index';
$route[ADMIN.'/advertisment_enquiry/bulkautions/(:any)/(:any)'] = 'advertisments_enquiry/bulkautions/$1/$2';
$route[ADMIN.'/advertisment_enquiry/(:any)'] = 'advertisments_enquiry/admin_index/$1';
$route[ADMIN.'/advertisment_enquiry/(:any)/(:any)'] = 'advertisments_enquiry/admin_index/$1/$2';
$route[ADMIN.'/advertisment_enquiry/(:any)/(:any)/(:any)'] = 'advertisments_enquiry/admin_index/$1/$2/$3';
$route[ADMIN.'/advertisment_enquiry/(:any)/(:any)/(:any)/(:any)'] = 'advertisments_enquiry/admin_index/$1/$2/$3/$4';

#Advertisment Customer List
$route[ADMIN.'/advertisment_customer_list/delete/(:any)'] = 'advertisments_customer_list/delete/$1';//1 deleted id
$route[ADMIN.'/advertisment_customer_list/view/(:any)'] = 'advertisments_customer_list/view/$1';
$route[ADMIN.'/advertisment_customer_list'] = 'advertisments_customer_list/admin_index';
$route[ADMIN.'/advertisment_customer_list/bulkautions/(:any)/(:any)'] = 'advertisments_customer_list/bulkautions/$1/$2';
$route[ADMIN.'/advertisment_customer_list/(:any)'] = 'advertisments_customer_list/admin_index/$1';
$route[ADMIN.'/advertisment_customer_list/(:any)/(:any)'] = 'advertisments_customer_list/admin_index/$1/$2';
$route[ADMIN.'/advertisment_customer_list/(:any)/(:any)/(:any)'] = 'advertisments_customer_list/admin_index/$1/$2/$3';
$route[ADMIN.'/advertisment_customer_list/(:any)/(:any)/(:any)/(:any)'] = 'advertisments_customer_list/admin_index/$1/$2/$3/$4';

#Coupons
$route[ADMIN.'/coupon/delete/(:any)'] = 'coupons/delete/$1';//1 deleted id
$route[ADMIN.'/coupon/view/(:any)'] = 'coupons/view/$1';
$route[ADMIN.'/coupon'] = 'coupons/admin_index';
$route[ADMIN.'/coupon/bulkautions/(:any)/(:any)'] = 'coupons/bulkautions/$1/$2';
$route[ADMIN.'/coupon/(:any)'] = 'coupons/admin_index/$1';
$route[ADMIN.'/coupon/(:any)/(:any)'] = 'coupons/admin_index/$1/$2';
$route[ADMIN.'/coupon/(:any)/(:any)/(:any)'] = 'coupons/admin_index/$1/$2/$3';
$route[ADMIN.'/coupon/(:any)/(:any)/(:any)/(:any)'] = 'coupons/admin_index/$1/$2/$3/$4';


#Keyword Enquiry
$route[ADMIN.'/keyword_enquiry/delete/(:any)'] = 'keywords_enquiry/delete/$1';//1 deleted id
$route[ADMIN.'/keyword_enquiry/view/(:any)'] = 'keywords_enquiry/view/$1';
$route[ADMIN.'/keyword_enquiry'] = 'keywords_enquiry/admin_index';
$route[ADMIN.'/keyword_enquiry/bulkautions/(:any)/(:any)'] = 'keywords_enquiry/bulkautions/$1/$2';
$route[ADMIN.'/keyword_enquiry/(:any)'] = 'keywords_enquiry/admin_index/$1';
$route[ADMIN.'/keyword_enquiry/(:any)/(:any)'] = 'keywords_enquiry/admin_index/$1/$2';
$route[ADMIN.'/keyword_enquiry/(:any)/(:any)/(:any)'] = 'keywords_enquiry/admin_index/$1/$2/$3';
$route[ADMIN.'/keyword_enquiry/(:any)/(:any)/(:any)/(:any)'] = 'keywords_enquiry/admin_index/$1/$2/$3/$4';




#Categories
$route[ADMIN.'/categories'] = 'categories/index';
$route[ADMIN.'/categories/getReports'] = 'categories/getReports';
$route[ADMIN.'/categories/delete/(:any)'] = 'categories/delete/$1';//1 deleted id
$route[ADMIN.'/categories/bulkautions/(:any)/(:any)'] = 'categories/bulkautions/$1/$2';
$route[ADMIN.'/category_view/view/(:any)'] = 'categories/view/$1';
$route[ADMIN.'/category_delete/delete/(:any)'] = 'categories/delete/$1';
$route[ADMIN.'/category_enable/enable/(:any)/(:any)/(:any)'] = 'categories/update_status/$1/enable/$2/$3';
$route[ADMIN.'/category_enable/disable/(:any)/(:any)/(:any)'] = 'categories/update_status/$1/disable/$2/$3';
$route[ADMIN.'/category_popular/enable/(:any)/(:any)/(:any)'] = 'categories/update_popular_status/$1/enable/$2/$3';
$route[ADMIN.'/category_popular/disable/(:any)/(:any)/(:any)'] = 'categories/update_popular_status/$1/disable/$2/$3';

$route[ADMIN.'/categories/add'] = 'categories/add';
$route[ADMIN.'/categories/edit/(:any)'] = 'categories/edit/$1';
$route[ADMIN.'/categories/(:any)'] = 'categories/index/$1';
$route[ADMIN.'/categories/(:any)/(:any)'] = 'categories/index/$1/$2';
$route[ADMIN.'/categories/(:any)/(:any)/(:any)'] = 'categories/index/$1/$2/$3';
$route[ADMIN.'/categories/(:any)/(:any)/(:any)/(:any)'] = 'categories/index/$1/$2/$3/$4';



#Main Categories
$route[ADMIN.'/main_category'] = 'main_categories/index';
$route[ADMIN.'/main_category/getReports'] = 'main_categories/getReports';
$route[ADMIN.'/main_category/delete/(:any)'] = 'main_categories/delete/$1';//1 deleted id
$route[ADMIN.'/main_category/bulkautions/(:any)/(:any)'] = 'main_categories/bulkautions/$1/$2';
$route[ADMIN.'/main_category_view/view/(:any)'] = 'main_categories/view/$1';
$route[ADMIN.'/main_category_delete/delete/(:any)'] = 'main_categories/delete/$1';
$route[ADMIN.'/main_category_enable/enable/(:any)/(:any)/(:any)'] = 'main_categories/update_status/$1/enable/$2/$3';
$route[ADMIN.'/main_category_enable/disable/(:any)/(:any)/(:any)'] = 'main_categories/update_status/$1/disable/$2/$3';
$route[ADMIN.'/main_category/add'] = 'main_categories/add';
$route[ADMIN.'/main_category/edit/(:any)'] = 'main_categories/edit/$1';
$route[ADMIN.'/main_category/(:any)'] = 'main_categories/index/$1';
$route[ADMIN.'/main_category/(:any)/(:any)'] = 'main_categories/index/$1/$2/$3';
$route[ADMIN.'/main_category/(:any)/(:any)/(:any)'] = 'main_categories/index/$1/$2/$3';
$route[ADMIN.'/main_category/(:any)/(:any)/(:any)/(:any)'] = 'main_categories/index/$1/$2/$3/$4';



#Blog Categories
$route[ADMIN.'/blog_category'] = 'blog_categories/index';
$route[ADMIN.'/blog_category/getReports'] = 'blog_categories/getReports';
$route[ADMIN.'/blog_category/delete/(:any)'] = 'blog_categories/delete/$1';//1 deleted id
$route[ADMIN.'/blog_category/bulkautions/(:any)/(:any)'] = 'blog_categories/bulkautions/$1/$2';
$route[ADMIN.'/blog_category_view/view/(:any)'] = 'blog_categories/view/$1';
$route[ADMIN.'/blog_category_delete/delete/(:any)'] = 'blog_categories/delete/$1';
$route[ADMIN.'/blog_category_enable/enable/(:any)/(:any)/(:any)'] = 'blog_categories/update_status/$1/enable/$2/$3';
$route[ADMIN.'/blog_category_enable/disable/(:any)/(:any)/(:any)'] = 'blog_categories/update_status/$1/disable/$2/$3';
$route[ADMIN.'/blog_category/add'] = 'blog_categories/add';
$route[ADMIN.'/blog_category/edit/(:any)'] = 'blog_categories/edit/$1';
$route[ADMIN.'/blog_category/(:any)'] = 'blog_categories/index/$1';
$route[ADMIN.'/blog_category/(:any)/(:any)'] = 'blog_categories/index/$1/$2';
$route[ADMIN.'/blog_category/(:any)/(:any)/(:any)'] = 'blog_categories/index/$1/$2/$3';
$route[ADMIN.'/blog_category/(:any)/(:any)/(:any)/(:any)'] = 'blog_categories/index/$1/$2/$3/$4';

#Blogs
$route[ADMIN.'/blogs'] = 'blogs/admin_index';
$route[ADMIN.'/blogs/getReports'] = 'blogs/getReports';
$route[ADMIN.'/blogs/delete/(:any)'] = 'blogs/delete/$1';//1 deleted id
$route[ADMIN.'/blogs/bulkautions/(:any)/(:any)'] = 'blogs/bulkautions/$1/$2';
$route[ADMIN.'/blogs_view/view/(:any)'] = 'blogs/admin_view/$1';
$route[ADMIN.'/blogs_delete/delete/(:any)'] = 'blogs/delete/$1';
$route[ADMIN.'/blogs_enable/enable/(:any)/(:any)/(:any)'] = 'blogs/update_status/$1/enable/$2/$3';
$route[ADMIN.'/blogs_enable/disable/(:any)/(:any)/(:any)'] = 'blogs/update_status/$1/disable/$2/$3';
$route[ADMIN.'/blogs/add'] = 'blogs/add';
$route[ADMIN.'/blogs/edit/(:any)'] = 'blogs/edit/$1';
$route[ADMIN.'/blogs/(:any)'] = 'blogs/admin_index/$1';
$route[ADMIN.'/blogs/(:any)/(:any)/(:any)'] = 'blogs/admin_index/$1/$2/$3';


#Contact Us
$route[ADMIN.'/contact_us'] = 'contactus/index';
$route[ADMIN.'/contact_us/delete/(:any)'] = 'contactus/delete/$1';//1 deleted id
$route[ADMIN.'/contact_us/bulkautions/(:any)/(:any)'] = 'contactus/bulkautions/$1/$2';
$route[ADMIN.'/contact_us/view/(:any)'] = 'contactus/view/$1';
$route[ADMIN.'/contact_us/delete/(:any)'] = 'contactus/delete/$1';
$route[ADMIN.'/contact_us/(:any)'] = 'contactus/index/$1';
$route[ADMIN.'/contact_us/(:any)/(:any)'] = 'contactus/index/$1/$2';
$route[ADMIN.'/contact_us/(:any)/(:any)/(:any)'] = 'contactus/index/$1/$2/$3';
$route[ADMIN.'/contact_us/(:any)/(:any)/(:any)/(:any)'] = 'contactus/index/$1/$2/$3/$4';
$route[ADMIN.'/contact_us/send_message'] = 'contactus/send_message';


#Enquiry
$route[ADMIN.'/customer_enquiry'] = 'advertisment_enquiry/index';
$route[ADMIN.'/customer_enquiry/delete/(:any)'] = 'advertisment_enquiry/delete/$1';//1 deleted id
$route[ADMIN.'/customer_enquiry/bulkautions/(:any)/(:any)'] = 'advertisment_enquiry/bulkautions/$1/$2';
$route[ADMIN.'/customer_enquiry/view/(:any)'] = 'advertisment_enquiry/view/$1';
$route[ADMIN.'/customer_enquiry/delete/(:any)'] = 'advertisment_enquiry/delete/$1';
$route[ADMIN.'/customer_enquiry/(:any)'] = 'advertisment_enquiry/index/$1';
$route[ADMIN.'/customer_enquiry/(:any)/(:any)/(:any)'] = 'advertisment_enquiry/index/$1/$2/$3';
$route[ADMIN.'/customer_enquiry/send_message'] = 'advertisment_enquiry/send_message';

#Feedbacks
$route[ADMIN.'/feed_backs'] = 'feedbacks/index';
$route[ADMIN.'/feed_backs/delete/(:any)'] = 'feedbacks/delete/$1';//1 deleted id
$route[ADMIN.'/feed_backs/bulkautions/(:any)/(:any)'] = 'feedbacks/bulkautions/$1/$2';
$route[ADMIN.'/feed_backs/view/(:any)'] = 'feedbacks/view/$1';
$route[ADMIN.'/feed_backs/delete/(:any)'] = 'feedbacks/delete/$1';
$route[ADMIN.'/feed_backs/(:any)'] = 'feedbacks/index/$1';
$route[ADMIN.'/feed_backs/(:any)/(:any)'] = 'feedbacks/index/$1/$2';
$route[ADMIN.'/feed_backs/(:any)/(:any)/(:any)'] = 'feedbacks/index/$1/$2/$3';
$route[ADMIN.'/feed_backs/(:any)/(:any)/(:any)/(:any)'] = 'feedbacks/index/$1/$2/$3/$4';
$route[ADMIN.'/feed_backs/send_message'] = 'feedbacks/send_message';


#Claim Your Bussiness
$route[ADMIN.'/claim_my_bussiness'] = 'claim_mybussiness/index';
$route[ADMIN.'/claim_my_bussiness/delete/(:any)'] = 'claim_mybussiness/delete/$1';//1 deleted id
$route[ADMIN.'/claim_my_bussiness/bulkautions/(:any)/(:any)'] = 'claim_mybussiness/bulkautions/$1/$2';
$route[ADMIN.'/claim_my_bussiness/view/(:any)'] = 'claim_mybussiness/view/$1';
$route[ADMIN.'/claim_my_bussiness/delete/(:any)'] = 'claim_mybussiness/delete/$1';
$route[ADMIN.'/claim_my_bussiness/create_account'] = 'claim_mybussiness/create_account';
$route[ADMIN.'/claim_my_bussiness/(:any)'] = 'claim_mybussiness/index/$1';
$route[ADMIN.'/claim_my_bussiness/(:any)/(:any)'] = 'claim_mybussiness/index/$1/$2';
$route[ADMIN.'/claim_my_bussiness/(:any)/(:any)/(:any)'] = 'claim_mybussiness/index/$1/$2/$3';
$route[ADMIN.'/claim_my_bussiness/(:any)/(:any)/(:any)/(:any)'] = 'claim_mybussiness/index/$1/$2/$3/$4';



######### Plan Clicks ###############
$route[ADMIN.'/plan_clicks'] = 'plan_clicks/index';
$route[ADMIN.'/plan_clicks/delete/(:any)'] = 'plan_clicks/delete/$1';//1 deleted id
$route[ADMIN.'/plan_clicks/bulkautions/(:any)/(:any)'] = 'plan_clicks/bulkautions/$1/$2';
$route[ADMIN.'/plan_clicks/view/(:any)'] = 'plan_clicks/view/$1';
$route[ADMIN.'/plan_clicks/delete/(:any)'] = 'plan_clicks/delete/$1';
$route[ADMIN.'/plan_clicks/(:any)'] = 'plan_clicks/index/$1';
$route[ADMIN.'/plan_clicks/(:any)/(:any)'] = 'plan_clicks/index/$1/$2';
$route[ADMIN.'/plan_clicks/(:any)/(:any)/(:any)'] = 'plan_clicks/index/$1/$2/$3';
$route[ADMIN.'/plan_clicks/(:any)/(:any)/(:any)/(:any)'] = 'plan_clicks/index/$1/$2/$3/$4';
######### Plan Orders ###############
$route[ADMIN.'/plan_orders'] = 'plan_orders/index';
$route[ADMIN.'/plan_orders/delete/(:any)'] = 'plan_orders/delete/$1';//1 deleted id
$route[ADMIN.'/plan_orders/bulkautions/(:any)/(:any)'] = 'plan_orders/bulkautions/$1/$2';
$route[ADMIN.'/plan_orders/view/(:any)'] = 'plan_orders/view/$1';
$route[ADMIN.'/plan_orders/delete/(:any)'] = 'plan_orders/delete/$1';
$route[ADMIN.'/plan_orders/(:any)'] = 'plan_orders/index/$1';
$route[ADMIN.'/plan_orders/(:any)/(:any)'] = 'plan_orders/index/$1/$2';
$route[ADMIN.'/plan_orders/(:any)/(:any)/(:any)'] = 'plan_orders/index/$1/$2/$3';
$route[ADMIN.'/plan_orders/(:any)/(:any)/(:any)/(:any)'] = 'plan_orders/index/$1/$2/$3/$4';


#Import Datas
$route[ADMIN.'/import_datas'] = 'import_datas/index';
$route[ADMIN.'/export_datas'] = 'export_datas/index';


######### Campaigns  ###############
$route[ADMIN.'/campaigns'] = 'campaign/index';
$route[ADMIN.'/campaigns/delete/(:any)'] = 'campaign/delete/$1';//1 deleted id
$route[ADMIN.'/campaigns/bulkautions/(:any)/(:any)'] = 'campaign/bulkautions/$1/$2';
$route[ADMIN.'/campaigns/view/(:any)'] = 'campaign/view/$1';
$route[ADMIN.'/campaigns/delete/(:any)'] = 'campaign/delete/$1';
$route[ADMIN.'/campaigns/(:any)'] = 'campaign/index/$1';
$route[ADMIN.'/campaigns/(:any)/(:any)'] = 'campaign/index/$1/$2';
$route[ADMIN.'/campaigns/(:any)/(:any)/(:any)'] = 'campaign/index/$1/$2/$3';
$route[ADMIN.'/campaigns/(:any)/(:any)/(:any)/(:any)'] = 'campaign/index/$1/$2/$3/$4';


$route[ADMIN.'/customer_campaigns'] = 'customer_campaigns/index';
$route[ADMIN.'/customer_campaigns/delete/(:any)'] = 'customer_campaigns/delete/$1';//1 deleted id
$route[ADMIN.'/customer_campaigns/bulkautions/(:any)/(:any)'] = 'customer_campaigns/bulkautions/$1/$2';
$route[ADMIN.'/customer_campaigns/view/(:any)'] = 'customer_campaigns/view/$1';
$route[ADMIN.'/customer_campaigns/delete/(:any)'] = 'customer_campaigns/delete/$1';
$route[ADMIN.'/customer_campaigns/(:any)'] = 'customer_campaigns/index/$1';
$route[ADMIN.'/customer_campaigns/(:any)/(:any)'] = 'customer_campaigns/index/$1/$2';
$route[ADMIN.'/customer_campaigns/(:any)/(:any)/(:any)'] = 'customer_campaigns/index/$1/$2/$3';
$route[ADMIN.'/customer_campaigns/(:any)/(:any)/(:any)/(:any)'] = 'customer_campaigns/index/$1/$2/$3/$4';

$route[ADMIN.'/customer_remainders/(:any)'] = 'customer_remainders/index/$1';
$route[ADMIN.'/customer_remainders/delete/(:any)'] = 'customer_remainders/delete/$1';//1 deleted id
$route[ADMIN.'/customer_remainders/bulkautions/(:any)/(:any)'] = 'customer_remainders/bulkautions/$1/$2';
$route[ADMIN.'/customer_remainder/view/(:any)'] = 'customer_remainders/view/$1';
$route[ADMIN.'/customer_remainders/delete/(:any)'] = 'customer_remainders/delete/$1';
$route[ADMIN.'/customer_remainders/(:any)'] = 'customer_remainders/index/$1';
$route[ADMIN.'/customer_remainders/(:any)/(:any)'] = 'customer_remainders/index/$1/$2';
$route[ADMIN.'/customer_remainders/(:any)/(:any)/(:any)'] = 'customer_remainders/index/$1/$2/$3';
$route[ADMIN.'/customer_remainders/(:any)/(:any)/(:any)/(:any)'] = 'customer_remainders/index/$1/$2/$3/$4';
$route[ADMIN.'/customer_remainders_enable/enable/(:any)/(:any)/(:any)'] = 'customer_remainders/update_status/$1/enable/$2/$3';//$2-status,$3-page no
$route[ADMIN.'/customer_remainders_enable/disable/(:any)/(:any)/(:any)'] = 'customer_remainders/update_status/$1/disable/$2/$3';//$2-status,$3-page no

$route[ADMIN.'/customer_remainder_histroy'] = 'customer_remainder_histroy/index';
$route[ADMIN.'/customer_remainder_histroy/(:any)'] = 'customer_remainder_histroy/index/$1';
$route[ADMIN.'/customer_remainder_histroy/delete/(:any)'] = 'customer_remainder_histroy/delete/$1';//1 deleted id
$route[ADMIN.'/customer_remainder_histroy/bulkautions/(:any)/(:any)'] = 'customer_remainder_histroy/bulkautions/$1/$2';
$route[ADMIN.'/customer_remainder_histroy/view/(:any)'] = 'customer_remainder_histroy/view/$1';
$route[ADMIN.'/customer_remainder_histroy/delete/(:any)'] = 'customer_remainder_histroy/delete/$1';
$route[ADMIN.'/customer_remainder_histroy'] = 'customer_remainder_histroy/index';
$route[ADMIN.'/customer_remainder_histroy/(:any)/(:any)/(:any)'] = 'customer_remainder_histroy/index/$1/$2/$3';
$route[ADMIN.'/reaminder_analysis'] = 'customer_remainder_histroy/reaminder_analysis';

#Notification Type
$route[ADMIN.'/notificationtype'] = 'notification_type/index';
$route[ADMIN.'/notificationtype/delete/(:any)'] = 'notification_type/delete/$1';//1 deleted id
$route[ADMIN.'/notificationtype/bulkautions/(:any)/(:any)'] = 'notification_type/bulkautions/$1/$2';
$route[ADMIN.'/notificationtype/view/(:any)'] = 'notification_type/view/$1';
$route[ADMIN.'/notificationtype/delete/(:any)'] = 'notification_type/delete/$1';
$route[ADMIN.'/notificationtype/(:any)'] = 'notification_type/index/$1';
$route[ADMIN.'/notificationtype/(:any)/(:any)/(:any)'] = 'notification_type/index/$1/$2/$3';
$route[ADMIN.'/notificationtype/add'] = 'notification_type/add';
$route[ADMIN.'/notification_type/edit/(:any)'] = 'notification_type/edit/$1';

################# End Admin Paths #########################

############Site Paths ###################
$route['forgot_password'] = 'home/forgot_password';
$route['reset_password/(:any)'] = 'home/reset_password';
$route['login'] = 'home/register/$1';
$route['user_login'] = 'home/login/$1';
$route['register'] = 'home/register/$1';
$route['users/verify/(:any)'] = 'home/verify/$1';
$route['google_login'] = 'site_webusers/google_login';
$route['logout'] = 'home/logout';
$route['signup'] = 'home/register';
$route['facebook'] = 'home/facebook';
$route['twitter'] = 'home/twitter';
$route['googleplus'] = 'home/googleplus';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms-and-conditions'] = 'home/get_pages';
$route['about-us'] = 'home/about_us';
$route['contact-us'] = 'home/contact_us';
$route['my_profile'] = 'home/my_profile';
$route['claim-my-bussiness'] = 'home/claim_my_bussiness';
$route['how-it-works'] = 'home/how_it_works';

#Listings
$route['business/(:any)/(:any)'] = 'listings/view/$1/$2';
$route['business/(:any)/(:any)/(:any)'] = 'listings/view/$1/$2/$3';
$route['business/(:any)/(:any)/(:any)'] = 'listings/view/$1/$2/$3';
$route['search/(:any)/(:any)'] = 'listings/index/$1/$2';
$route['search/(:any)'] = 'listings/index/$1';
$route['category-search/(:any)/(:any)/(:any)'] = 'listings/index/$1/$2/$3';
$route['category-search/(:any)/(:any)'] = 'listings/index/$1/$2';
$route['category-search/(:any)'] = 'listings/index/$1';
$route['service-search/(:any)/(:any)/(:any)'] = 'listings/index/$1/$2/$3';
$route['service-search/(:any)/(:any)'] = 'listings/index/$1/$2';
$route['service-search/(:any)'] = 'listings/index/$1';
$route['default_controller'] = "home";
$route['404_override'] = '';
$route['register-your-business']='listings/add';
$route['home-search/(:any)'] = 'listings/index/$1';

#Blogs
$route['blogs/(:any)/(:any)'] = 'blogs/view/$1/$2';
$route['blog/(:any)'] = 'blogs/index/$1';
$route['blog/(:any)/(:any)'] = 'blogs/index/$1/$2';
$route['blog/(:any)/(:any)/(:any)'] = 'blogs/index/$1/$2/$3';
$route['blog-category-search/(:any)/(:any)'] = 'blogs/index/$1/$2';
$route['blog-category-search/(:any)'] = 'blogs/index/$1';


#Blogs
$route['jobs/(:any)/(:any)'] = 'jobs/view/$1/$2';
$route['jobs/(:any)/(:any)/(:any)'] = 'jobs/view/$1/$2/$3';
$route['job'] = 'jobs/index/';
$route['job/(:any)'] = 'jobs/index/$1';
$route['job/(:any)/(:any)'] = 'jobs/index/$1/$2';
$route['job/(:any)/(:any)/(:any)'] = 'jobs/index/$1/$2/$3';
$route['job-category-search/(:any)/(:any)'] = 'jobs/index/$1/$2';
$route['job-category-search/(:any)'] = 'jobs/index/$1';

#Blogs
$route['news-view/(:any)/(:any)'] = 'news/view/$1/$2';
$route['news/(:any)'] = 'news/index/$1';
$route['news/(:any)/(:any)'] = 'news/index/$1/$2';
$route['news/(:any)/(:any)/(:any)'] = 'news/index/$1/$2/$3';
$route['news-category-search/(:any)/(:any)'] = 'news/index/$1/$2';
$route['news-category-search/(:any)'] = 'news/index/$1';

#Coupons
$route['coupons/downloaded_coupon_list/(:any)'] = 'coupons/downloaded_coupon_list/$1';
$route['coupons/(:any)/(:any)'] = 'coupons/view/$1/$2';
$route['coupon/(:any)'] = 'coupons/index/$1';
$route['coupon/(:any)/(:any)'] = 'coupons/index/$1/$2';
$route['coupon/(:any)/(:any)/(:any)'] = 'coupons/index/$1/$2/$3';
$route['coupon-category-search/(:any)/(:any)'] = 'coupons/index/$1/$2';
$route['coupon-category-search/(:any)/(:any)/(:any)'] = 'coupons/index/$1/$2/$3';
$route['coupon-category-search/(:any)'] = 'coupons/index/$1';

#Offers
$route['offers/(:any)/(:any)'] = 'offers/view/$1/$2';
$route['offer/(:any)'] = 'offers/index/$1';
$route['offer/(:any)/(:any)'] = 'offers/index/$1/$2';
$route['offer/(:any)/(:any)/(:any)'] = 'offers/index/$1/$2/$3';
$route['offers-category-search/(:any)/(:any)'] = 'offers/index/$1/$2';
$route['offers-category-search/(:any)'] = 'offers/index/$1';

######################Customers##########################
$route['my-orders']='customers/my_orders';

$route['buyer'] = 'customers/set_role';
$route['merchant'] = 'customers/set_role';
$route['dashboard'] = 'customers/dashboard';
$route['dashboard'] = 'customers/dashboard';
$route['business-profile'] = 'customers/business_profile';
$route['my-profile'] = 'customers/my_profile';
$route['customer-list'] = 'customers/customer_list';
$route['customer-add'] = 'customers/customer_add';
$route['invite-customer'] = 'customers/customer_list';
$route['send-sms'] = 'customers/send_sms';
$route['send-email'] = 'customers/send_email';
$route['blog-list'] = 'customers/blog_list';
$route['blog-add'] = 'customers/blog_add';
$route['share-profile']='customers/share_profile';


$route['my-coupons']='coupons/my_coupons';
$route['my-coupons/(:any)']='coupons/my_coupons/$1';
$route['profile-stastics']='reports/my_stastics';
$route['campaign-stastics']='reports/campaign_stastics';
$route['remainder-stastics']='reports/remainder_stastics';
$route['campaign-tracklist']='reports/campaign_tracklist';

$route['sms_package_list']='customers/sms_package_list';
$route['my-plans']='customers/plan_packages_list';
$route['coupons-list'] = 'coupons/coupons_list';
$route['coupons-add'] = 'coupons/coupons_add';
$route['import-customer'] = 'customers/import_customers';
$route['gallery'] = 'customers/my_gallery';
$route['downloaded-coupons-list'] = 'coupons/downloaded_coupon_list';
$route['business-enquires'] = 'customers/enquiry_list';

$route['my-groups'] = 'groups/group_list';
$route['group-add'] = 'groups/add_group';
$route['edit-groups/(:any)'] = 'groups/edit_group/$1';
$route['downloaded-enquiry-list'] = 'customers/download_enquiry_list';
$route['my-feedback'] = 'customers/send_feedback';
$route['remainders-settings'] = 'customers/remainders_settings';
$route['customer-remainders'] = 'customers/products_list';


$route['business-reviews'] = 'comments/review_list';
$route['my-reviews'] = 'comments/my_reviews';
$route['review-add'] = 'comments/add_review';
$route['edit-review/(:any)'] = 'comments/edit_review/$1';
$route['customer-remainder'] = 'customers/customers_remainders/$1';


$route['my-products'] = 'products/products_list';
$route['add-products'] = 'products/add_products';
$route['edit-products/(:any)'] = 'products/edit_products/$1';

$route['general-campaign'] = 'campaigns/general_campaigns';
$route['offer-campaign'] = 'campaigns/offer_campaigns';
$route['remainder-campaign'] = 'campaigns/remainder_campaigns';
$route['campaign-histroy'] = 'campaigns/campaign_histroy';
$route['sms-order-histroy'] = 'campaigns/sms_order_histroy';
$route['campaign-interset'] = 'campaigns/campaign_interset';

$route['remainders-histroy'] = 'remainders/histroy';
$route['remainders-list'] = 'remainders/index';
$route['remainder/(:any)'] = 'remainders/remainder_list';
$route['remainder_add/(:any)'] = 'remainders/add';
$route['remainder_edit/(:any)/(:any)'] = 'remainders/edit/$1';
$route['my-offers'] = 'customers/my_offers/$1';
$route['my-notifications'] = 'customers/my_notification';
$route['my-senderID'] = 'customers/my_senderid';
$route['my-notifications'] = 'notifications/my_notifications';
$route['coupons_edit/(:any)'] = 'coupons/coupons_edit/$1';
$route['mycoupons/coupon-list/(:any)'] = 'coupons/coupons_list/$1';
$route['mycoupons/coupon-list'] = 'coupons/coupons_list/1';
$route['sms-credit'] = 'customers/sms_credit';
$route['my-campaign-offers'] = 'campaigns/my_campaign_offers';
$route['my-notifications-settings'] = 'settings/notification_settings';
$route['my-campaign-offers'] = 'campaigns/my_campaign_offers';
$route['upgrade-plan'] = 'customers/upgrade_plan_packages_list';
$route['bussiness-claims'] = 'customers/claim_bussiness';
?>