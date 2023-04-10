<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
        $this->load->model('Billing_model'); 
        $this->load->library('cart');
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->helper('form');
		$vars['branch_info'] = $this->Billing_model->company_branch_profile($this->brunch);
		$this->load->vars($vars);
    }
    public function index(){
        $data['title'] = "Product Sales";
        $data['content'] = $this->load->view('Administrator/sales/product_sales', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function supplierList(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Supplier List";
        $data['content'] = $this->load->view('Administrator/reports/supplierList', $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function price_listprint()  {
        $data['title'] = "Customer List";
		$select_one = $this->session->userdata('select_one');
		$category = $category = $this->session->userdata('category');
		$product = $product = $this->session->userdata('product');

		
		if($select_one =='All'){
			$data['products'] = $this->Product_model->get_all_product_price_list();
		}elseif($select_one == 'Category'){
			$data['category'] = $this->Other_model->get_single_category_info($category);
		}elseif($select_one == 'Product'){
			$data['products'] = $this->Product_model->get_singel_product_pice_list($product);
		}
        $this->load->view('Administrator/reports/price_listprint', $data);
    }
    public function employeelist()  {
        $data['title'] = "Employee List";
        $this->load->view('Administrator/reports/employeelist', $data);
    }
    public function price_list()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Price List";
        $data['content'] = $this->load->view('Administrator/reports/price_list', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function sales_invoice()  {
        $data['title'] = "Sales Invoice";
        $id = $this->session->userdata('lastidforprint');
        if(!$id){
            $id = $this->session->userdata('SalesID');
        }
        
		$data['selse'] = $this->Sale_model->get_sales_master_info($id);
		$data['SalesID'] = $id; 
        $this->load->view('Administrator/reports/sales_invoice', $data);
    }
    public function Purchase_invoice()  {
        $data['title'] = "Purchase Bill";
        $data['PurchID'] = $this->session->userdata('PurchID');
        $this->load->view('Administrator/reports/purchase_bill', $data);
    }
	
    function search_purchase_record()  {
        $searchtype = $this->session->userdata('searchtype');
        $Purchase_startdate = $this->session->userdata('Purchase_startdate');
        $Purchase_enddate = $this->session->userdata('Purchase_enddate');
        $Supplierid = $this->session->userdata('Supplierid');
        if($searchtype == "All"){
            $sql = "
                SELECT
                tbl_purchasemaster.*,
                tbl_supplier.* 
                FROM tbl_purchasemaster 
                left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo 
                WHERE tbl_purchasemaster.status = 'a'
                AND tbl_purchasemaster.PurchaseMaster_OrderDate between  '$Purchase_startdate' and '$Purchase_enddate'
            ";
        }
        if($searchtype == "Supplier"){
            $sql = "
                SELECT
                tbl_purchasemaster.*,
                tbl_supplier.* 
                FROM tbl_purchasemaster 
                left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo 
                WHERE tbl_purchasemaster.Supplier_SlNo = '$Supplierid'
                and tbl_purchasemaster.status = 'a'
                and tbl_purchasemaster.PurchaseMaster_OrderDate between '$Purchase_startdate' and '$Purchase_enddate'
            ";
        }
        $result = $this->db->query($sql);
        $datas["record"] = $result->result();
        $this->load->view('Administrator/reports/purchase_record_print', $datas);
    }
	 
    function search_invoice_sales_record()  {
        $sbrunch = $this->session->userdata('BRANCHid');
        $searchtype = $this->session->userdata('searchtype');
        $Sales_startdate = $this->session->userdata('Sales_startdate');
        $Sales_enddate = $this->session->userdata('Sales_enddate');
        $customerID = $this->session->userdata('customerID');
        $Salestype = $this->session->userdata('Salestype');
		$data['records'] = $this->Sale_model->all_sale_record_data($Sales_startdate,$Sales_enddate);
		
        $this->load->view('Administrator/reports/sales_invoince_record_print', $data);
	}
    function search_sales_record()  {
        // print_r('yyyyy'); die();
        $sbrunch = $this->session->userdata('BRANCHid');
        $searchtype = $this->session->userdata('searchtype');
        $Sales_startdate = $this->session->userdata('Sales_startdate');
        $Sales_enddate = $this->session->userdata('Sales_enddate');
        $customerID = $this->session->userdata('customerID');
        $productID = $this->session->userdata('productID');
        $adminId = $this->session->userdata('adminId');
        $Salestype = $this->session->userdata('Salestype');
		
        if($searchtype == "All"){ 
            if($Salestype == 'All'){
                $data['records'] = $this->Sale_model->all_sale_record_data($Sales_startdate,$Sales_enddate);
            }else{
                $data['records'] = $this->Sale_model->sale_type_wise_sale_record($Salestype,$Sales_startdate,$Sales_enddate);
            }
             $data["invoive"]="All";
        }
        if($searchtype == "Customer"){
            if($Salestype == 'All'){

                $data['records'] = $this->Sale_model->customer_wise_sale_record($customerID,$Sales_startdate,$Sales_enddate);

            }else{
                $data['records'] = $this->Sale_model->sale_type_wise_sale_record($Salestype,$Sales_startdate,$Sales_enddate);
            }
            $data["invoive"]="";
        }
        if($searchtype == "invoice"){
            if($Salestype == 'All'){
                $data['records'] = $this->Sale_model->all_sale_record_data($Sales_startdate,$Sales_enddate);
                $data["invoive"]="invoice";
            }else{
                $data['records'] = $this->Sale_model->cus_sale_record_data($Salestype,$Sales_startdate,$Sales_enddate);
                $data["invoive"]="invoice";
            }
        }
        if($searchtype == "Qty"){
            if($productID == 'All' && $customerID == 'All'){
                $data['records'] = $this->Sale_model->all_product_sale_qty($Sales_startdate,$Sales_enddate);
            }else if($productID == 'All' && $customerID != 'All'){
                $data['records'] = $this->Sale_model->customer_wise_product_sale_qty($customerID, $Sales_startdate,$Sales_enddate);
            }else if($productID != 'All' && $customerID == 'All'){
                $data['records'] = $this->Sale_model->product_sale_qty($productID, $Sales_startdate,$Sales_enddate);
            }else{
                $data['records'] = $this->Sale_model->customer_and_product_sale_qty($productID,$customerID, $Sales_startdate,$Sales_enddate);
            }
            $data["invoive"]="Qty";
        }

        if($searchtype == "User"){
             
                $data['records'] = $this->Sale_model->all_sale_record_data_by_user($adminId, $Sales_startdate,$Sales_enddate);
                $data["invoive"]="User";
        } 

        $this->load->view('Administrator/reports/sales_record_print', $data);
    }
	
    function sales_record_print($invoce)  { 
        $datas["SalesID"] = $invoce;
        $datas['selse'] = $this->Sale_model->get_sales_master_info($invoce);
        $this->load->view('Administrator/reports/sales_invoice', $datas);
    }
    function sales_stock()  {
        $datas['title'] = "Sales Stock";
        $this->load->view('Administrator/reports/sales_sotck', $datas);
    }
    function purchase_stock()  {
        $datas['title'] = "Purchase Stock";
        $this->load->view('Administrator/reports/purchase_stock', $datas);
    }
    function search_supplier_due()  {
        $searchtype = $this->session->userdata('searchtype');
        $Purchase_startdate = $this->session->userdata('Purchase_startdate');
        $Purchase_enddate = $this->session->userdata('Purchase_enddate');
        $Supplierid = $this->session->userdata('Supplierid');
        if($searchtype == "All"){
           $data['records'] = $this->Report_model->all_supplier_due_report();
        }
        if($searchtype == "Supplier"){
            $data['records'] = $this->Report_model->supplier_wise_due_report($Supplierid);
        }

        $this->load->view('Administrator/reports/supplier_due_list_print', $data);
    }
    function search_customer_due()  {
        $searchtype = $this->session->userdata('searchtype');
        $Sales_startdate = $this->session->userdata('Sales_startdate');
        $Sales_enddate = $this->session->userdata('Sales_enddate');
        $customerID = $this->session->userdata('customerID');
        if($searchtype == "All"){
            //$sql = "SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SaleMaster_SaleDate between  '$Sales_startdate' and '$Sales_enddate' group by tbl_salesmaster.SalseCustomer_IDNo";
            $sql = "SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_customer left join  tbl_salesmaster  on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo  WHERE tbl_salesmaster.SaleMaster_branchid = '$this->brunch' group by tbl_customer.Customer_SlNo";
        }
        if($searchtype == "Customer"){
            //$sql = "SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SalseCustomer_IDNo = '$customerID' and  tbl_salesmaster.SaleMaster_SaleDate between  '$Sales_startdate' and '$Sales_enddate' group by tbl_salesmaster.SalseCustomer_IDNo";
            $sql = "SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SalseCustomer_IDNo = '$customerID' And tbl_salesmaster.SaleMaster_branchid = '$this->brunch'  group by tbl_salesmaster.SalseCustomer_IDNo";
        }
		$result = $this->db->query($sql);
        $datas["record"] = $result->result();
        
        $this->load->view('Administrator/reports/customer_due_print', $datas);
    }
    public function cusDuePrint($customerID)
    {
        $Sales_startdate = $this->session->userdata('Sales_startdate');
        $Sales_enddate = $this->session->userdata('Sales_enddate');

        $datas["record"] = $this->db->join('tbl_customer','tbl_customer.Customer_SlNo=tbl_salesmaster.SalseCustomer_IDNo','left')
                                                          ->where('tbl_salesmaster.SalseCustomer_IDNo',$customerID)
                                                          ->where('tbl_salesmaster.SaleMaster_branchid',$this->brunch)
                                                          ->group_by('tbl_salesmaster.SalseCustomer_IDNo')
                                                          ->get('tbl_salesmaster')->result();

        
        $this->load->view('Administrator/reports/customer_due_print', $datas);
        
    }
    function supplier_payment_print()  {
        $searchtype = $this->session->userdata('searchtype');
        $Purchase_startdate = $this->session->userdata('Purchase_startdate');
        $Purchase_enddate = $this->session->userdata('Purchase_enddate');
        $Supplierid = $this->session->userdata('Supplierid');
        if($searchtype == "All"){
            $sql = "SELECT tbl_supplier_payment.*, tbl_supplier.* FROM tbl_supplier_payment left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_supplier_payment.SPayment_customerID WHERE tbl_supplier_payment.SPayment_date between  '$Purchase_startdate' and '$Purchase_enddate'";
        }
        if($searchtype == "Supplier"){
            $sql = "SELECT tbl_supplier_payment.*, tbl_supplier.* FROM tbl_supplier_payment left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_supplier_payment.SPayment_customerID WHERE tbl_supplier_payment.SPayment_customerID = '$Supplierid' and  tbl_supplier_payment.SPayment_date between  '$Purchase_startdate' and '$Purchase_enddate'";
        }
		$result = $this->db->query($sql);
        $datas["recordss"] = $result->row();
        $datas["record"] = $result->result();
        $this->load->view('Administrator/reports/supplier_payment_print', $datas);
    }


    function customer_payment_print()  {
        $searchtype = $this->session->userdata('searchtype');
		$startdate = $this->session->userdata('startdate');
		$enddate = $this->session->userdata('enddate');
        $customerID = $this->session->userdata('customerID');
        if($searchtype == "All"){
            
            $sql = "SELECT  tbl_customer_payment.*, tbl_customer.* FROM tbl_customer_payment left join tbl_customer on tbl_customer.Customer_SlNo = tbl_customer_payment.CPayment_customerID WHERE tbl_customer.Customer_brunchid='$this->brunch' AND tbl_customer_payment.CPayment_date between  '$startdate' and '$enddate'";
			$result = $this->db->query($sql);

		}
        if($searchtype == "Customer"){
			$this->db->select('tbl_customer_payment.*, tbl_customer.*');
			$this->db->from('tbl_customer_payment');
			$this->db->join('tbl_customer', 'tbl_customer_payment.CPayment_customerID = tbl_customer.Customer_SlNo', 'left');
			$this->db->where('tbl_customer_payment.CPayment_customerID',$customerID);
			$this->db->where('tbl_customer_payment.CPayment_date >=', $startdate)->where('tbl_customer_payment.CPayment_date <=', $enddate);
			$result = $this->db->get();
		}

        $datas["recordss"] = $result->row();
        $datas["record"] = $result->result();
         
        $this->load->view('Administrator/reports/customer_payment_print', $datas);
    }
    function customer_due_payment(){
        $datas['title'] = "Customer Due Payment";
        $this->load->view('Administrator/reports/customer_due_payment', $datas);
    }

    public function current_stock(){
        $category = $this->session->userdata("brand");
        $branchID = $this->session->userdata("BRANCHid");
         
        if ($category=='All') {
            $sql ="SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' group by tbl_purchasedetails.Product_IDNo";

            $result2 = $this->db->select('ProductCategory_ID')->from('tbl_product')->distinct('ProductCategory_ID')->get();
        }
        else{        
        $sql = "SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_product.ProductCategory_ID='$category' AND  tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' group by tbl_purchasedetails.Product_IDNo";

        $result2 = $this->db->select('ProductCategory_ID')->from('tbl_product')->distinct('ProductCategory_ID')->get();
        }
        $result = $this->db->query($sql);
        $datas['recordData'] = $result->result();
        $datas['brandDistinct'] = $result2->result();
        $datas['all'] = $category;
		$datas['branchID'] =  $this->session->userdata("BRANCHid");
        $this->load->view('Administrator/reports/current_stock', $datas);
    }
	
    public function stockAvailable(){
        $data['title'] = "Stock Available";
		$branchID = $this->session->userdata("BRANCHid");
        $sql ="SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' group by tbl_purchasedetails.Product_IDNo";
        
		$result = $this->db->query($sql);
		$data['record'] = $result->result();
		$data['branchID'] =  $this->session->userdata("BRANCHid");
        $this->load->view('Administrator/reports/stock_available', $data);
    }
	
    function total_stock(){
        $datas['title'] = "Total Stock";
		$this->load->view('Administrator/reports/total_stock', $datas);
    }
	
    function branch_stock()  {
        $datas['title'] = "Branch Stock";
        $this->load->view('Administrator/reports/branch_stock', $datas);
    }
	
    function expense_print()  {
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
        $accountid = $this->session->userdata('accountid');
        $searchtype = $this->session->userdata('searchtype');
         $BRANCHid = $this->session->userdata('BRANCHid');
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Out Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Out Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$result = $this->db->query($sql);
        $datas["record"] = $result->result();
        
        $this->load->view('Administrator/reports/expense_list', $datas);
    }
    
    function transaction_report_print()  {
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
        $accountid = $this->session->userdata('accountid');
        $searchtype = $this->session->userdata('searchtype');
        $BRANCHid = $this->session->userdata('BRANCHid');

        if($searchtype == 'Account'){
            if($accountid == 'All'){
                $result = $this->Other_model->transaction_account_all('A');
            }else{
                $result = $this->Other_model->transaction_by_account('A',$accountid);
            }
        }elseif($searchtype == 'Received'){
            if($accountid == 'All'){
                $result = $this->Other_model->transaction_account_all('R');
            }else{
                $result = $this->Other_model->transaction_by_account('R',$accountid);
            }
        }else{
            if($accountid == 'All'){
                $result = $this->Other_model->transaction_account_all('P');
            }else{
                $result = $this->Other_model->transaction_by_account('P',$accountid);
            }
        }

        
        $datas["record"] = $result;
        
        $this->load->view('Administrator/reports/transaction_list_print', $datas);
    }
    
    function deposit_print()  {
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
        $accountid = $this->session->userdata('accountid');
        $searchtype = $this->session->userdata('searchtype');
         $BRANCHid = $this->session->userdata('BRANCHid');
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Deposit To Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
           // $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_date between '$expence_startdate' and '$expence_enddate'";
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Deposit To Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        $result = $this->db->query($sql);
        $datas["record"] = $result->result();
        
        $this->load->view('Administrator/reports/deposit_list', $datas);
    }
	
    function withdraw_print()  {
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
        $accountid = $this->session->userdata('accountid');
        $searchtype = $this->session->userdata('searchtype');
		$BRANCHid = $this->session->userdata('BRANCHid');
       
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Withdraw Form Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
           // $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_date between '$expence_startdate' and '$expence_enddate'";
			$sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Withdraw Form Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$result = $this->db->query($sql);
        $datas["record"] = $result->result();
        
        $this->load->view('Administrator/reports/withdraw_list', $datas);
    }
	
    function income_print()  {
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
        $accountid = $this->session->userdata('accountid');
        $searchtype = $this->session->userdata('searchtype');
		$BRANCHid = $this->session->userdata('BRANCHid');
       
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='In Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
			$sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='In Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$result = $this->db->query($sql);
        $datas["record"] = $result->result();
        
        $this->load->view('Administrator/reports/income_list', $datas);
    }
	
    function cashview_print()  {
        $sql = $this->db->query("SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID ");
        $datas["record"] = $sql->result();
        $this->load->view('Administrator/reports/cashview_print', $datas);
    }
    function salesreturnlist(){
        $this->load->view('Administrator/reports/salesreturnlist');
    }
    function purchase_returnlist(){
        $this->load->view('Administrator/reports/purchase_return_list');
    }
    function customerwise_sales(){
        $this->load->view('Administrator/reports/customerwise_sales');
    }
    function productwise_sales(){
        $this->load->view('Administrator/reports/productwise_sales');
    }
    function customerwise_branch_sales(){
        $this->load->view('Administrator/reports/customerwise_branch_sales');
    }
    function daily_cashview_print(){
        $this->load->view('Administrator/reports/daily_cashview_print');
    }
    function datewise_cashview_print(){
        $this->load->view('Administrator/reports/datewise_cashview_print');
    }

    function branchwise_invoice_product_list(){
        $this->load->view('Administrator/reports/invoice_product_list');
    }

    function customer_advance_payment(){
        $this->load->view('Administrator/reports/customer_advance_payment');
    }
	
	public function productlist()
	{
		$data['title']  = 'Product List';
        $data['content'] = $this->load->view('Administrator/reports/productList', $data, true);
        $this->load->view('Administrator/index', $data);
	}
	
	 public function cashStatment() {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $datas['title'] = "Cash Statement"; 
        $data['content'] = $this->load->view('Administrator/reports/cashStatement', $datas, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    public function cashStatmentList() {
        $brunch = $this->session->userdata('BRANCHid');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
		
		$date = array(
        'startdate'  => $this->input->post('startdate'),
        'enddate'     => $this->input->post('enddate'),
		);
		$this->session->set_userdata($date);
	
        $datas["saleRecords"] = $this->Sale_model->full_sale_statment($startdate, $enddate);
        $datas["purchaseRecords"] = $this->Purchase_model->full_purchase_statment($startdate, $enddate);
        $datas["expenseRecords"] = $this->Billing_model->cash_transaction($startdate, $enddate);
        $this->load->view('Administrator/reports/cashStatementList', $datas);

    }

    public function cashStatmentListPrint(){
        $data['title'] = "Balance Sheet Print";
		$brunch = $this->session->userdata('BRANCHid');
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
		
        $datas["saleRecords"] = $this->Sale_model->full_sale_statment($startdate, $enddate);
        $datas["purchaseRecords"] = $this->Purchase_model->full_purchase_statment($startdate, $enddate);
        $datas["expenseRecords"] = $this->Billing_model->cash_transaction($startdate, $enddate);
        $this->load->view('Administrator/reports/cashStatementPrint', $datas);
    }
	
    public function balance_sheet_report_branch_wise($id = null) {
        $brunch = $id;
        
        if($brunch == 'All'):
            $sqlSales = $this->db->query("SELECT tbl_salesmaster.*, tbl_salereturn.SaleMaster_InvoiceNo as saleReturnInv, tbl_salereturn.SaleReturn_ReturnAmount FROM tbl_salesmaster left join tbl_salereturn on tbl_salereturn.SaleMaster_InvoiceNo = tbl_salesmaster.SaleMaster_InvoiceNo");
            $sqlPurchase = $this->db->query("SELECT tbl_purchasemaster.*, tbl_purchasereturn.PurchaseMaster_InvoiceNo as purReturnInv, tbl_purchasereturn.PurchaseReturn_ReturnAmount FROM tbl_purchasemaster left join tbl_purchasereturn on tbl_purchasereturn.PurchaseMaster_InvoiceNo = tbl_purchasemaster.PurchaseMaster_InvoiceNo");

            $sqlExpense = $this->db->query("SELECT * FROM tbl_cashtransaction");
            $customerPayment = $this->db->query("SELECT * FROM tbl_customer_payment");
            $supplierPayment = $this->db->query("SELECT * FROM tbl_supplier_payment");
        else:
            $sqlSales = $this->db->query("SELECT tbl_salesmaster.*, tbl_salereturn.SaleMaster_InvoiceNo as saleReturnInv, tbl_salereturn.SaleReturn_ReturnAmount FROM tbl_salesmaster left join tbl_salereturn on tbl_salereturn.SaleMaster_InvoiceNo = tbl_salesmaster.SaleMaster_InvoiceNo where tbl_salesmaster.SaleMaster_branchid = '$brunch'");
            $sqlPurchase = $this->db->query("SELECT tbl_purchasemaster.*, tbl_purchasereturn.PurchaseMaster_InvoiceNo as purReturnInv, tbl_purchasereturn.PurchaseReturn_ReturnAmount FROM tbl_purchasemaster left join tbl_purchasereturn on tbl_purchasereturn.PurchaseMaster_InvoiceNo = tbl_purchasemaster.PurchaseMaster_InvoiceNo where tbl_purchasemaster.PurchaseMaster_BranchID = '$brunch'");

            $sqlExpense = $this->db->query("SELECT * FROM tbl_cashtransaction where Tr_branchid = '$brunch'");
            $customerPayment = $this->db->query("SELECT * FROM tbl_customer_payment where CPayment_brunchid = '$brunch'");
            $supplierPayment = $this->db->query("SELECT * FROM tbl_supplier_payment where SPayment_brunchid = '$brunch'");
        endif;
        
        $datas["saleRecords"] = $sqlSales->result();
        $datas["purchaseRecords"] = $sqlPurchase->result();
        $datas["expenseRecords"] = $sqlExpense->result();
        $datas["customerPayment"] = $customerPayment->result();
        $datas["supplierPayment"] = $supplierPayment->result();

        $this->load->view('Administrator/reports/balanceSheetReportBranchWise', $datas);
    }


    public function balanceSheet() {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $datas['title'] = "Balance In Out";
        $data['content'] = $this->load->view('Administrator/reports/balanceSheet', $datas, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    	
    public function balanceSheetList() {
        $brunch = $this->session->userdata('BRANCHid');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
		
		$date = array(
        'startdate'  => $this->input->post('startdate'),
        'enddate'     => $this->input->post('enddate'),
		);
		$this->session->set_userdata($date);
		
        $datas["saleRecords"] = $this->Sale_model->full_sale_statment($startdate, $enddate);
        $datas["purchaseRecords"] = $this->Purchase_model->full_purchase_statment($startdate, $enddate);
        $datas["expenseRecords"] = $this->Billing_model->cash_transaction($startdate, $enddate);
        $datas["customerPayment"] = $this->Customer_model->customer_payment_statment($startdate, $enddate);
        $datas["supplierPayment"] = $this->Other_model->supplier_payment_statment($startdate, $enddate);
    
        $this->load->view('Administrator/reports/balanceSheetList', $datas);

    }

    public function balanceSheetListPrint(){
        $data['title'] = "Balance Sheet Print";
		$brunch = $this->session->userdata('BRANCHid');
        $startdate = $this->session->userdata('startdate');
        $enddate = $this->session->userdata('enddate');
		
        $datas["saleRecords"] = $this->Sale_model->full_sale_statment($startdate, $enddate);
        $datas["purchaseRecords"] = $this->Purchase_model->full_purchase_statment($startdate, $enddate);
        $datas["expenseRecords"] = $this->Billing_model->cash_transaction($startdate, $enddate);
        $datas["customerPayment"] = $this->Customer_model->customer_payment_statment($startdate, $enddate);
        $datas["supplierPayment"] = $this->Other_model->supplier_payment_statment($startdate, $enddate);
        $this->load->view('Administrator/reports/balanceSheetPrint', $datas);
    }
		
    public function branch_stock_print(){
		$data['Branch_ID'] = $BranchID = $this->session->userdata('Branch_ID');
        $data['Branch_category'] = $category = $this->session->userdata('Branch_category');
        $this->session->set_userdata($data);
		if($category != 'All'){
			$this->db->SELECT("tbl_product.*, tbl_productcategory.*,tbl_unit.*,tbl_color.*,tbl_brand.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID left join tbl_unit on tbl_unit.Unit_SlNo=tbl_product.Unit_ID  LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand LEFT JOIN tbl_country ON tbl_country.Country_SlNo=tbl_product.country where tbl_product.ProductCategory_ID = '$category' AND tbl_product.Product_branchid = '$BranchID'");
			$query = $this->db->get();
			$result = $query->result();
			$data['product'] = $result;
			$data['show'] = 1;
		}else{
			$this->db->SELECT('*');
			$this->db->from('tbl_productcategory');
			$this->db->where('category_branchid',$BranchID);
			$query = $this->db->get();
			$category = $query->result();
			
			foreach($category as $vcategory)
			{
				$categoryid = $vcategory->ProductCategory_SlNo;
				$this->db->SELECT("tbl_product.*, tbl_productcategory.*,tbl_unit.*,tbl_color.*,tbl_brand.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID left join tbl_unit on tbl_unit.Unit_SlNo=tbl_product.Unit_ID  LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand LEFT JOIN tbl_country ON tbl_country.Country_SlNo=tbl_product.country where tbl_product.ProductCategory_ID = '$categoryid' AND tbl_product.Product_branchid = '$BranchID'");
				$query = $this->db->get();
				$productCat[] = $query->result();
			}
			
			$data['category'] = $category;
			$data['productCat'] = @$productCat;
			$data['show'] = 0;
		}
        $this->load->view('Administrator/reports/branch_stock_print', $data);
    }
	
	public function selectOne($value){
		if($value == 'Category')
		{
			$category = $this->Billing_model->select_category_by_branch($this->brunch);
			?>
			<select id="category"  data-placeholder="Choose a Category ....." class="chosen-select" style="width:200px">
				<option value=""></option>		
			<?php
			foreach($category as $vcategory)
			{
			?>
				<option value="<?php echo $vcategory->ProductCategory_SlNo; ?>"><?php echo $vcategory->ProductCategory_Name; ?></option>
			<?php
			}
			?>
			</select>
			<?php
		}else{
			$products = $this->Product_model->products_by_brunch();
			//echo "<pre>";print_r($product);exit;
			?>
			<select id="product"  data-placeholder="Choose a Product ....." class="chosen-select" style="width:200px">
				<option value=""></option>		
			<?php
			foreach($products as $product)
			{
			?>
				<option value="<?php echo $product->Product_SlNo; ?>"><?php echo $product->Product_Name; ?>-<?php echo $product->Product_Code; ?></option>
			<?php
			}
			?>
			</select>
			<?php
		}
	}
	
	public function price_list_report(){
		$session['select_one'] = $select_one = $this->input->post('select_one');
		$session['category'] = $category = $this->input->post('category');
		$session['product'] = $product = $this->input->post('product');
		$this->session->set_userdata($session);

		if($select_one =='All'){
			$data['products'] = $this->Product_model->get_all_product_price_list();
		}elseif($select_one == 'Category'){
			$data['category'] = $this->Other_model->get_single_category_info($category);
		}elseif($select_one == 'Product'){
			$data['products'] = $this->Product_model->get_singel_product_pice_list($product);
        }
        
		$this->load->view('Administrator/reports/price_list_search', $data);
	}
	
	public function profitLossPrint(){
		$data['searchtype'] = $this->session->userdata('searchtype');
		$data['ProductID'] = $this->session->userdata('ProductID');
		$data['startdate'] = $this->session->userdata('startdate');
		$data['enddate'] = $this->session->userdata('enddate');
		$this->load->view('Administrator/reports/profit_loss',$data);
    }
    
    public function reOrderList(){
        $data['title'] = "Re-Order List";
        $data['content'] = $this->load->view('Administrator/reports/reorder_list', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function dayBook(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Daily Book";
        $data['content'] = $this->load->view('Administrator/reports/day_book', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function balance_sheet() {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $datas['title'] = "Balance Sheet";
        $data['content'] = $this->load->view('Administrator/reports/balance_sheet', $datas, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    public function getBalanceSheet()
    {
        $res = [ 'success'   => false, 'message'  => 'Invalid' ];

        try {
            $branchId = $this->brunch;
            $data       = json_decode($this->input->raw_input_stream);
            $date       = null;

            if(isset($data->date) && $data->date != ''){
                $date = new DateTime($data->date);
                $date = $date->modify('+1 day')->format('Y-m-d');
            }
            
            $cash_balance = $this->mt->getTransactionSummary($date)->cash_balance;
            $bank_accounts = $this->mt->getBankTransactionSummary(null, $date);
            $loan_accounts = $this->mt->getLoanTransactionSummary(null, $date);
            $invest_accounts = $this->mt->getInvestmentTransactionSummary(null, $date);

            //assets
            $assets = $this->mt->assetsReport('', $date);

            $assets = array_reduce($assets, function($prev, $curr){ return $prev + $curr->approx_amount;});

            //customer prev due adjust
            $customer_prev_due = $this->db->query("
                SELECT ifnull(sum(previous_due), 0) as amount
                from tbl_customer
                where Customer_brunchid = '$this->brunch'
            ")->row()->amount;

            //customer dues
            $customer_dues = $this->mt->customerDue(" and c.status = 'a'", $date);
            $bad_debts = $this->mt->customerDue(" and c.status = 'd'", $date);

            $customer_dues = array_reduce($customer_dues, function($prev, $curr){ return $prev + $curr->dueAmount;});

            $bad_debts = array_reduce($bad_debts, function($prev, $curr){ return $prev + $curr->dueAmount;});

            //stock values
            $stocks = $this->db->query("
                select
                    (select ifnull(sum(pd.PurchaseDetails_TotalQuantity), 0) 
                        from tbl_purchasedetails pd 
                        join tbl_purchasemaster pm on pm.PurchaseMaster_SlNo = pd.PurchaseMaster_IDNo
                        where pd.Product_IDNo = p.Product_SlNo
                        and pd.PurchaseDetails_branchID = '$branchId'
                        and pd.Status = 'a'
                        " . (isset($date) && $date != null ? " and pm.PurchaseMaster_OrderDate < '$date'" : "") . "
                    ) as purchased_quantity,
                            
                    (select ifnull(sum(prd.PurchaseReturnDetails_ReturnQuantity), 0) 
                        from tbl_purchasereturndetails prd 
                        join tbl_purchasereturn pr on pr.PurchaseReturn_SlNo = prd.PurchaseReturn_SlNo
                        where prd.PurchaseReturnDetailsProduct_SlNo = p.Product_SlNo
                        and prd.PurchaseReturnDetails_brachid = '$branchId'
                        " . (isset($date) && $date != null ? " and pr.PurchaseReturn_ReturnDate < '$date'" : "") . "
                    ) as purchase_returned_quantity,
                            
                    (select ifnull(sum(sd.SaleDetails_TotalQuantity), 0) 
                        from tbl_saledetails sd
                        join tbl_salesmaster sm on sm.SaleMaster_SlNo = sd.SaleMaster_IDNo
                        where sd.Product_IDNo = p.Product_SlNo
                        and sd.SaleDetails_BranchId  = '$branchId'
                        and sd.Status = 'a'
                        " . (isset($date) && $date != null ? " and sm.SaleMaster_SaleDate < '$date'" : "") . "
                    ) as sold_quantity,
                            
                    (select ifnull(sum(srd.SaleReturnDetails_ReturnQuantity), 0)
                        from tbl_salereturndetails srd 
                        join tbl_salereturn sr on sr.SaleReturn_SlNo = srd.SaleReturn_IdNo
                        where srd.SaleReturnDetailsProduct_SlNo = p.Product_SlNo
                        and srd.SaleReturnDetails_brunchID = '$branchId'
                        " . (isset($date) && $date != null ? " and sr.SaleReturn_ReturnDate < '$date'" : "") . "
                    ) as sales_returned_quantity,
                            
                    (select ifnull(sum(dmd.DamageDetails_DamageQuantity), 0) 
                        from tbl_damagedetails dmd
                        join tbl_damage dm on dm.Damage_SlNo = dmd.Damage_SlNo
                        where dmd.Product_SlNo = p.Product_SlNo
                        and dmd.status = 'a'
                        and dm.Damage_brunchid = '$branchId'
                        " . (isset($date) && $date != null ? " and dm.Damage_Date < '$date'" : "") . "
                    ) as damaged_quantity,
                
                    (select ifnull(sum(trd.quantity), 0)
                        from tbl_transferdetails trd
                        join tbl_transfermaster tm on tm.transfer_id = trd.transfer_id
                        where trd.product_id = p.Product_SlNo
                        and tm.transfer_from = '$branchId'
                        " . (isset($date) && $date != null ? " and tm.transfer_date < '$date'" : "") . "
                    ) as transferred_from_quantity,

                    (select ifnull(sum(trd.quantity), 0)
                        from tbl_transferdetails trd
                        join tbl_transfermaster tm on tm.transfer_id = trd.transfer_id
                        where trd.product_id = p.Product_SlNo
                        and tm.transfer_to = '$branchId'
                        " . (isset($date) && $date != null ? " and tm.transfer_date < '$date'" : "") . "
                    ) as transferred_to_quantity,
                            
                    (select (purchased_quantity + sales_returned_quantity + transferred_to_quantity) - (sold_quantity + purchase_returned_quantity + damaged_quantity + transferred_from_quantity)) as current_quantity,
                    (select p.Product_Purchase_Rate * current_quantity) as stock_value
                from tbl_product p
                where p.status = 'a' 
                and p.is_service = 'false'
            ")->result();

            $stock_value = array_sum(
                array_map(function($product){
                    return $product->stock_value;
                }, $stocks));

            //supplier prev due adjust
            $supplier_prev_due = $this->db->query("
                SELECT ifnull(sum(previous_due), 0) as amount
                from tbl_supplier
                where Supplier_brinchid = '$this->brunch'
            ")->row()->amount;

            //supplier due
            $supplier_dues = $this->mt->supplierDue("", $date);

            $supplier_dues = array_reduce($supplier_dues, function($prev, $curr){ return $prev + $curr->due;});

            //profit loss
            $sales = $this->db->query("
                select 
                    sm.*
                from tbl_salesmaster sm
                where sm.SaleMaster_branchid = ? 
                and sm.Status = 'a'
                " . ($date == null ? "" : " and sm.SaleMaster_SaleDate < '$date'") . "
            ", $this->session->userdata('BRANCHid'))->result();

            foreach($sales as $sale){
                $sale->saleDetails = $this->db->query("
                    select
                        sd.*,
                        (sd.Purchase_Rate * sd.SaleDetails_TotalQuantity) as purchased_amount,
                        (select sd.SaleDetails_TotalAmount - purchased_amount) as profit_loss
                    from tbl_saledetails sd
                    where sd.SaleMaster_IDNo = ?
                ", $sale->SaleMaster_SlNo)->result();
            }

            $profits = array_reduce($sales, function($prev, $curr){ 
                return $prev + array_reduce($curr->saleDetails, function($p, $c){
                    return $p + $c->profit_loss;
                });
            });

            $total_transport_cost = array_reduce($sales, function($prev, $curr){ 
                return $prev + $curr->SaleMaster_Freight;
            });
            
            $total_discount = array_reduce($sales, function($prev, $curr){ 
                return $prev + $curr->SaleMaster_TotalDiscountAmount;
            });

            $total_vat = array_reduce($sales, function($prev, $curr){ 
                return $prev + $curr->SaleMaster_TaxAmount;
            });


            $other_income_expense = $this->db->query("
                select
                (
                    select ifnull(sum(ct.In_Amount), 0)
                    from tbl_cashtransaction ct
                    where ct.Tr_branchid = '" . $this->session->userdata('BRANCHid') . "'
                    and ct.status = 'a'
                    " . ($date == null ? "" : " and ct.Tr_date < '$date'") . "
                ) as income,
            
                (
                    select ifnull(sum(ct.Out_Amount), 0)
                    from tbl_cashtransaction ct
                    where ct.Tr_branchid = '" . $this->session->userdata('BRANCHid') . "'
                    and ct.status = 'a'
                    " . ($date == null ? "" : " and ct.Tr_date < '$date'") . "
                ) as expense,

                (
                    select ifnull(sum(it.amount), 0)
                    from tbl_investment_transactions it
                    where it.branch_id = '" . $this->session->userdata('BRANCHid') . "'
                    and it.transaction_type = 'Profit'
                    and it.status = 1
                    " . ($date == null ? "" : " and it.transaction_date < '$date'") . "
                ) as profit_distribute,

                (
                    select ifnull(sum(lt.amount), 0)
                    from tbl_loan_transactions lt
                    where lt.branch_id = '" . $this->session->userdata('BRANCHid') . "'
                    and lt.transaction_type = 'Interest'
                    and lt.status = 1
                    " . ($date == null ? "" : " and lt.transaction_date < '$date'") . "
                ) as loan_interest,

                (
                    select ifnull(sum(a.valuation - a.as_amount), 0)
                    from tbl_assets a
                    where a.branchid = '" . $this->session->userdata('BRANCHid') . "'
                    and a.buy_or_sale = 'sale'
                    and a.status = 'a'
                    " . ($date == null ? "" : " and a.as_date < '$date'") . "
                ) as assets_sales_profit_loss,
            
                (
                    select ifnull(sum(ep.total_payment_amount), 0)
                    from tbl_employee_payment ep
                    where ep.branch_id = '" . $this->session->userdata('BRANCHid') . "'
                    and ep.status = 'a'
                    " . ($date == null ? "" : " and ep.payment_date < '$date'") . "
                ) as employee_payment,

                (
                    select ifnull(sum(dd.damage_amount), 0) 
                    from tbl_damagedetails dd
                    join tbl_damage d on d.Damage_SlNo = dd.Damage_SlNo
                    where d.Damage_brunchid = '" . $this->session->userdata('BRANCHid') . "'
                    and dd.status = 'a'
                    " . ($date == null ? "" : " and d.Damage_Date  < '$date'") . "
                ) as damaged_amount,

                (
                    select ifnull(sum(rd.SaleReturnDetails_ReturnAmount) - sum(sd.Purchase_Rate * rd.SaleReturnDetails_ReturnQuantity), 0)
                    from tbl_salereturndetails rd
                    join tbl_salereturn r on r.SaleReturn_SlNo = rd.SaleReturn_IdNo
                    join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = r.SaleMaster_InvoiceNo
                    join tbl_saledetails sd on sd.Product_IDNo = rd.SaleReturnDetailsProduct_SlNo and sd.SaleMaster_IDNo = sm.SaleMaster_SlNo
                    where r.Status = 'a'
                    and r.SaleReturn_brunchId = '" . $this->session->userdata('BRANCHid') . "'
                    " . ($date == null ? "" : " and r.SaleReturn_ReturnDate  < '$date'") . "
                ) as returned_amount
            ")->row();

            $net_profit = ($profits + $total_transport_cost + $other_income_expense->income + $total_vat) - ($total_discount + $other_income_expense->returned_amount + $other_income_expense->damaged_amount + $other_income_expense->expense + $other_income_expense->employee_payment + $other_income_expense->profit_distribute + $other_income_expense->loan_interest + $other_income_expense->assets_sales_profit_loss );

            $statements = [
                'assets'            => $assets,
                'cash_balance'      => $cash_balance,
                'bank_accounts'     => $bank_accounts,
                'loan_accounts'     => $loan_accounts,
                'invest_accounts'   => $invest_accounts,
                'customer_dues'     => $customer_dues,
                'supplier_dues'     => $supplier_dues,
                'bad_debts'         => $bad_debts,
                'supplier_prev_due' => $supplier_prev_due,
                'customer_prev_due' => $customer_prev_due,
                'stock_value'       => $stock_value,
                'net_profit'        => $net_profit,
            ];

            $res = [ 'success'   => true, 'statements'  => $statements ];

        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function materialList()
	{
		$data['title']  = 'Materials';
        $data['materials'] = $this->db->query("
            select
            m.*,
            c.ProductCategory_Name as category_name
            from tbl_materials m
            join tbl_productcategory c on c.ProductCategory_SlNo = m.category_id
        ")->result();
		$this->load->view('Administrator/reports/materialList', $data);
    }
}
