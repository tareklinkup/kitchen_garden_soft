<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Check_model extends CI_Model
{
	/*======== get all data info =========*/
	public function get_all_check_info()
	{	
		$this->db->select('tbl_checks.*, tbl_customer.Customer_Name,tbl_customer.Customer_Code ');
		$this->db->from('tbl_checks');
		$this->db->join('tbl_customer', 'tbl_checks.cus_id = tbl_customer.Customer_SlNo' );
		$this->db->where('tbl_checks.status', 'a')->where('tbl_checks.branch_id', $this->session->userdata('BRANCHid') )->order_by('tbl_checks.id', 'desc');
		$result = $this->db->get()->result();

		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}

	/*======== get all pending data info =========*/
	public function get_all_pending_check_info()
	{	
		$this->db->select('tbl_checks.*, tbl_customer.Customer_Name ,tbl_customer.Customer_Code');
		$this->db->from('tbl_checks');
		$this->db->join('tbl_customer', 'tbl_checks.cus_id = tbl_customer.Customer_SlNo' );
		$this->db->where('tbl_checks.check_status', 'Pe')->where('tbl_checks.branch_id', $this->session->userdata('BRANCHid') )->where('tbl_checks.status', 'a')->order_by('id', 'desc');
		$result = $this->db->get()->result();

		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}

	public function get_all_dis_check_info()
	{	
		$this->db->select('tbl_checks.*, tbl_customer.Customer_Name ,tbl_customer.Customer_Code');
		$this->db->from('tbl_checks');
		$this->db->join('tbl_customer', 'tbl_checks.cus_id = tbl_customer.Customer_SlNo' );
		$this->db->where('tbl_checks.check_status', 'Di')->where('tbl_checks.branch_id', $this->session->userdata('BRANCHid') )->where('tbl_checks.status', 'a')->order_by('id', 'desc');
		$result = $this->db->get()->result();

		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}

	/*======== get all data info =========*/
	public function get_all_paid_check_info()
	{	
		$this->db->select('tbl_checks.*, tbl_customer.Customer_Name,tbl_customer.Customer_Code ');
		$this->db->from('tbl_checks');
		$this->db->join('tbl_customer', 'tbl_checks.cus_id = tbl_customer.Customer_SlNo' );
		$this->db->where('tbl_checks.check_status', 'Pa')->where('tbl_checks.branch_id', $this->session->userdata('BRANCHid') )->where('tbl_checks.status', 'a')->order_by('id', 'desc');
		$result = $this->db->get()->result();

		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}

	/*======== get all data info =========*/
	public function get_all_remaind_check_info()
	{	
		$this->db->select('tbl_checks.*, tbl_customer.Customer_Name,tbl_customer.Customer_Code ');
		$this->db->from('tbl_checks');
		$this->db->join('tbl_customer', 'tbl_checks.cus_id = tbl_customer.Customer_SlNo' );
		$this->db->where('tbl_checks.remid_date >=', date('Y-m-d'))->where('tbl_checks.branch_id', $this->session->userdata('BRANCHid') )->where('tbl_checks.check_status', 'Pe')->where('tbl_checks.status', 'a')->order_by('id', 'desc');
		$result = $this->db->get()->result();

		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}


	/*========= Store Function ==========*/
	public function store_check_info()
	{
		$attr = array(
			'cus_id' =>$this->input->post('cus_id'),
			'branch_id'=>$this->session->userdata('BRANCHid'),
			'bank_name' =>$this->input->post('bank_name'),
			'branch_name' =>$this->input->post('branch_name'),
			'check_no' =>$this->input->post('check_no'),
			'check_amount' =>$this->input->post('check_amount'),
			'date' =>$this->input->post('date'),
			'check_date' =>$this->input->post('check_date'),
			'remid_date' =>$this->input->post('remid_date'),
			'sub_date' =>$this->input->post('sub_date'),
			'note' =>$this->input->post('note'),
			'check_status' =>$this->input->post('check_status'),
			'status'=>'a',
			'created_by' =>$this->session->userdata('FullName'),
			'created_at' =>date('Y-m-d'),
		);

		$result = $this->db->insert('tbl_checks', $attr);
		if($result){ return TRUE;}else{return FALSE; }
	}

	public function store_check_info_sale($SM_id = Null,$cus_id = Null)
	{
		$cheque = $this->session->userdata('cheque');

		$attr = array(
			'cus_id' =>$cus_id,
			'SM_id'=>$SM_id,
			'branch_id'=>$this->session->userdata('BRANCHid'),
			'bank_name' =>$cheque['bank_name'],
			'branch_name' =>$cheque['branch_name'],
			'check_no' =>$cheque['check_no'],
			'check_amount' =>$cheque['check_amount'],
			'date' =>$cheque['date'],
			'check_date' =>$cheque['check_date'],
			'remid_date' =>$cheque['remid_date'],
			'sub_date' =>$cheque['sub_date'],
			'note' =>$cheque['note'],
			'check_status' =>'Pe',
			'status'=>'a',
			'created_by' =>$this->session->userdata('FullName'),
			'created_at' =>date('Y-m-d H:i:s'),
		);

		$result = $this->db->insert('tbl_checks', $attr);
		if($result){ return TRUE;}else{return FALSE; }
	}

	/*=======  find data by id =========*/
	public function check_data_by_id($id=Null)
	{
		if(!is_null($id)){
			$this->db->select('tbl_checks.*, tbl_customer.Customer_Name,tbl_customer.Customer_Code ');
			$this->db->from('tbl_checks');
			$this->db->join('tbl_customer', 'tbl_checks.cus_id = tbl_customer.Customer_SlNo' );
			$this->db->where('tbl_checks.id', $id)->where('tbl_checks.branch_id', $this->session->userdata('BRANCHid') )->where('tbl_checks.status', 'a');
			$result = $this->db->get()->row();

			if($result){ return $result; }else{ return FALSE; }
		}else{
			return FALSE;
		}
	}

	/*====================Update Lc Data ============================*/	
	public function update_check_data($id= null)
	{
		$attr = array(
			'cus_id' =>$this->input->post('cus_id'),
			'bank_name' =>$this->input->post('bank_name'),
			'branch_name' =>$this->input->post('branch_name'),
			'check_no' =>$this->input->post('check_no'),
			'check_amount' =>$this->input->post('check_amount'),
			'date' =>$this->input->post('date'),
			'check_date' =>$this->input->post('check_date'),
			'remid_date' =>$this->input->post('remid_date'),
			'sub_date' =>$this->input->post('sub_date'),
			'note' =>$this->input->post('note'),
			'check_status' =>$this->input->post('check_status'),
		);

		$this->db->where('id', $id);
		$qu = $this->db->update('tbl_checks', $attr);
		
		if ( $this->db->affected_rows()) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	/*====================Delete Lc Data ============================*/	
	public function delete_check_data($id= null)
	{
		$attr = array(
			'status' => 'd'
		);

		$this->db->where('id', $id);
		$qu = $this->db->update('tbl_checks', $attr);
		
		if ( $this->db->affected_rows()) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function cheque_status_change($id= null)
	{
		$attr = array(
			'check_status' => 'Pa'
		);

		$this->db->where('id', $id);
		$qu = $this->db->update('tbl_checks', $attr);

		if ( $this->db->affected_rows()) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function cheque_make_dishonor($id = Null){
		$attr = array(
			'check_status' => 'Di'
		);

		$this->db->where('id', $id);
		$qu = $this->db->update('tbl_checks', $attr);

		if ( $this->db->affected_rows()) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

}
