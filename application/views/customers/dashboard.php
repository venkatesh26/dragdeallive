<?php
   $addId=get_my_addId($this->session->userdata('user_id'));
   $dashboardData=get_customer_dashboard_data($addId);
   $businnesInformation=getBusinessInforamtion($addId,$this->session->userdata('user_id'));
   $sms_info=getSmsInforamtion($this->session->userdata('user_id'));
   $customers_info=getCustomersInforamtion($this->session->userdata('user_id'));
   $latest_camp_list=getCampaignTrackList($this->session->userdata('user_id'));
   $latest_camp_lead_list = getCampaignLeadList($this->session->userdata('user_id'));
?>

<article class="content dashboard-page white-bg-art">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <section class="section dashboard-page-card-block">
   
      <div class="row">
          <img src="<?php echo base_url().'assets/img/under_construction.png'?>">
      </div>
      <!-- /.row -->
   </section>