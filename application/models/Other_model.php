<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 3:38 PM
 */

class Other_model extends CI_Model
{
	protected  $BRANCHid;

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function get_current_branch_compnay_info(){
		$res = $this->db->where('company_BrunchId',$this->BRANCHid)->get('tbl_company')->row();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function general_supplier_info(){
		$res = $this->db->where('Supplier_Type', 'G')->get('tbl_supplier')->row();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}
	/*= get area all data ======*/
	public function get_area_data(){
		$res = $this->db->where('status', 'a')->order_by('District_Name', 'asc')->get('tbl_district')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function branch_wise_category(){
		$res = $this->db->where('category_branchid', $this->BRANCHid)->where('status', 'a')->order_by('ProductCategory_SlNo', 'asc')->get('tbl_productcategory')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_single_category_info($id){
		$res = $this->db->where('ProductCategory_SlNo', $id)->where('category_branchid', $this->BRANCHid)->where('status', 'a')->get('tbl_productcategory')->row();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function branch_wise_brand(){
		$res = $this->db->where('brand_branchid', $this->BRANCHid)->where('status', 'a')->order_by('brand_SiNo', 'desc')
			->get('tbl_brand')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function all_color_info(){
		$res = $this->db->where('status', 'a')->order_by('color_SiNo', 'desc')->get('tbl_color')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function all_unit_info(){
		$res = $this->db->where('status', 'a')->order_by('Unit_SlNo', 'desc')->get('tbl_unit')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function branch_wise_supplier_info(){
		$res = $this->db->where('Supplier_brinchid', $this->BRANCHid)->where('status', 'a')->order_by('Supplier_SlNo', 'desc')->get('tbl_supplier')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_all_asset_info(){

		$res = $this->db->where('branchid', $this->BRANCHid)->where('status', 'a')->order_by('as_id', 'desc')->get('tbl_assets')->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_all_account_info(){
		$res = $this->db->where('branch_id', $this->BRANCHid)->where('status', 'a')->order_by('Acc_Code', 'asc')->get('tbl_account')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function supplier_payment_statment($startdate, $enddate)
	{
		$res = 	$this->db->where('SPayment_brunchid', $this->BRANCHid)
				->where('SPayment_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" AND "'. date('Y-m-d', strtotime($enddate)).'"')->get('tbl_supplier_payment')->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function transaction_account_all($type = Null){
	
		$startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
        
		if($type == 'P'){
			$tr_type = 'Out Cash';
		}else{
			$tr_type = 'In Cash';
		}
		$this->db->select('tbl_cashtransaction.*,tbl_account.*')->from('tbl_cashtransaction');
		$this->db->join('tbl_account', 'tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID','left');
		$this->db->where('tbl_cashtransaction.status', 'a');
		$this->db->where('tbl_cashtransaction.Tr_branchid', $this->BRANCHid);
		$this->db->where("DATE_FORMAT(tbl_cashtransaction.Tr_date,'%Y-%m-%d') >=",$startdate);
		$this->db->where("DATE_FORMAT(tbl_cashtransaction.Tr_date,'%Y-%m-%d') <=",$enddate);
		if($type != 'A'){
			$this->db->where('tbl_cashtransaction.Tr_Type',$tr_type);
		}
		$res = $this->db->order_by('tbl_cashtransaction.Tr_SlNo', 'desc')->get()->result();

		return $res;
	}

	public  function transaction_by_account($type = Null, $account_id = Null){
		
		$startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');


		if($type == 'P'){
			$tr_type = 'Out Cash';
		}else{
			$tr_type = 'In Cash';
		}
		$this->db->select('tbl_cashtransaction.*,tbl_account.*')->from('tbl_cashtransaction');
		$this->db->join('tbl_account', 'tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID','left');
		$this->db->where('tbl_cashtransaction.status', 'a');
		$this->db->where('tbl_cashtransaction.Tr_branchid', $this->BRANCHid);
		$this->db->where('tbl_cashtransaction.Acc_SlID', $account_id);
		$this->db->where("DATE_FORMAT(tbl_cashtransaction.Tr_date,'%Y-%m-%d') >=",$startdate);
		$this->db->where("DATE_FORMAT(tbl_cashtransaction.Tr_date,'%Y-%m-%d') <=",$enddate);
		if($type != 'A'){
			$this->db->where('tbl_cashtransaction.Tr_Type',$tr_type);
		}
		$res = $this->db->order_by('tbl_cashtransaction.Tr_SlNo', 'desc')->get()->result();

		return $res;
	}
}
