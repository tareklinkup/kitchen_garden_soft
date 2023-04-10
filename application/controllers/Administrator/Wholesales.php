<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wholesales extends CI_Controller {
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
        $this->cart->destroy();
        $data['title'] = "Whole Sales Product";
        $data['content'] = $this->load->view('Administrator/sales/wholesales_product', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    function SelectProducts()  {
        $ProID = $this->input->post('ProID');
        $query = "SELECT tbl_product.*,tbl_unit.* FROM tbl_product left join tbl_unit on tbl_unit.Unit_SlNo = tbl_product.Unit_ID where tbl_product.Product_SlNo = '$ProID'";
        $data['Product'] = $this->mt->edit_by_id($query);
        $this->load->view('Administrator/sales/ajax_wholesalesProduct', $data);
    }
    //Designation
   
    public function sales_order(){
        $re = 0;
        if ($cart = $this->cart->contents()){
            foreach ($cart as $item){
                $branchID = $this->session->userdata("BRANCHid");
                $pid = $item['id'];
                $qty = $item['qty'];
                $proStock = 0;
                $SPQ = mysql_query("SELECT * FROM tbl_purchasedetails WHERE Product_IDNo = '$pid' AND PurchaseDetails_branchID = '$branchID'");
                while ($pdrow = mysql_fetch_array($SPQ)) {
                    $proStock += $pdrow['PurchaseDetails_TotalQuantity'];
                }
                $SSI = mysql_query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$pid' AND SaleInventory_brunchid = '$branchID'");
                $sirow = mysql_fetch_array($SSI);
                $proStock -= $sirow['SaleInventory_TotalQuantity'];
                $proStock += $sirow['SaleInventory_ReturnQuantity'];
                $SPI = mysql_query("SELECT * FROM tbl_purchaseinventory WHERE purchProduct_IDNo = '$pid' AND PurchaseInventory_brunchid = '$branchID'");
                $pirow = mysql_fetch_array($SPI);
                $proStock -= $pirow['PurchaseInventory_ReturnQuantity'];
                $proStock -= $pirow['PurchaseInventory_DamageQuantity'];

                if($qty > $proStock){
                    echo $re = 0;
                }else{
                    echo $re = 1;
                }

            }
        }

        if($re == 0){
            return false;
        }

        $sales = array(
            "SaleMaster_InvoiceNo"                      =>$this->input->post('salesInvoiceno'),
            "SalseCustomer_IDNo"                        =>$this->input->post('customerID'),
            "SaleMaster_SaleDate"                       =>$this->input->post('sales_date'),
            "SaleMaster_Description"                    =>$this->input->post('SelesNotes'),
            "SaleMaster_TotalSaleAmount"                =>$this->input->post('subTotal'),
            "SaleMaster_TotalDiscountAmount"            =>$this->input->post('SellsDiscount'),
            "SaleMaster_TaxAmount"                      =>$this->input->post('vatPersent'),
            "SaleMaster_Freight"                        =>$this->input->post('SellsFreight'),
            "SaleMaster_SubTotalAmount"                 =>$this->input->post('SellTotals'),
            "SaleMaster_PaidAmount"                     =>$this->input->post('SellsPaid'),
            "SaleMaster_DueAmount"                      =>$this->input->post('SellsDue'),
            "Status"                                    =>'W',
            "AddBy"                                     =>$this->session->userdata("FullName"),
            "SaleMaster_branchid"                       =>$this->session->userdata("BRANCHid"),
            "AddTime"                                   =>date("Y-m-d H:i:s")
        );      
        $sales_id = $this->Billing_model->SalesOrder($sales);
        $data = array(
            "CPayment_date"                     =>$this->input->post('sales_date', TRUE),
            "CPayment_invoice"                  =>$this->input->post('salesInvoiceno', TRUE),
            "CPayment_customerID"               =>$this->input->post('customerID', TRUE),
            "CPayment_amount"                   =>$this->input->post('SellsPaid', TRUE),
            "CPayment_notes"                    =>$this->input->post('SelesNotes', TRUE),
            "CPayment_Addby"                    =>$this->session->userdata("FullName"),
            "CPayment_brunchid"                 =>$this->session->userdata("BRANCHid")
        );
        $this->mt->save_data("tbl_customer_payment", $data);
        
        if ($cart = $this->cart->contents()){
            foreach ($cart as $item){
                $packagename = $item['packagename'];
                $proname = $item['name'];
                $packagecode = $item['packagecode'];
                if($packagename == $proname){
                    $sqqS = mysql_query("SELECT tbl_package_create.*, tbl_product.* FROM tbl_package_create left join tbl_product on tbl_product.product_create_pack_id = tbl_package_create.create_ID WHERE tbl_package_create.create_pacageID = '$packagecode'");
                    while($romS = mysql_fetch_array($sqqS)){
                        $proids = $romS['Product_SlNo'];
                        $sellPRICE = $romS['create_sell_price'];
                        $PurchpackagPRICE = $romS['create_purch_price'];
                        $packagNAME = $romS['create_item'];
                        $packqty = $romS['cteate_qty']*$item['qty'];
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
                        $sql = mysql_query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '".$proids."'");
                        $rox = mysql_fetch_array($sql);
                        $id = $rox['SaleInventory_SlNo'];
                        $oldStock = $rox['SaleInventory_TotalQuantity'];
                        $oldpackStock = $rox['SaleInventory_qty'];

                        if($rox['sellProduct_IdNo']== $proids){
                            $addStock = array(
                                'sellProduct_IdNo'                      => $proids,
                                'SaleInventory_TotalQuantity'           => $oldStock+$packqty,
                                'SaleInventory_qty'                     => $oldpackStock+$item['qty'],
                                'SaleInventory_packname'                => $packagename
                            );
                            $this->mt->update_data("tbl_saleinventory",$addStock,$id,'SaleInventory_SlNo');  
                        }else{
                            $addStock = array(
                                'sellProduct_IdNo'                      => $proids,
                                'SaleInventory_TotalQuantity'           => $packqty,
                                'SaleInventory_qty'                     => $item['qty'],
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
                        'Purchase_Rate'                 => $item['purchaserate']
                    );
                    $this->Billing_model->insert_sales_detail($order_detail);
                    // Stock add
                    $sql = mysql_query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '".$item['id']."'");
                    $rox = mysql_fetch_array($sql);
                    $id = $rox['SaleInventory_SlNo'];
                    $oldStock = $rox['SaleInventory_TotalQuantity'];

                    if($rox['sellProduct_IdNo']== $item['id']){
                        $addStock = array(
                            'sellProduct_IdNo'                      => $item['id'],
                            'SaleInventory_TotalQuantity'           => $oldStock+$item['qty'],
                            'SaleInventory_brunchid'                => $this->sbrunch,
                            "UpdateBy"                              =>$this->session->userdata("FullName"),
                            "UpdateTime"                            =>date("Y-m-d H:i:s")
                        );
                        $this->mt->update_data("tbl_saleinventory",$addStock,$id,'SaleInventory_SlNo');  
                    }else{
                        $addStock = array(
                            'sellProduct_IdNo'                      => $item['id'],
                            'SaleInventory_TotalQuantity'           => $item['qty'],
                            'SaleInventory_brunchid'                => $this->sbrunch,
                            "AddBy"                                 =>$this->session->userdata("FullName"),
                            "AddTime"                               =>date("Y-m-d H:i:s")
                        );
                    $this->mt->save_data("tbl_saleinventory",$addStock);
                    } 
                }
                
            }// end foreach
        }// end if

        $this->cart->destroy();
        $sss['lastidforprint'] = $sales_id;
        $this->session->set_userdata($sss);
        $this->load->view('Administrator/sales/product_sales');
    }
}
