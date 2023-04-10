<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 3:38 PM
 */

class Report_model extends CI_Model
{
	protected  $BRANCHid;

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function all_supplier_due_report()
	{	
		$this->db->select('tbl_purchasemaster.*, tbl_supplier.*')->from('tbl_purchasemaster');
		$this->db->join('tbl_supplier', 'tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo');
		$this->db->where('tbl_supplier.Supplier_brinchid ', $this->BRANCHid)->where('tbl_supplier.status', 'a');
		$res = $this->db->group_by('tbl_purchasemaster.Supplier_SlNo')->get()->result();
		
		if($res){
			return $res;
		}else{
			return false;
		}
	}

	public function supplier_wise_due_report($sup_id = Null)
	{	
		$this->db->select('tbl_purchasemaster.*, tbl_supplier.*')->from('tbl_purchasemaster');
		$this->db->join('tbl_supplier', 'tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo');
		$this->db->where('tbl_purchasemaster.Supplier_SlNo', $sup_id)->where('tbl_supplier.Supplier_brinchid ', $this->BRANCHid)->where('tbl_supplier.status', 'a');
		$res = $this->db->group_by('tbl_purchasemaster.Supplier_SlNo')->get()->result();
		
		if($res){
			return $res;
		}else{
			return false;
		}
	}
}