<?php
class Production extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->sbrunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
    }
    public function index(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Production";
        $data['production_id'] = 0;
        $data['productionSl'] = $this->mt->generateProductionCode();
        $data['content'] = $this->load->view('Administrator/production/production', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function edit($production_id = 0){
        $data['title'] = "Production Edit";
        $data['production_id'] = $production_id;
        $production = $this->db->query("
            select * from tbl_productions
            where production_id = '$production_id'
        ")->result();
        $data['productionSl'] = $production[0]->production_sl;
        $data['content'] = $this->load->view('Administrator/production/production', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function addProduction(){

        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $countProductionSl = $this->db->query("select * from tbl_productions where production_sl = ?", $data->production->production_sl)->num_rows();
            if($countProductionSl > 0){
                $data->production->production_sl = $this->mt->generateProductionCode();
            }
            $production = array(
                'production_sl' => $data->production->production_sl,
                'date' => $data->production->date,
                'incharge_id' => $data->production->incharge_id,
                'shift' => $data->production->shift,
                'note' => $data->production->note,
                'labour_cost' => $data->production->labour_cost,
                'material_cost' => $data->production->material_cost,
                'other_cost' => $data->production->other_cost,
                'total_cost' => $data->production->total_cost,
                'status' => 'a'
            );
    
            $this->db->insert('tbl_productions', $production);
            $productionId = $this->db->insert_id();

            

            foreach($data->materials as $material){
                $material = array(
                    'production_id' => $productionId,
                    'material_id' => $material->material_id,
                    'quantity' => $material->quantity,
                    'purchase_rate' => $material->purchase_rate,
                    'total' => $material->total,
                    'status' => 'a'
                );
                $this->db->insert('tbl_production_details', $material);
            }

            foreach($data->products as $product){
                $productionProduct = array(
                    'production_id' => $productionId,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'total' => $product->total,
                    'status' => 'a'
                );

                $this->db->insert('tbl_production_products', $productionProduct);

                $productInventoryCount = $this->db->query("select * from tbl_currentinventory ci where ci.product_id = ? and ci.branch_id = ?", [$product->product_id, $this->session->userdata('BRANCHid')])->num_rows();
                if($productInventoryCount == 0){
                    $inventory = array(
                        'product_id' => $product->product_id,
                        'production_quantity' => $product->quantity,
                        'branch_id' => $this->session->userdata('BRANCHid')
                    );

                    $this->db->insert('tbl_currentinventory', $inventory);
                } else {
                    $this->db->query("update tbl_currentinventory set production_quantity = production_quantity + ? where product_id = ? and branch_id = ?", [$product->quantity, $product->product_id, $this->session->userdata('BRANCHid')]);
                }
            }

            $res = ['success'=>true, 'message'=>'Production entry success', 'productionId'=>$productionId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateProduction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $productionId = $data->production->production_id;
            $production = array(
                'production_sl' => $data->production->production_sl,
                'date' => $data->production->date,
                'incharge_id' => $data->production->incharge_id,
                'shift' => $data->production->shift,
                'note' => $data->production->note,
                'labour_cost' => $data->production->labour_cost,
                'material_cost' => $data->production->material_cost,
                'other_cost' => $data->production->other_cost,
                'total_cost' => $data->production->total_cost
            );
    
            $this->db->where('production_id', $productionId)->update('tbl_productions', $production);

            $this->db->delete('tbl_production_details', array('production_id' => $productionId));
            foreach($data->materials as $material){
                $material = array(
                    'production_id' => $productionId,
                    'material_id' => $material->material_id,
                    'quantity' => $material->quantity,
                    'purchase_rate' => $material->purchase_rate,
                    'total' => $material->total,
                    'status' => 'a'
                );
                $this->db->insert('tbl_production_details', $material);
            }

            $oldProducts = $this->db->query("select * from tbl_production_products where production_id = ?", $productionId)->result();
            $this->db->delete('tbl_production_products', array('production_id' => $productionId));
            foreach($oldProducts as $oldProduct){
                $this->db->query("update tbl_currentinventory set production_quantity = production_quantity - ? where product_id = ? and branch_id = ?", [$oldProduct->quantity, $oldProduct->product_id, $this->session->userdata('BRANCHid')]);
            }
            foreach($data->products as $product){
                $productionProduct = array(
                    'production_id' => $productionId,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'total' => $product->total,
                    'status' => 'a'
                );

                $this->db->insert('tbl_production_products', $productionProduct);

                $productInventoryCount = $this->db->query("select * from tbl_currentinventory ci where ci.product_id = ? and ci.branch_id = ?", [$product->product_id, $this->session->userdata('BRANCHid')])->num_rows();
                if($productInventoryCount == 0){
                    $inventory = array(
                        'product_id' => $product->product_id,
                        'production_quantity' => $product->quantity,
                        'branch_id' => $this->session->userdata('BRANCHid')
                    );

                    $this->db->insert('tbl_currentinventory', $inventory);
                } else {
                    $this->db->query("update tbl_currentinventory set production_quantity = production_quantity + ? where product_id = ? and branch_id = ?", [$product->quantity, $product->product_id, $this->session->userdata('BRANCHid')]);
                }
            }

            $res = ['success'=>true, 'message'=>'Production update success', 'productionId'=>$productionId];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function productions(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Production Record";
        $data['content'] = $this->load->view('Administrator/production/productions', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getProductions(){
        $options = json_decode($this->input->raw_input_stream);

        $idClause = '';
        $dateClause = '';


        if(isset($options->production_id) && $options->production_id != 0){
            $idClause = " and pr.production_id = '$options->production_id'";
        }

        if(isset($options->dateFrom) && isset($options->dateTo) && $options->dateFrom != null && $options->dateTo != null){
            $dateClause = " and pr.date between '$options->dateFrom' and '$options->dateTo'";
        }
        $productions = $this->db->query("
            select 
            pr.*,
            e.Employee_Name as incharge_name
            from tbl_productions pr
            join tbl_employee e on e.Employee_SlNo = pr.incharge_id
            where pr.status = 'a' $idClause $dateClause
        ")->result();
        echo json_encode($productions);
    }

    public function getProductionRecord(){
        $options = json_decode($this->input->raw_input_stream);

        $dateClause = '';

        if(isset($options->dateFrom) && isset($options->dateTo) && $options->dateFrom != null && $options->dateTo != null){
            $dateClause = " and pr.date between '$options->dateFrom' and '$options->dateTo'";
        }
        $productions = $this->db->query("
            select 
            pr.*,
            e.Employee_Name as incharge_name
            from tbl_productions pr
            join tbl_employee e on e.Employee_SlNo = pr.incharge_id
            where pr.status = 'a' $dateClause
        ")->result();

        foreach($productions as $production){
            $production->products = $this->db->query("
                select
                    pp.*,
                    p.Product_Code as product_code,
                    p.Product_Name as name,
                    p.ProductCategory_ID as category_id,
                    pc.ProductCategory_Name as category_name,
                    u.Unit_Name as unit_name
                from tbl_production_products pp
                join tbl_product p on p.Product_SlNo = pp.product_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                join tbl_unit u on u.Unit_SlNo = p.unit_id
                where pp.status = 'a'
                and pp.production_id = ?
            ", $production->production_id)->result();
        }
        echo json_encode($productions);
    }

    public function getProductionDetails(){
        $options = json_decode($this->input->raw_input_stream);
        $productionDetails = $this->db->query("
            select
            pd.*,
            m.name,
            m.category_id,
            u.Unit_Name as unit_name,
            pc.ProductCategory_Name as category_name
            from tbl_production_details pd
            join tbl_materials m on m.material_id = pd.material_id
            join tbl_productcategory pc on pc.ProductCategory_SlNo = m.category_id
            join tbl_unit u on u.Unit_SlNo = m.unit_id
            where pd.status = 'a' 
            and pd.production_id = '$options->production_id'
        ")->result();

        echo json_encode($productionDetails);
    }

    public function getProductionProducts(){
        $options = json_decode($this->input->raw_input_stream);
        $productionProducts = $this->db->query("
            select
                pp.*,
                p.Product_Code as product_code,
                p.Product_Name as name,
                p.ProductCategory_ID as category_id,
                pc.ProductCategory_Name as category_name,
                u.Unit_Name as unit_name
            from tbl_production_products pp
            join tbl_product p on p.Product_SlNo = pp.product_id
            join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            join tbl_unit u on u.Unit_SlNo = p.unit_id
            where pp.status = 'a'
            and pp.production_id = '$options->production_id'
        ")->result();

        echo json_encode($productionProducts);
    }

    public function deleteProduction(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            $this->db->query("update tbl_productions set status = 'd' where production_id = ?", $data->productionId);
            $this->db->query("update tbl_production_details set status = 'd' where production_id = ?", $data->productionId);
            $this->db->query("update tbl_production_products set status = 'd' where production_id = ?", $data->productionId);
            $res = ['success'=>true, 'message'=>'Production deleted successfully'];
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function productionInvoice($productionId){
        $data['title'] = "Production Invoice";
        $data['productionId'] = $productionId;
        $data['content'] = $this->load->view("Administrator/production/production_invoice", $data, true);
        $this->load->view("Administrator/index", $data);
    }
}