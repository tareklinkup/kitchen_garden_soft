<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 12/1/2018
 * Time: 11:37 AM
 */

class Purchase_model extends CI_Model
{

	protected  $BRANCHid;

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function pruchase_serial_id(){
		$row = $this->db->order_by('PurchaseMaster_SlNo', 'desc')->limit('1')->get('tbl_purchasemaster')->row();

		@$invoice = $row->PurchaseMaster_InvoiceNo;
		$previousinvoice = substr($invoice, 3, 11);
		if (!empty($invoice)) {
			if ($previousinvoice<10) {
				$purchInvoice = 'CP-00'.($previousinvoice+1);
			}
			elseif ($previousinvoice<100) {
				$purchInvoice = 'CP-0'.($previousinvoice+1);
			}
			else{
				$purchInvoice = 'CP-'.($previousinvoice+1);
			}
		}
		else{
			$purchInvoice = 'CP-001';
		}

		return $purchInvoice;
	}

	public function all_purchase_return_invoice(){

		$res = $this->db->select('PurchaseMaster_SlNo,PurchaseMaster_InvoiceNo, ')->where('PurchaseMaster_BranchID', $this->BRANCHid)
			->where('status', 'a')->order_by('PurchaseMaster_InvoiceNo', 'desc')->get('tbl_purchasemaster')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_purchase_invoice_info(){
		$res = $this->db->select('PurchaseMaster_SlNo, PurchaseMaster_InvoiceNo')->where('PurchaseMaster_BranchID', $this->BRANCHid)
			->where('status', 'a')->order_by('PurchaseMaster_InvoiceNo', 'desc')->get('tbl_purchasemaster')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function single_purchase_master_info($id = Null){

		$this->db->select('tbl_purchasemaster.*, tbl_purchasemaster.AddBy as served, tbl_supplier.*')->from('tbl_purchasemaster');
		$this->db->join('tbl_supplier', 'tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo', 'left');
		$res = $this->db->where('tbl_purchasemaster.PurchaseMaster_SlNo',$id)->get()->row();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function invoice_wise_purchase_products($id = Null){

		$this->db->select('tbl_purchasedetails.*, tbl_product.*,tbl_productcategory.*,tbl_brand.*')->from('tbl_purchasedetails');
		$this->db->join('tbl_product', 'tbl_product.Product_SlNo = tbl_purchasedetails.Product_IDNo', 'left');
		$this->db->join('tbl_productcategory', 'tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID', 'left');
		$this->db->join('tbl_brand', 'tbl_brand.brand_SiNo=tbl_product.brand', 'left');
		$res = $this->db->where('tbl_purchasedetails.PurchaseMaster_IDNo', $id)->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function full_purchase_statment($startDate, $endDate)
	{	

		$this->db->select('tbl_purchasemaster.*, tbl_purchasereturn.PurchaseMaster_InvoiceNo as purReturnInv, tbl_purchasereturn.PurchaseReturn_ReturnAmount')->from('tbl_purchasemaster');
		$this->db->join('tbl_purchasereturn', 'tbl_purchasereturn.PurchaseMaster_InvoiceNo = tbl_purchasemaster.PurchaseMaster_InvoiceNo');
		$this->db->where('PurchaseMaster_BranchID', $this->BRANCHid);
		$this->db->where('tbl_purchasemaster.PurchaseMaster_OrderDate BETWEEN "'. date('Y-m-d', strtotime($startDate)). '" and "'. date('Y-m-d', strtotime($endDate)).'"');
		$res =  $this->db->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}



}
