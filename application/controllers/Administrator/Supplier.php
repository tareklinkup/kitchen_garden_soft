<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $access = $this->session->userdata('userId');
        $this->brunch = $this->session->userdata('BRANCHid');
         if($access == '' ){
            redirect("Login");
        }
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
    }
    public function index()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Supplier";
        $data['supplierCode'] = $this->mt->generateSupplierCode();
        $data['content'] = $this->load->view('Administrator/add_supplier', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function supplier_country()  {
        $this->load->view('Administrator/supplier_country');
    }
    public function insert_country()  {
        $mail = $this->input->post('add_country');
        $query = $this->db->query("SELECT CountryName from tbl_country where CountryName = '$mail'");
        
        if($query->num_rows() > 0){
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/sup_country',$data);
        }
        else{
            $data = array(
                "CountryName"          =>$this->input->post('add_country', TRUE),
                "AddBy"                  =>$this->session->userdata("FullName"),
                "AddTime"                =>date("Y-m-d H:i:s")
                );
            $this->mt->save_data('tbl_country',$data);
            $this->load->view('Administrator/ajax/sup_country');
        }
    }
    public function supplier_district()  {
        $this->load->view('Administrator/supplier_district');
    }
    public function insert_district()  {
        $mail = $this->input->post('District');
        $query = $this->db->query("SELECT District_Name from tbl_district where District_Name = '$mail'");
        
        if($query->num_rows() > 0){
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/supplier_district',$data);
        }
        else{
            $data = array(
                "District_Name"          =>$this->input->post('District', TRUE),
                "AddBy"                  =>$this->session->userdata("FullName"),
                "AddTime"                =>date("Y-m-d H:i:s")
                );
            $this->mt->save_data('tbl_district',$data);
            $this->load->view('Administrator/ajax/supplier_district');
        }
    }
    public function addSupplier()
    {
        $res = ['success'=>false, 'message'=>''];
        try{
            $supplierObj = json_decode($this->input->post('data'));
            $supplierCodeCount = $this->db->query("select * from tbl_supplier where Supplier_Code = ?", $supplierObj->Supplier_Code)->num_rows();
            if($supplierCodeCount > 0){
                $supplierObj->Supplier_Code = $this->mt->generateSupplierCode();
            }

            $supplierMobileCount = $this->db->query("select * from tbl_supplier where Supplier_Mobile = ?", $supplierObj->Supplier_Mobile)->num_rows();
            if($supplierMobileCount > 0){
                $res = ['success'=>false, 'message'=>'Mobile number already exists'];
                echo Json_encode($res);
                exit;
            }

            $supplier = (array)$supplierObj;

            $supplier["Supplier_brinchid"] = $this->session->userdata("BRANCHid");
            $supplier["AddBy"] = $this->session->userdata("FullName");
            $supplier["AddTime"] = date("Y-m-d H:i:s");

            $this->db->insert('tbl_supplier', $supplier);
            $supplierId = $this->db->insert_id();

            if(!empty($_FILES)) {
                $config['upload_path'] = './uploads/suppliers/';
                $config['allowed_types'] = 'gif|jpg|png';

                $imageName = $supplierObj->Supplier_Code;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/

                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/suppliers/'. $imageName ; 
                $config['new_image'] = './uploads/suppliers/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 640;
                $config['height']   = 480;

                $this->load->library('image_lib', $config); 
                $this->image_lib->resize();

                $imageName = $supplierObj->Supplier_Code . $this->upload->data('file_ext');

                $this->db->query("update tbl_supplier set image_name = ? where Supplier_SlNo = ?", [$imageName, $supplierId]);
            }

            $res = ['success'=>true, 'message'=>'Supplier added successfully', 'supplierCode'=>$this->mt->generateSupplierCode()];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateSupplier()
    {
        $res = ['success'=>false, 'message'=>''];
        try{
            $supplierObj = json_decode($this->input->post('data'));
            $supplierMobileCount = $this->db->query("select * from tbl_supplier where Supplier_Mobile = ? and Supplier_SlNo != ?", [$supplierObj->Supplier_Mobile, $supplierObj->Supplier_SlNo])->num_rows();
            if($supplierMobileCount > 0){
                $res = ['success'=>false, 'message'=>'Mobile number already exists'];
                echo Json_encode($res);
                exit;
            }
            $supplier = (array)$supplierObj;
            $supplierId = $supplierObj->Supplier_SlNo;

            unset($supplier["Supplier_SlNo"]);
            $supplier["Supplier_brinchid"] = $this->session->userdata("BRANCHid");
            $supplier["UpdateBy"] = $this->session->userdata("FullName");
            $supplier["UpdateTime"] = date("Y-m-d H:i:s");

            $this->db->where('Supplier_SlNo', $supplierId)->update('tbl_supplier', $supplier);

            if(!empty($_FILES)) {
                $config['upload_path'] = './uploads/suppliers/';
                $config['allowed_types'] = 'gif|jpg|png';

                $imageName = $supplierObj->Supplier_Code;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/

                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/suppliers/'. $imageName ; 
                $config['new_image'] = './uploads/suppliers/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 640;
                $config['height']   = 480;

                $this->load->library('image_lib', $config); 
                $this->image_lib->resize();

                $imageName = $supplierObj->Supplier_Code . $this->upload->data('file_ext');

                $this->db->query("update tbl_supplier set image_name = ? where Supplier_SlNo = ?", [$imageName, $supplierId]);
            }

            $res = ['success'=>true, 'message'=>'Supplier updated successfully', 'supplierCode'=>$this->mt->generateSupplierCode()];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function supplier_edit()  {
        $id = $this->input->post('edit');
       // $query = $this->db->query("SELECT tbl_supplier.*, tbl_country.*,tbl_district.* FROM tbl_supplier left join tbl_country on tbl_country.Country_SlNo=tbl_supplier.Country_SlNo left join tbl_district on tbl_district.District_SlNo=tbl_supplier.District_SlNo where tbl_supplier.Supplier_SlNo = '$id'");
        $query = $this->db->query("SELECT * from tbl_supplier where tbl_supplier.Supplier_SlNo = '$id'");
		$data['selected'] = $query->row();
		//echo "<pre>";print_r($data['selected']);exit;
        $this->load->view('Administrator/edit/supplier_edit', $data);
    }
    public function deleteSupplier(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("update tbl_supplier set status = 'd' where Supplier_SlNo = ?", $data->supplierId);

            $res = ['success'=>true, 'message'=>'Supplier deleted'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }
    function supplier_due(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = 'Supplier Due';
        $data['content'] = $this->load->view('Administrator/due_report/supplier_due', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    } 
    function search_supplier_due()  {
        $dAta['searchtype']= $searchtype = $this->input->post('searchtype');
        $dAta['Purchase_startdate']=$Purchase_startdate = $this->input->post('Purchase_startdate');
        $dAta['Purchase_enddate']=$Purchase_enddate = $this->input->post('Purchase_enddate');
        $dAta['Supplierid']=$Supplierid = $this->input->post('Supplierid');
        $this->session->set_userdata($dAta);

        if($searchtype == "All"){
           $data['records'] = $this->Report_model->all_supplier_due_report();
        }
        if($searchtype == "Supplier"){
            $data['records'] = $this->Report_model->supplier_wise_due_report($Supplierid);
        }
        $this->load->view('Administrator/due_report/supplier_due_list', $data);
    }
    function supplier_due_payment($Supplierid)  {
        $Purchase_startdate = $this->session->userdata('Purchase_startdate');
        $Purchase_enddate = $this->session->userdata('Purchase_enddate');
        
       $sql = $this->db->query("SELECT tbl_purchasemaster.*, tbl_supplier.* FROM tbl_purchasemaster left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo WHERE tbl_purchasemaster.Supplier_SlNo = '$Supplierid' group by tbl_purchasemaster.Supplier_SlNo");
        $datas["record"] = $sql->result();
        $this->load->view('Administrator/due_report/supplier_due_payment', $datas);
    }


    public function supplierPaymentPage()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Supplier Payment";

        $data['paymentHis'] = $this->Billing_model->fatch_all_supplier_payment();
		$data['suppliers'] = $this->Other_model->branch_wise_supplier_info();
        $data['content'] = $this->load->view('Administrator/due_report/supplierPaymentPage', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    function fatch_supplier_name($Suppid= null){
        $supplier = $this->db->where('Supplier_SlNo',$Suppid)->get('tbl_supplier')->row();

        $data = array(
            'sup_name'      => $supplier->Supplier_Name,
            'due'                => $this->mt->getSupplierDueById($Suppid)
        );
        echo json_encode($data);
    }

    function supplierEdit($Suppid= null){
        $data['edit'] = $this->db->where('SPayment_id',$Suppid)->get('tbl_supplier_payment')->row();
        $this->load->view('Administrator/edit/payment_edit_supplier', $data);
    }

    function suppliertDelete($Suppid= null){
        
        $attr = array(
            'SPayment_status'     =>   'd'
        );

        $this->db->where('SPayment_id', $Suppid);
        $qu = $this->db->update('tbl_supplier_payment', $attr);
        
        if ( $this->db->affected_rows()) {
            echo json_encode(TRUE);
        }else {
            echo json_encode(FALSE);
        }
    }


    function supplierPaymentUpdate($Suppid= null){
        
        $attr = array(
            "SPayment_date"          =>$this->input->post('paymentDate', TRUE),
            "SPayment_invoice"       =>$this->input->post('tr_id', TRUE),
            "SPayment_customerID"    =>$this->input->post('SuppID', TRUE),
            "SPayment_TransactionType"=>$this->input->post('tr_type', TRUE),
            "SPayment_amount"        =>$this->input->post('paidAmount', TRUE),
            "SPayment_notes"         =>$this->input->post('Note', TRUE),
            "SPayment_Paymentby"     =>$this->input->post('Paymentby', TRUE),
            "SPayment_Addby"         =>$this->session->userdata("FullName"),
            "SPayment_brunchid"      =>$this->session->userdata("BRANCHid"),
            "SPayment_UpdateDAte"    =>date('Y-m-d'),
        );

        $this->db->where('SPayment_id', $Suppid);
        $qu = $this->db->update('tbl_supplier_payment', $attr);
        
        if ( $this->db->affected_rows()) {
            echo json_encode(TRUE);
        }else {
            echo json_encode(FALSE);
        }
    }

    function supplier_PaymentAmount(){
        
        $data = array(
            "SPayment_date"          =>$this->input->post('paymentDate', TRUE),
            "SPayment_invoice"       =>$this->input->post('tr_id', TRUE),
            "SPayment_customerID"    =>$this->input->post('SuppID', TRUE),
            "SPayment_TransactionType"=>$this->input->post('tr_type', TRUE),
            "SPayment_amount"        =>$this->input->post('paidAmount', TRUE),
            "SPayment_notes"         =>$this->input->post('Note', TRUE),
            "SPayment_Paymentby"     =>$this->input->post('Paymentby', TRUE),
            "SPayment_Addby"         =>$this->session->userdata("FullName"),
            "SPayment_brunchid"      =>$this->session->userdata("BRANCHid"),
            "SPayment_AddDAte"       =>date('Y-m-d'),
            "SPayment_status"        =>'a',
        );
        $this->mt->save_data("tbl_supplier_payment", $data);
        echo json_encode(TRUE);

    }
    function supplier_payment_report(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Supplier Payment Reports";
        $data['content'] = $this->load->view('Administrator/payment_reports/supplier_payment_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    function search_supplier_payments()  {
        $dAta['searchtype']= $searchtype = $this->input->post('searchtype');
        $dAta['Purchase_startdate']=$Purchase_startdate = $this->input->post('Purchase_startdate');
        $dAta['Purchase_enddate']=$Purchase_enddate = $this->input->post('Purchase_enddate');
        $dAta['Supplierid']=$Supplierid = $this->input->post('Supplierid');
        $this->session->set_userdata($dAta);

        // if($searchtype == "All"){
        //     $sql = "SELECT tbl_supplier_payment.*, tbl_supplier.* FROM tbl_supplier_payment left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_supplier_payment.SPayment_customerID WHERE tbl_supplier_payment.SPayment_date between  '$Purchase_startdate' and '$Purchase_enddate'";
        // }

        if($searchtype == "Supplier"){
            $sql = "SELECT 
                                tbl_supplier_payment.*,
                                tbl_supplier.* 
                        FROM tbl_supplier_payment 
                        left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_supplier_payment.SPayment_customerID 
                        WHERE tbl_supplier_payment.SPayment_customerID = '$Supplierid' 
                        and  tbl_supplier_payment.SPayment_date 
                            between  '$Purchase_startdate' 
                            and '$Purchase_enddate' 
                        GROUP BY tbl_supplier_payment.SPayment_invoice
                        order by SPayment_date";
        }
        $result = $this->db->query($sql);
        
        $dueSql = "SELECT s.Supplier_Name,
        (select ifnull(sum(PurchaseMaster_SubTotalAmount), 0.00) from tbl_purchasemaster where Supplier_SlNo = s.Supplier_SlNo and PurchaseMaster_OrderDate < '$Purchase_startdate' ) as purchaseAmount,
        (select ifnull(sum(SPayment_amount), 0.00) from tbl_supplier_payment where SPayment_customerID = s.Supplier_SlNo and SPayment_date < '$Purchase_startdate') as paidAmount,
        (select ifnull(sum(PurchaseReturn_ReturnAmount), 0.00) from tbl_purchasereturn where Supplier_IDdNo = s.Supplier_SlNo and PurchaseReturn_ReturnDate < '$Purchase_startdate') as returnAmount,
        (select (s.previous_due + purchaseAmount) - (paidAmount + returnAmount)) as dueAmount
        from tbl_supplier s
        where Supplier_SLNo = '$Supplierid'";

        $dueResult = $this->db->query($dueSql);

        $datas["record"] = $result->result();
        $datas["recordss"] = $result->row();
        $datas["due"] = $dueResult->row();
        $this->load->view('Administrator/payment_reports/supplier_payment_report_list', $datas);
    }

    public function getSuppliers(){
        $suppliers = $this->db->query("
            select 
            *,
            concat(Supplier_Code, ' - ', Supplier_Name) as display_name
            from tbl_supplier
            where Status = 'a'
            and Supplier_Type != 'G'
            and Supplier_brinchid = ? or Supplier_brinchid = 0
            order by Supplier_SlNo desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($suppliers);
    }

    public function getSupplierDue(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->supplierId) && $data->supplierId != null){
            $clauses = " and s.Supplier_SlNo = '$data->supplierId'";
        }
        $supplierDues = $this->mt->supplierDue($clauses);

        echo json_encode($supplierDues);
    }

    public function getSupplierLedger(){
        $data = json_decode($this->input->raw_input_stream);
        $previousDueQuery = $this->db->query("select ifnull(previous_due, 0.00) as previous_due from tbl_supplier where Supplier_SlNo = '$data->supplierId'")->row();
        $payments = $this->db->query("
            select
                'a' as sequence,
                pm.PurchaseMaster_SlNo as id,
                pm.PurchaseMaster_OrderDate date,
                concat('Purchase ', pm.PurchaseMaster_InvoiceNo) as description,
                pm.PurchaseMaster_TotalAmount as bill,
                pm.PurchaseMaster_PaidAmount as paid,
                (pm.PurchaseMaster_TotalAmount - pm.PurchaseMaster_PaidAmount) as due,
                0.00 as returned,
                0.00 as cash_received,
                0.00 as balance
            from tbl_purchasemaster pm
            where pm.Supplier_SlNo = '$data->supplierId'
            and pm.status = 'a'
            
            UNION
            select
                'b' as sequence,
                sp.SPayment_id as id,
                sp.SPayment_date as date,
                concat('Paid - ', 
                    case sp.SPayment_Paymentby
                        when 'bank' then concat('Bank - ', ba.account_name, ' - ', ba.account_number, ' - ', ba.bank_name)
                        else 'Cash'
                    end, ' ', sp.SPayment_notes
                ) as description,
                0.00 as bill,
                sp.SPayment_amount as paid,
                0.00 as due,
                0.00 as returned,
                0.00 as cash_received,
                0.00 as balance
            from tbl_supplier_payment sp 
            left join tbl_bank_accounts ba on ba.account_id = sp.account_id
            where sp.SPayment_customerID = '$data->supplierId'
            and sp.SPayment_TransactionType = 'CP'
            and sp.SPayment_status = 'a'
            
            UNION
            select 
                'c' as sequence,
                sp2.SPayment_id as id,
                sp2.SPayment_date as date,
                concat('Received - ', 
                    case sp2.SPayment_Paymentby
                        when 'bank' then concat('Bank - ', ba.account_name, ' - ', ba.account_number, ' - ', ba.bank_name)
                        else 'Cash'
                    end, ' ', sp2.SPayment_notes
                ) as description,
                0.00 as bill,
                0.00 as paid,
                0.00 as due,
                0.00 as returned,
                sp2.SPayment_amount as cash_received,
                0.00 as balance
            from tbl_supplier_payment sp2
            left join tbl_bank_accounts ba on ba.account_id = sp2.account_id
            where sp2.SPayment_customerID = '$data->supplierId'
            and sp2.SPayment_TransactionType = 'CR'
            and sp2.SPayment_status = 'a'
            
            UNION
            select
                'd' as sequence,
                pr.PurchaseReturn_SlNo as id,
                pr.PurchaseReturn_ReturnDate as date,
                'Purchase Return' as description,
                0.00 as bill,
                0.00 as paid,
                0.00 as due,
                pr.PurchaseReturn_ReturnAmount as returned,
                0.00 as cash_received,
                0.00 as balance
            from tbl_purchasereturn pr
            where pr.Supplier_IDdNo = '$data->supplierId'
            
            order by date, sequence, id
        ")->result();

        $previousBalance = $previousDueQuery->previous_due;

        foreach($payments as $key=>$payment){
            $lastBalance = $key == 0 ? $previousDueQuery->previous_due : $payments[$key - 1]->balance;
            $payment->balance = ($lastBalance + $payment->bill + $payment->cash_received) - ($payment->paid + $payment->returned);
        }

        if((isset($data->dateFrom) && $data->dateFrom != null) && (isset($data->dateTo) && $data->dateTo != null)){
            $previousPayments = array_filter($payments, function($payment) use ($data){
                return $payment->date < $data->dateFrom;
            });

            $previousBalance = count($previousPayments) > 0 ? $previousPayments[count($previousPayments) - 1]->balance : $previousBalance;

            $payments = array_filter($payments, function($payment) use ($data){
                return $payment->date >= $data->dateFrom && $payment->date <= $data->dateTo;
            });
        }

        $res['previousBalance'] = $previousBalance;
        $res['payments'] = $payments;
        echo json_encode($res);
    }

    public function getSupplierPayments(){
        $data = json_decode($this->input->raw_input_stream);

        $paymentTypeClause = "";
        if(isset($data->paymentType) && $data->paymentType != '' && $data->paymentType == 'received'){
            $paymentTypeClause = " and sp.SPayment_TransactionType = 'CR'";
        }
        if(isset($data->paymentType) && $data->paymentType != '' && $data->paymentType == 'paid'){
            $paymentTypeClause = " and sp.SPayment_TransactionType = 'CP'";
        }

        $dateClause = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $dateClause = " and sp.SPayment_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $payments = $this->db->query("
            select
                sp.*,
                s.Supplier_Code,
                s.Supplier_Name,
                s.Supplier_Mobile,
                ba.account_name,
                ba.account_number,
                ba.bank_name,
                case sp.SPayment_TransactionType
                when 'CR' then 'Received'
                    when 'CP' then 'Paid'
                end as transaction_type,
                case sp.SPayment_Paymentby
                    when 'bank' then concat('Bank - ', ba.account_name, ' - ', ba.account_number, ' - ', ba.bank_name)
                    else 'Cash'
                end as payment_by
            from tbl_supplier_payment sp
            left join tbl_bank_accounts ba on ba.account_id = sp.account_id
            join tbl_supplier s on s.Supplier_SlNo = sp.SPayment_customerID
            where sp.SPayment_status = 'a'
            and sp.SPayment_brunchid = ? $paymentTypeClause $dateClause
            order by sp.SPayment_id desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($payments);
    }

    public function addSupplierPayment(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $paymentObj = json_decode($this->input->raw_input_stream);
    
            $payment = (array)$paymentObj;
            $payment['SPayment_invoice'] = $this->mt->generateSupplierPaymentCode();
            $payment['SPayment_status'] = 'a';
            $payment['SPayment_Addby'] = $this->session->userdata("FullName");
            $payment['SPayment_AddDAte'] = date('Y-m-d H:i:s');
            $payment['SPayment_brunchid'] = $this->session->userdata("BRANCHid");

            $this->db->insert('tbl_supplier_payment', $payment);
            $paymentId = $this->db->insert_id();
            
            $res = ['success'=>true, 'message'=>'Payment added successfully', 'paymentId'=>$paymentId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateSupplierPayment(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $paymentObj = json_decode($this->input->raw_input_stream);
            $paymentId = $paymentObj->SPayment_id;
    
            $payment = (array)$paymentObj;
            unset($payment['SPayment_id']);
            $payment['update_by'] = $this->session->userdata("FullName");
            $payment['SPayment_UpdateDAte'] = date('Y-m-d H:i:s');

            $this->db->where('SPayment_id', $paymentObj->SPayment_id)->update('tbl_supplier_payment', $payment);
            
            $res = ['success'=>true, 'message'=>'Payment updated successfully', 'paymentId'=>$paymentId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteSupplierPayment(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
    
            $this->db->set(['SPayment_status'=>'d'])->where('SPayment_id', $data->paymentId)->update('tbl_supplier_payment');
            
            $res = ['success'=>true, 'message'=>'Payment deleted successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }
}
