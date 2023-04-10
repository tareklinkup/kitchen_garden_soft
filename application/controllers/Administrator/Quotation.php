<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {
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
    }
	
    public function index()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Quotation Entry";
        $data['quotationId'] = 0;
        $data['invoice'] = $this->mt->generateQuotationInvoice();
        $data['content'] = $this->load->view('Administrator/quotation/quotation_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    public function addQuotation(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $invoice = $data->quotation->invoiceNo;
            $invoiceCount = $this->db->query("select * from tbl_quotation_master where SaleMaster_InvoiceNo = ?", $invoice)->num_rows();
            if($invoiceCount != 0){
                $invoice = $this->mt->generateQuotationInvoice();
            }

            $quotation = array(
                'SaleMaster_InvoiceNo' => $invoice,
                'SaleMaster_SaleDate' => $data->quotation->quotationDate,
                'SaleMaster_customer_name' => $data->quotation->customerName,
                'SaleMaster_customer_mobile' => $data->quotation->customerMobile,
                'SaleMaster_customer_address' => $data->quotation->customerAddress,
                'SaleMaster_TotalSaleAmount' => $data->quotation->total,
                'SaleMaster_TotalDiscountAmount' => $data->quotation->discount,
                'SaleMaster_TaxAmount' => $data->quotation->vat,
                'SaleMaster_SubTotalAmount' => $data->quotation->subTotal,
                'Status' => 'a',
                "AddBy" => $this->session->userdata("FullName"),
                'AddTime' => date("Y-m-d H:i:s"),
                'SaleMaster_branchid' => $this->session->userdata("BRANCHid")
            );
    
            $this->db->insert('tbl_quotation_master', $quotation);
            
            $quotationId = $this->db->insert_id();
    
            foreach($data->cart as $cartProduct){
                $quotationDetails = array(
                    'SaleMaster_IDNo' => $quotationId,
                    'Product_IDNo' => $cartProduct->productId,
                    'SaleDetails_TotalQuantity' => $cartProduct->quantity,
                    'SaleDetails_Rate' => $cartProduct->salesRate,
                    'SaleDetails_TotalAmount' => $cartProduct->total,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date('Y-m-d H:i:s'),
                    'SaleDetails_BranchId' => $this->session->userdata('BRANCHid')
                );
    
                $this->db->insert('tbl_quotation_details', $quotationDetails);
            }

            $res = ['success'=>true, 'message'=>'Quotation added', 'quotationId'=>$quotationId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateQuotation(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $quotationId = $data->quotation->quotationId;

            $quotation = array(
                'SaleMaster_InvoiceNo' => $data->quotation->invoiceNo,
                'SaleMaster_SaleDate' => $data->quotation->quotationDate,
                'SaleMaster_customer_name' => $data->quotation->customerName,
                'SaleMaster_customer_mobile' => $data->quotation->customerMobile,
                'SaleMaster_customer_address' => $data->quotation->customerAddress,
                'SaleMaster_TotalSaleAmount' => $data->quotation->total,
                'SaleMaster_TotalDiscountAmount' => $data->quotation->discount,
                'SaleMaster_TaxAmount' => $data->quotation->vat,
                'SaleMaster_SubTotalAmount' => $data->quotation->subTotal,
                'Status' => 'a',
                "AddBy" => $this->session->userdata("FullName"),
                'AddTime' => date("Y-m-d H:i:s"),
                'SaleMaster_branchid' => $this->session->userdata("BRANCHid")
            );
    
            $this->db->where('SaleMaster_SlNo', $quotationId)->update('tbl_quotation_master', $quotation);

            $this->db->query("delete from tbl_quotation_details where SaleMaster_IDNo = ?", $quotationId);
            
            foreach($data->cart as $cartProduct){
                $quotationDetails = array(
                    'SaleMaster_IDNo' => $quotationId,
                    'Product_IDNo' => $cartProduct->productId,
                    'SaleDetails_TotalQuantity' => $cartProduct->quantity,
                    'SaleDetails_Rate' => $cartProduct->salesRate,
                    'SaleDetails_TotalAmount' => $cartProduct->total,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date('Y-m-d H:i:s'),
                    'SaleDetails_BranchId' => $this->session->userdata('BRANCHid')
                );
    
                $this->db->insert('tbl_quotation_details', $quotationDetails);
            }
            
            $res = ['success'=>true, 'message'=>'Quotation updated', 'quotationId'=>$quotationId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function quotationRecord(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Quotation Record";
        $data['content'] = $this->load->view('Administrator/quotation/quotation_record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getQuotations(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and qm.SaleMaster_SaleDate between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->quotationId) && $data->quotationId != ''){
            $clauses .= " and qm.SaleMaster_SlNo = '$data->quotationId'";
            $res['quotationDetails'] = $this->db->query("
                select 
                    qd.*,
                    p.Product_Code,
                    p.Product_Name,
                    pc.ProductCategory_Name,
                    u.Unit_Name

                from tbl_quotation_details qd
                join tbl_product p on p.Product_SlNo = qd.Product_IDNo
                join tbl_unit u on u.Unit_SlNo = p.Unit_ID
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where qd.SaleMaster_IDNo = ?
            ", $data->quotationId)->result();
        }

        $res['quotations'] = $this->db->query("
            select * from tbl_quotation_master qm 
            where qm.Status = 'a'
            and qm.SaleMaster_branchid = ?
            $clauses
            order by qm.SaleMaster_SlNo desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($res);
    }

    public function editQuotation($quotationId){
        $data['title'] = "Quotation Edit";
        $data['quotationId'] = $quotationId;
        $data['invoice'] = '';
        $data['content'] = $this->load->view('Administrator/quotation/quotation_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function deleteQuotation(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $this->db->query("delete from tbl_quotation_master where SaleMaster_SlNo = ?", $data->quotationId);
            $this->db->query("delete from tbl_quotation_details where SaleMaster_IDNo = ?", $data->quotationId);
            $res = ['success'=>true, 'message'=>'Quotation deleted'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }
        
        echo json_encode($res);
    }


    public function checkInvoice() {
        $invoice = $this->input->post('invoice');
        $row = $this->db->query("SELECT * FROM tbl_quotation_master WHERE SaleMaster_InvoiceNo = '$invoice'")->row();
        if($row->SaleMaster_InvoiceNo == $invoice){
            return true;
        }else{
            return false; 
        } 
    }

    
    public function quotation_report()  {
        $data['title'] = "Quotation Report";
        $id = $this->session->userdata('lastidforprint');
		$data['selse'] =  $this->Quotation_model->find_quotation_info_by_id($id);
		$data['quo_details'] = $this->Quotation_model->get_invoice_wise_quotation_product_details($id);
		$data['SalesID'] = $id;

        $data['content'] = $this->load->view('Administrator/quotation/quotationReport', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    
    public function quotationInvoice($quotationId)  {
        $data['title'] = "Quotation Invoice";
        $data['quotationId'] = $quotationId;
        $data['content'] = $this->load->view('Administrator/quotation/quotation_invoice', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function quotationInvoiceReport()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Quotation Invoice";
        $data['content'] = $this->load->view('Administrator/quotation/quotation_invoice_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function delete_quotation_invoice() {
        $id = $this->input->post('SaleMasteriD');

        $attr = array( 'Status'  =>  'd' );

        $qu = $this->db->where('SaleMaster_SlNo', $id)->update('tbl_quotation_master', $attr);
        
        if ( $this->db->affected_rows()) {
            return TRUE;
        }else {
            return FALSE;
        }
    }




}
