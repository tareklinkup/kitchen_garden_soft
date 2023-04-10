<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->sbrunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
        $this->load->model('Billing_model');
        $this->load->library('cart');
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->helper('form');
        $this->load->model('SMS_model', 'sms', true);
    }
    
    public function index($serviceOrProduct = 'product')  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $this->cart->destroy();
        $this->session->unset_userdata('cheque');
        $data['title'] = "Product Sales";
        
        $invoice = $this->mt->generateSalesInvoice();

        $data['isService'] = $serviceOrProduct == 'product' ? 'false' : 'true';
        $data['salesId'] = 0;
        $data['invoice'] = $invoice;
        $data['content'] = $this->load->view('Administrator/sales/product_sales', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    
    //Designation
    function selectCustomer()  {
        $Custid = $this->input->post('cid');

        $data['due'] = $this->mt->getCustomerDueById($Custid);

        $query = $this->db->query("SELECT * FROM tbl_customer where Customer_SlNo = '$Custid'");   
        $data['customer'] = $query->row();
        $this->load->view('Administrator/sales/ajax_customer', $data);
    }
    function SelectProducts()  {
        $ProID = $this->input->post('ProID');
        $data['SalesFrom'] = $this->input->post('SalesFrom');
        $query = $this->db->query("
            SELECT
            tbl_product.*,
            tbl_unit.*, 
            tbl_brand.*
            FROM tbl_product 
            left join tbl_unit on tbl_unit.Unit_SlNo = tbl_product.Unit_ID 
            left join tbl_brand on tbl_brand.brand_SiNo = tbl_product.brand 
            where tbl_product.Product_SlNo = '$ProID'
        ");
        $data['product'] = $query->row();
        //echo "<pre>";print_r($data['Product']);exit;
        $this->load->view('Administrator/sales/ajax_product', $data);
    }

    function SelectCatWiseSaleProduct(){
        $data['ProCat'] = $this->input->post('ProCat');
        
        $this->load->view('Administrator/sales/ajax_CatWiseProduct', $data);
    }

    public function addSales(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $invoice = $data->sales->invoiceNo;
            $invoiceCount = $this->db->query("select * from tbl_salesmaster where SaleMaster_InvoiceNo = ?", $invoice)->num_rows();
            if($invoiceCount != 0){
                $invoice = $this->mt->generateSalesInvoice();
            }

            $customerId = $data->sales->customerId;
            if(isset($data->customer)){
                $customer = (array)$data->customer;
                unset($customer['Customer_SlNo']);
                unset($customer['display_name']);
                $customer['Customer_Code'] = $this->mt->generateCustomerCode();
                $customer['status'] = 'a';
                $customer['AddBy'] = $this->session->userdata("FullName");
                $customer['AddTime'] = date("Y-m-d H:i:s");
                $customer['Customer_brunchid'] = $this->session->userdata("BRANCHid");

                $this->db->insert('tbl_customer', $customer);
                $customerId = $this->db->insert_id();
            }

            $sales = array(
                'SaleMaster_InvoiceNo' => $invoice,
                'SalseCustomer_IDNo' => $customerId,
                'employee_id' => $data->sales->employeeId,
                'SaleMaster_SaleDate' => $data->sales->salesDate,
                'SaleMaster_SaleType' => $data->sales->salesType,
                'SaleMaster_TotalSaleAmount' => $data->sales->total,
                'SaleMaster_TotalDiscountAmount' => $data->sales->discount,
                'SaleMaster_TaxAmount' => $data->sales->vat,
                'SaleMaster_Freight' => $data->sales->transportCost,
                'SaleMaster_SubTotalAmount' => $data->sales->subTotal,
                'SaleMaster_PaidAmount' => $data->sales->paid,
                'SaleMaster_DueAmount' => $data->sales->due,
                'SaleMaster_Previous_Due' => $data->sales->previousDue,
                'SaleMaster_Description' => $data->sales->note,
                'Status' => 'a',
                'is_service' => $data->sales->isService,
                "AddBy" => $this->session->userdata("FullName"),
                'AddTime' => date("Y-m-d H:i:s"),
                'SaleMaster_branchid' => $this->session->userdata("BRANCHid")
            );
    
            $this->db->insert('tbl_salesmaster', $sales);
            
            $salesId = $this->db->insert_id();
    
            foreach($data->cart as $cartProduct){
                $saleDetails = array(
                    'SaleMaster_IDNo' => $salesId,
                    'Product_IDNo' => $cartProduct->productId,
                    'SaleDetails_TotalQuantity' => $cartProduct->quantity,
                    'Purchase_Rate' => $cartProduct->purchaseRate,
                    'SaleDetails_Rate' => $cartProduct->salesRate,
                    'SaleDetails_Tax' => $cartProduct->vat,
                    'SaleDetails_TotalAmount' => $cartProduct->total,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date('Y-m-d H:i:s'),
                    'SaleDetails_BranchId' => $this->session->userdata('BRANCHid')
                );
    
                $this->db->insert('tbl_saledetails', $saleDetails);
    
                //update stock
                $this->db->query("
                    update tbl_currentinventory 
                    set sales_quantity = sales_quantity + ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$cartProduct->quantity, $cartProduct->productId, $this->session->userdata('BRANCHid')]);
            }
            $currentDue = $data->sales->previousDue + ($data->sales->total - $data->sales->paid);
            //Send sms
            $customerInfo = $this->db->query("select * from tbl_customer where Customer_SlNo = ?", $customerId)->row();
            $sendToName = $customerInfo->owner_name != '' ? $customerInfo->owner_name : $customerInfo->Customer_Name;
            $currency = $this->session->userdata('Currency_Name');

            $message = "Dear {$sendToName},\nYour bill is {$currency} {$data->sales->total}. Received {$currency} {$data->sales->paid} and current due is {$currency} {$currentDue} for invoice {$invoice}";
            $recipient = $customerInfo->Customer_Mobile;
            $this->sms->sendSms($recipient, $message);
    
            $res = ['success'=>true, 'message'=>'Sales Success', 'salesId'=>$salesId];

        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function salesEdit($productOrService, $salesId){
        $data['title'] = "Sales update";
        $sales = $this->db->query("select * from tbl_salesmaster where SaleMaster_SlNo = ?", $salesId)->row();
        $data['isService'] = $productOrService == 'product' ? 'false' : 'true';
        $data['salesId'] = $salesId;
        $data['invoice'] = $sales->SaleMaster_InvoiceNo;
        $data['content'] = $this->load->view('Administrator/sales/product_sales', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getSaleDetails(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->customerId) && $data->customerId != ''){
            $clauses .= " and c.Customer_SlNo = '$data->customerId'";
        }

        if(isset($data->productId) && $data->productId != ''){
            $clauses .= " and p.Product_SlNo = '$data->productId'";
        }

        if(isset($data->categoryId) && $data->categoryId != ''){
            $clauses .= " and pc.ProductCategory_SlNo = '$data->categoryId'";
        }

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and sm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
        }

        $saleDetails = $this->db->query("
            select 
                sd.*,
                p.Product_Code,
                p.Product_Name,
                p.ProductCategory_ID,
                pc.ProductCategory_Name,
                sm.SaleMaster_InvoiceNo,
                sm.SaleMaster_SaleDate,
                c.Customer_Code,
                c.Customer_Name
            from tbl_saledetails sd
            join tbl_product p on p.Product_SlNo = sd.Product_IDNo
            join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            join tbl_salesmaster sm on sm.SaleMaster_SlNo = sd.SaleMaster_IDNo
            join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where sd.Status != 'd'
            and sm.SaleMaster_branchid = ?
            $clauses
        ", $this->sbrunch)->result();

        echo json_encode($saleDetails);
    }

    public function getSalesRecord(){
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");
        $clauses = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and sm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->userFullName) && $data->userFullName != ''){
            $clauses .= " and sm.AddBy = '$data->userFullName'";
        }

        if(isset($data->customerId) && $data->customerId != ''){
            $clauses .= " and sm.SalseCustomer_IDNo = '$data->customerId'";
        }

        if(isset($data->employeeId) && $data->employeeId != ''){
            $clauses .= " and sm.employee_id = '$data->employeeId'";
        }

        $sales = $this->db->query("
            select 
                'a' as sequence,
                sm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile,
                c.Customer_Address,
                e.Employee_Name,
                br.Brunch_name,
                (
                    select ifnull(count(*), 0) from tbl_saledetails sd 
                    where sd.SaleMaster_IDNo = 1
                    and sd.Status != 'd'
                ) as total_products
            from tbl_salesmaster sm
            left join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            left join tbl_employee e on e.Employee_SlNo = sm.employee_id
            left join tbl_brunch br on br.brunch_id = sm.SaleMaster_branchid
            where sm.SaleMaster_branchid = '$branchId'
            and sm.Status = 'a'
            $clauses
            order by sm.SaleMaster_SlNo desc

        ")->result();

        foreach($sales as $sale){
            $sale->saleDetails = $this->db->query("
                select 
                    sd.*,
                    'a' as sequence,
                    p.Product_Name,
                    pc.ProductCategory_Name
                from tbl_saledetails sd
                join tbl_product p on p.Product_SlNo = sd.Product_IDNo
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where sd.SaleMaster_IDNo = $sale->SaleMaster_SlNo
                and sd.Status != 'd'
            "
            )->result();
        }




        echo json_encode($sales);
    }
    
    public function getSales(){
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";
        $clausesb = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and sm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
            $clausesb .= " and SUBSTRING(o.created_at, 1, 10) between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->userFullName) && $data->userFullName != ''){
            $clauses .= " and sm.AddBy = '$data->userFullName'";
        }

        if(isset($data->customerId) && $data->customerId != ''){
            $clauses .= " and sm.SalseCustomer_IDNo = '$data->customerId'";
        }

        if(isset($data->employeeId) && $data->employeeId != ''){
            $clauses .= " and sm.employee_id = '$data->employeeId'";
        }

        if(isset($data->customerType) && $data->customerType != ''){
            $clauses .= " and c.Customer_Type = '$data->customerType'";
        }

        if(isset($data->salesId) && $data->salesId != 0 && $data->salesId != ''){
            $clauses .= " and SaleMaster_SlNo = '$data->salesId'";
            $saleDetails = $this->db->query("
                select 
                    sd.*,
                    p.Product_Code,
                    p.Product_Name,
                    pc.ProductCategory_Name,
                    u.Unit_Name
                from tbl_saledetails sd
                join tbl_product p on p.Product_SlNo = sd.Product_IDNo
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                join tbl_unit u on u.Unit_SlNo = p.Unit_ID
                where sd.SaleMaster_IDNo = ?
            ", $data->salesId)->result();
    
            $res['saleDetails'] = $saleDetails;
        }
        $sales = $this->db->query("
            select 
            'a' as sequence,
            'Software' as by_sale,
            sm.SaleMaster_SlNo,
            sm.SaleMaster_InvoiceNo,
            sm.SaleMaster_SaleDate,
            sm.AddBy,
            sm.SaleMaster_SubTotalAmount,
            sm.SaleMaster_TaxAmount,
            sm.SaleMaster_TotalDiscountAmount,
            sm.SaleMaster_Freight,
            sm.SaleMaster_TotalSaleAmount,
            sm.SaleMaster_PaidAmount,
            sm.SaleMaster_DueAmount,
            sm.SaleMaster_Description,
            concat(sm.SaleMaster_InvoiceNo, ' - ', c.Customer_Name) as invoice_text,
            c.Customer_Code,
            c.Customer_Name,
            c.Customer_Mobile,
            c.Customer_Address,
            c.Customer_Type,
            e.Employee_Name,
            br.Brunch_name
            from tbl_salesmaster sm
            left join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            left join tbl_employee e on e.Employee_SlNo = sm.employee_id
            left join tbl_brunch br on br.brunch_id = sm.SaleMaster_branchid
            where sm.SaleMaster_branchid = '$branchId'
            and sm.Status != 'd'
            $clauses
        ")->result();
        
        $res['sales'] = $sales;

        echo json_encode($res);
    }

    public function updateSales(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $salesId = $data->sales->salesId;

            if(isset($data->customer)){
                $customer = (array)$data->customer;
                unset($customer['Customer_SlNo']);
                unset($customer['display_name']);
                $customer['UpdateBy'] = $this->session->userdata("FullName");
                $customer['UpdateTime'] = date("Y-m-d H:i:s");

                $this->db->where('Customer_SlNo', $data->sales->customerId)->update('tbl_customer', $customer);
            }

            $sales = array(
                'SalseCustomer_IDNo' => $data->sales->customerId,
                'employee_id' => $data->sales->employeeId,
                'SaleMaster_SaleDate' => $data->sales->salesDate,
                'SaleMaster_SaleType' => $data->sales->salesType,
                'SaleMaster_TotalSaleAmount' => $data->sales->total,
                'SaleMaster_TotalDiscountAmount' => $data->sales->discount,
                'SaleMaster_TaxAmount' => $data->sales->vat,
                'SaleMaster_Freight' => $data->sales->transportCost,
                'SaleMaster_SubTotalAmount' => $data->sales->subTotal,
                'SaleMaster_PaidAmount' => $data->sales->paid,
                'SaleMaster_DueAmount' => $data->sales->due,
                'SaleMaster_Previous_Due' => $data->sales->previousDue,
                'SaleMaster_Description' => $data->sales->note,
                "UpdateBy" => $this->session->userdata("FullName"),
                'UpdateTime' => date("Y-m-d H:i:s"),
                "SaleMaster_branchid" => $this->session->userdata("BRANCHid")
            );
    
            $this->db->where('SaleMaster_SlNo', $salesId);
            $this->db->update('tbl_salesmaster', $sales);
            
            $currentSaleDetails = $this->db->query("select * from tbl_saledetails where SaleMaster_IDNo = ?", $salesId)->result();
            $this->db->query("delete from tbl_saledetails where SaleMaster_IDNo = ?", $salesId);

            foreach($currentSaleDetails as $product){
                $this->db->query("
                    update tbl_currentinventory 
                    set sales_quantity = sales_quantity - ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$product->SaleDetails_TotalQuantity, $product->Product_IDNo, $this->session->userdata('BRANCHid')]);
            }
    
            foreach($data->cart as $cartProduct){
                $saleDetails = array(
                    'SaleMaster_IDNo' => $salesId,
                    'Product_IDNo' => $cartProduct->productId,
                    'SaleDetails_TotalQuantity' => $cartProduct->quantity,
                    'Purchase_Rate' => $cartProduct->purchaseRate,
                    'SaleDetails_Rate' => $cartProduct->salesRate,
                    'SaleDetails_Tax' => $cartProduct->vat,
                    'SaleDetails_TotalAmount' => $cartProduct->total,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date('Y-m-d H:i:s'),
                    'SaleDetails_BranchId' => $this->session->userdata("BRANCHid")
                );
    
                $this->db->insert('tbl_saledetails', $saleDetails);
    
                $this->db->query("
                    update tbl_currentinventory 
                    set sales_quantity = sales_quantity + ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$cartProduct->quantity, $cartProduct->productId, $this->session->userdata('BRANCHid')]);
            }
    
            $res = ['success'=>true, 'message'=>'Sales Updated', 'salesId'=>$salesId];

        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getSaleDetailsForReturn(){
        $data = json_decode($this->input->raw_input_stream);
        $saleDetails = $this->db->query("
            select
                sd.*,
                sd.SaleDetails_Rate as return_rate,
                p.Product_Name,
                p.Product_Code,
                pc.ProductCategory_Name,
                (
                    select ifnull(sum(srd.SaleReturnDetails_ReturnQuantity), 0)
                    from tbl_salereturndetails srd
                    join tbl_salereturn sr on sr.SaleReturn_SlNo = srd.SaleReturn_IdNo
                    where sr.Status = 'a'
                    and srd.SaleReturnDetailsProduct_SlNo = sd.Product_IDNo
                    and sr.SaleMaster_InvoiceNo = sm.SaleMaster_InvoiceNo
                ) as returned_quantity,
                (
                    select ifnull(sum(srd.SaleReturnDetails_ReturnAmount), 0)
                    from tbl_salereturndetails srd
                    join tbl_salereturn sr on sr.SaleReturn_SlNo = srd.SaleReturn_IdNo
                    where sr.Status = 'a'
                    and srd.SaleReturnDetailsProduct_SlNo = sd.Product_IDNo
                    and sr.SaleMaster_InvoiceNo = sm.SaleMaster_InvoiceNo
                ) as returned_amount
            from tbl_saledetails sd
            join tbl_salesmaster sm on sm.SaleMaster_SlNo = sd.SaleMaster_IDNo
            join tbl_product p on p.Product_SlNo = sd.Product_IDNo
            left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            where sm.SaleMaster_SlNo = ?
        ", $data->salesId)->result();

        echo json_encode($saleDetails);
    }

    public function addSalesReturn(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $salesReturn = array(
                'SaleMaster_InvoiceNo' => $data->invoice->SaleMaster_InvoiceNo,
                'SaleReturn_ReturnDate' => $data->salesReturn->returnDate,
                'SaleReturn_ReturnAmount' => $data->salesReturn->total,
                'SaleReturn_Description' => $data->salesReturn->note,
                'Status' => 'a',
                'AddBy' => $this->session->userdata("FullName"),
                'AddTime' => date('Y-m-d H:i:s'),
                'SaleReturn_brunchId' => $this->session->userdata("BRANCHid")
            );

            $this->db->insert('tbl_salereturn', $salesReturn);
            $salesReturnId = $this->db->insert_id();

            $totalReturnAmount = 0;
            foreach($data->cart as $product){
                $returnDetails = array(
                    'SaleReturn_IdNo' => $salesReturnId,
                    'SaleReturnDetailsProduct_SlNo' => $product->Product_IDNo,
                    'SaleReturnDetails_ReturnQuantity' => $product->return_quantity,
                    'SaleReturnDetails_ReturnAmount' => $product->return_amount,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date('Y-m-d H:i:s'),
                    'SaleReturnDetails_brunchID' => $this->session->userdata("BRANCHid")
                );
                
                $this->db->insert('tbl_salereturndetails', $returnDetails);

                $totalReturnAmount += $product->return_amount;

                $this->db->query("
                    update tbl_currentinventory 
                    set sales_return_quantity = sales_return_quantity + ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$product->return_quantity, $product->Product_IDNo, $this->session->userdata('BRANCHid')]);
            }

            $customerInfo = $this->db->query("select * from tbl_customer where Customer_SlNo = ?", $data->invoice->SalseCustomer_IDNo)->row();
            if($customerInfo->Customer_Type == 'G') {
                $customerPayment = array(
                    'CPayment_date' => $data->salesReturn->returnDate,
                    'CPayment_invoice' => $data->invoice->SaleMaster_InvoiceNo,
                    'CPayment_customerID' => $data->invoice->SalseCustomer_IDNo,
                    'CPayment_TransactionType' => 'CP',
                    'CPayment_amount' => $totalReturnAmount,
                    'CPayment_Paymentby' => 'cash',
                    'CPayment_brunchid' => $this->session->userdata("BRANCHid"),
                    'CPayment_previous_due' => 0,
                    'CPayment_Addby' => $this->session->userdata("FullName"),
                    'CPayment_AddDAte' => date('Y-m-d H:i:s'),
                    'CPayment_status' => 'a'
                );

                $this->db->insert('tbl_customer_payment', $customerPayment);
            }
            
            $res = ['success'=>true, 'message'=>'Return Success', 'id' => $salesReturnId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateSalesReturn(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $salesReturnId = $data->salesReturn->returnId;
            
            $oldReturn = $this->db->query("select * from tbl_salereturn where SaleReturn_SlNo = ?", $salesReturnId)->row();
            $oldDetails = $this->db->query("select * from tbl_salereturndetails sr where sr.SaleReturn_IdNo = ?", $salesReturnId)->result();

            $salesReturn = array(
                'SaleMaster_InvoiceNo' => $data->invoice->SaleMaster_InvoiceNo,
                'SaleReturn_ReturnDate' => $data->salesReturn->returnDate,
                'SaleReturn_ReturnAmount' => $data->salesReturn->total,
                'SaleReturn_Description' => $data->salesReturn->note,
                'Status' => 'a',
                'AddBy' => $this->session->userdata("FullName"),
                'AddTime' => date('Y-m-d H:i:s'),
                'SaleReturn_brunchId' => $this->session->userdata("BRANCHid")
            );

            $this->db->where('SaleReturn_SlNo', $salesReturnId)->update('tbl_salereturn', $salesReturn);

            foreach($oldDetails as $product) {
                $this->db->query("
                    update tbl_currentinventory 
                    set sales_return_quantity = sales_return_quantity - ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$product->SaleReturnDetails_ReturnQuantity, $product->SaleReturnDetailsProduct_SlNo, $this->session->userdata('BRANCHid')]);
            }

            $this->db->query("delete from tbl_salereturndetails where SaleReturn_IdNo = ?", $salesReturnId);

            $totalReturnAmount = 0;
            foreach($data->cart as $product){
                $returnDetails = array(
                    'SaleReturn_IdNo' => $salesReturnId,
                    'SaleReturnDetailsProduct_SlNo' => $product->Product_IDNo,
                    'SaleReturnDetails_ReturnQuantity' => $product->return_quantity,
                    'SaleReturnDetails_ReturnAmount' => $product->return_amount,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date('Y-m-d H:i:s'),
                    'SaleReturnDetails_brunchID' => $this->session->userdata("BRANCHid")
                );
                
                $this->db->insert('tbl_salereturndetails', $returnDetails);

                $totalReturnAmount += $product->return_amount;

                $this->db->query("
                    update tbl_currentinventory 
                    set sales_return_quantity = sales_return_quantity + ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$product->return_quantity, $product->Product_IDNo, $this->session->userdata('BRANCHid')]);
            }

            $customerInfo = $this->db->query("select * from tbl_customer where Customer_SlNo = ?", $data->invoice->SalseCustomer_IDNo)->row();
            if($customerInfo->Customer_Type == 'G') {
                $this->db->query("
                    delete from tbl_customer_payment 
                    where CPayment_invoice = ? 
                    and CPayment_customerID = ?
                    and CPayment_amount = ?
                    limit 1
                ", [
                    $data->invoice->SaleMaster_InvoiceNo,
                    $data->invoice->SalseCustomer_IDNo,
                    $oldReturn->SaleReturn_ReturnAmount
                ]);
                
                $customerPayment = array(
                    'CPayment_date' => $data->salesReturn->returnDate,
                    'CPayment_invoice' => $data->invoice->SaleMaster_InvoiceNo,
                    'CPayment_customerID' => $data->invoice->SalseCustomer_IDNo,
                    'CPayment_TransactionType' => 'CP',
                    'CPayment_amount' => $totalReturnAmount,
                    'CPayment_Paymentby' => 'cash',
                    'CPayment_brunchid' => $this->session->userdata("BRANCHid"),
                    'CPayment_previous_due' => 0,
                    'CPayment_Addby' => $this->session->userdata("FullName"),
                    'CPayment_AddDAte' => date('Y-m-d H:i:s'),
                    'CPayment_status' => 'a'
                );

                $this->db->insert('tbl_customer_payment', $customerPayment);
            }
            
            $res = ['success'=>true, 'message'=>'Return Updated', 'id' => $salesReturnId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteSaleReturn() {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['success' => false, 'message' => ''];

        try {
            $data = json_decode($this->input->raw_input_stream);
    
            $oldReturn = $this->db->query("
                select 
                    sr.*,
                    c.Customer_SlNo,
                    c.Customer_Code,
                    c.Customer_Name,
                    c.Customer_Type
                from tbl_salereturn sr
                join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = sr.SaleMaster_InvoiceNo
                join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
                where sr.SaleReturn_SlNo = ?
            ", $data->id)->row();
            
            $this->db->query("delete from tbl_salereturn where SaleReturn_SlNo = ?", $data->id);

            $returnDetails = $this->db->query("select * from tbl_salereturndetails srd where srd.SaleReturn_IdNo = ?", $data->id)->result();

            if($oldReturn->Customer_Type == 'G') {
                $this->db->query("
                    delete from tbl_customer_payment 
                    where CPayment_invoice = ? 
                    and CPayment_customerID = ?
                    and CPayment_amount = ?
                    limit 1
                ", [
                    $oldReturn->SaleMaster_InvoiceNo,
                    $oldReturn->Customer_SlNo,
                    $oldReturn->SaleReturn_ReturnAmount
                ]);
            }
    
            foreach($returnDetails as $product) {
                $this->db->query("
                    update tbl_currentinventory set 
                    sales_return_quantity = sales_return_quantity - ? 
                    where product_id = ? 
                    and branch_id = ?
                ", [$product->SaleReturnDetails_ReturnQuantity, $product->SaleReturnDetailsProduct_SlNo, $this->sbrunch]);
            }
    
            $this->db->query("delete from tbl_salereturndetails where SaleReturn_IdNo = ?", $data->id);
            $res = ['success' => true, 'message' => 'Sale return deleted'];
        } catch(Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
        
    }

    public function getSaleReturns() {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if((isset($data->fromDate) && $data->fromDate != '') && (isset($data->toDate) && $data->toDate != '')) {
            $clauses .= " and sr.SaleReturn_ReturnDate between '$data->fromDate' and '$data->toDate'";
        }

        if(isset($data->id) && $data->id != '') {
            $clauses .= " and sr.SaleReturn_SlNo = '$data->id'";

            $res['returnDetails'] = $this->db->query("
                SELECT
                    srd.*,
                    p.Product_Code,
                    p.Product_Name
                from tbl_salereturndetails srd
                join tbl_product p on p.Product_SlNo = srd.SaleReturnDetailsProduct_SlNo
                where srd.SaleReturn_IdNo = ?
            ", $data->id)->result();
        }

        $res['returns'] = $this->db->query("
            select  
                sr.*,
                c.Customer_SlNo,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Address,
                c.Customer_Mobile,
                c.owner_name,
                sm.SaleMaster_TotalDiscountAmount,
                sm.SaleMaster_SlNo
            from tbl_salereturn sr
            join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = sr.SaleMaster_InvoiceNo
            left join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where sr.Status = 'a'
            and sr.SaleReturn_brunchId = '$this->sbrunch'
            $clauses
        ")->result();

        echo json_encode($res);

    }

    public function getSaleReturnDetails(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and sr.SaleReturn_ReturnDate between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->customerId) && $data->customerId != ''){
            $clauses .= " and sm.SalseCustomer_IDNo = '$data->customerId'";
        }

        if(isset($data->productId) && $data->productId != ''){
            $clauses .= " and srd.SaleReturnDetailsProduct_SlNo = '$data->productId'";
        }

        $returnDetails = $this->db->query("
            select
                srd.*,
                p.Product_Code,
                p.Product_Name,
                sr.SaleMaster_InvoiceNo,
                sr.SaleReturn_ReturnDate,
                sr.SaleReturn_Description,
                sm.SalseCustomer_IDNo,
                c.Customer_Code,
                c.Customer_Name
            from tbl_salereturndetails srd
            join tbl_product p on p.Product_SlNo = srd.SaleReturnDetailsProduct_SlNo
            join tbl_salereturn sr on sr.SaleReturn_SlNo = srd.SaleReturn_IdNo
            join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = sr.SaleMaster_InvoiceNo
            join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where sr.SaleReturn_brunchId = ?
            $clauses
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($returnDetails);
    }

    public function saleReturnInvoice($id) {
        $data['title'] = "Sale return Invoice";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/sales/sale_return_invoice', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function sales_order(){

        $query0 =$this->db->query("SELECT * FROM tbl_salesmaster ORDER BY SaleMaster_SlNo DESC LIMIT 1");
        $row = $query0->row();

        @$invoice = $row->SaleMaster_InvoiceNo;
        $previousinvoice = substr($invoice, 3, 11);
        if (!empty($invoice)) {
           if ($previousinvoice<10) {
                 $salesInvoiceno = 'CS-00'.($previousinvoice+1);
            }
            else if ($previousinvoice<100) {
                $salesInvoiceno = 'CS-0'.($previousinvoice+1);
            }
            else{
                 $salesInvoiceno = 'CS-'.($previousinvoice+1);
            }
        }
        else{
             $salesInvoiceno = 'CS-001';
        }
        
        $SalesFrom=$this->input->post('SalesFrom');
        $CType=$this->input->post('CType');
        $re = 0;
        if ($cart = $this->cart->contents()){
            foreach ($cart as $item){
                $branchID = $this->session->userdata("BRANCHid");
                $SalesFrom=$this->input->post('SalesFrom');
                $pid = $item['id'];
                $qty = $item['qty'];
                $proStock = 0;

                $sql = $this->db->query("SELECT * FROM tbl_purchaseinventory WHERE PurchaseInventory_Store='$SalesFrom' AND purchProduct_IDNo = '$pid'  AND PurchaseInventory_brunchid = '$branchID'");


                $stock = "";
                $orw = $sql->result();
                foreach($orw as $orw){
                    $stock = $stock+$orw->PurchaseInventory_TotalQuantity;
                    $returnQty = $orw->PurchaseInventory_ReturnQuantity;
                    $damageQty = $orw->PurchaseInventory_DamageQuantity;
                } 
                $sqll = $this->db->query("SELECT * FROM tbl_saleinventory WHERE SaleInventory_Store='$SalesFrom' AND sellProduct_IdNo = '$pid' AND SaleInventory_brunchid = '$branchID'");



                $SaleInventory_TotalQuantity=0;
                $SaleInventory_ReturnQuantity=0;
                $rows = $sqll->result();
                foreach($rows as $rows){
                    $SaleInventory_TotalQuantity =  $SaleInventory_TotalQuantity+$rows->SaleInventory_TotalQuantity;
                    $SaleInventory_ReturnQuantity = $SaleInventory_ReturnQuantity+$rows->SaleInventory_ReturnQuantity;
                }


                $tsql = $this->db->query("SELECT * FROM sr_transferdetails WHERE Product_IDNo = '$pid' AND Brunch_to = '$branchID' AND fld_status = 'a'")->result();
                $transferQuantity=0;
                $transferQuantity2=0;
                $curentstock=0;
                foreach($tsql as $trows){
                    $transferQuantity =  $transferQuantity+$trows->TransferDetails_TotalQuantity;
                }

                $tsql2 = $this->db->query("SELECT * FROM sr_transferdetails WHERE Product_IDNo = '$pid' AND Brunch_from = '$branchID' AND fld_status = 'a'")->result();
                foreach($tsql2 as $trows2){
                    $transferQuantity2 =  $transferQuantity2+$trows2->TransferDetails_TotalQuantity;
                }


                $curentstock = $stock - $SaleInventory_TotalQuantity;
                $curentstock += $SaleInventory_ReturnQuantity+$transferQuantity;
                $curentstock -= $transferQuantity2;

                $roxx = $this->db->query("SELECT * FROM tbl_purchaseinventory WHERE PurchaseInventory_Store = '$SalesFrom' AND purchProduct_IDNo = '$pid' AND PurchaseInventory_brunchid = '$branchID'")->row();

                $returnQty = 0;  $damageQty = 0;
                //echo "<pre>";print_r($roxx);exit;

                if(isset($roxx->PurchaseInventory_ReturnQuantity)):
                $returnQty = $roxx->PurchaseInventory_ReturnQuantity;
                else:
                $returnQty = 0; 
                endif;

                if(isset($roxx->PurchaseInventory_DamageQuantity)):
                $damageQty = $roxx->PurchaseInventory_DamageQuantity;
                else:
                $damageQty = 0; 
                endif;
                $curentstock = $curentstock-$returnQty;
                $curentstock = $curentstock-$damageQty;

                if($qty > $curentstock){
                    $re = 0;
                }else{ 
                    $re = 1;
                }

            }
        }

        if($re == 0){
            return false;
        }       

        $sales = array(
            "SaleMaster_InvoiceNo"          =>$salesInvoiceno,
            "SalseCustomer_IDNo"            =>$this->input->post('customerID'),
            "SaleMaster_SaleDate"           =>$this->input->post('sales_date'),
            "SaleMaster_Description"        =>$this->input->post('SelesNotes'),
            "SaleMaster_SaleType"           =>$this->input->post('SalesFrom'),
            "SaleMaster_TotalSaleAmount"    =>$this->input->post('subTotal'),
            "SaleMaster_TotalDiscountAmount"=>$this->input->post('SellsDiscount'),
            "SaleMaster_RewordDiscount"     =>$this->input->post('Reword_Discount'),
            "SaleMaster_TaxAmount"          =>$this->input->post('vatPersent'),
            "SaleMaster_Freight"            =>$this->input->post('SellsFreight'),
            "SaleMaster_SubTotalAmount"     =>$this->input->post('SellTotals'),
            "SaleMaster_PaidAmount"         =>$this->input->post('SellsPaid'),
            "SaleMaster_DueAmount"          =>$this->input->post('SellsDue'),
            "SaleMaster_Previous_Due"          =>$this->input->post('SaleMaster_Previous_Due'),
            "payment_type"					=>$this->input->post('payment_type'),
            "AddBy"                         =>$this->session->userdata("FullName"),
            "SaleMaster_branchid"           =>$this->session->userdata("BRANCHid"),
            "AddTime"                       =>date("Y-m-d H:i:s")
        );  

        $sales_id = $this->Billing_model->SalesOrder($sales);
        if ($CType=='G') {            
            $G_All = array(
                'G_Name' =>$this->input->post('C_name') ,
                'G_Mobile' =>$this->input->post('C_Mobile') ,
                'G_Address' =>$this->input->post('C_Address') ,
                'G_Sale_Mastar_SiNO' =>$sales_id ,
                 );
            $this->mt->save_data("genaral_customer_info", $G_All);
            }
        $data = array(
            "CPayment_date"         =>$this->input->post('sales_date', TRUE),
            "CPayment_invoice"      =>$salesInvoiceno,
            "CPayment_customerID"   =>$this->input->post('customerID', TRUE),
            "CPayment_amount"       =>$this->input->post('SellsPaid', TRUE),
            "CPayment_notes"        =>$this->input->post('SelesNotes', TRUE),
            "CPayment_Addby"        =>$this->session->userdata("FullName"),
            "CPayment_brunchid"     =>$this->session->userdata("BRANCHid")
        );
        $this->mt->save_data("tbl_customer_payment", $data);
        
        if ($cart = $this->cart->contents()){
            foreach ($cart as $item){
                $packagename = $item['packagename'];
                $proname = $item['name'];
                $packagecode = $item['packagecode'];
                if($packagename == $proname){
                    $sqqS = $this->db->query("SELECT tbl_package_create.*, tbl_product.* FROM tbl_package_create left join tbl_product on tbl_product.product_create_pack_id = tbl_package_create.create_ID WHERE tbl_package_create.create_pacageID = '$packagecode'");
                    $romS = $sqqS->result();
                    foreach($romS as $romS){
                        $proids = $romS->Product_SlNo;
                        $sellPRICE = $romS->create_sell_price;
                        $PurchpackagPRICE = $romS->create_purch_price;
                        $packagNAME = $romS->create_item;
                        $packqty = $romS->cteate_qty*$item['qty'];
                        $order_detail = array(
                            'SaleMaster_IDNo'               => $sales_id,
                            'Product_IDNo'                  => $proids,
                            'SaleDetails_TotalQuantity'     => $packqty,
                            'SeleDetails_qty'               => $item['qty'],
                            'SaleDetails_Rate'              => $sellPRICE,
                            'SaleDetails_unit'              => 'pcs',
                            'packSellPrice'                 => $item['price'],
                            'packageName'                   => $item['name'],
                            'Purchase_Rate'                 => $PurchpackagPRICE
                        );
                        $this->Billing_model->insert_sales_detail($order_detail);
                        $sql = $this->db->query("SELECT * FROM tbl_saleinventory WHERE SaleInventory_Store='$SalesFrom' AND  sellProduct_IdNo = '".$proids."'");
                        $rox = $sql->row();
                        $id = $rox->SaleInventory_SlNo;
                        $oldStock = $rox->SaleInventory_TotalQuantity;
                        $oldpackStock = $rox->SaleInventory_qty;

                        if($rox->sellProduct_IdNo == $proids){
                            $addStock = array(
                                'sellProduct_IdNo'                      => $proids,
                                'SaleInventory_TotalQuantity'           => $oldStock+$packqty,
                                'SaleInventory_qty'                     => $oldpackStock+$item['qty'],
                                'SaleInventory_Store'=>$SalesFrom,
                                'SaleInventory_packname'                => $packagename
                            );
                            $this->mt->update_data("tbl_saleinventory",$addStock,$id,'SaleInventory_SlNo');  
                        }else{
                            $addStock = array(
                                'sellProduct_IdNo'                      => $proids,
                                'SaleInventory_TotalQuantity'           => $packqty,
                                'SaleInventory_qty'                     => $$item['qty'],
                                'SaleInventory_Store'=>$SalesFrom,
                                'SaleInventory_packname'                => $packagename
                            );
                        $this->mt->save_data("tbl_saleinventory",$addStock);
                        }
                    }   
                }
                else{
                    $order_detail = array(
                        'SaleMaster_IDNo'               => $sales_id,
                        'Product_IDNo'                  => $item['id'],
                        'SaleDetails_TotalQuantity'     => $item['qty'],
                        'SaleDetails_Rate'              => $item['price'],
                        'SaleDetails_unit'              => $item['image'],
						'SaleDetails_Discount'			=> $item['pro_discount'],
						'Discount_amount'				=> $item['discount_amount'],
                        'Purchase_Rate'                 => $item['purchaserate'],
						"AddTime"                       =>date("Y-m-d H:i:s")
                    );
                    $this->Billing_model->insert_sales_detail($order_detail);
                    // Stock add
                    $sql = $this->db->query("SELECT * FROM tbl_saleinventory WHERE SaleInventory_Store='$SalesFrom' AND sellProduct_IdNo = '".$item['id']."'");
                    $rox = $sql->row();
                    $id = $rox->SaleInventory_SlNo;
                    $oldStock = $rox->SaleInventory_TotalQuantity;

                    if($rox->sellProduct_IdNo == $item['id']){
                        $addStock = array(
                            'sellProduct_IdNo'            => $item['id'],
                            'SaleInventory_TotalQuantity' => $oldStock+$item['qty'],
                            'SaleInventory_brunchid'      => $this->sbrunch,
                            'SaleInventory_Store'         =>$SalesFrom,
                            "UpdateBy"         =>$this->session->userdata("FullName"),
                            "UpdateTime"                  =>date("Y-m-d H:i:s")
                        );
                        $this->mt->update_data("tbl_saleinventory",$addStock,$id,'SaleInventory_SlNo');  
                    }else{
                        $addStock = array(
                            'sellProduct_IdNo'            => $item['id'],
                            'SaleInventory_TotalQuantity' => $item['qty'],
                            'SaleInventory_brunchid'      => $this->sbrunch,
                            'SaleInventory_Store'         =>$SalesFrom,
                            "AddBy"         =>$this->session->userdata("FullName"),
                            "AddTime"                     =>date("Y-m-d H:i:s")
                        );
                    $this->mt->save_data("tbl_saleinventory",$addStock);
                    } 
                }
                
                $Pid=$item['id'];
                $Pfld='Product_SlNo';
                $ProductPrice = array(
                'Product_SellingPrice' => $item['price'],
                'body_rate' => $item['bodyrate']
                );
                $this->mt->update_data("tbl_product",$ProductPrice,$Pid,$Pfld);
                
            }// end foreach
        }// end if

        if($this->input->post('payment_type') == 'Cheque'){
            $this->Check_model->store_check_info_sale($sales_id,$this->input->post('customerID'));

        }


        $this->cart->destroy();
        $sss['lastidforprint'] = $sales_id;
        $this->session->set_userdata($sss);
        $this->load->view('Administrator/sales/product_sales');
    }
    
    function salesreturn(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        
        $data['returnId'] = 0;
        $data['title'] = " Sales Return";
        $data['content'] = $this->load->view('Administrator/sales/salseReturn', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function salesReturnEdit($id){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        
        $data['returnId'] = $id;
        $data['title'] = " Sales Return";
        $data['content'] = $this->load->view('Administrator/sales/salseReturn', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function salesreturnSearch(){
        $invoice = $this->input->post('invoiceno');
        $sql = $this->db->query("SELECT * FROM tbl_salesmaster WHERE SaleMaster_SlNo = '$invoice'");
        $row = $sql->row();
        $data['proID'] = $row->SaleMaster_SlNo;
        $data['invoices'] = $row->SaleMaster_InvoiceNo;
        $da['Store'] = $row->SaleMaster_SaleType;
        $this->session->set_userdata($da);
        $this->load->view('Administrator/sales/salesReturnList', $data);
    }
    function SalesReturnInsert(){
        $returnqty = $this->input->post('returnqty');
        $returnamount = $this->input->post('returnamount');
        //echo "<pre>";print_r($returnamount);exit;
        $return_date = $this->input->post('return_date');
        $productID = $this->input->post('productID');
        $salseQTY = $this->input->post('salseQTY');
        $invoices = $this->input->post('invoice');
        $totalQty = "";
        $RAmount = "";
        $totalarray =  sizeof($returnqty);
        for($j=0;$j<$totalarray; $j++){
            $rqtys = $this->input->post('returnqty');
            $totalQty = $rqtys[$j]+$totalQty;
            $ramounts = $this->input->post('returnamount');
            $RAmount =$ramounts[$j]+$RAmount;
        }
        $sqlll = $this->db->query("SELECT * FROM tbl_salereturn where SaleMaster_InvoiceNo = '$invoices'");
        $ros = $sqlll->row();
        //echo "<pre>";print_r($ros);exit;
        @$iid = $ros->SaleReturn_SlNo;
        @$ivo = $ros->SaleMaster_InvoiceNo;

        @$totalqt = $ros->SaleReturn_ReturnQuantity;
        @$totalamou = $ros->SaleReturn_ReturnAmount;
        $fld = 'SaleReturn_SlNo';

            $return = array(
                "SaleMaster_InvoiceNo"               =>$invoices,
                "SaleReturn_ReturnDate"              =>$this->input->post('return_date'),
                "SaleReturn_ReturnQuantity"          =>$totalQty,
                "SaleReturn_ReturnAmount"            =>$RAmount,
                "SaleReturn_Description"             =>$this->input->post('Notes'),
                
                "AddBy"                              =>$this->session->userdata("FullName"),
                "SaleReturn_brunchId"                =>$this->session->userdata("BRANCHid"),
                "AddTime"                            =>date("Y-m-d H:i:s")
            );      
            $return_id = $this->Billing_model->SalesReturn('tbl_salereturn',$return);
            if($return_id > 0){
            for($i=0;$i<$totalarray; $i++){
                $returnqtyss = $this->input->post('returnqty');
                $returnamounts = $this->input->post('returnamount');
                $productIDs = $this->input->post('productID');
                $salseQTYs = $this->input->post('salseQTY');

                if($returnqtyss[$i] != 0){
                    $returns = array(
                        "SaleReturn_IdNo"                           =>$return_id,
                        "SaleReturnDetails_ReturnDate"              =>$this->input->post('return_date'),
                        "SaleReturnDetailsProduct_SlNo"             =>$productIDs[$i],
                        "SaleReturnDetails_SaleQuantity"            =>$salseQTYs[$i],
                        "SaleReturnDetails_ReturnQuantity"          =>$returnqtyss[$i],
                        "SaleReturnDetails_ReturnAmount"            =>$returnamount[$i],
                        
                        "AddBy"                                     =>$this->session->userdata("FullName"),
                        "SaleReturnDetails_brunchID"                =>$this->session->userdata("BRANCHid"),
                        "AddTime"                                   =>date("Y-m-d H:i:s")
                    );      
                    $this->Billing_model->SalesReturn('tbl_salereturndetails',$returns);
                    $dataR = array(
                        "CPayment_date" => date('Y-m-d'),
                        "CPayment_invoice" => $invoices,
                        "CPayment_TransactionType" => "RP",
                        "CPayment_customerID" => $this->db->where('SaleMaster_InvoiceNo',$invoices)->get('tbl_salesmaster')->row()->SalseCustomer_IDNo,
                        "CPayment_amount" => $returnamount[$i],
                        "CPayment_notes" => 'Sale Returns',
                        "CPayment_Addby" => $this->session->userdata("FullName"),
                        "CPayment_brunchid" => $this->session->userdata("BRANCHid")
                    );
                    $this->mt->save_data("tbl_customer_payment", $dataR);
                     }
               
            }
            }           

      
        for($f=0;$f<$totalarray; $f++){
            $productIDs = $this->input->post('productID');
            $rqtyss = $this->input->post('returnqty');
            //------------------------------------------
            $productsCodes = $this->input->post('productsCodes');
            $productsCode=$productsCodes[$f];
            $packnames = $this->input->post('packname');
            $packnames = $packnames[$f];
            $productsName = $this->input->post('productsName');
            $productsName = $productsName[$f];

                $store=$this->session->userdata('Store');
                $sqls = $this->db->query("SELECT * FROM tbl_saleinventory WHERE  SaleInventory_Store='$store' AND  sellProduct_IdNo ='".$productIDs[$f]."'");
                $ROW = $sqls->row();
                $id = $ROW->SaleInventory_SlNo;
                $qt = $ROW->SaleInventory_ReturnQuantity;
                $fld = "SaleInventory_SlNo";
                $returns = array(
                    "SaleInventory_ReturnQuantity"      =>$rqtyss[$f]+$qt
                );      
                $this->mt->update_data('tbl_saleinventory',$returns, $id,$fld);       
            
        } 
        
        $this->load->view('Administrator/sales/blankpage');

    }
    public function sales_invoice()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Sales Invoice"; 
		$data['content'] = $this->load->view('Administrator/sales/sales_invoice', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function sales_invoice_search()  {
        $id = $this->input->post('SaleMasteriD');
        $datas['SalesID']=$SalesID = $this->input->post('SaleMasteriD');
        $this->session->set_userdata('SalesID',$SalesID);


		$this->db->select('tbl_salesmaster.*, tbl_salesmaster.AddBy as served, tbl_customer.*,genaral_customer_info.*');
		$this->db->from('tbl_salesmaster'); 
		$this->db->join('tbl_customer','tbl_salesmaster.SalseCustomer_IDNo =tbl_customer.Customer_SlNo', 'left');
		$this->db->join('genaral_customer_info','tbl_salesmaster.SaleMaster_SlNo =genaral_customer_info.G_Sale_Mastar_SiNO', 'left');
		$datas['selse']= $this->db->where('tbl_salesmaster.SaleMaster_SlNo',$SalesID)->get()->row();



        $this->load->view('Administrator/sales/sales_invoice_search', $datas);
    }
    function sales_record()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Sales Record";  
        $data['content'] = $this->load->view('Administrator/sales/sales_record', $data, TRUE);
        $this->load->view('Administrator/index', $data); 
    }



    
     function select_customerName()  { 
       ?>
       <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="customerID"> Select Customer </label>
        <div class="col-sm-3">
            <select name="" id="customerID" data-placeholder="Choose a Customer..." class="chosen-select" >
                <option value="All">All</option>
                <?php 
                $sql = $this->db->query("SELECT * FROM tbl_customer where Customer_brunchid = '".$this->sbrunch."' AND Customer_Type = 'Local' order by Customer_Name asc");
                $row = $sql->result();
                foreach($row as $row){ ?>

                <option value="<?php echo $row->Customer_SlNo; ?>"><?php echo $row->Customer_Name; ?> (<?php echo $row->Customer_Code; ?>)</option>
                <?php } ?>
            </select>
        </div>
    </div>
       <?php
    }
    function select_InvCustomerName()  {
        ?>
        <div class="form-group">
            <div class="col-sm-3">
                <select id="Salestype" class="chosen-select" name="Salestype">
                    <option value="All">All</option>
                    <?php
                    $sql = $this->db->query("SELECT * FROM tbl_customer where Customer_brunchid = '".$this->sbrunch."' AND Customer_Type = 'Local' order by Customer_Name asc");
                    $row = $sql->result();
                    foreach($row as $row){ ?>

                        <option value="<?php echo $row->Customer_SlNo; ?>"><?php echo $row->Customer_Name; ?> (<?php echo $row->Customer_Code; ?>)</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php
    }
    function sales_customerName()  {
        $id = $this->input->post('customerID');
        $sql = mysql_query("SELECT * FROM tbl_customer WHERE Customer_SlNo = '$id'");
        $row = mysql_fetch_array($sql);
        $datas['customerName'] = $row['Customer_Name'];
        $this->load->view('Administrator/sales/salesrecord_customername', $datas);
    } 
    
    function search_sales_record()  { 
        // print_r($this->input->post());die();
        $data=array();
        $dAta['searchtype']= $searchtype = $this->input->post('searchtype');
        $dAta['Sales_startdate']=$Sales_startdate = $this->input->post('Sales_startdate');
        $dAta['Sales_enddate']=$Sales_enddate = $this->input->post('Sales_enddate');
        $dAta['customerID']=$customerID = $this->input->post('customerID');
        $dAta['productID']=$productID = $this->input->post('productID');
        $dAta['adminId']=$adminId = $this->input->post('adminId');
        $dAta['Salestype']=$Salestype = $this->input->post('Salestype');
        

        $this->session->set_userdata($dAta);

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

        // echo "<pre>";
        // print_r($data);die();
        $this->load->view('Administrator/sales/sales_record_list', $data); 
    }
    
    function sales_stock()  {
        $data['title'] = "Sales Stock";
        $data['content'] = $this->load->view('Administrator/stock/sales_stock', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function saleInvoicePrint($saleId)  {
        $data['title'] = "Sales Invoice";
        $data['salesId'] = $saleId;
        $data['content'] = $this->load->view('Administrator/sales/sellAndreport', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    function return_list()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Sales Return List";
        $data['content'] = $this->load->view('Administrator/sales/sales_return_record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    function saleReturnDetails()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Sales Return Details";
        $data['content'] = $this->load->view('Administrator/sales/sale_return_details', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    function sales_return_record() {
        $datas['searchtype']= $searchtype = $this->input->post('searchtype');
        $datas['productID']= $productID = $this->input->post('productID');
        $datas['startdate']= $startdate = $this->input->post('startdate');
        $datas['enddate']= $enddate = $this->input->post('enddate');
        $this->session->set_userdata($datas);
        //echo "<pre>";print_r($datas);exit;
        $this->load->view('Administrator/sales/return_list', $datas);
    }
    function craditlimit(){
        $cid = $this->input->post('custID');
        $sql = mysql_query("SELECT *  FROM tbl_customer_payment  where CPayment_customerID = '$cid' ");
        $sell = '';
        $paid = '';
        while($rox = mysql_fetch_array($sql)){
            $paid =$paid+ $rox['CPayment_amount'];
        }
        $sqlx = mysql_query("SELECT * FROM tbl_salesmaster  where SalseCustomer_IDNo = '$cid' ");
        while($rox = mysql_fetch_array($sqlx)){
            $sell =$sell+ $rox['SaleMaster_SubTotalAmount'];
        }

        //echo  $sell.'<br>';echo $paid;
        $data['totaldue'] = $sell-$paid;
        $sqll = mysql_query("SELECT * FROM tbl_customer WHERE Customer_SlNo = '$cid'");
        $rol = mysql_fetch_array($sqll);
        $data['craditlimit'] = $rol['Customer_Credit_Limit'];
        $this->load->view('Administrator/sales/craditlimit', $data);
    }

    function customerwise_sales(){
        $data['title'] = "Customerwise Sales";
        $data['content'] = $this->load->view('Administrator/sales/customerwise_sales', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function customer_sales_search(){
        $data['customerID'] = $this->input->post('customerID', TRUE);
        $data['startdate'] = $this->input->post('startdate', TRUE);
        $data['enddate'] = $this->input->post('enddate', TRUE);
        $this->session->set_userdata($data);
        $this->load->view('Administrator/sales/customer_sales_search', $data);

    }

    function customerwise_branch_sales(){
        $data['title'] = "Branch Customerwise Sales Record";
        $data['content'] = $this->load->view('Administrator/sales/customerwise_branch_sales', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function branch_customer_search(){
        $data['BranchID'] = $this->input->post('BranchID', TRUE);
        $this->load->view('Administrator/sales/branch_customer_search', $data);
    }

    function branch_customer_sales_search(){
        $data['BranchID'] = $this->input->post('BranchID', TRUE);
        $data['customerID'] = $this->input->post('customerID', TRUE);
        $data['startdate'] = $this->input->post('startdate', TRUE);
        $data['enddate'] = $this->input->post('enddate', TRUE);
        $this->session->set_userdata($data);
        $this->load->view('Administrator/sales/branchwise_invoice_product_list', $data);

    }

    function productwise_sales(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Productwise Sales";
        $data['products'] = $this->Product_model->products_by_brunch();
        $data['content'] = $this->load->view('Administrator/sales/productwise_sales', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function product_sales_search(){
        $data['ProductID'] = $this->input->post('ProductID', TRUE);
        $data['startdate'] = $this->input->post('startdate', TRUE);
        $data['enddate'] = $this->input->post('enddate', TRUE);
        $this->session->set_userdata($data);
        $this->load->view('Administrator/sales/product_sales_search', $data);
    }

    function invoice_product_list(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Invoice Product List";
        $data['content'] = $this->load->view('Administrator/sales/sales_record_product_list', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function branchwise_customer_search(){
        $data['BranchID'] = $this->input->post('BranchID', TRUE);
        $this->load->view('Administrator/sales/branchwise_customer_search', $data);
    }

    function invoice_product_list_search(){
        $data['BranchID'] = $this->session->userdata('BRANCHid');
        $data['customerID'] = $this->input->post('customerID', TRUE);
        $data['startdate'] = $this->input->post('startdate', TRUE);
        $data['enddate'] = $this->input->post('enddate', TRUE);
        $this->session->set_userdata($data);
        $this->load->view('Administrator/sales/invoice_product_list', $data);
    }
    
    public function sales_update_form($SaleMaster_SlNo)  {
        // ====================
        $data['products'] = $this->Product_model->products_by_brunch();
        $cusSalesID = $this->db->where('SaleMaster_SlNo', $SaleMaster_SlNo)->get('tbl_salesmaster')->row();
        $Custid =  $cusSalesID->SalseCustomer_IDNo;
        $purchase = 0;
        $paid = 0;
        $customer = $this->db->where('Customer_SlNo', $Custid)->get('tbl_customer')->row();

        // ====================
        $salesMaster = $this->db->where('SalseCustomer_IDNo', $Custid)->select_sum('SaleMaster_DueAmount')->get('tbl_salesmaster')->row();
        $dueAm =  $salesMaster->SaleMaster_DueAmount;

        // ====================
        $salesPaid = $this->db->where('CPayment_customerID',$Custid)->where('CPayment_TransactionType','')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
        $salesPaidAm = $salesPaid->CPayment_amount;

        // ====================
        $paidAmount = $this->db->where('CPayment_customerID',$Custid)->where('CPayment_TransactionType','CR')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
        $paidAm = $paidAmount->CPayment_amount;

        // ====================
        $payAmount = $this->db->where('CPayment_customerID',$Custid)->where('CPayment_TransactionType','CP')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
        $payAm = $payAmount->CPayment_amount;

        // ====================
        $prevDueAmount = $this->db->where('Customer_SlNo',$Custid)->get('tbl_customer')->row();
        // ====================
        $prevDueAmount = $this->db->where('Customer_SlNo',$Custid)->get('tbl_customer')->row();
        if(isset($prevDueAmount->previous_due)):
            $prevDue = $prevDueAmount->previous_due;
        else:
            $prevDue = 0;
        endif;

        $due =($payAm + $dueAm + $prevDue) - ($salesPaidAm + $paidAm);

            
        if($due): 
            $data['dueAmont'] = $due; 
        else: 
            $data['dueAmont'] = 0.00; 
        endif;

        if(isset($customer->Customer_Credit_Limit)):
            $data['craditlimits'] = $customer->Customer_Credit_Limit;
        else:
            $data['craditlimits'] =0;
        endif;


        $this->cart->destroy();
        //echo $SalseCustomer_IDNo;
        $data['title'] = "Product Sales Update";
        $data['sm_cus']=$cus =$this->Billing_model->select_customer_sales_master($SaleMaster_SlNo);

        $data['product_mas_det']= $oldDatas = $this->Billing_model->select_product_sales_details($SaleMaster_SlNo);

        /*8888888888888888888888888888888888888888888888888888888888888888888888888888*/
        foreach ($oldDatas as $oldData):
            $insert_data = array(
                'id' => $oldData->Product_SlNo,
                'name' => $oldData->Product_Name,
                'price' => $oldData->SaleDetails_Rate,
                'saleIn' => $oldData->SaleDetails_Rate,
                'discount_amount' =>$oldData->Discount_amount,
                'purchaserate' => $oldData->Purchase_Rate,
                'qty' => $oldData->SaleDetails_TotalQuantity,
                'SaleMaster_InvoiceNo'=>$cus->SaleMaster_InvoiceNo,
                'SaleDetails_SlNo'=>$oldData->SaleDetails_SlNo,
                'SaleMaster_SlNo'=>$cus->SaleMaster_SlNo,
                'SaleDetails_TotalQuantity'=>$oldData->SaleDetails_TotalQuantity,
                'SaleMaster_TaxAmount'=>$cus->SaleMaster_TaxAmount,
                'SaleMaster_TotalSaleAmount'=>$cus->SaleMaster_TotalSaleAmount,
                'Product_IDNo'=>$oldData->Product_IDNo,
                'SaleMaster_PaidAmount'=>$cus->SaleMaster_PaidAmount,
                'unit'=>$this->Billing_model->getUnitById($oldData->Unit_ID),
            );
        $this->cart->insert($insert_data);
        endforeach;
        /*8888888888888888888888888888888888888888888888888888888888888888888888888888*/

        $data['content'] = $this->load->view('Administrator/sales/product_sales_update', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    
    public function sales_order_update(){

        $salesInvoiceno=$this->input->post('salesInvoiceno');
        $sales_id=$this->input->post('SaleMaster_SlNo');

        /*Salemaster Update*/
        $sales = array(
            "SaleMaster_InvoiceNo"            =>$this->input->post('salesInvoiceno'),
            "SalseCustomer_IDNo"              =>$this->input->post('customerID'),
            "SaleMaster_SaleDate"             =>$this->input->post('sales_date'),
            "SaleMaster_Description"          =>$this->input->post('SelesNotes'),
            "SaleMaster_TotalSaleAmount"      =>$this->input->post('subTotal'),
            "SaleMaster_TotalDiscountAmount"  =>$this->input->post('SellsDiscount'),
            "SaleMaster_RewordDiscount"       =>$this->input->post('Reword_Discount'),
            "SaleMaster_TaxAmount"            =>$this->input->post('vatPersent'),
            "SaleMaster_Freight"              =>$this->input->post('SellsFreight'),
            "SaleMaster_SubTotalAmount"       =>$this->input->post('SellTotals'),
            "SaleMaster_PaidAmount"           =>$this->input->post('SellsPaid'),
            "SaleMaster_DueAmount"            =>$this->input->post('SellsDue'),
            "UpdateBy"                        =>$this->session->userdata("FullName"),
            "SaleMaster_branchid"             =>$this->session->userdata("BRANCHid"),
            "UpdateTime"                      =>date("Y-m-d H:i:s")
        );      
        $this->Billing_model->SalesOrderUpdate($sales,$salesInvoiceno);

        /*Customer Payment Update*/
        $data = array(
            "CPayment_date"       =>$this->input->post('sales_date', TRUE),
            "CPayment_invoice"    =>$this->input->post('salesInvoiceno', TRUE),
            "CPayment_customerID" =>$this->input->post('customerID', TRUE),
            "CPayment_amount"     =>$this->input->post('SellsPaid', TRUE),
            "CPayment_notes"      =>$this->input->post('SelesNotes', TRUE),
            "CPayment_Addby"      =>$this->session->userdata("FullName"),
            "CPayment_brunchid"   =>$this->session->userdata("BRANCHid")
        );

        $this->Billing_model->update_customer_payment_data("tbl_customer_payment", $data,$salesInvoiceno);

        /*CartData Insert Or Update to sale details */
        if ($cart = $this->cart->contents()){
            foreach ($cart as $item){
                $proname = $item['name'];
                    $order_detail = array(
                        'SaleMaster_IDNo'                   => $sales_id,
                        'Product_IDNo'                         => $item['id'],
                        'SaleDetails_TotalQuantity'    => $item['qty'],
                        'SaleDetails_Rate'                     => $item['price'],
                        'SaleDetails_unit'                      => $item['unit'],
                        'Purchase_Rate'                         => $item['purchaserate']
                    );

                    $oldSalesDetail =  $this->db->where('SaleMaster_IDNo',$sales_id)->where('Product_IDNo',$item['id'])->get('tbl_saledetails')->row();
                    if(count($oldSalesDetail)>0):

                        /*update old details*/
                        $this->db->where('SaleMaster_IDNo',$sales_id)->where('Product_IDNo',$item['id'])->update('tbl_saledetails',$order_detail);
                        $newQty  = $item['qty'] - $oldSalesDetail->SaleDetails_TotalQuantity;
                        $item['qty'] = $newQty;
                        $this->_addStock($item);

                    else:

                        /*insert new details*/
                        $this->Billing_model->update_sales_detail($order_detail);
                        $this->_addStock($item);

                    endif;

            }// end foreach
        }// end if

        $this->cart->destroy();
        $sss['lastidforprint'] = $sales_id;
        $this->session->set_userdata($sss);
        echo json_encode(true);
    }

    /*Used in Sales Update*/
    private function _addStock($item){
        // Stock add
        $rox = $this->db->where('sellProduct_IdNo',$item['id'])->get('tbl_saleinventory')->row();
        $id = $rox->SaleInventory_SlNo;
        $oldStock = $rox->SaleInventory_TotalQuantity;

        if($rox->sellProduct_IdNo == $item['id']){
            $addStock = array(
                'sellProduct_IdNo'           => $item['id'],
                'SaleInventory_TotalQuantity'=> $oldStock+$item['qty'],
                'SaleInventory_brunchid'     => $this->sbrunch,
                "UpdateBy"    =>$this->session->userdata("FullName"),
                "UpdateTime"                 =>date("Y-m-d H:i:s")
            );
            $this->mt->update_data("tbl_saleinventory",$addStock,$id,'SaleInventory_SlNo');
        }else{
            $addStock = array(
                'sellProduct_IdNo'            => $item['id'],
                'SaleInventory_TotalQuantity' => $item['qty'],
                'SaleInventory_brunchid'      => $this->sbrunch,
                "AddBy"     =>$this->session->userdata("FullName"),
                "AddTime"                     =>date("Y-m-d H:i:s")
            );
            $this->mt->save_data("tbl_saleinventory",$addStock);
        }
    }


    /*Delete Sales Record*/
    public function  deleteSales(){

        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $saleId = $data->saleId;

            $sale = $this->db->select('*')->where('SaleMaster_SlNo', $saleId)->get('tbl_salesmaster')->row();
            if($sale->Status != 'a'){
                $res = ['success'=>false, 'message'=>'Sale not found'];
                echo json_encode($res);
                exit;
            }
            
            $returnCount = $this->db->query("select * from tbl_salereturn sr where sr.SaleMaster_InvoiceNo = ? and sr.Status = 'a'", $sale->SaleMaster_InvoiceNo)->num_rows();
            
            if($returnCount != 0) {
                $res = ['success'=>false, 'message'=>'Unable to delete. Sale return found'];
                echo json_encode($res);
                exit;
            }

            /*Get Sale Details Data*/
            $saleDetails = $this->db->select('Product_IDNo, SaleDetails_TotalQuantity')->where('SaleMaster_IDNo', $saleId)->get('tbl_saledetails')->result();

            foreach ($saleDetails as $detail){
                /*Get Product Current Quantity*/
                $totalQty = $this->db->where(['product_id' => $detail->Product_IDNo, 'branch_id'=>$sale->SaleMaster_branchid])->get('tbl_currentinventory')->row()->sales_quantity;

                /* Subtract Product Quantity form  Current Quantity  */
                $newQty = $totalQty - $detail->SaleDetails_TotalQuantity;

                    /*Update Sales Inventory*/
                $this->db->set('sales_quantity', $newQty)->where(['product_id' => $detail->Product_IDNo, 'branch_id'=>$sale->SaleMaster_branchid])->update('tbl_currentinventory');

            }

            /*Delete Sale Details*/
            $this->db->set('Status', 'd')->where('SaleMaster_IDNo', $saleId)->update('tbl_saledetails');

            /*Delete Sale Master Data*/
            $this->db->set('Status', 'd')->where('SaleMaster_SlNo', $saleId)->update('tbl_salesmaster');
            $res = ['success'=>true, 'message'=>'Sale deleted'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }






    
//     public function product_delete($id = null){
//       // $id = $this->input->post('deleted');
//        // $id = $this->input->post('SaleDetails_SlNo');
//        $Product_IDNo = $this->input->post('Product_IDNo');
//        $SaleMaster_SlNo = $this->input->post('SaleMaster_SlNo');
//        $SaleMaster_InvoiceNo = $this->input->post('SaleMaster_InvoiceNo');
//        $SaleDetails_TotalQuantity = $this->input->post('SaleDetails_TotalQuantity');
//        $SaleDetailsPrice = $this->input->post('SaleDetailsPrice');
//        $SaleMaster_TotalSaleAmount = $this->input->post('SaleMaster_TotalSaleAmount');
//        $SaleMaster_TaxAmount = $this->input->post('SaleMaster_TaxAmount');
//
//        $fld = 'SaleDetails_SlNo';
//        $delete = $this->mt->delete_data("tbl_saledetails", $id, $fld);
//        if(isset($delete))
//        {
//            $sirow = $this->db->where('sellProduct_IdNo',$Product_IDNo)->get('tbl_saleinventory')->row();
//
//
//            $data1['SaleInventory_TotalQuantity'] = $sirow->SaleInventory_TotalQuantity-$SaleDetails_TotalQuantity;
//            $this->Billing_model->update_saleinventory("tbl_saleinventory",$data1,$Product_IDNo);
//
//            $data2['SaleMaster_TotalSaleAmount'] = $SaleMaster_TotalSaleAmount-$SaleDetailsPrice;
//            $total = $data2['SaleMaster_TotalSaleAmount']/100*$SaleMaster_TaxAmount+$data2['SaleMaster_TotalSaleAmount'];
//            //$data2['SaleMaster_PaidAmount'] = $total;
//            $data2['SaleMaster_SubTotalAmount'] = $total;
//            $this->Billing_model->update_salesmaster("tbl_salesmaster",$data2,$SaleMaster_SlNo);
//        }
//        redirect('Administrator/Sales/sales_update_form/'.$SaleMaster_SlNo,'refresh');
//    }

    function profitLoss(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Profit & Loss ";
        $data['products'] = $this->Product_model->products_by_brunch();
        $data['content'] = $this->load->view('Administrator/sales/profit_loss', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }   
    function profitLossSearch(){
        $data['searchtype'] = $this->input->post('searchtype');
        $data['ProductID'] = $this->input->post('ProductID');
        $data['startdate'] = $this->input->post('startdate');
        $data['enddate'] = $this->input->post('enddate');
        $this->session->set_userdata($data);
        $this->load->view('Administrator/sales/profit_loss_search', $data);
    }

    public function getProfitLoss(){
        $data = json_decode($this->input->raw_input_stream);

        $customerClause = "";
        if($data->customer != null && $data->customer != ''){
            $customerClause = " and sm.SalseCustomer_IDNo = '$data->customer'";
        }

        $dateClause = "";
        if(($data->dateFrom != null && $data->dateFrom != '') && ($data->dateTo != null && $data->dateTo != '')){
            $dateClause = " and sm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
        }


        $sales = $this->db->query("
            select 
                sm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile
            from tbl_salesmaster sm
            join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where sm.SaleMaster_branchid = ? 
            and sm.Status = 'a'
            $customerClause $dateClause
        ", $this->session->userdata('BRANCHid'))->result();

        foreach($sales as $sale){
            $sale->saleDetails = $this->db->query("
                select
                    sd.*,
                    p.Product_Code,
                    p.Product_Name,
                    (sd.Purchase_Rate * sd.SaleDetails_TotalQuantity) as purchased_amount,
                    (select sd.SaleDetails_TotalAmount - purchased_amount) as profit_loss
                from tbl_saledetails sd 
                join tbl_product p on p.Product_SlNo = sd.Product_IDNo
                where sd.SaleMaster_IDNo = ?
            ", $sale->SaleMaster_SlNo)->result();
        }

        echo json_encode($sales);
    }

    public function chalan($saleId){
        $data['title'] = "Chalan Invoice";
        $data['saleId'] = $saleId;
        $data['content'] = $this->load->view('Administrator/sales/chalan', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function checkSaleReturn($invoice)
    {
        $res = ['found'=>false];

        $returnCount = $this->db->query("select * from tbl_salereturn where SaleMaster_InvoiceNo = ? and Status = 'a'", $invoice)->num_rows();
            
        if($returnCount != 0) {
            $res = ['found'=>true];
        }

        echo json_encode($res);
    }
}
