<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->model('Billing_model');
    }
    public function index()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Product";
        $data['productCode'] = $this->mt->generateProductCode();
        $data['content'] = $this->load->view('Administrator/products/add_product', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function fanceybox_unit()
    {
        $this->load->view('Administrator/products/fanceybox_unit');
    }
    public function insert_unit()
    {
        $mail = $this->input->post('add_unit');
        $query = $this->db->query("SELECT Unit_Name from tbl_unit where Unit_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/fanceybox_product_unit', $data);
        } else {
            $data = array(
                "Unit_Name"          => $this->input->post('add_unit', TRUE),
                "AddBy"                  => $this->session->userdata("FullName"),
                "AddTime"                => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_unit', $data);
            $this->load->view('Administrator/ajax/fanceybox_product_unit');
        }
    }

    public function addProduct()
    {

        $res = ['success' => false, 'message' => ''];
        try {
            $productObj = json_decode($this->input->post('data'));

            $productNameCount = $this->db->query("select * from tbl_product where Product_Name = ?", $productObj->Product_Name)->num_rows();
            if ($productNameCount > 0) {
                $res = ['success' => false, 'message' => 'Product name already exists'];
                echo json_encode($res);
                exit;
            }

            $productCodeCount = $this->db->query("select * from tbl_product where Product_Code = ?", $productObj->Product_Code)->num_rows();
            if ($productCodeCount > 0) {
                $productObj->Product_Code = $this->mt->generateProductCode();
            }

            $product = (array)$productObj;
            $product['is_service'] = $productObj->is_service == true ? 'true' : 'false';
            $product['is_website'] = $productObj->is_website == true ? 'true' : 'false';
            $product['status'] = 'a';
            $product['AddBy'] = $this->session->userdata("FullName");
            $product['AddTime'] = date('Y-m-d H:i:s');
            $product['Product_branchid'] = $this->brunch;


            $this->db->insert('tbl_product', $product);

            $id = $this->db->insert_id();

            if (!empty($_FILES['image']['name'])) {
                $currentDirectory = getcwd();
                $dir = "/uploads/products/";
                $filename = time() . "-" . $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);
                $this->db->where('Product_SlNo', $id);
                $this->db->update('tbl_product', array("image" => $filename));
            }

            $res = ['success' => true, 'message' => 'Product added successfully', 'productId' => $this->mt->generateProductCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function chk_product_code()
    {
        $Pid = $this->input->post('Pid');
        $data['duplicate'] = array();

        $query = $this->db->query("SELECT * FROM tbl_product WHERE Product_Code='$Pid'");
        if ($query->num_rows() > 0) {
            $data['duplicate'] = 'yes';
        }
        $this->load->view('Administrator/ajax/product', $data['duplicate']);
    }
    public function product_edit()
    {
        $data['title'] = "Update Product";
        $id = $this->input->post('edit');
        $data['allproduct'] =  $this->Billing_model->select_all_Product();
        $data['selected'] = $this->Billing_model->get_product_by_id($id);
        $this->load->view('Administrator/edit/product', $data);
    }
    public function updateProduct()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $productObj = json_decode($this->input->post('data'));

            $productNameCount = $this->db->query("select * from tbl_product where Product_Name = ? and Product_SlNo != ?", [$productObj->Product_Name, $productObj->Product_SlNo])->num_rows();
            if ($productNameCount > 0) {
                $res = ['success' => false, 'message' => 'Product name already exists'];
                echo json_encode($res);
                exit;
            }

            $product = (array)$productObj;
            unset($product['Product_SlNo']);
            $product['is_service'] = $productObj->is_service == true ? 'true' : 'false';
            $product['is_website'] = $productObj->is_website == true ? 'true' : 'false';
            $product['UpdateBy'] = $this->session->userdata("FullName");
            $product['UpdateTime'] = date('Y-m-d H:i:s');

            $this->db->where('Product_SlNo', $productObj->Product_SlNo)->update('tbl_product', $product);

            if (!empty($_FILES['image']['name'])) {
                $imagePath = './uploads/products/' . $productObj->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $currentDirectory = getcwd();
                $dir = "/uploads/products/";
                $filename = time() . "-" . $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);
                $this->db->where('Product_SlNo', $productObj->Product_SlNo);
                $this->db->update('tbl_product', array("image" => $filename));
            }

            $res = ['success' => true, 'message' => 'Product updated successfully', 'productId' => $this->mt->generateProductCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function deleteProduct()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $query = $this->db->get('product_publisheds');
            foreach ($query->result() as $value) {
                if ($value->product_id == $data->productId) {
                    $res = ['success' => false, 'message' => 'Can\'t delete! Product already published'];
                    echo json_encode($res);
                    exit;
                }
            }

            $imagePath = './uploads/products/' . $data->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $this->db->set(['status' => 'd'])->where('Product_SlNo', $data->productId)->update('tbl_product');
            $res = ['success' => true, 'message' => 'Product deleted successfully'];

        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function activeProduct()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $productId = $this->input->post('productId');
            $this->db->query("update tbl_product set status = 'a' where Product_SlNo = ?", $productId);
            $res = ['success' => true, 'message' => 'Product activated'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getProducts()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if (isset($data->categoryId) && $data->categoryId != '') {
            $clauses .= " and p.ProductCategory_ID = '$data->categoryId'";
        }

        if (isset($data->isService) && $data->isService != null && $data->isService != '') {
            $clauses .= " and p.is_service = '$data->isService'";
        }

        $products = $this->db->query("
            select
                p.*,
                concat(p.Product_Name, ' - ', p.Product_Code) as display_text,
                pc.ProductCategory_Name,
                br.brand_name,
                u.Unit_Name
            from tbl_product p
            left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            left join tbl_brand br on br.brand_SiNo = p.brand
            left join tbl_unit u on u.Unit_SlNo = p.Unit_ID
            where p.status = 'a'
            $clauses
            order by p.Product_SlNo desc
        ")->result();

        echo json_encode($products);
    }

    public function getProductStock()
    {
        $inputs = json_decode($this->input->raw_input_stream);
        $stock = $this->mt->productStock($inputs->productId);
        echo $stock;
    }

    public function getCurrentStock()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if (isset($data->stockType) && $data->stockType == 'low') {
            $clauses .= " and current_quantity <= Product_ReOrederLevel";
        }
        $stock = $this->db->query("
            select * from(
                select
                    ci.*,
                    (select (ci.purchase_quantity + ci.sales_return_quantity + ci.transfer_to_quantity + ci.production_quantity) - (ci.sales_quantity + ci.purchase_return_quantity + ci.damage_quantity + ci.transfer_from_quantity)) as current_quantity,
                    p.Product_Name,
                    p.Product_Code,
                    p.Product_ReOrederLevel,
                    (select (p.Product_Purchase_Rate * current_quantity)) as stock_value,
                    pc.ProductCategory_Name,
                    b.brand_name,
                    u.Unit_Name
                from tbl_currentinventory ci
                join tbl_product p on p.Product_SlNo = ci.product_id
                left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                left join tbl_brand b on b.brand_SiNo = p.brand
                left join tbl_unit u on u.Unit_SlNo = p.Unit_ID
                where p.status = 'a'
                and p.is_service = 'false'
                and ci.branch_id = ?
            ) as tbl
            where 1 = 1
            $clauses
        ", $this->session->userdata("BRANCHid"))->result();

        $res['stock'] = $stock;
        $res['totalValue'] = array_sum(
            array_map(function ($product) {
                return $product->stock_value;
            }, $stock)
        );

        echo json_encode($res);
    }

    public function getTotalStock()
    {
        $data = json_decode($this->input->raw_input_stream);

        $branchId = $this->session->userdata('BRANCHid');
        $clauses = "";
        if (isset($data->categoryId) && $data->categoryId != null) {
            $clauses .= " and p.ProductCategory_ID = '$data->categoryId'";
        }

        if (isset($data->productId) && $data->productId != null) {
            $clauses .= " and p.Product_SlNo = '$data->productId'";
        }

        if (isset($data->brandId) && $data->brandId != null) {
            $clauses .= " and p.brand = '$data->brandId'";
        }

        $stock = $this->db->query("
            select
                p.*,
                pc.ProductCategory_Name,
                b.brand_name,
                u.Unit_Name,
                (select ifnull(sum(pd.PurchaseDetails_TotalQuantity), 0) 
                        from tbl_purchasedetails pd 
                        where pd.Product_IDNo = p.Product_SlNo
                        and pd.PurchaseDetails_branchID = '$branchId'
                        and pd.Status = 'a') as purchased_quantity,
                        
                (select ifnull(sum(prd.PurchaseReturnDetails_ReturnQuantity), 0) 
                        from tbl_purchasereturndetails prd 
                        where prd.PurchaseReturnDetailsProduct_SlNo = p.Product_SlNo
                        and prd.PurchaseReturnDetails_brachid = '$branchId') as purchase_returned_quantity,
                        
                (select ifnull(sum(sd.SaleDetails_TotalQuantity), 0) 
                        from tbl_saledetails sd
                        where sd.Product_IDNo = p.Product_SlNo
                        and sd.SaleDetails_BranchId  = '$branchId'
                        and sd.Status = 'a') as sold_quantity,
                        
                (select ifnull(sum(srd.SaleReturnDetails_ReturnQuantity), 0)
                        from tbl_salereturndetails srd 
                        where srd.SaleReturnDetailsProduct_SlNo = p.Product_SlNo
                        and srd.SaleReturnDetails_brunchID = '$branchId') as sales_returned_quantity,
                        
                (select ifnull(sum(dmd.DamageDetails_DamageQuantity), 0) 
                        from tbl_damagedetails dmd
                        join tbl_damage dm on dm.Damage_SlNo = dmd.Damage_SlNo
                        where dmd.Product_SlNo = p.Product_SlNo
                        and dmd.status = 'a'
                        and dm.Damage_brunchid = '$branchId') as damaged_quantity,
            
                (select ifnull(sum(trd.quantity), 0)
                        from tbl_transferdetails trd
                        join tbl_transfermaster tm on tm.transfer_id = trd.transfer_id
                        where trd.product_id = p.Product_SlNo
                        and tm.transfer_from = '$branchId') as transferred_from_quantity,

                (select ifnull(sum(trd.quantity), 0)
                        from tbl_transferdetails trd
                        join tbl_transfermaster tm on tm.transfer_id = trd.transfer_id
                        where trd.product_id = p.Product_SlNo
                        and tm.transfer_to = '$branchId') as transferred_to_quantity,
                
                (select ifnull(sum(pp.quantity), 0)
                        from tbl_production_products pp
                        where pp.product_id = p.Product_SlNo) as production_quantity,
                        
                (select (purchased_quantity + sales_returned_quantity + transferred_to_quantity + production_quantity) - (sold_quantity + purchase_returned_quantity + damaged_quantity + transferred_from_quantity)) as current_quantity,
                (select p.Product_Purchase_Rate * current_quantity) as stock_value
            from tbl_product p
            left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            left join tbl_brand b on b.brand_SiNo = p.brand
            left join tbl_unit u on u.Unit_SlNo = p.Unit_ID
            where p.status = 'a' and p.is_service = 'false' $clauses
        ")->result();

        $res['stock'] = $stock;
        $res['totalValue'] = array_sum(
            array_map(function ($product) {
                return $product->stock_value;
            }, $stock)
        );

        echo json_encode($res);
    }

    public function fanceybox_category()
    {
        $this->load->view('Administrator/products/fanceybox_category');
    }
    public function insert_fanceybox_category()
    {
        $mail = $this->input->post('add_Category');
        $query = $this->db->query("SELECT ProductCategory_Name from tbl_productcategory where ProductCategory_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/fanceybox_product_cat', $data);
        } else {
            $data = array(
                "ProductCategory_Name"                  => $this->input->post('add_Category', TRUE),
                "ProductCategory_Description"           => $this->input->post('catdescrip', TRUE),
                "AddBy"                                 => $this->session->userdata("FullName"),
                "AddTime"                               => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_productcategory', $data);
            $this->load->view('Administrator/ajax/fanceybox_product_cat');
        }
    }

    public function current_stock()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Current Stock";
        $data['categories'] = $this->Other_model->branch_wise_category();
        $data['brands'] = $this->Other_model->branch_wise_brand();
        $data['products'] = $this->Product_model->products_by_brunch();
        $data['content'] = $this->load->view('Administrator/stock/current_stock', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function stockAvailable()
    {
        $data['title'] = "Stock Available";
        $branchID = $this->session->userdata("BRANCHid");
        $sql = "SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' group by tbl_purchasedetails.Product_IDNo";

        $result = $this->db->query($sql);
        $data['record'] = $result->result();
        $data['branchID'] =  $this->session->userdata("BRANCHid");
        $data['content'] = $this->load->view('Administrator/stock/stock_available', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function total_stock()
    {
        $data['title'] = "Total Stock";
        $data['content'] = $this->load->view('Administrator/stock/total_stock', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function searchproduct()
    {
        $data['Searchkey'] = $this->input->post('Searchkey');
        $this->load->view('Administrator/ajax/search_product', $data);
    }

    public function branch_stock()
    {
        $data['title'] = "Branch Stock";
        $data['content'] = $this->load->view('Administrator/stock/branch_stock', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function branch_stock_search()
    {
        $data['Branch_ID'] = $BranchID = $this->input->post('BranchID');
        $data['Branch_category'] = $category = $this->input->post('Categorys');
        $this->session->set_userdata($data);
        if ($category != 'All') {
            $this->db->SELECT("
                tbl_product.*, 
                tbl_productcategory.*,
                tbl_unit.*,
                tbl_color.*,
                tbl_brand.* 
                FROM tbl_product 
                left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID 
                left join tbl_unit on tbl_unit.Unit_SlNo=tbl_product.Unit_ID  
                LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color 
                LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand 
                where tbl_product.ProductCategory_ID = '$category' 
                AND tbl_product.Product_branchid = '$BranchID'
            ");
            $query = $this->db->get();
            $result = $query->result();
            $data['product'] = $result;
            $data['show'] = 1;
        } else {
            $this->db->SELECT('*');
            $this->db->from('tbl_productcategory');
            $this->db->where('category_branchid', $BranchID);
            $query = $this->db->get();
            $category = $query->result();

            foreach ($category as $vcategory) {
                $categoryid = $vcategory->ProductCategory_SlNo;
                $this->db->SELECT("
                        tbl_product.*, 
                        tbl_productcategory.*,
                        tbl_unit.*,
                        tbl_color.*,
                        tbl_brand.* 
                    FROM tbl_product 
                    left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID 
                    left join tbl_unit on tbl_unit.Unit_SlNo=tbl_product.Unit_ID  
                    LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color 
                    LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand 
                    where tbl_product.ProductCategory_ID = '$categoryid' 
                    AND tbl_product.Product_branchid = '$BranchID'
                ");
                $query = $this->db->get();
                $productCat[] = $query->result();
                //$data['productCat'] = $query->result();
            }

            $data['category'] = $category;
            $data['productCat'] = @$productCat;
            $data['show'] = 0;
        }
        $this->load->view('Administrator/stock/branch_stock_search', $data);
    }

    public function search_stock()
    {
        $Store = $data['Store'] = $this->input->post('Store');
        $Category = $data['Category'] = $this->input->post('Category');
        $Product =  $data['Product'] = $this->input->post('Product');
        $Supplier =  $data['Supplier']  = $this->input->post('Supplier');
        $brand =  $data['brand']  = $this->input->post('brand');
        $branchID = $data['branchID'] = $this->session->userdata("BRANCHid");
        //		 echo $brand; die();

        if ($Store == 'Total' || $Store == 'Current') :
            $data['sql'] = $this->db->query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo left join sr_transferdetails on sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_product.status='a' AND tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' or sr_transferdetails.Brunch_to = '$branchID' group by tbl_purchasedetails.Product_IDNo")->result();

        elseif ($Store == 'Category') :
            $data['sql'] = $this->db->query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo left join sr_transferdetails on sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_product.status='a' AND tbl_product.ProductCategory_ID='$Category' AND  tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' or sr_transferdetails.Brunch_to = '$branchID' group by tbl_purchasedetails.Product_IDNo")->result();

        elseif ($Store == 'Product') :
            $data['sql'] = $this->db->query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo left join sr_transferdetails on sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_product.status='a' AND tbl_product.Product_SlNo='$Product' AND tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' or sr_transferdetails.Brunch_to = '$branchID' group by tbl_purchasedetails.Product_IDNo")->result();

        elseif ($Store == 'Supplier') :
            $data['sql'] = $this->db->query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo left join sr_transferdetails on sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_product.status='a' AND tbl_purchasedetails.Supplier_IDNo = '$Supplier' AND tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' or sr_transferdetails.Brunch_to = '$branchID' group by tbl_purchasedetails.Product_IDNo")->result();
        elseif ($Store == 'Brand') :
            $ddd = $data['sql'] = $this->db->query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo left join sr_transferdetails on sr_transferdetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_product.status='a' AND tbl_product.brand='$brand' AND  tbl_purchaseinventory.PurchaseInventory_brunchid = '$branchID' or sr_transferdetails.Brunch_to = '$branchID' group by tbl_purchasedetails.Product_IDNo")->result();
        endif;


        $this->session->set_userdata($data);
        $this->load->view('Administrator/stock/search_stock', $data);
    }


    public function fanceybox_warehouse()
    {
        $this->load->view('Administrator/products/fanceybox_warehouse');
    }
    public function insert_fanceybox_Warehouse()
    {
        $mail = $this->input->post('add_Category');
        $query = $this->db->query("SELECT warehouse_name from tbl_warehouse where warehouse_name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/fanceybox_Warehouse', $data);
        } else {
            $data = array(
                "warehouse_name"    => $this->input->post('add_Category', TRUE)

            );
            $this->mt->save_data('tbl_warehouse', $data);
            $this->load->view('Administrator/ajax/fanceybox_Warehouse');
        }
    }

    /*  public function selectProduct(){
		$data['title']  = 'Product';
        $pCategory = $this->input->post('pCategory');
        $brand = $this->input->post('brand');
        $BRANCHid = $this->session->userdata("BRANCHid");
        $data['sproduct'] = $this->Billing_model->selectProduct($pCategory,$brand,$BRANCHid);
	    $data['content'] = $this->load->view('Administrator/products/add_product', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	 */
    public function selectProduct()
    {
        $data['title']  = 'Product';
        $brand = $this->input->post('brand');
        $pCategory = $this->input->post('pCategory');
        $BRANCHid = $this->session->userdata("BRANCHid");
        if ($brand == 'All' and $pCategory != 'All') {
            $data['sproduct'] =  $this->Billing_model->select_Product_by_category($pCategory, $BRANCHid);
        } else if ($brand == 'All' and $pCategory == 'All') {
            $data['allproduct'] =  $this->Billing_model->select_all_Product();
        } else if ($brand != 'All' and $pCategory == 'no') {
            $data['sproduct'] = $this->Billing_model->select_Product_by_brand($brand, $BRANCHid);
        } else {
            $data['sproduct'] = $this->Billing_model->selectProduct($pCategory, $brand, $BRANCHid);
        }

        $data['content'] = $this->load->view('Administrator/products/add_product', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function productlist()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title']  = 'Product';
        $data['allproduct'] =  $this->Billing_model->select_all_Product_list();

        $this->load->view('Administrator/products/productList', $data);
        //$this->load->view('Administrator/index', $data);
    }

    public function product_name()
    {
        $data['allproduct'] = $allproduct =  $this->Billing_model->get_product_name();
        // print_r($allproduct); exit();
        $this->load->view('Administrator/products/product_name', $data);
    }

    public function barcodeGenerateFancybox($Product_SlNo)
    {
        $data['Product_SlNo'] = $Product_SlNo;
        $this->load->view('Administrator/products/barcode_fancybox', $data);
    }

    public function barcodeGenerate($Product_SlNo)
    {
        $data['product'] = $this->Billing_model->select_Product_by_id($Product_SlNo);
        $this->load->view('Administrator/products/barcode/barcode', $data);
    }

    function barcode($kode)
    {

        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text' => $kode), array());
    }

    public function view_all_product()
    {
        $data['title']  = 'Product';
        $data['allproduct'] =  $allproduct = $this->Billing_model->select_Product_without_limit();

?>
        <br />
        <div class="table-responsive">
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Product ID</th>
                        <th>Categoty Name</th>
                        <th>Product Name</th>
                        <th class="hidden-480">Brand</th>

                        <th>Color</th>
                        <!--<th class="hidden-480">Purchase Rate</th>
					<th class="hidden-480">Sell Rate</th>--->

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($allproduct as $vallproduct) {
                    ?>
                        <tr>
                            <td class="center">
                                <label class="pos-rel">
                                    <input type="checkbox" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td>
                                <a href="#"><?php echo $vallproduct->Product_Code; ?></a>
                            </td>
                            <td><?php echo $vallproduct->ProductCategory_Name; ?></td>
                            <td class="hidden-480"><?php echo $vallproduct->Product_Name; ?></td>
                            <td><?php echo $vallproduct->brand_name; ?></td>

                            <td class="hidden-480">
                                <span class="label label-sm label-info arrowed arrowed-righ">
                                    <?php echo $vallproduct->color_name; ?>
                                </span>
                            </td>
                            <!--<td class="hidden-480"><?php echo $vallproduct->Product_Purchase_Rate; ?></td>
								<td class="hidden-480"><?php echo $vallproduct->Product_SellingPrice; ?></td>-->

                            <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <span class="blue" onclick="Edit_product(<?php echo $vallproduct->Product_SlNo; ?>)" style="cursor:pointer;">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </span>

                                    <a class="green" href="" onclick="deleted(<?php echo $vallproduct->Product_SlNo; ?>)">
                                        <i class="ace-icon fa fa-trash bigger-130 text-danger"></i>
                                    </a>

                                    <a class="black" href="<?php echo base_url(); ?>Administrator/Products/barcodeGenerate/<?php echo $vallproduct->Product_SlNo; ?>" target="_blank">
                                        <i class="ace-icon fa fa-barcode bigger-130"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
<?php
        //echo "<pre>";print_r($data['allproduct']);exit;
        //$this->load->view('Administrator/products/all_product', $data, TRUE);
        //$this->load->view('Administrator/index', $data);
    }

    public function productLedger()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title']  = 'Product Ledger';

        $data['content'] = $this->load->view('Administrator/products/product_ledger', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function getProductLedger()
    {
        $data = json_decode($this->input->raw_input_stream);
        $result = $this->db->query("
            select 
                'a' as sequence,
                pp.production_products_id as id,
                p.date,
                concat('Production - ', p.note) as description,
                pp.price as rate,
                pp.quantity as in_quantity,
                0 as out_quantity    
            from tbl_production_products pp
            join tbl_productions p on p.production_id = pp.production_id
            where p.status = 'a'
            and pp.product_id = " . $data->productId . "

            UNION
            select
                'b' as sequence,
                pd.PurchaseDetails_SlNo as id,
                pm.PurchaseMaster_OrderDate as date,
                concat('Purchase - ', pm.PurchaseMaster_InvoiceNo, ' - ', s.Supplier_Name) as description,
                pd.PurchaseDetails_Rate as rate,
                pd.PurchaseDetails_TotalQuantity as in_quantity,
                0 as out_quantity
            from tbl_purchasedetails pd
            join tbl_purchasemaster pm on pm.PurchaseMaster_SlNo = pd.PurchaseMaster_IDNo
            join tbl_supplier s on s.Supplier_SlNo = pm.Supplier_SlNo
            where pd.Status = 'a'
            and pd.Product_IDNo = " . $data->productId . "
            and pd.PurchaseDetails_branchID = " . $this->brunch . "
            
            UNION
            select 
                'c' as sequence,
                sd.SaleDetails_SlNo as id,
                sm.SaleMaster_SaleDate as date,
                concat('Sale - ', sm.SaleMaster_InvoiceNo, ' - ', c.Customer_Name) as description,
                sd.SaleDetails_Rate as rate,
                0 as in_quantity,
                sd.SaleDetails_TotalQuantity as out_quantity
            from tbl_saledetails sd
            join tbl_salesmaster sm on sm.SaleMaster_SlNo = sd.SaleMaster_IDNo
            join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where sd.Status = 'a'
            and sd.Product_IDNo = " . $data->productId . "
            and sd.SaleDetails_BranchId = " . $this->brunch . "
            
            UNION
            select 
                'd' as sequence,
                prd.PurchaseReturnDetails_SlNo as id,
                pr.PurchaseReturn_ReturnDate as date,
                concat('Purchase Return - ', pr.PurchaseMaster_InvoiceNo, ' - ', s.Supplier_Name) as description,
                (prd.PurchaseReturnDetails_ReturnAmount / prd.PurchaseReturnDetails_ReturnQuantity) as rate,
                0 as in_quantity,
                prd.PurchaseReturnDetails_ReturnQuantity as out_quantity
            from tbl_purchasereturndetails prd
            join tbl_purchasereturn pr on pr.PurchaseReturn_SlNo = prd.PurchaseReturn_SlNo
            join tbl_supplier s on s.Supplier_SlNo = pr.Supplier_IDdNo
            where prd.Status = 'a'
            and prd.PurchaseReturnDetailsProduct_SlNo = " . $data->productId . "
            and prd.PurchaseReturnDetails_brachid = " . $this->brunch . "
            
            UNION
            select
                'e' as sequence, 
                srd.SaleReturnDetails_SlNo as id,
                sr.SaleReturn_ReturnDate as date,
                concat('Sale Return - ', sr.SaleMaster_InvoiceNo, ' - ', c.Customer_Name) as description,
                (srd.SaleReturnDetails_ReturnAmount / srd.SaleReturnDetails_ReturnQuantity) as rate,
                srd.SaleReturnDetails_ReturnQuantity as in_quantity,
                0 as out_quantity
            from tbl_salereturndetails srd
            join tbl_salereturn sr on sr.SaleReturn_SlNo = srd.SaleReturn_IdNo
            join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = sr.SaleMaster_InvoiceNo
            join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo
            where srd.Status = 'a'
            and srd.SaleReturnDetailsProduct_SlNo = " . $data->productId . "
            and srd.SaleReturnDetails_brunchID = " . $this->brunch . "
            
            UNION
            select
                'f' as sequence, 
                trd.transferdetails_id as id,
                tm.transfer_date as date,
                concat('Transferred From: ', b.Brunch_name, ' - ', tm.note) as description,
                0 as rate,
                trd.quantity as in_quantity,
                0 as out_quantity
            from tbl_transferdetails trd
            join tbl_transfermaster tm on tm.transfer_id = trd.transfer_id
            join tbl_brunch b on b.brunch_id = tm.transfer_from
            where trd.product_id = " . $data->productId . "
            and tm.transfer_to = " . $this->brunch . "
            
            UNION
            select 
                'g' as sequence,
                trd.transferdetails_id as id,
                tm.transfer_date as date,
                concat('Transferred To: ', b.Brunch_name, ' - ', tm.note) as description,
                0 as rate,
                0 as in_quantity,
                trd.quantity as out_quantity
            from tbl_transferdetails trd
            join tbl_transfermaster tm on tm.transfer_id = trd.transfer_id
            join tbl_brunch b on b.brunch_id = tm.transfer_to
            where trd.product_id = " . $data->productId . "
            and tm.transfer_from = " . $this->brunch . "
            
            UNION
            select 
                'h' as sequence,
                dmd.DamageDetails_SlNo as id,
                d.Damage_Date as date,
                concat('Damaged - ', d.Damage_Description) as description,
                0 as rate,
                0 as in_quantity,
                dmd.DamageDetails_DamageQuantity as out_quantity
            from tbl_damagedetails dmd
            join tbl_damage d on d.Damage_SlNo = dmd.Damage_SlNo
            where dmd.Product_SlNo = " . $data->productId . "
            and d.Damage_brunchid = " . $this->brunch . "

            order by date, sequence, id
        ")->result();

        $ledger = array_map(function ($key, $row) use ($result) {
            $row->stock = $key == 0 ? $row->in_quantity - $row->out_quantity : ($result[$key - 1]->stock + ($row->in_quantity - $row->out_quantity));
            return $row;
        }, array_keys($result), $result);

        $previousRows = array_filter($ledger, function ($row) use ($data) {
            return $row->date < $data->dateFrom;
        });

        $previousStock = empty($previousRows) ? 0 : end($previousRows)->stock;

        $ledger = array_filter($ledger, function ($row) use ($data) {
            return $row->date >= $data->dateFrom && $row->date <= $data->dateTo;
        });

        echo json_encode(['ledger' => $ledger, 'previousStock' => $previousStock]);
    }
}
