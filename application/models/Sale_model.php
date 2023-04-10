<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 3:23 PM
 */

class Sale_model extends CI_Model
{
	public $BRANCHid;

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function get_branch_wise_sale_invoice(){
		$branch_id = $this->session->userdata('BRANCHid');
		$res = $this->db->select('SaleMaster_SlNo, SaleMaster_InvoiceNo')->where('SaleMaster_branchid',$branch_id)
				->order_by('SaleMaster_SlNo', 'desc')->get('tbl_salesmaster')->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_sales_master_info($id = Null){

		$this->db->select('tbl_salesmaster.*, tbl_salesmaster.AddBy as served, tbl_customer.*,genaral_customer_info.*')->from('tbl_salesmaster');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->join('genaral_customer_info', 'genaral_customer_info.G_Sale_Mastar_SiNO=tbl_salesmaster.SaleMaster_SlNo', 'left');
		$res = $this->db->where('tbl_salesmaster.SaleMaster_SlNo', $id)->get()->row();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function all_sale_record_data($start_date, $end_date)
	{	
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

    public function cus_sale_record_data($cus_id,$start_date, $end_date)
    {
        $this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
        $this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
        $this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
        $this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
        $this->db->where('tbl_salesmaster.SalseCustomer_IDNo', $cus_id);
        $this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

        if($res){
            return $res;
        }else{
            return FALSE;
        }
    }

	public function customer_wise_sale_record($cus_id=Null, $start_date, $end_date)
	{
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SalseCustomer_IDNo', $cus_id);
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function sale_type_wise_sale_record($type = Null,$start_date, $end_date)
	{	
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.Status', $type);
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function full_sale_statment($startdate, $enddate)
	{	
		$this->db->select('tbl_salesmaster.*,tbl_salereturn.SaleMaster_InvoiceNo as saleReturnInv, tbl_salereturn.SaleReturn_ReturnAmount')->from('tbl_salesmaster');
		$this->db->join('tbl_salereturn', 'tbl_salereturn.SaleMaster_InvoiceNo = tbl_salesmaster.SaleMaster_InvoiceNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" and "'. date('Y-m-d', strtotime($enddate)).'"');
		$res =  $this->db->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	} 

	public function product_sale_qty($productId=Null,$start_date,$end_date)
	{	
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_saledetails.Product_IDNo',$productId);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}

		
	}

	public function all_product_sale_qty($start_date,$end_date)
	{
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function customer_wise_product_sale_qty($customerID,$start_date,$end_date)
	{
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.SalseCustomer_IDNo',$customerID);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function customer_and_product_sale_qty($productID, $customerID,$start_date,$end_date)
	{
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_saledetails.Product_IDNo',$productID);
		$this->db->where('tbl_salesmaster.SalseCustomer_IDNo',$customerID);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function all_sale_record_data_by_user($userName , $start_date, $end_date)
	{	
		$this->db->select('tbl_salesmaster.*, tbl_saledetails.*, tbl_customer.*')->from('tbl_salesmaster');
		$this->db->join('tbl_saledetails', 'tbl_saledetails.SaleMaster_IDNo = tbl_salesmaster.SaleMaster_SlNo', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo', 'left');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid', $this->BRANCHid);
		$this->db->where('tbl_salesmaster.AddBy', $userName);
		$this->db->where('tbl_salesmaster.SaleMaster_SaleDate BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$res =  $this->db->group_by('tbl_salesmaster.SaleMaster_InvoiceNo')->order_by('tbl_salesmaster.SaleMaster_SlNo','desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}


}
