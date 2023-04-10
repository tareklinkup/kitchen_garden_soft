<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 3:33 PM
 */

class Customer_model extends CI_Model
{
	public $BRANCHid;

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function get_brunch_wise_customer_all_info(){


		$this->db->select('tbl_customer.*, tbl_district.*')->from('tbl_customer');
		$this->db->join('tbl_district', 'tbl_customer.area_ID = tbl_district.District_SlNo', 'left');
		$this->db->where('tbl_customer.Customer_brunchid',$this->BRANCHid)->where('tbl_customer.status', 'a');
		$res = $this->db->order_by('tbl_customer.Customer_Code', 'desc')->get()->result();

		if($res){
			return $res;
		}
		return FALSE;
	}

	public function get_customer_name_code_brunch_wise(){
		$res = $this->db->select('Customer_SlNo, Customer_Name, Customer_Code')->where('Customer_brunchid',$this->BRANCHid)->where('status', 'a')
			->order_by('Customer_Code', 'desc')->get('tbl_customer')->result();
		if($res){
			return $res;
		}
		return FALSE;
	}

	public function get_customer_name_code($cusId){
		$res = $this->db->select('Customer_SlNo, Customer_Name, Customer_Code')->where('Customer_SlNo',$cusId)->get('tbl_customer')->row();
		if($res){
			return $res;
		}
		return FALSE;
	}

	public function customer_payment_statment($startdate, $enddate)
	{	
		$res = $this->db->where('CPayment_brunchid', $this->BRANCHid)
				->where('CPayment_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" AND "'. date('Y-m-d', strtotime($enddate)).'"')->get('tbl_customer_payment')->result();
		if($res){
			return $res;
		}
		return FALSE;
	}

	public function last_customer_payment($cus_id = Null)
	{
		$res = $this->db->where('CPayment_customerID', $cus_id)->where('CPayment_status','a')->get('tbl_customer_payment')->row();
		 return $res;
	}
}
