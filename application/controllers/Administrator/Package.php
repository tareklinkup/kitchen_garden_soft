<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }  
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
    }
    function index()  {
        $data['title'] = "Package";
        $data['content'] = $this->load->view('Administrator/package/add_package', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    
    function package_Insert()  {
        $name = $this->input->post('packagename');
        $pCategory = $this->input->post('pCategory');
        $query = $this->db->query("SELECT * from tbl_package where package_name = '$name'");
        if($query->num_rows() > 0){
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/package/add_package',$data);
        }
        else{
             $serial ="P1000"; $sql = mysql_query("SELECT * FROM tbl_product");
            while ($d = mysql_fetch_array($sql)){
                if($d['Product_Code']!=null){$serial = $d['Product_Code'];}
            } $serial = explode("P",$serial);
                $serial=$serial['1']; $autoserial= $serial+1;$proIDD = "P".$autoserial;

            $data = array(
                "package_name"  =>$name,
                "package_categoryid"  =>$this->input->post('pCategory'),
                "package_purchPrice"  =>$this->input->post('purchaseprice'),
                "package_ProCode"  =>$proIDD,

                "package_sellPrice"  =>$this->input->post('salesprice')
            );
            $lastid = $this->mt->save_date_id("tbl_package", $data);

            $data = array(
                "Product_packageID"            =>$lastid,
                "Product_Code"                 =>$proIDD,
                "ProductCategory_ID"           =>$pCategory,
                "Product_Name"                 =>$name,
                "Product_type"                 =>'Product',
                "Product_ReOrederLevel"        =>'0',
                "Product_Purchase_Rate"        =>$this->input->post('purchaseprice', TRUE),
                "Product_SellingPrice"         =>$this->input->post('salesprice', TRUE),
                "Unit_ID"                      =>"pcs",
                "AddBy"                        =>$this->session->userdata("FullName"),
                "AddTime"                      =>date("Y-m-d H:i:s")
            );
        $this->mt->save_data('tbl_product',$data);
        $this->load->view('Administrator/package/add_package');
        }
    }
   
    function packageEdit() {
        $id = $this->input->post('editid');
        $query = "SELECT tbl_package.*, tbl_productcategory.* FROM tbl_package left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo =tbl_package.package_categoryid WHERE tbl_package.package_ID = '$id'";
        $data['selected'] = $this->mt->edit_by_id($query);
        $this->load->view('Administrator/edit/package_edit', $data);
    }
    function packageUdate(){
        $id = $this->input->post('id');
        $fld = 'package_ID';
            $data = array(
                "package_name"  =>$this->input->post('packagename'),
                "package_categoryid"  =>$this->input->post('pCategory'),
                "package_purchPrice"  =>$this->input->post('purchaseprice'),
                "package_sellPrice"  =>$this->input->post('salesprice')
            );
        $this->mt->update_data("tbl_package", $data, $id,"package_ID");
        $this->load->view('Administrator/package/add_package'); 
    } 
    function packageDelete(){
        $fld = 'package_ID';
        $id = $this->input->post("deleted");
        $this->mt->delete_data("tbl_package", $id, "package_ID");
        $this->load->view('Administrator/package/add_package');
    }
    // Careate Package=======================================================================
    function create()  {
        $data['title'] = "Package Create";
        $data['content'] = $this->load->view('Administrator/package/create', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    } 
    function package_create_Insert()  {
        $name = $this->input->post('packageItem');
        $query = $this->db->query("SELECT * from tbl_package_create where create_item = '$name'");
        if($query->num_rows() > 0){
           echo "F";
            //$this->load->view('Administrator/package/create',$data);
        }
        else{
            $serial ="P1000"; $sql = mysql_query("SELECT * FROM tbl_product");
            while ($d = mysql_fetch_array($sql)){
                if($d['Product_Code']!=null){$serial = $d['Product_Code'];}
            } $serial = explode("P",$serial);
                $serial=$serial['1']; $autoserial= $serial+1;$proIDD = "P".$autoserial;

            $data = array(
                "create_pacageID"       =>$this->input->post('packateType'),
                "create_item"           =>$this->input->post('packageItem'),
                "create_purch_price"    =>$this->input->post('purchprice'),
                "cteate_qty"    =>$this->input->post('itemqty'),
                "create_proCode"        =>$proIDD,
                "create_sell_price"     =>$this->input->post('sellpirce')
            );
            $lasID = $this->mt->save_date_id("tbl_package_create", $data);
            $data = array(
                "product_create_pack_id"       =>$lasID,
                "Product_Code"                 =>$proIDD,
                "ProductCategory_ID"           =>$this->input->post('pCategory'),
                "Product_Name"                 =>$this->input->post('packageItem'),
                "Product_type"                 =>'Product',
                "Product_ReOrederLevel"        =>'0',
                "Product_Purchase_Rate"        =>$this->input->post('purchprice', TRUE),
                "Product_SellingPrice"         =>$this->input->post('sellpirce', TRUE),
                "Unit_ID"                      =>"0",
                "AddBy"                        =>$this->session->userdata("FullName"),
                "AddTime"                      =>date("Y-m-d H:i:s")
            );
        $this->mt->save_data('tbl_product',$data);
            //echo "T";
            $this->load->view('Administrator/package/create');
        }
    }
    function createDelete(){
        $id = $this->input->post("deleted");
        $sqls =mysql_query("SELECT * FROM tbl_product WHERE product_create_pack_id = '$id'");
            $ROM = mysql_fetch_array($sqls);
            $prodcid = $ROM['Product_SlNo'];

        $this->mt->delete_data("tbl_package_create", $id, 'create_ID');
        $this->mt->delete_data("tbl_product", $prodcid, 'Product_SlNo');
        $this->load->view('Administrator/package/create');
    }
    function createEdit() {
        $id = $this->input->post('editid');
        $query = "SELECT tbl_package_create.*, tbl_package.*,tbl_product.*,tbl_productcategory.* FROM tbl_package_create left join tbl_package on tbl_package.package_ProCode = tbl_package_create.create_pacageID left join tbl_product on tbl_product.product_create_pack_id=tbl_package_create.create_ID left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID WHERE tbl_package_create.create_ID = '$id'";
        $data['selected'] = $this->mt->edit_by_id($query);
        $this->load->view('Administrator/edit/package_create_edit', $data);
    }
    function createUdate(){
        $id = $this->input->post('id');
        $pcode = $this->input->post('pcode');
            $data = array(
               "create_pacageID"  =>$this->input->post('packateType'),
                "create_item"  =>$this->input->post('packageItem'),
                "create_purch_price"  =>$this->input->post('purchprice'),
                "cteate_qty"    =>$this->input->post('itemqty'),
                "create_proCode"  =>$pcode,
                "create_sell_price"  =>$this->input->post('sellpirce')
                );
            $this->mt->update_data("tbl_package_create", $data, $id,'create_ID');

            $sqls =mysql_query("SELECT * FROM tbl_product WHERE Product_Code = '$pcode'");
            $ROM = mysql_fetch_array($sqls);
            $prodcid = $ROM['Product_SlNo'];
            $data = array(
                "product_create_pack_id"       =>$id,
                "Product_Code"                 =>$pcode,
                "ProductCategory_ID"            =>$this->input->post('pCategory'),
                "Product_Name"                 =>$this->input->post('packageItem'),
                "Product_type"                 =>'Product',
                "Product_ReOrederLevel"        =>'0',
                "Product_Purchase_Rate"        =>$this->input->post('purchprice', TRUE),
                "Product_SellingPrice"         =>$this->input->post('sellpirce', TRUE),
                "Unit_ID"                      =>"0",
                "AddBy"                        =>$this->session->userdata("FullName"),
                "AddTime"                      =>date("Y-m-d H:i:s")
            );
            $this->mt->update_data('tbl_product',$data,$prodcid, 'Product_SlNo');
        $this->load->view('Administrator/package/create'); 
    } 
    
}
