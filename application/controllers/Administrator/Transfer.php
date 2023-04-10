<?php
    class Transfer extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $access = $this->session->userdata('userId');
            if($access == '' ){
                redirect("Login");
            }
            $this->load->model('Model_table', "mt", TRUE);
        }

        public function productTransfer(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }

            $data['transferId'] = 0;
            $data['title'] = "Product Transfer";
            $data['content'] = $this->load->view('Administrator/transfer/product_transfer', $data, TRUE);
            $this->load->view('Administrator/index', $data);
        }

        public function transferEdit($transferId){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }

            $data['transferId'] = $transferId;
            $data['title'] = "Product Transfer";
            $data['content'] = $this->load->view('Administrator/transfer/product_transfer', $data, TRUE);
            $this->load->view('Administrator/index', $data);
        }

        public function addProductTransfer(){
            $res = ['success'=>false, 'message'=>''];
            try{
                $data = json_decode($this->input->raw_input_stream);
                $transfer = array(
                    'transfer_date' => $data->transfer->transfer_date,
                    'transfer_by' => $data->transfer->transfer_by,
                    'transfer_from' => $this->session->userdata('BRANCHid'),
                    'transfer_to' => $data->transfer->transfer_to,
                    'note' => $data->transfer->note,
                    'total_amount' => $data->transfer->total_amount
                );

                $this->db->insert('tbl_transfermaster', $transfer);
                $transferId = $this->db->insert_id();

                foreach($data->cart as $cartProduct){
                    $transferDetails = array(
                        'transfer_id' => $transferId,
                        'product_id' => $cartProduct->product_id,
                        'quantity' => $cartProduct->quantity,
                        'purchase_rate' => $cartProduct->purchase_rate,
                        'total' => $cartProduct->total
                    );

                    $this->db->insert('tbl_transferdetails', $transferDetails);

                    $currentBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $this->session->userdata('BRANCHid')])->num_rows();
                    if($currentBranchInventoryCount == 0){
                        $currentBranchInventory = array(
                            'product_id' => $cartProduct->product_id,
                            'transfer_from_quantity' => $cartProduct->quantity,
                            'branch_id' => $this->session->userdata('BRANCHid')
                        );

                        $this->db->insert('tbl_currentinventory', $currentBranchInventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory 
                            set transfer_from_quantity = transfer_from_quantity + ? 
                            where product_id = ? 
                            and branch_id = ?
                        ", [$cartProduct->quantity, $cartProduct->product_id, $this->session->userdata('BRANCHid')]);
                    }

                    $transferToBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $data->transfer->transfer_to])->num_rows();
                    if($transferToBranchInventoryCount == 0){
                        $transferToBranchInventory = array(
                            'product_id' => $cartProduct->product_id,
                            'transfer_to_quantity' => $cartProduct->quantity,
                            'branch_id' => $data->transfer->transfer_to
                        );

                        $this->db->insert('tbl_currentinventory', $transferToBranchInventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory
                            set transfer_to_quantity = transfer_to_quantity + ?
                            where product_id = ?
                            and branch_id = ?
                        ", [$cartProduct->quantity, $cartProduct->product_id, $data->transfer->transfer_to]);
                    }
                }
                $res = ['success'=>true, 'message'=>'Transfer success'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }

        public function updateProductTransfer(){
            $res = ['success'=>false, 'message'=>''];
            try{
                $data           = json_decode($this->input->raw_input_stream);
                $transferId     =   $data->transfer->transfer_id;

                $oldTransfer    =   $this->db->query("select * from tbl_transfermaster where transfer_id = ?", $transferId)->row();

                $transfer = array(
                    'transfer_date' => $data->transfer->transfer_date,
                    'transfer_by' => $data->transfer->transfer_by,
                    'transfer_from' => $this->session->userdata('BRANCHid'),
                    'transfer_to' => $data->transfer->transfer_to,
                    'note' => $data->transfer->note
                );

                $this->db->where('transfer_id', $transferId)->update('tbl_transfermaster', $transfer);

                $oldTransferDetails = $this->db->query("select * from tbl_transferdetails where transfer_id = ?", $transferId)->result();
                $this->db->query("delete from tbl_transferdetails where transfer_id = ?", $transferId);
                foreach($oldTransferDetails as $oldDetails) {
                    $this->db->query("
                        update tbl_currentinventory 
                        set transfer_from_quantity = transfer_from_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$oldDetails->quantity, $oldDetails->product_id, $this->session->userdata('BRANCHid')]);

                    $this->db->query("
                        update tbl_currentinventory 
                        set transfer_to_quantity = transfer_to_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$oldDetails->quantity, $oldDetails->product_id, $oldTransfer->transfer_to]);
                }

                foreach($data->cart as $cartProduct){
                    $transferDetails = array(
                        'transfer_id' => $transferId,
                        'product_id' => $cartProduct->product_id,
                        'quantity' => $cartProduct->quantity
                    );

                    $this->db->insert('tbl_transferdetails', $transferDetails);

                    $currentBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $this->session->userdata('BRANCHid')])->num_rows();
                    if($currentBranchInventoryCount == 0){
                        $currentBranchInventory = array(
                            'product_id' => $cartProduct->product_id,
                            'transfer_from_quantity' => $cartProduct->quantity,
                            'branch_id' => $this->session->userdata('BRANCHid')
                        );

                        $this->db->insert('tbl_currentinventory', $currentBranchInventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory 
                            set transfer_from_quantity = transfer_from_quantity + ? 
                            where product_id = ? 
                            and branch_id = ?
                        ", [$cartProduct->quantity, $cartProduct->product_id, $this->session->userdata('BRANCHid')]);
                    }

                    $transferToBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $data->transfer->transfer_to])->num_rows();
                    if($transferToBranchInventoryCount == 0){
                        $transferToBranchInventory = array(
                            'product_id' => $cartProduct->product_id,
                            'transfer_to_quantity' => $cartProduct->quantity,
                            'branch_id' => $data->transfer->transfer_to
                        );

                        $this->db->insert('tbl_currentinventory', $transferToBranchInventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory
                            set transfer_to_quantity = transfer_to_quantity + ?
                            where product_id = ?
                            and branch_id = ?
                        ", [$cartProduct->quantity, $cartProduct->product_id, $data->transfer->transfer_to]);
                    }
                }
                $res = ['success'=>true, 'message'=>'Transfer updated'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }

        public function transferList(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Transfer List";
            $data['content'] = $this->load->view('Administrator/transfer/transfer_list', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function receivedList(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Received List";
            $data['content'] = $this->load->view('Administrator/transfer/received_list', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function getTransfers(){
            $data = json_decode($this->input->raw_input_stream);

            $clauses = "";
            if(isset($data->branch) && $data->branch != ''){
                $clauses .= " and tm.transfer_to = '$data->branch'";
            }

            if((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')){
                $clauses .= " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }

            if(isset($data->transferId) && $data->transferId != ''){
                $clauses .= " and tm.transfer_id = '$data->transferId'";
            }

            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_from = ? $clauses
            ", $this->session->userdata('BRANCHid'))->result();

            echo json_encode($transfers);
        }

        public function getTransferDetails() {
            $data = json_decode($this->input->raw_input_stream);
            $transferDetails = $this->db->query("
                select 
                    td.*,
                    p.Product_Code,
                    p.Product_Name,
                    pc.ProductCategory_Name
                from tbl_transferdetails td
                join tbl_product p on p.Product_SlNo = td.product_id
                left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where td.transfer_id = ?
            ", $data->transferId)->result();

            echo json_encode($transferDetails);
        }

        public function getReceives(){
            $data = json_decode($this->input->raw_input_stream);

            $branchClause = "";
            if($data->branch != null && $data->branch != ''){
                $branchClause = " and tm.transfer_from = '$data->branch'";
            }

            $dateClause = "";
            if(($data->dateFrom != null && $data->dateFrom != '') && ($data->dateTo != null && $data->dateTo != '')){
                $dateClause = " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }


            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_from_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_from
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_to = ? $branchClause $dateClause
            ", $this->session->userdata('BRANCHid'))->result();

            echo json_encode($transfers);
        }

        public function transferInvoice($transferId){
            $data['title'] = 'Transfer Invoice';

            $data['transfer'] = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_id = ?
            ", $transferId)->row();

            $data['transferDetails'] = $this->db->query("
                select
                    td.*,
                    p.Product_Code,
                    p.Product_Name,
                    pc.ProductCategory_Name
                from tbl_transferdetails td
                join tbl_product p on p.Product_SlNo = td.product_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where td.transfer_id = ?
            ", $transferId)->result();

            $data['content'] = $this->load->view('Administrator/transfer/transfer_invoice', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function deleteTransfer() {
            $res = ['success'=>false, 'message'=>''];
            try{
                $data = json_decode($this->input->raw_input_stream);
                $transferId = $data->transferId;

                $oldTransfer = $this->db->query("select * from tbl_transfermaster where transfer_id = ?", $transferId)->row();
                $oldTransferDetails = $this->db->query("select * from tbl_transferdetails where transfer_id = ?", $transferId)->result();

                $this->db->query("delete from tbl_transfermaster where transfer_id = ?", $transferId);
                $this->db->query("delete from tbl_transferdetails where transfer_id = ?", $transferId);
                foreach($oldTransferDetails as $oldDetails) {
                    $this->db->query("
                        update tbl_currentinventory 
                        set transfer_from_quantity = transfer_from_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$oldDetails->quantity, $oldDetails->product_id, $this->session->userdata('BRANCHid')]);

                    $this->db->query("
                        update tbl_currentinventory 
                        set transfer_to_quantity = transfer_to_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$oldDetails->quantity, $oldDetails->product_id, $oldTransfer->transfer_to]);
                }

                $res = ['success'=>true, 'message'=>'Transfer deleted'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }
    }