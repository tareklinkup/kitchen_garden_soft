<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Billing_model extends CI_Model {

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

     // Get all details ehich store in "products" table in database.
        public function get_all()
	{
		$query = $this->db->get('products');
		return $query->result_array();
	}
    
    // Insert customer details in "customer" table in database.
	public function purchaseOrder($data)
	{
		$this->db->insert('tbl_purchasemaster', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;		
	}
	
        // Insert order date with customer id in "orders" table in database.
	public function insert_order($data)
	{
		$this->db->insert('order_tbl', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;
	}
	
        // Insert ordered product detail in "order_detail" table in database.
	public function insert_order_detail($data) {
		$this->db->insert('tbl_purchasedetails', $data);
	}
	
        // Insert ordered product detail in "save_employee_data" table in database.
	/* public function save_employee_data($data) {
		$this->db->insert('tbl_employee', $data);
	} */
	
	// ==========================quotation customer & Product==========================================
	public function quotation_customer_insert($data) {
		$this->db->insert('tbl_quotaion_customer', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;		
	}
	
	public function quotationCreate($data) {
		$this->db->insert('tbl_quotation_master', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;		
	}
	public function insert_quotation_detail($data) {
		$this->db->insert('tbl_quotation_details', $data);
	}
	// ==========================Sales Product==========================================
	public function SalesOrder($data) {
		$this->db->insert('tbl_salesmaster', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;		
	}
	public function insert_sales_detail($data) {
		$this->db->insert('tbl_saledetails', $data);
	}
	// ==========================Sales Return==========================================
	public function SalesReturn($table, $data) {
		$this->db->insert($table, $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;		
	}
	
	public function select_customer_sales_master($SaleMaster_SlNo){
		$this->db->SELECT("tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster left join tbl_customer on tbl_salesmaster.SalseCustomer_IDNo=tbl_customer.Customer_SlNo  WHERE tbl_salesmaster.SaleMaster_SlNo='$SaleMaster_SlNo'");
		$query = $this->db->get();
		$result = $query->row();
		//echo "<pre>";print_r($result);exit;
		return $result;
	}
	
	public function select_product_sales_details($SaleMaster_SlNo){
		 $this->db->SELECT("tbl_product.*, tbl_saledetails.* FROM tbl_product left join tbl_saledetails on tbl_product.Product_SlNo=tbl_saledetails.Product_IDNo  WHERE tbl_saledetails.SaleMaster_IDNo='$SaleMaster_SlNo'");
		$query = $this->db->get();
		$result = $query->result();
		//echo "<pre>";print_r($result);exit;
		return $result; 
	}
       
	public function selectProduct($pCategory,$brand,$BRANCHid){
		$this->db->SELECT("tbl_product.*, tbl_productcategory.*, tbl_color.*,tbl_brand.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color left join tbl_brand on tbl_brand.brand_SiNo=tbl_product.brand where tbl_product.brand='$brand' AND tbl_product.ProductCategory_ID='$pCategory' AND tbl_product.Product_branchid='$BRANCHid' order by tbl_product.Product_Code desc");
		$query = $this->db->get();
		$result = $query->result();
		return $result; 
	}
	
	public function select_Product_by_brand($brand,$BRANCHid){
		$this->db->SELECT("tbl_product.*, tbl_productcategory.*, tbl_color.*,tbl_brand.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color left join tbl_brand on tbl_brand.brand_SiNo=tbl_product.brand where tbl_product.brand='$brand' AND tbl_product.Product_branchid='$BRANCHid' order by tbl_product.Product_Code desc");
		$query = $this->db->get();
		$result = $query->result();
		return $result; 
	}
	  
	public function select_Product_by_category($pCategory,$BRANCHid){
		$this->db->SELECT("tbl_product.*, tbl_productcategory.*,tbl_color.*,tbl_brand.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color left join tbl_brand on tbl_brand.brand_SiNo=tbl_product.brand where tbl_product.ProductCategory_ID='$pCategory' AND tbl_product.status='a' AND tbl_product.Product_branchid='$BRANCHid' order by tbl_product.Product_Code desc");
		$query = $this->db->get();
		$result = $query->result();
		return $result; 
	}
	     
	public function select_all_Product(){
		$branchId = $this->session->userdata("BRANCHid");
		$products = $this->db->query("
			select
				p.*,
				pc.ProductCategory_Name,
				c.color_name,
				b.brand_name,
				case p.status
					when 'a' then 'Active'
					else 'Inactive'
				end as active_status
			from tbl_product p
			left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
			left join tbl_color c on c.color_SiNo = p.color
			left join tbl_brand b on b.brand_SiNo = p.brand
			where p.Product_branchid = ?
		", $branchId)->result();

		return $products; 
	}

	public function get_product_name()
	{
		$res = $this->db->select('Product_SlNo,Product_Name,Product_Code')->order_by('Product_SlNo','desc')->where('status','a')->where('Product_branchid',$this->BRANCHid)->get('tbl_product')->result();
		return $res;
	}

	public function get_product_by_id($id = Null){

		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->SELECT("tbl_product.*, tbl_productcategory.*,tbl_color.*,tbl_brand.*,tbl_unit.*");
		$this->db->from('tbl_product');
		$this->db->join('tbl_productcategory','tbl_product.ProductCategory_ID= tbl_productcategory.ProductCategory_SlNo', 'left');
		$this->db->join('tbl_color','tbl_product.color= tbl_color.color_SiNo', 'left');
		$this->db->join('tbl_brand','tbl_product.brand= tbl_brand.brand_SiNo', 'left');
		$this->db->join('tbl_unit','tbl_product.Unit_ID= tbl_unit.Unit_SlNo', 'left');
		$this->db->where('tbl_product.Product_SlNo', $id)->where('tbl_product.Product_branchid',$BRANCHid)->where('tbl_product.status', 'a');
		$result = $this->db->order_by('tbl_product.Product_SlNo', 'desc')->get()->row();

		return $result;
	}
	
	public function select_Product_without_limit(){
		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->SELECT("tbl_product.*, tbl_productcategory.*,tbl_color.*,tbl_brand.*,tbl_country.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand LEFT JOIN tbl_country ON tbl_country.Country_SlNo=tbl_product.country WHERE tbl_product.status='a' AND tbl_product.Product_branchid='$BRANCHid' order by tbl_product.Product_Code desc");
		$query = $this->db->get();
		$result = $query->result();
		return $result; 
	}

	public function select_all_Product_list(){
		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->SELECT("
			tbl_product.*,
			tbl_productcategory.*,
			tbl_color.*,
			tbl_brand.*
			FROM tbl_product 
			left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID 
			LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color 
			LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand 
			WHERE tbl_product.status='a'
			AND tbl_product.Product_branchid='$BRANCHid'
			order by tbl_product.Product_Code asc
		");
		$query = $this->db->get();
		$result = $query->result();
		//, tbl_product.ProductCategory_ID asc, tbl_product.brand asc
		return $result; 
	}
	
	public function update_saleinventory($table,$data,$id)
	{
		$this->db->where('sellProduct_IdNo', $id);
        $this->db->update($table, $data);
	}
     
	public function update_salesmaster($table,$data,$id)
	{
		$this->db->where('SaleMaster_SlNo', $id);
        $this->db->update($table, $data);
	}
         
	public function update_customerpayment($table,$data,$id)
	{
		$this->db->where('CPayment_invoice', $id);
        $this->db->update($table, $data);
	}

// ==========================Sales Product Update==========================================
	public function SalesOrderUpdate($data,$salesInvoiceno) {
		$this->db->where('SaleMaster_InvoiceNo', $salesInvoiceno);
		$this->db->update('tbl_salesmaster', $data);
		//$id = $this->db->insert_id();
		//return (isset($id)) ? $id : FALSE;		
	}
	public function update_sales_detail($data) {
		$this->db->insert('tbl_saledetails', $data);
	}
    public function update_purchase_detail($data) {
        $this->db->insert('tbl_purchasedetails', $data);
    }
	public function getUnitById($id){
	    return $this->db->where('Unit_SlNo',$id)->get('tbl_unit')->row()->Unit_Name;
    }

    public function update_customer_payment_data($table, $data,$id)
	{
		$this->db->where('CPayment_invoice', $id);
        $this->db->update($table, $data);
	}	
		   
  	public function select_brand_by_category($id){
		$this->db->select('*');
		$this->db->from('tbl_brand');
		$this->db->where('ProductCategory_SlNo',$id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	   
  	public function select_category($brunch){
		$this->db->select('*');
		$this->db->from('tbl_productcategory');
		$this->db->where("category_branchid",$brunch);
		$this->db->order_by("ProductCategory_Name","ASC");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	   
  	public function select_Product_by_id($Product_SlNo){
		$this->db->select('*');
		$this->db->from('tbl_product');
		$this->db->where('Product_SlNo',$Product_SlNo);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	public function select_category_by_brand($id){
		$this->db->SELECT("tbl_productcategory.ProductCategory_SlNo,tbl_productcategory.ProductCategory_Name from tbl_product inner join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID where tbl_product.brand='$id'");
		$this->db->distinct('tbl_product.ProductCategory_ID');
		$this->db->order_by("tbl_productcategory.ProductCategory_Name","ASC");
		$query = $this->db->get();
		$result = $query->result() ;
		return $result;
	}  
	
	public function select_supplier_purhase_master($PurchaseMaster_SlNo){
		$this->db->SELECT("
		                                    tbl_purchasemaster.*, 
		                                    tbl_supplier.* 
		                                    FROM 
		                                        tbl_purchasemaster 
		                                     left join tbl_supplier on tbl_purchasemaster.Supplier_SlNo=tbl_supplier.Supplier_SlNo 
		                                    WHERE tbl_purchasemaster.PurchaseMaster_SlNo='$PurchaseMaster_SlNo'
		                                    ");
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	public function select_product_parchase_details($PurchaseMaster_SlNo){
		 $this->db->SELECT("
		 tbl_product.*, 
		 tbl_purchasedetails.* ,
		 tbl_productcategory.* 
		 FROM tbl_product 
		 left join tbl_purchasedetails on tbl_product.Product_SlNo=tbl_purchasedetails.Product_IDNo  
		 left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID  
		 WHERE tbl_purchasedetails.PurchaseMaster_IDNo='$PurchaseMaster_SlNo'");

		$query = $this->db->get();
		$result = $query->result();

		return $result; 
	}
	
	public function update_purchaseinventory($table,$data,$id)
	{
		$this->db->where('purchProduct_IDNo', $id);
        $this->db->update($table, $data);
	}
     
	public function update_purchasemaster($table,$data,$id)
	{
		$this->db->where('PurchaseMaster_SlNo', $id);
        $this->db->update($table, $data);
	}
         
	/* public function update_supplier_payment($table,$data,$id)
	{
		$this->db->where('SPayment_invoice', $id);
        $this->db->update($table, $data);
	} */
   
   // ==========================Purchase Product Update==========================================
	public function purchaseOrderUpdate($data,$purchInvoice) {
		$this->db->where('PurchaseMaster_InvoiceNo', $purchInvoice);
		$this->db->update('tbl_purchasemaster', $data);
		//$id = $this->db->insert_id();
		//return (isset($id)) ? $id : FALSE;		
	}
	public function update_purchasedetails_data($data) {
		$this->db->insert('tbl_purchasedetails', $data);
	}

    public function update_supplier_payment_data($table, $data,$id)
	{
		$this->db->where('SPayment_invoice', $id);
        $this->db->update($table, $data);
	} 

	public function deactive_user($table, $id, $field)
	{
		$data['Status'] = 'd';
		$this->db->where($field, $id);
        $this->db->update($table, $data);
	}	 
	
	public function active_user($table, $id, $field)
	{
		$data['Status'] = 'a';
		$this->db->where($field, $id);
        $this->db->update($table, $data);
	}	 
	
  	public function select_bank(){
		$this->db->select('*');
		$this->db->from('tbl_bank');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
  	public function select_all_transaction(){
  		$this->db->select('tbl_cashtransaction.*,tbl_account.*')->from('tbl_cashtransaction');
  		$this->db->join('tbl_account', 'tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID', 'left');
  		$this->db->where('tbl_cashtransaction.Tr_branchid',$this->BRANCHid)->where('tbl_cashtransaction.status', 'a');
  		$res = $this->db->order_by('tbl_cashtransaction.Tr_SlNo', 'asc')->get()->result();

		return $res;
	}
	
  	public function fatch_all_payment(){
		$this->db->select('tbl_customer_payment.*, tbl_customer.Customer_Name')->from('tbl_customer_payment');
		$this->db->join('tbl_customer', 'tbl_customer_payment.CPayment_customerID=tbl_customer.Customer_SlNo');
		$result = $this->db->where('tbl_customer_payment.CPayment_status','a')->where('tbl_customer_payment.CPayment_brunchid', $this->BRANCHid)
			->order_by('tbl_customer_payment.CPayment_invoice', 'desc')->get()->result();
		return $result;
	}

	public function fatch_all_supplier_payment(){
		$this->db->select('*');
		$result = $this->db->from('tbl_supplier_payment')->where('SPayment_status','a')->get()->result();
		return $result;
	}
	
  	public function select_brand($brunch){
		$this->db->select('*');
		$this->db->from('tbl_brand');
		$this->db->where('brand_branchid',$brunch);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	public function select_compay_profile($table,$id,$fld){
		//echo $table;
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($fld,$id);
		$query = $this->db->get();
		$result =$query->row();
		return $result;
		/* echo "<pre>";print_r($result);exit;
		if($ss= $query->num_rows()>0){
		   return $query->row();
			
		}else {
		   return 0; 
		} */
		
		//$result = $query->row();
		//return $result;
	}
	
	// ==========================Transfer Product==========================================
	public function insert_transfer_product($data) {
		$this->db->insert('sr_transfermaster', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;	
		}
		
	public function select_pending_transfer_product(){
		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->SELECT("TM.TransferMaster_SiNo, TM.TransferMaster_InvoiceNo, TM.TransferMaster_Date, B.Brunch_name, TD.TransferDetails_SiNo, TD.TransferDetails_TotalQuantity, TD.TransferDetails_unit, PD.Product_Code, PD.Product_Name, PC.ProductCategory_Name, BR.brand_name FROM sr_transfermaster AS TM
		INNER JOIN sr_transferdetails AS TD ON TM.TransferMaster_SiNo = TD.TransferMaster_IDNo
		INNER JOIN tbl_product AS PD ON TD.Product_IDNo = PD.Product_SlNo
		INNER JOIN tbl_productcategory AS PC ON PC.ProductCategory_SlNo = PD.ProductCategory_ID
		INNER JOIN tbl_brand AS BR ON BR.brand_SiNo = PD.brand
		INNER JOIN tbl_brunch AS B ON B.brunch_id = TM.TransferMaster_Transferto
		WHERE TD.fld_status='p' AND TD.Brunch_from='$BRANCHid' AND TM.TransferMaster_Transferfrom='$BRANCHid'");
		$query = $this->db->get();
		$result = $query->result();
		return $result; 
	}	
	
	public function select_receive_transfer_product(){
		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->SELECT("TM.TransferMaster_SiNo, TM.TransferMaster_InvoiceNo, TM.TransferMaster_Date,TM.TransferMaster_Transferfrom,TM.TransferMaster_Transferto, B.Brunch_name, TD.TransferDetails_SiNo, TD.TransferDetails_TotalQuantity, TD.TransferDetails_unit, PD.Product_Code, PD.Product_SlNo, PD.Product_Name, PC.ProductCategory_Name, BR.brand_name FROM sr_transfermaster AS TM
		INNER JOIN sr_transferdetails AS TD ON TM.TransferMaster_SiNo = TD.TransferMaster_IDNo
		INNER JOIN tbl_product AS PD ON TD.Product_IDNo = PD.Product_SlNo
		INNER JOIN tbl_productcategory AS PC ON PC.ProductCategory_SlNo = PD.ProductCategory_ID
		INNER JOIN tbl_brand AS BR ON BR.brand_SiNo = PD.brand
		INNER JOIN tbl_brunch AS B ON B.brunch_id = TM.TransferMaster_Transferfrom
		WHERE TD.fld_status='p' AND TD.Brunch_to='$BRANCHid' AND TM.TransferMaster_Transferto='$BRANCHid'");
		$query = $this->db->get();
		$result = $query->result();
		return $result; 
	}
	
	public function update_transfer_details($TransferDetails_SiNo)
	{
		$data['fld_status'] = 'a';
		$this->db->where('TransferDetails_SiNo', $TransferDetails_SiNo);
        $this->db->update('sr_transferdetails', $data);
	}

	public function get_transfer_data_by_branch($transfer_startdate,$transfer_enddate){
		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->select('*');   
		$this->db->from('sr_transfermaster');
		$this->db->join('sr_transferdetails','sr_transfermaster.TransferMaster_SiNo = sr_transferdetails.TransferMaster_IDNo');
		$this->db->join('tbl_product','sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo');
		$this->db->join('tbl_productcategory','tbl_product.ProductCategory_ID = tbl_productcategory.ProductCategory_SlNo');

		$this->db->where('sr_transfermaster.TransferMaster_Date >=', $transfer_startdate);
		$this->db->where('sr_transfermaster.TransferMaster_Date <=',  $transfer_enddate);
		$this->db->where('sr_transfermaster.TransferMaster_Transferfrom', $BRANCHid);
		$resTransfer = $this->db->get()->result();
		return $resTransfer;
	}
	
	public function get_recieve_data_by_branch($transfer_startdate,$transfer_enddate){
		$BRANCHid = $this->session->userdata("BRANCHid");
		$this->db->select('*');   
		$this->db->from('sr_transfermaster');
		$this->db->join('sr_transferdetails','sr_transfermaster.TransferMaster_SiNo = sr_transferdetails.TransferMaster_IDNo');
		$this->db->join('tbl_product','sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo');
		$this->db->join('tbl_productcategory','tbl_product.ProductCategory_ID = tbl_productcategory.ProductCategory_SlNo');

		$this->db->where('sr_transfermaster.TransferMaster_Date >=', $transfer_startdate);
		$this->db->where('sr_transfermaster.TransferMaster_Date <=',  $transfer_enddate);
		$this->db->where('sr_transfermaster.TransferMaster_Transferto', $BRANCHid);
		$resTransfer = $this->db->get()->result();
		return $resTransfer;
	}
	

	public function select_category_by_branch($id){
		$this->db->SELECT('*');
		$this->db->from('tbl_productcategory');
		$this->db->where('category_branchid',$id);
		$this->db->order_by("ProductCategory_Name","ASC");
		$query = $this->db->get();
		$result = $query->result() ;
		return $result;
	} 

	public function select_by_id($table, $id, $field)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field, $id);
		$query = $this->db->get();
		$result = $query->row();
		//print_r($result);exit;
		return $result;
	}	 
				   
  	public function company_branch_profile($id){
		$company = $this->db->query("select * from tbl_company order by Company_SlNo desc limit 1")->row();
		$branch = $this->db->query("select * from tbl_brunch where brunch_id = ?", $id)->row();

		return (object)[
			'Company_Logo_thum' => $company->Company_Logo_thum,
			'Company_Logo_org' => $company->Company_Logo_org,
			'Company_Name' => $branch->Brunch_title,
			'Repot_Heading' => $branch->Brunch_address,
			'print_type' => $company->print_type
		];
	}

	public function getCurrentBranch(){
		$branchInfo = $this->db->query("select * from tbl_brunch where brunch_id = ?", $this->session->userdata('BRANCHid'))->row();
		return $branchInfo;
	}
		
	public function cash_transaction($startdate, $enddate)
	{	
		$res = $this->db->where('Tr_branchid', $this->BRANCHid)
				->where('Tr_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" and "'. date('Y-m-d', strtotime($enddate)).'"')
				->get('tbl_cashtransaction')->result();

		return $res;	
	}
}
