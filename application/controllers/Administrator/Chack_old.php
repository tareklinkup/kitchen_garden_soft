<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chack_old extends CI_Controller {
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
    public function Bank_Check_From_Customer(){
        $data['title'] = "Bank Check From Customer";
        $data['content'] = $this->load->view('Administrator/chack/Bank_Check_From_Customer', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Bank_Check_From_Supplier(){
        $data['title'] = "Bank Check From Supplier";
        $data['content'] = $this->load->view('Administrator/chack/Bank_Check_From_Supplier', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Bank_Check_Reminder(){
        $data['title'] = "Bank Check Reminder";
        $data['content'] = $this->load->view('Administrator/chack/Bank_Check_Reminder', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function previous_Check_search_page(){
        $data['title'] = "Previous Check";
        $data['content'] = $this->load->view('Administrator/chack/previous_check_search', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Bank_ckect_insert(){        
        $Customer=$this->input->post('Customer');
        $Check_No=$this->input->post('Check_No');
        $Bank_Name=$this->input->post('Bank_Name');
        $Amount=$this->input->post('Amount');
        $Issu_Date=$this->input->post('Issu_Date');
        $Check_Date=$this->input->post('Check_Date');
        $Reminder_Date=$this->input->post('Reminder_Date');
        $query = $this->db->query("SELECT Check_No from bank_check_customer where Check_No = '$Check_No'");
        
        if($query->num_rows() > 0){
            echo "Cheque Already Exists";
        }
        else{
            $data = array(
                'Customer_id' => $Customer, 
                'Check_No' => $Check_No, 
                'Bank_Name' => $Bank_Name, 
                'Amount' => $Amount, 
                'Issu_Date' => $Issu_Date, 
                'Check_Date' => $Check_Date, 
                'Reminder_Date' => $Reminder_Date, 
                'status' => 'C', 
                'action' => 'P',
                'bank_check_brunchID'=> $this->sbrunch
            );
            $this->mt->save_data('bank_check_customer',$data);
            $this->load->view('Administrator/ajax/bank_check_customer');
        }
    }
    public function Bank_ckect_Approved(){
        $id=$this->input->post('id');
        $fld='SiNo';
        $data = array('action' => 'A', );
        $this->mt->update_data("bank_check_customer", $data, $id,$fld);
        $this->load->view('Administrator/ajax/bank_check_customer');
    }
    public function Bank_ckect_insert_supplier(){
        $Customer=$this->input->post('Customer');
        $Check_No=$this->input->post('Check_No');
        $Bank_Name=$this->input->post('Bank_Name');
        $Amount=$this->input->post('Amount');
        $Issu_Date=$this->input->post('Issu_Date');
        $Check_Date=$this->input->post('Check_Date');
        $Reminder_Date=$this->input->post('Reminder_Date');
        $query = $this->db->query("SELECT Check_No from bank_check_customer where Check_No = '$Check_No'");
        
        if($query->num_rows() > 0){
            echo "Cheque Already Exists";
        }
        else{
            $data = array(
                'Customer_id' => $Customer, 
                'Check_No' => $Check_No, 
                'Bank_Name' => $Bank_Name, 
                'Amount' => $Amount, 
                'Issu_Date' => $Issu_Date, 
                'Check_Date' => $Check_Date, 
                'Reminder_Date' => $Reminder_Date, 
                'status' => 'S', 
                'action' => 'P',
                'bank_check_brunchID'=> $this->sbrunch 
            );
            $this->mt->save_data('bank_check_customer',$data);
            $this->load->view('Administrator/ajax/bank_check_supplier');
        }
    }
    public function Bank_ckect_Approved_supplier(){
        $id=$this->input->post('id');
        $fld='SiNo';
        $data = array('action' => 'A', );
        $this->mt->update_data("bank_check_customer", $data, $id,$fld);
        $this->load->view('Administrator/ajax/bank_check_supplier');
    }
    public function check_reminder_search(){
        $brunch = $this->session->userdata('BRANCHid');
        $dAta['type']=$type=$this->input->post('type');
        $dAta['customerID']=$customerID=$this->input->post('customerID');
        $dAta['supplierID']=$supplierID=$this->input->post('supplierID');
        $dAta['startdate']=$startdate=$this->input->post('startdate');
        $dAta['enddate']=$enddate=$this->input->post('enddate');        
        $this->session->set_userdata($dAta);
        if ($type=='Customer') {
            if ($customerID=='All') {
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C' AND bank_check_customer.action='P' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/check_reminder_search',$datas);
            }else{
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C' AND bank_check_customer.action='P' AND bank_check_customer.Customer_id='$customerID' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/check_reminder_search',$datas);
            }
        }elseif($type=='Supplier'){
            if ($customerID=='All') {
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_supplier.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_supplier ON tbl_supplier.Supplier_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='S' AND bank_check_customer.action='P' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/check_reminder_search_supplier',$datas);
            }else{
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_supplier.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_supplier ON tbl_supplier.Supplier_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='S' AND bank_check_customer.action='P' AND bank_check_customer.Customer_id='$customerID' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/check_reminder_search_supplier',$datas);
            }
        }
        
        
    }
    public function Bank_ckect_Approved_reminder(){
        $brunch = $this->session->userdata('BRANCHid');
        $id=$this->input->post('id');
        $fld='SiNo';
        $data = array('action' => 'A', );
        $this->mt->update_data("bank_check_customer", $data, $id,$fld);
        $startdate=$this->session->userdata("startdate");
        $enddate=$this->session->userdata("enddate");
        $customerID=$this->session->userdata("customerID");
        
        if ($customerID=='All') {
            $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C' AND bank_check_customer.action='P' AND bank_check_customer.bank_check_brunchID='$brunch'");
            $datas['alldata']=$q->result_array();
            $this->load->view('Administrator/ajax/check_reminder_search',$datas);
        }else{
            $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C' AND bank_check_customer.action='P' AND bank_check_customer.Customer_id='$customerID' AND bank_check_customer.bank_check_brunchID='$brunch'");
            $datas['alldata']=$q->result_array();
            $this->load->view('Administrator/ajax/check_reminder_search',$datas);
        }
    }

    public function previous_check_search(){
        $brunch = $this->session->userdata('BRANCHid');
        $dAta['type']=$type=$this->input->post('type');
        $dAta['customerID']=$customerID=$this->input->post('customerID');
        $dAta['supplierID']=$supplierID=$this->input->post('supplierID');
        $dAta['startdate']=$startdate=$this->input->post('startdate');
        $dAta['enddate']=$enddate=$this->input->post('enddate');        
        $this->session->set_userdata($dAta);
        if ($type=='Customer') {
            if ($customerID=='All') {
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C' AND bank_check_customer.action='A' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/previous_check_search',$datas);
            }else{
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C' AND bank_check_customer.action='A' AND bank_check_customer.Customer_id='$customerID' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/previous_check_search',$datas);
            }
        }elseif($type=='Supplier'){
            if ($customerID=='All') {
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_supplier.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_supplier ON tbl_supplier.Supplier_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='S' AND bank_check_customer.action='A' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/previous_check_search',$datas);
            }else{
                $q=$this->db->query("SELECT bank_check_customer.*,tbl_supplier.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_supplier ON tbl_supplier.Supplier_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='S' AND bank_check_customer.action='A' AND bank_check_customer.Customer_id='$customerID' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/previous_check_search',$datas);
            }
        }
        
        
    }
    
    public function supplierDue(){
        $Supplierid=$this->input->post('Customer');
        $sql = "SELECT tbl_purchasemaster.*, tbl_supplier.* FROM tbl_purchasemaster left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo WHERE tbl_purchasemaster.Supplier_SlNo = '$Supplierid'  group by tbl_purchasemaster.Supplier_SlNo";
        $datas["record"] = $this->mt->ccdata($sql);
        
        $this->load->view('Administrator/chack/supplier_due', $datas);
    }
    public function chackSearch(){
        $brunch=$this->sbrunch;
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $q=$this->db->query("SELECT bank_check_customer.*,tbl_customer.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='C'  AND bank_check_customer.bank_check_brunchID='$brunch'");
        $datas['alldata']=$q->result_array();
        $this->load->view('Administrator/ajax/chackSearch',$datas);
    }
    public function chackSearchSupplier(){
        $brunch=$this->sbrunch;
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $q=$this->db->query("SELECT bank_check_customer.*,tbl_supplier.*,tbl_bank.* FROM bank_check_customer LEFT JOIN tbl_supplier ON tbl_supplier.Supplier_SlNo=bank_check_customer.Customer_id LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=bank_check_customer.Bank_Name WHERE bank_check_customer.Reminder_Date BETWEEN '$startdate' AND '$enddate' AND bank_check_customer.status='S' AND bank_check_customer.bank_check_brunchID='$brunch'");
                $datas['alldata']=$q->result_array();
                $this->load->view('Administrator/ajax/chackSearchSupplier',$datas);
    }

}
