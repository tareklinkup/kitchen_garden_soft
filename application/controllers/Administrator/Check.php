<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/10/2018
 * Time: 12:37 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check extends CI_Controller
{
	public $brunch_id;
	/*==========Admin Login Check=============*/
	public function __construct()
	{
		parent::__construct();
		$this->brunch_id = $this->session->userdata('BRANCHid');
		$access = $this->session->userdata('userId');
		if($access == '' ){
			redirect("Login");
		}
		$this->load->model("Model_myclass", "mmc", TRUE);
		$this->load->model('Model_table', "mt", TRUE);
		$this->load->model('Billing_model');
	}

	/*==========Admin Login Check==========*/
	public function index()
	{
		$access = $this->session->userdata('userId');
		if($access == '' ){
			redirect("Login");
		}	
	}

	/*========== Check Entry page ===========*/
	public function check_entry_page()
	{
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
		$data['title'] = 'Cheque Information';
		$data['checks'] = $this->Check_model->get_all_check_info();
		$data['customers'] = $this->db->select('Customer_SlNo,Customer_Code,Customer_Name')->where('Customer_brunchid',$this->brunch_id)->where('status', 'a')->get('tbl_customer')->result();
		$data['content'] = $this->load->view('Administrator/check/check_entry', $data, TRUE);
		$this->load->view('Administrator/index', $data);

	}

	public function check_pendaing_date_list()
	{
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
		$data['title'] = 'Pending Cheque Information';
		$data['checks'] = $this->Check_model->get_all_pending_check_info();
		$data['content'] = $this->load->view('Administrator/check/pending_check_list', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}

	public function check_reminder_date_list()
	{	 
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
		$data['title'] = 'Reminder Cheque Information';
		$data['checks'] = $this->Check_model->get_all_remaind_check_info();
		$data['content'] = $this->load->view('Administrator/check/check_reminder_list', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}

	public function check_dishonor_date_list()
	{	
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
		$data['title'] = 'Dishonoured Cheque Information';
		$data['checks'] = $this->Check_model->get_all_dis_check_info();
		$data['content'] = $this->load->view('Administrator/check/dishonor_list', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}

	public function check_paid_date_list()
	{	
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
		$data['title'] = 'Paid Cheque Information';
		$data['checks'] = $this->Check_model->get_all_paid_check_info();
		$data['content'] = $this->load->view('Administrator/check/paid_check_list', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}

	public function check_list()
	{
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
		$data['title'] = 'Paid Cheque Information';
		$data['checks'] = $this->Check_model->get_all_check_info();
		$data['content'] = $this->load->view('Administrator/check/check_list', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}

	public function view_check_entry_from(){
		$this->load->view('Administrator/check/cheque_entry_form');
	}

	public  function sale_cheque_store(){
		$this->session->set_userdata('cheque', $this->input->post());

		if($this->session->userdata('cheque')){
//			print_r($this->session->userdata("cheque"));
			echo 1;
		}else{
			echo 0;
		}
	}

	/*====== Check Information Store ==========*/
	public function check_date_store()
	{	

		$this->form_validation->set_rules('cus_id', 'Customer', 'required|trim');
		$this->form_validation->set_rules('check_amount', 'Check Amount', 'required|trim');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
		$this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');
		$this->form_validation->set_rules('check_no', 'Check No', 'required|trim');
		$this->form_validation->set_rules('date', 'Date', 'required|trim');
		$this->form_validation->set_rules('check_date', 'Check Date', 'required|trim');
		$this->form_validation->set_rules('remid_date', 'Reminder Date', 'required|trim');
		$this->form_validation->set_rules('sub_date', 'Submit Date', 'required|trim');

		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Check Information';
			$data['checks'] = $this->Check_model->get_all_check_info();
			$data['customers'] = $this->db->select('Customer_SlNo,Customer_Code,Customer_Name')->where('Customer_brunchid',$this->brunch_id)->where('status', 'a')->get('tbl_customer')->result();
			$data['content'] = $this->load->view('Administrator/check/check_entry', $data, TRUE);
			$this->load->view('Administrator/index', $data);
		}else{
			if($this->Check_model->store_check_info()){
				$data['success']="Store Successfully";
				$this->session->set_flashdata($data);
				redirect('check/entry');
			}else{
				$data['error']="Store UnSuccessful";
				$this->session->set_flashdata($data);
				redirect('check/entry');
			}
		}
	}

	/*======== Submit the check in bank =========*/
	public function check_paid_submission($cheque_id = Null){

		$this->Check_model->cheque_status_change($cheque_id);

		echo 1;
	}

	public function check_dishonor_submission($id = Null){
		if($this->Check_model->cheque_make_dishonor($id)){
			$data['error']="Cheque Make Dishonor";
			$this->session->set_flashdata($data);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data['error']="Cheque Dishonor not Done";
			$this->session->set_flashdata($data);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	/*======== Check View Page =========*/
	public function check_view_page($id=Null)
	{
		if($result = $this->Check_model->check_data_by_id($id)){ 
			$data['check'] = $result;
			$this->load->view('Administrator/check/check_view_page', $data);
		}else{
			$data['error']="No Data Found";
			$this->session->set_flashdata($data);
			redirect('check/entry');
		}
	}

	/*====== check edit page view======*/
	public function check_edit_page($id=Null)
	{
		if($result = $this->Check_model->check_data_by_id($id)){
			$data['title'] = 'Check Edit Information';
			$data['check'] = $result;
			$data['customers'] = $this->db->select('Customer_SlNo,Customer_Code,Customer_Name')->where('Customer_brunchid',$this->brunch_id)->where('status', 'a')->get('tbl_customer')->result();
			$data['content'] = $this->load->view('Administrator/check/edit_check', $data, TRUE);
			$this->load->view('Administrator/index', $data);
		}else{
			$data['error']="No Data Found";
			$this->session->set_flashdata($data);
			redirect('check/entry');
		}
	}

	/*======== update check information ========*/
	public function check_update_info($id=Null)
	{
		$this->form_validation->set_rules('cus_id', 'Customer', 'required|trim');
		$this->form_validation->set_rules('check_amount', 'Check Amount', 'required|trim');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
		$this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');
		$this->form_validation->set_rules('check_no', 'Check No', 'required|trim');
		$this->form_validation->set_rules('date', 'Date', 'required|trim');
		$this->form_validation->set_rules('check_date', 'Check Date', 'required|trim');
		$this->form_validation->set_rules('remid_date', 'Reminder Date', 'required|trim');
		$this->form_validation->set_rules('sub_date', 'Submit Date', 'required|trim');

		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Check Information';
			$data['checks'] = $this->Check_model->get_all_check_info();
			$data['customers'] = $this->db->select('Customer_SlNo,Customer_Code,Customer_Name')->where('Customer_brunchid',$this->brunch_id)->where('status', 'a')->get('tbl_customer')->result();
			$data['content'] = $this->load->view('Administrator/check/check_entry', $data, TRUE);
			$this->load->view('Administrator/index', $data);
		}else{
			if($this->Check_model->update_check_data($id)){
				$data['success']="Update Successfully";
				$this->session->set_flashdata($data);
				redirect('check/entry');
			}else{
				$data['error']="Update UnSuccessful";
				$this->session->set_flashdata($data);
				redirect('check/entry');
			}
		}
	}

	/*========== Delete Lc Number info =======*/
	public function check_delete_info($id=Null)
	{	

		if($this->Check_model->delete_check_data($id)){
			$data['success']=" Delete Successfully";
			$this->session->set_flashdata($data);
			redirect('check/entry');
		}else{
			$data['error']="Delete UnSuccessful";
			$this->session->set_flashdata($data);
			redirect('check/entry');
		}
	}
}
