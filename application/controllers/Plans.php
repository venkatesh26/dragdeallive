<?php
class Plans extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('plans_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
    }

    public function index() {
		$data['plans'] = $this->plans_model->get_plans(1);
		$data['main_content'] = 'admin/plans/index';
		$data['title']="Plan Types";
		$this->load->view('includes/template', $data);
    }
	
    public function edit($id) {
		$getValues = $this->plans_model->get_values($id);
		if(count($getValues)) {
			// add breadcrumbs
			$this->breadcrumbs->push('Plans', base_url().ADMIN.'/plans');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/plans/edit');
			$this->form_validation->set_rules('name', 'Name','trim|required');
			$this->form_validation->set_rules('price', 'Price','trim|required|numeric');
			$this->form_validation->set_rules('plan_valid_days', 'Validity','trim|required|numeric|greater_than[0]');
			$this->form_validation->set_rules('auction_limit', 'Auction Limit','trim|required|numeric|greater_than[0]');
			$this->form_validation->set_rules('commision', 'Commision','trim|required|numeric|greater_than[0]|max_length[2]');
			if (isset($_POST) && !empty($_POST))
			{		
				if ($this->form_validation->run() === true)
				{
					$this->plans_model->edit($id);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/plans');
				}			
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['plans'] = $getValues;
			$this->data['is_active']=$getValues['is_active'] ? 1 : 0 ; 
			//echo $this->data['is_active'];die;
			$this->data['main_content'] = 'admin/plans/edit';
			$this->data['title']="Edit Plans";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/plans');
		}

    }
}
?>