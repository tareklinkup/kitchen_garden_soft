<?php

/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 5:14 PM
 */

class Quotation_model extends CI_Model
{
	protected $branch_id;
	public function __construct()
	{
		$this->branch_id = $this->session->userdata('BRANCHid');
	}

	public function get_branch_wise_quotation_invoice()
	{

		$res = $this->db->select('SaleMaster_SlNo, SaleMaster_InvoiceNo')->where('SaleMaster_branchid', $this->branch_id)
			->order_by('SaleMaster_SlNo', 'desc')->get(' tbl_quotation_master')->result();

		if ($res) {
			return $res;
		} else {
			return FALSE;
		}
	}

	public function find_quotation_info_by_id($quotation_id  = Null)
	{
		$this->db->select('tbl_quotation_master.*, tbl_quotation_master.AddBy as served, tbl_quotaion_customer.*')->from('tbl_quotation_master');
		$this->db->join('tbl_quotaion_customer', 'tbl_quotaion_customer.quotation_customer_id = tbl_quotation_master.SalseCustomer_IDNo', 'left');
		$res = $this->db->where('tbl_quotation_master.SaleMaster_SlNo', $quotation_id)->get()->row();
		if ($res) {
			return $res;
		} else {
			return FALSE;
		}
	}

	public function get_invoice_wise_quotation_product_details($quotation_id = Null)
	{

		$this->db->select('tbl_quotation_details.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*')->from('tbl_quotation_details');
		$this->db->join('tbl_product', 'tbl_product.Product_SlNo = tbl_quotation_details.Product_IDNo', 'left');
		$this->db->join('tbl_productcategory', 'tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID', 'left');
		$this->db->join('tbl_color', 'tbl_color.color_SiNo=tbl_product.color', 'left');
		$this->db->join('tbl_brand', 'tbl_brand.brand_SiNo=tbl_product.brand', 'left');
		$res = $this->db->where('tbl_quotation_details.SaleMaster_IDNo', $quotation_id)->get()->result();

		if ($res) {
			return $res;
		} else {
			return FALSE;
		}
	}
}
