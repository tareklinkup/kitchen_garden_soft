<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invest extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
    }
    
    public function investmentAccount()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Add Investment Account";
        $data['accountCode'] = $this->mt->generateInvestmentAccountCode();
        $data['content'] = $this->load->view('Administrator/account/invest/add_investment_account', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function addInvestmentAccount()
    {
        $res = ['success'=>false, 'message'=>''];
        try{
            $accountObj = json_decode($this->input->raw_input_stream);

            $duplicateCodeCount = $this->db->query("select * from tbl_investment_account where Acc_Code = ?", $accountObj->Acc_Code)->num_rows();
            if($duplicateCodeCount != 0){
                $accountObj = $this->mt->generateInvestmentAccountCode();
            }

            $duplicateNameCount = $this->db->query("select * from tbl_investment_account where Acc_Name = ? and branch_id = ?", [$accountObj->Acc_Name, $this->brunch])->num_rows();
            if($duplicateNameCount != 0){
                $this->db->query("update tbl_investment_account set status = 'a' where Acc_Name = ? and branch_id = ?", [$accountObj->Acc_Name, $this->brunch]);
                $res = ['success'=>true, 'message'=>'Account activated', 'newAccountCode'=>$this->mt->generateInvestmentAccountCode()];
                echo json_encode($res);
                exit;
            }

            $account = (array)$accountObj;
            unset($account['Acc_SlNo']);
            $account['status'] = 'a';
            $account['AddBy'] = $this->session->userdata("FullName");
            $account['AddTime'] = date('Y-m-d H:i:s');
            $account['branch_id'] = $this->brunch;

            $this->db->insert('tbl_investment_account', $account);

            $res = ['success'=>true, 'message'=>'Account added', 'newAccountCode'=>$this->mt->generateInvestmentAccountCode()];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }


    public function updateInvestmentAccount()
    {
        $res = ['success'=>false, 'message'=>'Nothing'];
        try{
            $accountObj = json_decode($this->input->raw_input_stream);

            $duplicateNameCount = $this->db->query("select * from tbl_investment_account where Acc_Name = ? and branch_id = ? and Acc_SlNo != ?", [$accountObj->Acc_Name, $this->brunch, $accountObj->Acc_SlNo])->num_rows();
            if($duplicateNameCount != 0){
                $this->db->query("update tbl_investment_account set status = 'a' where Acc_Name = ? and branch_id = ?", [$accountObj->Acc_Name, $this->brunch]);
                $res = ['success'=>true, 'message'=>'Account activated', 'newAccountCode'=>$this->mt->generateInvestmentAccountCode()];
                echo json_encode($res);
                exit;
            }

            $account = (array)$accountObj;
            unset($account['Acc_SlNo']);
            $account['UpdateBy'] = $this->session->userdata("FullName");
            $account['UpdateTime'] = date('Y-m-d H:i:s');

            $this->db->where('Acc_SlNo', $accountObj->Acc_SlNo)->update('tbl_investment_account', $account);

            $res = ['success'=>true, 'message'=>'Account updated', 'newAccountCode'=>$this->mt->generateInvestmentAccountCode()];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }

    public function deleteInvestmentAccount()
    {
        $res = ['success'=>false, 'message'=>'Nothing'];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $balance = $this->mt->getInvestmentTransactionSummary($data->accountId)[0]->balance;

            if($balance != 0){
                $res = ['success'=>false, 'message'=>'You Need To 0 Balance For Delete a Account'];
                echo json_encode($res);
                exit;
            }

            $this->db->query("update tbl_investment_account set status = 'd' where Acc_SlNo = ?", $data->accountId);

            $res = ['success'=>true, 'message'=>'Account deleted'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }

    public function getInvestmentAccounts()
    {
        $accounts = $this->db->query("select * from tbl_investment_account where status = 'a' and branch_id = ?", $this->session->userdata('BRANCHid'))->result();
        echo json_encode($accounts);
    }

    public function investmentTransactions(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Investment Transactions";
        $data['content'] = $this->load->view('Administrator/account/invest/investment_transactions', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function getInvestmentTransactions(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->accountId) && $data->accountId != null){
            $clauses .= " and lt.account_id = '$data->accountId'";
        }

        if(isset($data->dateFrom) && $data->dateFrom != '' 
        && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and lt.transaction_date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->transactionType) && $data->transactionType != ''){
            $clauses .= " and lt.transaction_type = '$data->transactionType'";
        }


        $transactions = $this->db->query("
            select 
                lt.*,
                ac.Acc_Code,
                ac.Acc_Name,
                u.FullName as saved_by
            from tbl_investment_transactions lt
            join tbl_investment_account ac on ac.Acc_SlNo = lt.account_id
            join tbl_user u on u.User_SlNo = lt.saved_by
            where lt.status = 1
            and lt.branch_id = ?
            $clauses
            order by lt.transaction_id desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($transactions);
    }

    public function addInvestmentTransaction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $transaction = (array)$data;
            $transaction['saved_by'] = $this->session->userdata('userId');
            $transaction['saved_datetime'] = date('Y-m-d H:i:s');
            $transaction['branch_id'] = $this->session->userdata('BRANCHid');

            $this->db->insert('tbl_investment_transactions', $transaction);

            $res = ['success'=>true, 'message'=>'Investment added successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateInvestmentTransaction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $transactionId = $data->transaction_id;
            $transaction = (array)$data;
            unset($transaction['transaction_id']);

            $this->db->where('transaction_id', $transactionId)->update('tbl_investment_transactions', $transaction);

            $res = ['success'=>true, 'message'=>'Investment update successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function removeInvestmentTransaction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $this->db->query("update tbl_investment_transactions set status = 0 where transaction_id = ?", $data->transaction_id);
            
            $res = ['success'=>true, 'message'=>'Investment removed'];
        } catch(Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getInvestmentBalance(){
        $data = json_decode($this->input->raw_input_stream);

        $accountId = null;
        if(isset($data->accountId) && $data->accountId != ''){
            $accountId = $data->accountId;
        }

        $investmentBalance = $this->mt->getInvestmentTransactionSummary($accountId);

        echo json_encode($investmentBalance);
    }

    public function investmentView(){
        $data['title'] = "Investment View";

        $data['investment_account_summary'] = $this->mt->getInvestmentTransactionSummary();

        $data['content'] = $this->load->view('Administrator/account/invest/investment_view', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function investmentTransactionReprot(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Investment Transaction Report";
        $data['content'] = $this->load->view("Administrator/account/invest/investment_transaction_report", $data, true);
        $this->load->view("Administrator/index", $data);
    }


    public function getAllInvestmentTransactions(){
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
                    lt.transaction_id as id,
                    lt.transaction_type as description,
                    lt.account_id,
                    lt.transaction_date,
                    lt.transaction_type,
                    lt.amount as receive,
                    0.00 as payment,
                    0.00 as profit,
                    lt.note,
                    ac.Acc_Code,
                    ac.Acc_Name,
                    0.00 as balance
                from tbl_investment_transactions lt
                join tbl_investment_account ac on ac.Acc_SlNo = lt.account_id
                where lt.status = 1
                and lt.transaction_type = 'Receive'
                and lt.branch_id = " . $this->session->userdata('BRANCHid') . "

                UNION
                select 
                    'b' as sequence,
                    lt.transaction_id as id,
                    lt.transaction_type as description,
                    lt.account_id,
                    lt.transaction_date,
                    lt.transaction_type,
                    0.00 as receive,
                    0.00 as payment,
                    lt.amount as profit,
                    lt.note,
                    ac.Acc_Code,
                    ac.Acc_Name,
                    0.00 as balance
                from tbl_investment_transactions lt
                join tbl_investment_account ac on ac.Acc_SlNo = lt.account_id
                where lt.status = 1
                and lt.transaction_type = 'Profit'
                and lt.branch_id = " . $this->session->userdata('BRANCHid') . "

                UNION
                select 
                    'c' as sequence,
                    lt.transaction_id as id,
                    lt.transaction_type as description,
                    lt.account_id,
                    lt.transaction_date,
                    lt.transaction_type,
                    0.00 as receive,
                    lt.amount as payment,
                    0.00 as interest,
                    lt.note,
                    ac.Acc_Code,
                    ac.Acc_Name,
                    0.00 as balance
                from tbl_investment_transactions lt
                join tbl_investment_account ac on ac.Acc_SlNo = lt.account_id
                where lt.status = 1
                and lt.transaction_type = 'Payment'
                and lt.branch_id = " . $this->session->userdata('BRANCHid') . "

            ) as tbl
            where 1 = 1 $clauses
            order by $order
        ")->result();

        if(!isset($data->ledger)){
            echo json_encode($transactions);
            exit;
        }

        $previousBalance = $this->mt->getInvestmentTransactionSummary($data->accountId, $data->dateFrom)[0]->balance;

        $transactions = array_map(function($key, $trn) use($previousBalance, $transactions) {
            $trn->balance = (($key == 0 ? $previousBalance : $transactions[$key - 1]->balance) + $trn->receive + $trn->profit) - $trn->payment;
            return $trn;
        }, array_keys($transactions), $transactions);
        
        $res['previousBalance'] = $previousBalance;
        $res['transactions'] = $transactions;

        echo json_encode($res);
    }

    public function investmentLedger() {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Investment Ledger";
        $data['content'] = $this->load->view("Administrator/account/invest/investment_ledger", $data, true);
        $this->load->view("Administrator/index", $data);
    }

}
