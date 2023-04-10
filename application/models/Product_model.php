<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 1:20 PM
 */

class Product_model extends CI_Model
{
	protected  $BRANCHid;
	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function make_product_code()
	{
		$serial ="P00001";
		$query = $this->db->query("SELECT * FROM tbl_product order by Product_SlNo desc limit 1");
		$result = $query->row();


		if(is_null($result)|| !isset($result)){
		            $generateCode = 'P00001';
		}else{

		    $num = substr($result->Product_Code, 1, strlen($result->Product_Code));

		    if($num < 9):
		        $num+=1;
		        $generateCode = 'P0000'.$num;
		    elseif($num < 99):
		        $num+=1;
		        $generateCode = 'P000'.$num;
		    elseif($num < 999):
		        $num+=1;
		        $generateCode = 'P00'.$num;
		    elseif($num<9999):
		        $num+=1;
		        $generateCode = 'P0'.$num; 
		    else:
		        $num+=1;
		        $generateCode = 'P'.$num;
		    endif;
		}

		return $generateCode;
	}

	public function products_by_brunch(){

		$res = $this->db
                            ->join('tbl_brand','tbl_brand.brand_SiNo=tbl_product.brand','left')
                            ->where('tbl_product.Product_branchid',$this->BRANCHid)
                            ->where('tbl_product.status', 'a')
                            ->order_by('tbl_product.Product_Name', 'asc')
                            ->get('tbl_product')
                            ->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}

	}

	public function get_all_product_price_list(){
		$this->db->select('tbl_product.*, tbl_brand.*')->from('tbl_product');
		$this->db->join('tbl_brand', 'tbl_brand.brand_SiNo=tbl_product.brand');
		$this->db->where('tbl_product.Product_branchid', $this->BRANCHid)->where('tbl_product.status', 'a');
		$res = $this->db->order_by('tbl_product.Product_Name', 'asc')->get()->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_all_product_price_category_wise($cat_id = Null){
		$this->db->select(' tbl_product.*, tbl_productcategory.*,tbl_brand.*')->from('tbl_product');
		$this->db->join('tbl_productcategory', 'tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID','left');
		$this->db->join('tbl_brand', 'tbl_brand.brand_SiNo=tbl_product.brand ','left');
		$this->db->where('tbl_product.Product_branchid', $this->BRANCHid)->where('tbl_product.ProductCategory_ID',$cat_id);
		$res = $this->db->order_by('tbl_product.Product_Name', 'asc')->get()->row();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function get_singel_product_pice_list($pro_id = Null){

		$this->db->select('tbl_product.*, tbl_brand.*')->from('tbl_product');
		$this->db->join('tbl_brand', 'tbl_brand.brand_SiNo=tbl_product.brand');
		$this->db->where('tbl_product.Product_branchid', $this->BRANCHid)->where('tbl_product.Product_SlNo',$pro_id)->where('tbl_product.status', 'a');
		$res = $this->db->order_by('tbl_product.Product_Name', 'asc')->get()->result();
		if($res){
			return $res;
		}else{
			return FALSE;
		}
	}

	public function all_damage_product_list()
	{	

		$this->db->select('tbl_damage.*,tbl_damagedetails.*,tbl_product.*, tbl_unit.*')->from('tbl_damage');
		$this->db->join('tbl_damagedetails', 'tbl_damagedetails.Damage_SlNo = tbl_damage.Damage_SlNo', 'left');
		$this->db->join('tbl_product', 'tbl_product.Product_SlNo= tbl_damagedetails.Product_SlNo', 'left');
		$this->db->join('tbl_unit', 'tbl_unit.Unit_SlNo = tbl_product.Unit_ID', 'left');
		$this->db->where('tbl_damage.Damage_brunchid',$this->BRANCHid);
		$this->db->where('tbl_damage.status','a');
		$res = $this->db->order_by('tbl_damage.Damage_InvoiceNo', 'desc')->get()->result();
		
		if($res){
			return $res;
		}else{
			return FALSE;
		}

	}

	public function demage_poduct_list_by_product_id($pro_id = Null)
	{	
		$this->db->select('tbl_damage.*,tbl_damagedetails.*,tbl_product.*, tbl_unit.*')->from('tbl_damage');
		$this->db->join('tbl_damagedetails', 'tbl_damagedetails.Damage_SlNo = tbl_damage.Damage_SlNo', 'left');
		$this->db->join('tbl_product', 'tbl_product.Product_SlNo= tbl_damagedetails.Product_SlNo', 'left');
		$this->db->join('tbl_unit', 'tbl_unit.Unit_SlNo = tbl_product.Unit_ID', 'left');
		$this->db->where('tbl_damagedetails.Product_SlNo',$pro_id);
		$this->db->where('tbl_damage.Damage_brunchid',$this->BRANCHid);
		$this->db->where('tbl_damage.status','a');
		$res = $this->db->order_by('tbl_damage.Damage_InvoiceNo', 'desc')->get()->result();

		if($res){
			return $res;
		}else{
			return FALSE;
		}
	
	}
}
