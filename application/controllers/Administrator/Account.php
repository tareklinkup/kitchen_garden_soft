<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
		$this->load->model('Billing_model');
    }
    public function index()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Add Account";
        $data['accountCode'] = $this->mt->generateAccountCode();
        $data['content'] = $this->load->view('Administrator/account/add_account', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
   
    public function addAccount() {
        $res = ['success'=>false, 'message'=>'Nothing'];
        try{
            $accountObj = json_decode($this->input->raw_input_stream);

            $duplicateCodeCount = $this->db->query("select * from tbl_account where Acc_Code = ?", $accountObj->Acc_Code)->num_rows();
            if($duplicateCodeCount != 0){
                $accountObj = $this->mt->generateAccountCode();
            }

            $duplicateNameCount = $this->db->query("select * from tbl_account where Acc_Name = ? and branch_id = ?", [$accountObj->Acc_Name, $this->brunch])->num_rows();
            if($duplicateNameCount != 0){
                $this->db->query("update tbl_account set status = 'a' where Acc_Name = ? and branch_id = ?", [$accountObj->Acc_Name, $this->brunch]);
                $res = ['success'=>true, 'message'=>'Account activated', 'newAccountCode'=>$this->mt->generateAccountCode()];
                echo json_encode($res);
                exit;
            }

            $account = (array)$accountObj;
            unset($account['Acc_SlNo']);
            $account['status'] = 'a';
            $account['AddBy'] = $this->session->userdata("FullName");
            $account['AddTime'] = date('Y-m-d H:i:s');
            $account['branch_id'] = $this->brunch;

            $this->db->insert('tbl_account', $account);

            $res = ['success'=>true, 'message'=>'Account added', 'newAccountCode'=>$this->mt->generateAccountCode()];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }
	
    public function account_insertFanceybox()  {
        $mail = $this->input->post('accountName');
        $query = $this->db->query("SELECT Acc_Name from tbl_account where Acc_Name = '$mail'");
        
        if($query->num_rows() > 0){
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/add_account',$data);
        }
        else{
            $data = array(
                "Acc_Code"          =>$this->input->post('account_id', TRUE),
                "Acc_Name"          =>$this->input->post('accountName', TRUE),
                "Acc_Type"          =>$this->input->post('accounttype', TRUE),
                "Acc_Description"          =>$this->input->post('Description', TRUE),
                "AddBy"                  =>$this->session->userdata("FullName"),
                "AddTime"                =>date("Y-m-d H:i:s")
                );
            $this->mt->save_data('tbl_account',$data);
            $this->load->view('Administrator/ajax/transaction/fancyboxResultOffice');
        }
    }
    
   
    public function addAccountTrans() {
        $this->load->view('Administrator/account/add_account_in_trans');
    }
   
    public function account_edit() {
        $id = $this->input->post('edit');
        $query = $this->db->query("SELECT * from tbl_account where Acc_SlNo = '$id'");
		
        $data['selected'] = $query->row();
        //$data['content'] = $this->load->view('Administrator/edit/supplier_edit', $data, TRUE);
        $this->load->view('Administrator/edit/account_edit', $data);
    }
    public function updateAccount(){
        $res = ['success'=>false, 'message'=>'Nothing'];
        try{
            $accountObj = json_decode($this->input->raw_input_stream);

            $duplicateNameCount = $this->db->query("select * from tbl_account where Acc_Name = ? and branch_id = ? and Acc_SlNo != ?", [$accountObj->Acc_Name, $this->brunch, $accountObj->Acc_SlNo])->num_rows();
            if($duplicateNameCount != 0){
                $this->db->query("update tbl_account set status = 'a' where Acc_Name = ? and branch_id = ?", [$accountObj->Acc_Name, $this->brunch]);
                $res = ['success'=>true, 'message'=>'Account activated', 'newAccountCode'=>$this->mt->generateAccountCode()];
                echo json_encode($res);
                exit;
            }

            $account = (array)$accountObj;
            unset($account['Acc_SlNo']);
            $account['UpdateBy'] = $this->session->userdata("FullName");
            $account['UpdateTime'] = date('Y-m-d H:i:s');

            $this->db->where('Acc_SlNo', $accountObj->Acc_SlNo)->update('tbl_account', $account);

            $res = ['success'=>true, 'message'=>'Account updated', 'newAccountCode'=>$this->mt->generateAccountCode()];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    } 
    public function deleteAccount(){
        $res = ['success'=>false, 'message'=>'Nothing'];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("update tbl_account set status = 'd' where Acc_SlNo = ?", $data->accountId);

            $res = ['success'=>true, 'message'=>'Account deleted'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }

    public function getAccounts(){
        $accounts = $this->db->query("select * from tbl_account where status = 'a' and branch_id = ?", $this->session->userdata('BRANCHid'))->result();
        echo json_encode($accounts);
    }
    // Cash Transaction
    public function cash_transaction()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Cash Transaction";
		$data['transaction'] = $this->Billing_model->select_all_transaction();
        $data['accounts'] = $this->Other_model->get_all_account_info();
        $data['content'] = $this->load->view('Administrator/account/cash_transaction', $data, TRUE);
        $this->load->view('Administrator/index', $data);

    }
    public function fancybox_add_account()  {
        $this->load->view('Administrator/ajax/fanceybox_add_account');
    }
    public function AccountType()  {
        $acc_type = $this->input->post('acc_type');
        if($acc_type=="Customer"){
            $this->load->view('Administrator/ajax/transaction/customer');
        }
        elseif($acc_type=="Official"){
            $this->load->view('Administrator/ajax/transaction/Official');
        }
        elseif($acc_type=="Supplier"){
            $this->load->view('Administrator/ajax/transaction/Supplier');
        }
    }
    public function OnselectName()  {
        $acc_type = $this->input->post('acc_type');
        $account_id = $this->input->post('account_id');
        if($acc_type=="Customer"){
            $query = "SELECT * from tbl_customer where Customer_SlNo = '$account_id'";
            $data['selected'] = $this->mt->edit_by_id($query);
            $this->load->view('Administrator/ajax/transaction/customer_name', $data);
        }
        elseif($acc_type=="Official"){
            $query = "SELECT * from tbl_account where Acc_SlNo = '$account_id'";
            $data['selected'] = $this->mt->edit_by_id($query);
            $this->load->view('Administrator/ajax/transaction/official_name', $data);
        }
        elseif($acc_type=="Supplier"){
            $query = "SELECT * from tbl_supplier where Supplier_SlNo = '$account_id'";
            $data['selected'] = $this->mt->edit_by_id($query);
            $this->load->view('Administrator/ajax/transaction/supplier_name', $data);
        }
    }
    public function AutoSelect()  {
        $tr_type = $this->input->post('tr_type');
        if($tr_type== "Deposit To Bank" or $tr_type== "Withdraw Form Bank"){
            $this->load->view('Administrator/ajax/transaction/Office_autoSelect');  
        }else{
            $this->load->view('Administrator/ajax/transaction/Office_None_Select');  
        }
    
    }

    public function fatch_all_account_id()  {
        $data = $this->Other_model->get_all_account_info();
        echo json_encode($data);
    }


    public function fatch_account_id()  {
        $id = $this->input->post('id');
        $attr = array('Acc_Tr_Type' =>  $id, 'status' =>  'a');
        $query = $this->db->get_where('tbl_account', $attr);
        $data = $query->result();
        echo json_encode($data);
    }

    public function getCashTransactions(){
        $data = json_decode($this->input->raw_input_stream);

        $dateClause = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $dateClause = " and ct.Tr_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $transactionTypeClause = "";
        if(isset($data->transactionType) && $data->transactionType != '' && $data->transactionType == 'received'){
            $transactionTypeClause = " and ct.Tr_Type = 'In Cash'";
        }
        if(isset($data->transactionType) && $data->transactionType != '' && $data->transactionType == 'paid'){
            $transactionTypeClause = " and ct.Tr_Type = 'Out Cash'";
        }

        $accountClause = "";
        if(isset($data->accountId) && $data->accountId != ''){
            $accountClause = " and ct.Acc_SlID = '$data->accountId'";
        }

        $transactions = $this->db->query("
            select 
                ct.*,
                a.Acc_Name
            from tbl_cashtransaction ct
            join tbl_account a on a.Acc_SlNo = ct.Acc_SlID
            where ct.status = 'a'
            and ct.Tr_branchid = ?
            $dateClause $transactionTypeClause $accountClause
            order by ct.Tr_SlNo desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($transactions);
    }

    public function getCashTransactionCode(){
        echo json_encode($this->mt->generateCashTransactionCode());
    }

    public function addCashTransaction()  {
        $res = ['success'=>false, 'message'=>''];
        try{
            $transactionObj = json_decode($this->input->raw_input_stream);

            $transaction = (array)$transactionObj;
            $transaction['status'] = 'a';
            $transaction['AddBy'] = $this->session->userdata("FullName");
            $transaction['AddTime'] = date('Y-m-d H:i:s');
            $transaction['Tr_branchid'] = $this->session->userdata('BRANCHid');

            $this->db->insert('tbl_cashtransaction', $transaction);

            $res = ['success'=>true, 'message'=>'Transaction added'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateCashTransaction()  {
        $res = ['success'=>false, 'message'=>''];
        try{
            $transactionObj = json_decode($this->input->raw_input_stream);

            $transaction = (array)$transactionObj;
            unset($transaction['Tr_SlNo']);
            $transaction['UpdateBy'] = $this->session->userdata("FullName");
            $transaction['UpdateTime'] = date('Y-m-d H:i:s');

            $this->db->where('Tr_SlNo', $transactionObj->Tr_SlNo)->update('tbl_cashtransaction', $transaction);

            $res = ['success'=>true, 'message'=>'Transaction updated'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function deleteCashTransaction()  {
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $this->db->set(['status'=>'d'])->where('Tr_SlNo', $data->transactionId)->update('tbl_cashtransaction');

            $res = ['success'=>true, 'message'=>'Transaction deleted'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }
	
    public function cash_transaction_edit() {
        $id = $this->input->post('edit');
        $query = $this->db->query("SELECT tbl_cashtransaction.*,tbl_account.*,tbl_bank.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=tbl_cashtransaction.Tr_Bank_Id where tbl_cashtransaction.Tr_SlNo = '$id'");
        $data['selected'] = $query->row();
        //$data['transaction'] = $this->Billing_model->select_all_transaction();
        $this->load->view('Administrator/edit/cash_transection_Edit', $data);
    }
	
    public function viewTransaction($id) {
        $query = $this->db->query("SELECT tbl_cashtransaction.*,tbl_account.*,tbl_bank.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID LEFT JOIN tbl_bank ON tbl_bank.Bank_SiNo=tbl_cashtransaction.Tr_Bank_Id where tbl_cashtransaction.Tr_SlNo = '$id'");
        $data['selected'] = $query->row();
		 //echo "<pre>";print_r($data['selected']);exit;
        $this->load->view('Administrator/account/cash_transection_view', $data);
    }
    public function cash_transaction_delete(){
        $id = $this->input->post('deleted');
        $fld = 'Tr_SlNo';
        if($this->mt->delete_data("tbl_cashtransaction", $id, $fld)){
			$message = 'Delete Success';
			echo json_encode($message);
		}
    }
    public function cash_transaction_update(){
        $id = $this->input->post('id');
        $fld = 'Tr_SlNo';
        $atype = $this->input->post('acc_type');
        $TrType = $this->input->post('tr_type');

        /* if($atype=="Official" && $TrType=="Cash Receive"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Acc_SlID"              =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "In_Amount"             =>$this->input->post('Amount', TRUE),
                "Out_Amount"            =>0,
                "Tr_Bank_Id"			=>$this->input->post('Bank_id', TRUE),
                "ChequeNumber"			=>$this->input->post('ChequeNumber', TRUE),
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "Tr_branchid"           =>$this->session->userdata("BRANCHid"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        }
        elseif($atype=="Official" && $TrType=="Cash Payment"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Acc_SlID"              =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "In_Amount"             =>0,
                "Out_Amount"            =>$this->input->post('Amount', TRUE),
                "Tr_Bank_Id"			=>$this->input->post('Bank_id', TRUE),
                "ChequeNumber"			=>$this->input->post('ChequeNumber', TRUE),
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "Tr_branchid"           =>$this->session->userdata("BRANCHid"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        } */
        //elseif($atype=="Official" && $TrType=="Deposit To Bank"){
			if($atype=="Official" && $TrType=="Deposit To Bank"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Acc_SlID"              =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "Out_Amount"            =>$this->input->post('Amount', TRUE),
                "In_Amount"             =>0,
                "Tr_Bank_Id"			=>$this->input->post('Bank_id', TRUE),
                "ChequeNumber"			=>$this->input->post('ChequeNumber', TRUE),
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "Tr_branchid"           =>$this->session->userdata("BRANCHid"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        }
        elseif($atype=="Official" && $TrType=="Withdraw Form Bank"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Acc_SlID"              =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "In_Amount"             =>$this->input->post('Amount', TRUE),
                "Out_Amount"            =>0,
                "Tr_Bank_Id"			=>$this->input->post('Bank_id', TRUE),
                "ChequeNumber"			=>$this->input->post('ChequeNumber', TRUE),
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "Tr_branchid"           =>$this->session->userdata("BRANCHid"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        } elseif($atype=="Official" && $TrType=="Out Cash"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Acc_SlID"              =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "In_Amount"             =>0,
                "Out_Amount"            =>$this->input->post('Amount', TRUE),
                "Tr_Bank_Id"			=>$this->input->post('Bank_id', TRUE),
                "ChequeNumber"			=>$this->input->post('ChequeNumber', TRUE),
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "Tr_branchid"           =>$this->session->userdata("BRANCHid"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        } elseif($atype=="Official" && $TrType=="Income"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Acc_SlID"              =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "In_Amount"             =>$this->input->post('Amount', TRUE),
                "Out_Amount"            =>0,
                "Tr_Bank_Id"			=>$this->input->post('Bank_id', TRUE),
                "ChequeNumber"			=>$this->input->post('ChequeNumber', TRUE),
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "Tr_branchid"           =>$this->session->userdata("BRANCHid"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        }
        /*elseif($atype=="Supplier"){
            $data = array(
                "Tr_Id"                 =>$this->input->post('Transaction_id', TRUE),
                "Tr_date"               =>$this->input->post('DaTe', TRUE),
                "Tr_Type"               =>$this->input->post('tr_type', TRUE),
                "Tr_account_Type"       =>$this->input->post('acc_type', TRUE),
                "Supplier_SlID"         =>$this->input->post('account_id', TRUE),
                "Tr_Description"        =>$this->input->post('Description', TRUE),
                "Out_Amount"            =>$this->input->post('Amount', TRUE),
                "In_Amount"             =>0,
                "UpdateBy"              =>$this->session->userdata("FullName"),
                "UpdateTime"            =>date("Y-m-d H:i:s")
            ); 
        }*/
        
		if($this->mt->update_data("tbl_cashtransaction", $data, $id,$fld)){
			$message = "Transaction Update Successful";
			echo json_encode($message);
		}
        //$this->load->view('Administrator/ajax/cash_transection', $data);
    } 
    
    function all_transaction_report()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Cash Transaction Report";
		$data['content'] = $this->load->view('Administrator/account/all_transaction_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function transaction_report_search()  {
        $dAta['startdate']=$startdate = $this->input->post('startdate');
        $dAta['enddate']=$enddate = $this->input->post('enddate');
        $dAta['accountid']=$accountid = $this->input->post('accountid');
        $dAta['searchtype']=$searchtype = $this->input->post('searchtype');
        $this->session->set_userdata($dAta);
        $BRANCHid = $this->session->userdata('BRANCHid');

        if($searchtype == 'All'){
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
        
        $this->load->view('Administrator/account/transaction_report_list', $datas);
    }
    
    function deposit()  {
        $data['title'] = "Deposit Information";
        $data['content'] = $this->load->view('Administrator/account/deposit_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    function deposit_search()  {
        $dAta['startdate']=$startdate = $this->input->post('startdate');
        $dAta['enddate']=$enddate = $this->input->post('enddate');
        $dAta['accountid']=$accountid = $this->input->post('accountid');
        $dAta['searchtype']=$searchtype = $this->input->post('searchtype');
        $this->session->set_userdata($dAta);
        $BRANCHid = $this->session->userdata('BRANCHid');
		
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Deposit To Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
           // $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_date between '$expence_startdate' and '$expence_enddate'";
			$sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Deposit To Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$query = $this->db->query($sql);
        $datas["record"] = $query->result();
        
        $this->load->view('Administrator/account/deposit_search_list', $datas);
    }
	
    function withdraw()  {
        $data['title'] = "Withdraw Information";
        $data['content'] = $this->load->view('Administrator/account/withdraw_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    function withdraw_search()  {
        $dAta['startdate']=$startdate = $this->input->post('startdate');
        $dAta['enddate']=$enddate = $this->input->post('enddate');
        $dAta['accountid']=$accountid = $this->input->post('accountid');
        $dAta['searchtype']=$searchtype = $this->input->post('searchtype');
        $this->session->set_userdata($dAta);
        $BRANCHid = $this->session->userdata('BRANCHid');
		
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Withdraw Form Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
			$sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Withdraw Form Bank' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$query = $this->db->query($sql);
        $datas["record"] = $query->result();
        
        $this->load->view('Administrator/account/withdraw_search_list', $datas);
    }
	
    function expense()  {
        $data['title'] = "Out Cash Information";
        $data['content'] = $this->load->view('Administrator/account/expense_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    function expense_search()  {
        $dAta['startdate']=$startdate = $this->input->post('startdate');
        $dAta['enddate']=$enddate = $this->input->post('enddate');
        $dAta['accountid']=$accountid = $this->input->post('accountid');
        $dAta['searchtype']=$searchtype = $this->input->post('searchtype');
        $this->session->set_userdata($dAta);
        $BRANCHid = $this->session->userdata('BRANCHid');
		
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Out Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
			$sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='Out Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$query = $this->db->query($sql);
        $datas["record"] = $query->result();
        
        $this->load->view('Administrator/account/expense_search_list', $datas);
    }

    function getOtherIncomeExpense(){
        $data = json_decode($this->input->raw_input_stream);

        $transactionDateClause = "";
        $employePaymentDateClause = "";
        $profitDistributeDateClause = "";
        $loanInterestDateClause = "";
        $assetsSalesDateClause = "";
        $damageClause = "";
        $returnClause = "";
        $purchaseClause = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $transactionDateClause = " and ct.Tr_date between '$data->dateFrom' and '$data->dateTo'";
            $employePaymentDateClause = " and ep.payment_date between '$data->dateFrom' and '$data->dateTo'";
            $profitDistributeDateClause = " and it.transaction_date between '$data->dateFrom' and '$data->dateTo'";
            $loanInterestDateClause = " and lt.transaction_date between '$data->dateFrom' and '$data->dateTo'";
            $assetsSalesDateClause = " and a.as_date between '$data->dateFrom' and '$data->dateTo'";
            $damageClause = " and d.Damage_Date between '$data->dateFrom' and '$data->dateTo'";
            $returnClause = " and r.SaleReturn_ReturnDate between '$data->dateFrom' and '$data->dateTo'";
            $purchaseClause = " and pm.PurchaseMaster_OrderDate between '$data->dateFrom' and '$data->dateTo'";
        }

        $result = $this->db->query("
            select
            (
                select ifnull(sum(ct.In_Amount), 0)
                from tbl_cashtransaction ct
                where ct.Tr_branchid = '" . $this->session->userdata('BRANCHid') . "'
                and ct.status = 'a'
                $transactionDateClause
            ) as income,
        
            (
                select ifnull(sum(ct.Out_Amount), 0)
                from tbl_cashtransaction ct
                where ct.Tr_branchid = '" . $this->session->userdata('BRANCHid') . "'
                and ct.status = 'a'
                $transactionDateClause
            ) as expense,
        
            (
                select ifnull(sum(ep.total_payment_amount), 0)
                from tbl_employee_payment ep
                where ep.branch_id = '" . $this->session->userdata('BRANCHid') . "'
                and ep.status = 'a'
                $employePaymentDateClause
            ) as employee_payment,

            (
                select ifnull(sum(it.amount), 0)
                from tbl_investment_transactions it
                where it.branch_id = '" . $this->session->userdata('BRANCHid') . "'
                and it.transaction_type = 'Profit'
                and it.status = 1
                $profitDistributeDateClause
            ) as profit_distribute,

            (
                select ifnull(sum(lt.amount), 0)
                from tbl_loan_transactions lt
                where lt.branch_id = '" . $this->session->userdata('BRANCHid') . "'
                and lt.transaction_type = 'Interest'
                and lt.status = 1
                $loanInterestDateClause
            ) as loan_interest,

            (
                select ifnull(sum(a.valuation - a.as_amount), 0)
                from tbl_assets a
                where a.branchid = '" . $this->session->userdata('BRANCHid') . "'
                and a.buy_or_sale = 'sale'
                and a.status = 'a'
                $assetsSalesDateClause
            ) as assets_sales_profit_loss,

            (
                select ifnull(sum(pm.PurchaseMaster_DiscountAmount), 0) 
                from tbl_purchasemaster pm
                where pm.PurchaseMaster_BranchID = '" . $this->session->userdata('BRANCHid') . "'
                and pm.status = 'a'
                $purchaseClause
            ) as purchase_discount,
            
            (
                select ifnull(sum(pm.PurchaseMaster_Tax), 0) 
                from tbl_purchasemaster pm
                where pm.PurchaseMaster_BranchID = '" . $this->session->userdata('BRANCHid') . "'
                and pm.status = 'a'
                $purchaseClause
            ) as purchase_vat,
            
            (
                select ifnull(sum(pm.PurchaseMaster_Freight), 0) 
                from tbl_purchasemaster pm
                where pm.PurchaseMaster_BranchID = '" . $this->session->userdata('BRANCHid') . "'
                and pm.status = 'a'
                $purchaseClause
            ) as purchase_transport_cost,
            
            (
                select ifnull(sum(dd.damage_amount), 0) 
                from tbl_damagedetails dd
                join tbl_damage d on d.Damage_SlNo = dd.Damage_SlNo
                where d.Damage_brunchid = '" . $this->session->userdata('BRANCHid') . "'
                and dd.status = 'a'
                $damageClause
            ) as damaged_amount,

            (
                select ifnull(sum(rd.SaleReturnDetails_ReturnAmount) - sum(sd.Purchase_Rate * rd.SaleReturnDetails_ReturnQuantity), 0)
                from tbl_salereturndetails rd
                join tbl_salereturn r on r.SaleReturn_SlNo = rd.SaleReturn_IdNo
                join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = r.SaleMaster_InvoiceNo
                join tbl_saledetails sd on sd.Product_IDNo = rd.SaleReturnDetailsProduct_SlNo and sd.SaleMaster_IDNo = sm.SaleMaster_SlNo
                where r.Status = 'a'
                and r.SaleReturn_brunchId = '" . $this->session->userdata('BRANCHid') . "'
                $returnClause
            ) as returned_amount
        ")->row();

        echo json_encode($result);
    }
	
    function income()  {
        $data['title'] = "Income Information";
        $data['content'] = $this->load->view('Administrator/account/income_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    function income_search()  {
        $dAta['startdate']=$startdate = $this->input->post('startdate');
        $dAta['enddate']=$enddate = $this->input->post('enddate');
        $dAta['accountid']=$accountid = $this->input->post('accountid');
        $dAta['searchtype']=$searchtype = $this->input->post('searchtype');
        $this->session->set_userdata($dAta);
        $BRANCHid = $this->session->userdata('BRANCHid');
		
        if($searchtype=="All"){
            $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='In Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
        elseif($searchtype=="Account"){
			$sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID where tbl_cashtransaction.Acc_SlID ='$accountid ' AND tbl_cashtransaction.Tr_branchid='$BRANCHid' AND tbl_cashtransaction.Tr_Type='In Cash' AND tbl_cashtransaction.Tr_date between '$startdate' AND '$enddate'";
        }
		$query = $this->db->query($sql);
        $datas["record"] = $query->result();
        
        $this->load->view('Administrator/account/income_search_list', $datas);
    }
	
    function cash_view()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Cash View";
        $sql = $this->db->query("SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID");
        $data["record"] = $sql->result();
        $data['content'] = $this->load->view('Administrator/account/cashview_search_list', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function daily_cash_view(){
        $data['title'] = "Daily Cash View";
        $userBranch = $this->session->userdata('BRANCHid');
        $sql = "SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID WHERE tbl_cashtransaction.Tr_branchid = '$userBranch' AND tbl_cashtransaction.Tr_date = CURDATE()";
        $data["record"] = $this->mt->ccdata($sql);
        $data['content'] = $this->load->view('Administrator/account/daily_cash_view', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function datewise_cash_view(){
        $data['title'] = "Datewise Cash View";
        $data['content'] = $this->load->view('Administrator/account/datewise_cash_view', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function datewise_cash_view_search(){
        if($this->input->post('BranchID', TRUE)){
            $data['BranchID'] = $this->input->post('BranchID', TRUE);
        }else{
            $data['BranchID'] = $this->session->userdata('BRANCHid');
        }
        
        $data['CDate'] = $this->input->post('CDate', TRUE);
        $this->session->set_userdata($data);
        $this->load->view('Administrator/account/datewise_cash_view_search', $data);

    }
	
	    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    public function add_bank(){
        $data['title'] = "Add Bank";
        $data['bank'] = $this->Billing_model->select_bank();
        $data['content'] = $this->load->view('Administrator/account/add_bank', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

// CREATE TABLE IF NOT EXISTS `tbl_Bank` (
//   `Bank_SiNo` int(11) NOT NULL AUTO_INCREMENT,
//   `Bank_name` varchar(100) NOT NULL,
//   `Branch` varchar(100) NOT NULL,
//   `Account_Title` varchar(100) NOT NULL,
//   `Account_No` varchar(100) NOT NULL,
//   PRIMARY KEY (`Bank_SiNo`)
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

    public function insert_Bank()  {
        $Bank_name = $this->input->post('Bank_name');
        $Branch = $this->input->post('Branch');
        $Account_Title = $this->input->post('Account_Title');
        $Account_No = $this->input->post('Account_No');
        $query = $this->db->query("SELECT Bank_name from tbl_bank where Bank_name = '$Bank_name'");
        
        if($query->num_rows() > 0){
            //echo "F";
            //$this->load->view('ajax/Country');
			$message='This bank name already exists';
			echo json_encode($message);
			//$this->session->set_userdata($sdata);
			//redirect('Administrator/Page/add_bank');
        }
        else{
            $data = array(
                "Bank_name"     =>$Bank_name,
                "Branch"        =>$this->brunch
                );
            if($this->mt->save_data('tbl_bank',$data)){
				$message='Add bank success';
				echo json_encode($message);
			}
			//redirect('Administrator/Page/add_bank');
            //$this->load->view('ajax/add_bank');
        }
    }
    public function fancybox_add_bank(){
        $this->load->view('Administrator/account/fancybox_add_bank');
    }
    public function fancyBox_insert_Bank(){
        $Bank = $this->input->post('Bank');
        $query = $this->db->query("SELECT Bank_name from tbl_Bank where Bank_name = '$Bank'");
        
        if($query->num_rows() > 0){
            echo "F";            
        }
        else{
            $data = array(
                "Bank_name" =>$Bank
                );
            $this->mt->save_data('tbl_Bank',$data);
            $this->load->view('Administrator/account/fancybox_select_add_bank');
        }
    }
    public function Bankdelete(){
        $id = $this->input->post('deleted');
        $fld = 'Bank_SiNo';
        $this->mt->delete_data("tbl_Bank", $id, $fld);
        echo "Success";
    }
    public function Bankedit($id){
        $data['title'] = "Edit Bank";
        $fld = 'Bank_SiNo';
		$data['bank'] = $this->Billing_model->select_bank();
        $data['selected'] = $this->Billing_model->select_by_id('tbl_Bank', $id,$fld);
        $data['content'] = $this->load->view('Administrator/edit/edit_Bank', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Update_Bank(){
        $Bank_SiNo = $this->input->post('Bank_SiNo');        
        $Bank_name = $this->input->post('Bank_name');
        $Branch = $this->input->post('Branch');
        $Account_Title = $this->input->post('Account_Title');
        $Account_No = $this->input->post('Account_No');
        //$query = $this->db->query("SELECT Bank_name from tbl_Bank where Bank_name = '$Bank_name'");
        $query = $this->db->query("SELECT Bank_name from tbl_Bank where Bank_SiNo = '$Bank_SiNo'");
        
        if($query->num_rows() > 1){
            echo "F";            
        }
        else{
            $fld = 'Bank_SiNo';
            $data = array(
                "Bank_name"       =>$Bank_name,
                "Branch"          =>$this->brunch
            );
        $this->mt->update_data("tbl_Bank", $data, $Bank_SiNo,$fld);
        echo "Success";
        }
        
    }

    public function bankAccounts(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Bank Accounts";
        $data['content'] = $this->load->view('Administrator/account/bank_accounts', $data, true);
        $this->load->view('Administrator/index', $data);
    }
    
    public function addBankAccount(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $accountCheck = $this->db->query("
                select
                *
                from tbl_bank_accounts
                where account_number = ?
            ", $data->account_number)->num_rows();

            if($accountCheck != 0){
                $res = ['success'=>false, 'message'=>'Account number already exists'];
                echo json_encode($res);
                exit;
            }

            $account = (array)$data;
            $account['saved_by'] = $this->session->userdata('userId');
            $account['saved_datetime'] = date('Y-m-d H:i:s');
            $account['branch_id'] = $this->session->userdata('BRANCHid');

            $this->db->insert('tbl_bank_accounts', $account);
            $res = ['success'=>true, 'message'=>'Account created successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBankAccount(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $accountCheck = $this->db->query("
                select
                *
                from tbl_bank_accounts
                where account_number = ?
                and account_id != ?
            ", [$data->account_number, $data->account_id])->num_rows();

            if($accountCheck != 0){
                $res = ['success'=>false, 'message'=>'Account number already exists'];
                echo json_encode($res);
                exit;
            }

            $account = (array)$data;
            $account['updated_by'] = $this->session->userdata('userId');
            $account['updated_datetime'] = date('Y-m-d H:i:s');

            $this->db->where('account_id', $data->account_id);
            $this->db->update('tbl_bank_accounts', $account);
            $res = ['success'=>true, 'message'=>'Account updated successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getBankAccounts(){
        $accounts = $this->db->query("
            select 
            *,
            case status 
            when 1 then 'Active'
            else 'Inactive'
            end as status_text
            from tbl_bank_accounts 
            where branch_id = ?
        ", $this->session->userdata('BRANCHid'))->result();
        echo json_encode($accounts);
    }

    public function changeAccountStatus(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $status = $data->account->status == 1 ? 0 : 1;
            $this->db->query("update tbl_bank_accounts set status = ? where account_id = ?", [$status, $data->account->account_id]);
            
            $res = ['success'=>true, 'message'=>'Status Changed'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function bankTransactions(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Bank Transactions";
        $data['content'] = $this->load->view('Administrator/account/bank_transactions', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function addBankTransaction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $transaction = (array)$data;
            $transaction['saved_by'] = $this->session->userdata('userId');
            $transaction['saved_datetime'] = date('Y-m-d H:i:s');
            $transaction['branch_id'] = $this->session->userdata('BRANCHid');

            $this->db->insert('tbl_bank_transactions', $transaction);

            $res = ['success'=>true, 'message'=>'Transaction added successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBankTransaction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $transactionId = $data->transaction_id;
            $transaction = (array)$data;
            unset($transaction['transaction_id']);

            $this->db->where('transaction_id', $transactionId)->update('tbl_bank_transactions', $transaction);

            $res = ['success'=>true, 'message'=>'Transaction update successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getBankTransactions(){
        $data = json_decode($this->input->raw_input_stream);

        $accountClause = "";
        if(isset($data->accountId) && $data->accountId != null){
            $accountClause = " and bt.account_id = '$data->accountId'";
        }

        $dateClause = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' 
        && isset($data->dateTo) && $data->dateTo != ''){
            $dateClause = " and bt.transaction_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $typeClause = "";
        if(isset($data->transactionType) && $data->transactionType != ''){
            $typeClause = " and bt.transaction_type = '$data->transactionType'";
        }


        $transactions = $this->db->query("
            select 
                bt.*,
                ac.account_name,
                ac.account_number,
                ac.bank_name,
                ac.branch_name,
                u.FullName as saved_by
            from tbl_bank_transactions bt
            join tbl_bank_accounts ac on ac.account_id = bt.account_id
            join tbl_user u on u.User_SlNo = bt.saved_by
            where bt.status = 1
            and bt.branch_id = ?
            $accountClause $dateClause $typeClause
            order by bt.transaction_id desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($transactions);
    }

    public function getAllBankTransactions(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        $order = "transaction_date desc, sequence, id desc";

        if(isset($data->accountId) && $data->accountId != null){
            $clauses .= " and account_id = '$data->accountId'";
        }

        if(isset($data->dateFrom) && $data->dateFrom != '' 
        && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and transaction_date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->transactionType) && $data->transactionType != ''){
            $clauses .= " and transaction_type = '$data->transactionType'";
        }

        if(isset($data->ledger)) {
            $order = "transaction_date, sequence, id";
        }

        $transactions = $this->db->query("
            select * from(
                select 
                    'a' as sequence,
                    bt.transaction_id as id,
                    bt.transaction_type as description,
                    bt.account_id,
                    bt.transaction_date,
                    bt.transaction_type,
                    bt.amount as deposit,
                    0.00 as withdraw,
                    bt.note,
                    ac.account_name,
                    ac.account_number,
                    ac.bank_name,
                    ac.branch_name,
                    0.00 as balance
                from tbl_bank_transactions bt
                join tbl_bank_accounts ac on ac.account_id = bt.account_id
                where bt.status = 1
                and bt.transaction_type = 'deposit'
                and bt.branch_id = " . $this->session->userdata('BRANCHid') . "

                UNION
                select 
                    'b' as sequence,
                    bt.transaction_id as id,
                    bt.transaction_type as description,
                    bt.account_id,
                    bt.transaction_date,
                    bt.transaction_type,
                    0.00 as deposit,
                    bt.amount as withdraw,
                    bt.note,
                    ac.account_name,
                    ac.account_number,
                    ac.bank_name,
                    ac.branch_name,
                    0.00 as balance
                from tbl_bank_transactions bt
                join tbl_bank_accounts ac on ac.account_id = bt.account_id
                where bt.status = 1
                and bt.transaction_type = 'withdraw'
                and bt.branch_id = " . $this->session->userdata('BRANCHid') . "
                
                UNION
                select
                    'c' as sequence,
                    cp.CPayment_id as id,
                    concat('Payment Received - ', c.Customer_Name, ' (', c.Customer_Code, ')') as description, 
                    cp.account_id,
                    cp.CPayment_date as transaction_date,
                    'deposit' as transaction_type,
                    cp.CPayment_amount as deposit,
                    0.00 as withdraw,
                    cp.CPayment_notes as note,
                    ac.account_name,
                    ac.account_number,
                    ac.bank_name,
                    ac.branch_name,
                    0.00 as balance
                from tbl_customer_payment cp
                join tbl_bank_accounts ac on ac.account_id = cp.account_id
                join tbl_customer c on c.Customer_SlNo = cp.CPayment_customerID
                where cp.account_id is not null
                and cp.CPayment_status = 'a'
                and cp.CPayment_TransactionType = 'CR'
                and cp.CPayment_brunchid = " . $this->session->userdata('BRANCHid') . "
                
                UNION
                select
                    'd' as sequence,
                    cp.CPayment_id as id,
                    concat('paid to customer - ', c.Customer_Name, ' (', c.Customer_Code, ')') as description, 
                    cp.account_id,
                    cp.CPayment_date as transaction_date,
                    'withdraw' as transaction_type,
                    0.00 as deposit,
                    cp.CPayment_amount as withdraw,
                    cp.CPayment_notes as note,
                    ac.account_name,
                    ac.account_number,
                    ac.bank_name,
                    ac.branch_name,
                    0.00 as balance
                from tbl_customer_payment cp
                join tbl_bank_accounts ac on ac.account_id = cp.account_id
                join tbl_customer c on c.Customer_SlNo = cp.CPayment_customerID
                where cp.account_id is not null
                and cp.CPayment_status = 'a'
                and cp.CPayment_TransactionType = 'CP'
                and cp.CPayment_brunchid = " . $this->session->userdata('BRANCHid') . "
                
                UNION
                select 
                    'e' as sequence,
                    sp.SPayment_id as id,
                    concat('paid - ', s.Supplier_Name, ' (', s.Supplier_Code, ')') as description, 
                    sp.account_id,
                    sp.SPayment_date as transaction_date,
                    'withdraw' as transaction_type,
                    0.00 as deposit,
                    sp.SPayment_amount as withdraw,
                    sp.SPayment_notes as note,
                    ac.account_name,
                    ac.account_number,
                    ac.bank_name,
                    ac.branch_name,
                    0.00 as balance
                from tbl_supplier_payment sp
                join tbl_bank_accounts ac on ac.account_id = sp.account_id
                join tbl_supplier s on s.Supplier_SlNo = sp.SPayment_customerID
                where sp.account_id is not null
                and sp.SPayment_status = 'a'
                and sp.SPayment_TransactionType = 'CP'
                and sp.SPayment_brunchid = " . $this->session->userdata('BRANCHid') . "
                
                UNION
                select 
                    'f' as sequence,
                    sp.SPayment_id as id,
                    concat('received from supplier - ', s.Supplier_Name, ' (', s.Supplier_Code, ')') as description, 
                    sp.account_id,
                    sp.SPayment_date as transaction_date,
                    'deposit' as transaction_type,
                    sp.SPayment_amount as deposit,
                    0.00 as withdraw,
                    sp.SPayment_notes as note,
                    ac.account_name,
                    ac.account_number,
                    ac.bank_name,
                    ac.branch_name,
                    0.00 as balance
                from tbl_supplier_payment sp
                join tbl_bank_accounts ac on ac.account_id = sp.account_id
                join tbl_supplier s on s.Supplier_SlNo = sp.SPayment_customerID
                where sp.account_id is not null
                and sp.SPayment_status = 'a'
                and sp.SPayment_TransactionType = 'CR'
                and sp.SPayment_brunchid = " . $this->session->userdata('BRANCHid') . "
            ) as tbl
            where 1 = 1 $clauses
            order by $order
        ")->result();

        if(!isset($data->ledger)){
            echo json_encode($transactions);
            exit;
        }

        $previousBalance = $this->mt->getBankTransactionSummary($data->accountId, $data->dateFrom)[0]->balance;

        $transactions = array_map(function($key, $trn) use($previousBalance, $transactions) {
            $trn->balance = (($key == 0 ? $previousBalance : $transactions[$key - 1]->balance) + $trn->deposit) - $trn->withdraw;
            return $trn;
        }, array_keys($transactions), $transactions);
        
        $res['previousBalance'] = $previousBalance;
        $res['transactions'] = $transactions;

        echo json_encode($res);
    }

    public function removeBankTransaction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $this->db->query("update tbl_bank_transactions set status = 0 where transaction_id = ?", $data->transaction_id);
            
            $res = ['success'=>true, 'message'=>'Transaction removed'];
        } catch(Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function bankTransactionReprot(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Bank Transaction Report";
        $data['content'] = $this->load->view("Administrator/account/bank_transaction_report", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function cashView(){
        $data['title'] = "Cash View";

        $data['transaction_summary'] = $this->mt->getTransactionSummary();

        $data['bank_account_summary'] = $this->mt->getBankTransactionSummary();

        $data['content'] = $this->load->view('Administrator/account/cash_view', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function getBankBalance(){
        $data = json_decode($this->input->raw_input_stream);

        $accountId = null;
        if(isset($data->accountId) && $data->accountId != ''){
            $accountId = $data->accountId;
        }

        $bankBalance = $this->mt->getBankTransactionSummary($accountId);

        echo json_encode($bankBalance);
    }

    public function getCashAndBankBalance(){
        $data = json_decode($this->input->raw_input_stream);

        $date = null;
        if(isset($data->date) && $data->date != ''){
            $date = $data->date;
        }

        $res['cashBalance'] = $this->mt->getTransactionSummary($date);

        $res['bankBalance'] = $this->mt->getBankTransactionSummary(null, $date);

        echo json_encode($res);
    }

    public function bankLedger() {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Bank Ledger";
        $data['content'] = $this->load->view("Administrator/account/bank_ledger", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function cashLedger() {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Cash Ledger";
        $data['content'] = $this->load->view("Administrator/account/cash_ledger", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function getCashLedger() {
        $data = json_decode($this->input->raw_input_stream);

        $previousBalance = $this->mt->getTransactionSummary($data->fromDate)->cash_balance;

        $ledger = $this->db->query("
            /* Cash In */
            select 
                sm.SaleMaster_SlNo as id,
                sm.SaleMaster_SaleDate as date,
                concat('Sale - ', sm.SaleMaster_InvoiceNo, ' - ', c.Customer_Name, ' (', c.Customer_Code, ')', ' - Bill: ', sm.SaleMaster_TotalSaleAmount) as description,
                sm.SaleMaster_PaidAmount as in_amount,
                0.00 as out_amount
            from tbl_salesmaster sm 
            join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where sm.Status = 'a'
            and sm.SaleMaster_branchid = '$this->brunch'
            and sm.SaleMaster_SaleDate between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                cp.CPayment_id as id,
                cp.CPayment_date as date,
                concat('Due collection - ', cp.CPayment_invoice, ' - ', c.Customer_Name, ' (', c.Customer_Code, ')') as description,
                cp.CPayment_amount as in_amount,
                0.00 as out_amount
            from tbl_customer_payment cp
            join tbl_customer c on c.Customer_SlNo = cp.CPayment_customerID
            where cp.CPayment_status = 'a'
            and cp.CPayment_brunchid = '$this->brunch'
            and cp.CPayment_TransactionType = 'CR'
            and cp.CPayment_Paymentby != 'bank'
            and cp.CPayment_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                sp.SPayment_id as id,
                sp.SPayment_date as date,
                concat('Received from supplier - ', sp.SPayment_invoice, ' - ', s.Supplier_Name, ' (', s.Supplier_Code, ')') as description,
                sp.SPayment_amount as in_amount,
                0.00 as out_amount
            from tbl_supplier_payment sp
            join tbl_supplier s on s.Supplier_SlNo = sp.SPayment_customerID
            where sp.SPayment_TransactionType = 'CR'
            and sp.SPayment_status = 'a'
            and sp.SPayment_Paymentby != 'bank'
            and sp.SPayment_brunchid = '$this->brunch'
            and sp.SPayment_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                ct.Tr_SlNo as id,
                ct.Tr_date as date,
                concat('Cash in - ', acc.Acc_Name) as description,
                ct.In_Amount as in_amount,
                0.00 as out_amount
            from tbl_cashtransaction ct
            join tbl_account acc on acc.Acc_SlNo = ct.Acc_SlID
            where ct.status = 'a'
            and ct.Tr_branchid = '$this->brunch'
            and ct.Tr_Type = 'In Cash'
            and ct.Tr_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                bt.transaction_id as id,
                bt.transaction_date as date,
                concat('Bank withdraw - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.account_name, ' - ', ba.account_number) as description,
                bt.amount as in_amount,
                0.00 as out_amount
            from tbl_bank_transactions bt 
            join tbl_bank_accounts ba on ba.account_id = bt.account_id
            where bt.status = 1
            and bt.branch_id = '$this->brunch'
            and bt.transaction_type = 'withdraw'
            and bt.transaction_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                bt.transaction_id as id,
                bt.transaction_date as date,
                concat('Loan Received - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.account_name, ' - ', ba.account_number) as description,
                bt.amount as in_amount,
                0.00 as out_amount
            from tbl_loan_transactions bt 
            join tbl_loan_accounts ba on ba.account_id = bt.account_id
            where bt.status = 1
            and bt.branch_id = '$this->brunch'
            and bt.transaction_type = 'Receive'
            and bt.transaction_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            select 
                ba.	account_id as id,
                ba.save_date as date,
                concat('Loan Initial Balance - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.account_name, ' - ', ba.account_number) as description,
                ba.initial_balance as in_amount,
                0.00 as out_amount
            from tbl_loan_accounts ba
            where ba.branch_id = '$this->brunch'
            and ba.save_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                bt.transaction_id as id,
                bt.transaction_date as date,
                concat('Invest Received - ', ba.Acc_Name, ' (', ba.Acc_Code, ')') as description,
                bt.amount as in_amount,
                0.00 as out_amount
            from tbl_investment_transactions bt 
            join tbl_investment_account ba on ba.Acc_SlNo = bt.account_id
            where bt.status = 1
            and bt.branch_id = '$this->brunch'
            and bt.transaction_type = 'Receive'
            and bt.transaction_date between '$data->fromDate' and '$data->toDate'

            UNION
            
            select 
                ass.as_id as id,
                ass.as_date as date,
                concat('Sale Assets - ', ass.as_name) as description,
                ass.as_amount as in_amount,
                0.00 as out_amount
            from tbl_assets ass
            where ass.branchid = '$this->brunch'
            and ass.status = 'a'
            and ass.buy_or_sale = 'sale'
            and ass.as_date between '$data->fromDate' and '$data->toDate'
            
            /* Cash out */
            
            UNION
            
            select 
                pm.PurchaseMaster_SlNo as id,
                pm.PurchaseMaster_OrderDate as date,
                concat('Purchase - ', pm.PurchaseMaster_InvoiceNo, ' - ', s.Supplier_Name, ' (', s.Supplier_Code, ')', ' - Bill: ', pm.PurchaseMaster_TotalAmount) as description,
                0.00 as in_amount,
                pm.PurchaseMaster_PaidAmount as out_amount
            from tbl_purchasemaster pm 
            join tbl_supplier s on s.Supplier_SlNo = pm.Supplier_SlNo
            where pm.status = 'a'
            and pm.PurchaseMaster_BranchID = '$this->brunch'
            and pm.PurchaseMaster_OrderDate between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                sp.SPayment_id as id,
                sp.SPayment_date as date,
                concat('Supplier payment - ', sp.SPayment_invoice, ' - ', s.Supplier_Name, ' (', s.Supplier_Code, ')') as description,
                0.00 as in_amount,
                sp.SPayment_amount as out_amount
            from tbl_supplier_payment sp 
            join tbl_supplier s on s.Supplier_SlNo = sp.SPayment_customerID
            where sp.SPayment_TransactionType = 'CP'
            and sp.SPayment_status = 'a'
            and sp.SPayment_Paymentby != 'bank'
            and sp.SPayment_brunchid = '$this->brunch'
            and sp.SPayment_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                cp.CPayment_id as id,
                cp.CPayment_date as date,
                concat('Paid to customer - ', cp.CPayment_invoice, ' - ', c.Customer_Name, '(', c.Customer_Code, ')') as description,
                0.00 as in_amount,
                cp.CPayment_amount as out_amount
            from tbl_customer_payment cp
            join tbl_customer c on c.Customer_SlNo = cp.CPayment_customerID
            where cp.CPayment_TransactionType = 'CP'
            and cp.CPayment_status = 'a'
            and cp.CPayment_Paymentby != 'bank'
            and cp.CPayment_brunchid = '$this->brunch'
            and cp.CPayment_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                ct.Tr_SlNo as id,
                ct.Tr_date as date,
                concat('Cash out - ', acc.Acc_Name) as description,
                0.00 as in_cash,
                ct.Out_Amount as out_amount
            from tbl_cashtransaction ct
            join tbl_account acc on acc.Acc_SlNo = ct.Acc_SlID
            where ct.Tr_Type = 'Out Cash'
            and ct.status = 'a'
            and ct.Tr_branchid = '$this->brunch'
            and ct.Tr_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                bt.transaction_id as id,
                bt.transaction_date as date,
                concat('Bank deposit - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.account_name, ' - ', ba.account_number) as description,
                0.00 as in_amount,
                bt.amount as out_amount
            from tbl_bank_transactions bt
            join tbl_bank_accounts ba on ba.account_id = bt.account_id
            where bt.transaction_type = 'deposit'
            and bt.status = 1
            and bt.branch_id = '$this->brunch'
            and bt.transaction_date between '$data->fromDate' and '$data->toDate'

            UNION
            
            select 
                ep.id as id,
                ep.payment_date as date,
                concat('Employee salary - ', m.month_name) as description,
                0.00 as in_amount,
                ep.total_payment_amount as out_amount
            from tbl_employee_payment ep
            join tbl_month m on m.month_id = ep.month_id
            where ep.branch_id = '$this->brunch'
            and ep.status = 'a'
            and ep.payment_date between '$data->fromDate' and '$data->toDate'
            
            UNION
            
            select 
                bt.transaction_id as id,
                bt.transaction_date as date,
                concat('Loan Payment - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.account_name, ' - ', ba.account_number) as description,
                0.00 as in_amount,
                bt.amount as out_amount
            from tbl_loan_transactions bt
            join tbl_loan_accounts ba on ba.account_id = bt.account_id
            where bt.transaction_type = 'Payment'
            and bt.status = 1
            and bt.branch_id = '$this->brunch'
            and bt.transaction_date between '$data->fromDate' and '$data->toDate'

            UNION
            
            select 
                bt.transaction_id as id,
                bt.transaction_date as date,
                concat('Invest Payment - ', ba.Acc_Name, ' (', ba.Acc_Code, ')') as description,
                0.00 as in_amount,
                bt.amount as out_amount
            from tbl_investment_transactions bt 
            join tbl_investment_account ba on ba.Acc_SlNo = bt.account_id
            where bt.status = 1
            and bt.branch_id = '$this->brunch'
            and bt.transaction_type = 'Payment'
            and bt.transaction_date between '$data->fromDate' and '$data->toDate'

            UNION
            
            select 
                ass.as_id as id,
                ass.as_date as date,
                concat('Buy Assets - ', ass.as_name, ' from ', ass.as_sp_name) as description,
                0.00 as in_amount,
                ass.as_amount as out_amount
            from tbl_assets ass
            where ass.branchid = '$this->brunch'
            and ass.status = 'a'
            and ass.buy_or_sale = 'buy'
            and ass.as_date between '$data->fromDate' and '$data->toDate'

            order by date, id
        ")->result();

        $ledger = array_map(function($ind, $row) use($previousBalance, $ledger) {
            $row->balance = (($ind == 0 ? $previousBalance : $ledger[$ind - 1]->balance) + $row->in_amount) - $row->out_amount;
            return $row;
        }, array_keys($ledger), $ledger);

        $res['previousBalance'] = $previousBalance;
        $res['ledger'] = $ledger;

        echo json_encode($res);
    }

}
