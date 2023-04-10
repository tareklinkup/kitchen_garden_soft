<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        $this->accountType = $this->session->userdata('accountType');
         if($access == ''){
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
        $data['title'] = "Assets Entry";
        $data['assets'] = $this->Other_model->get_all_asset_info();
        $data['content'] = $this->load->view('Administrator/assets/assets_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    public function insert_Assets()  {
        $data = array(
            "as_date"           =>date('Y-m-d'),
            "as_name"           =>$this->input->post('assetsname'),
            "as_sp_name"        =>$this->input->post('supplier_name'),
            "as_qty"            =>$this->input->post('qty'),
            "as_rate"           =>$this->input->post('rate'),
            "as_amount"         =>$this->input->post('amount'),
            "unit_valuation"    =>$this->input->post('unit_valuation') ?? 0.00,
            "valuation"         =>$this->input->post('valuation') ?? 0.00,
            "buy_or_sale"       =>$this->input->post('buy_or_sale'),
            "as_note"           =>$this->input->post('note'),
            "status"            =>'a',
            "AddBy"             =>$this->session->userdata("FullName"),
            "AddTime"           =>date("Y-m-d H:i:s"),
            "branchid"          =>$this->session->userdata('BRANCHid'),
        );
        $this->mt->save_data('tbl_assets',$data);
        echo json_encode(TRUE); 
    }


    public function Assets_edit($id=null)
    {
        $data['edit'] = $this->db->where('as_id',$id)->get('tbl_assets')->row();
        $this->load->view('Administrator/assets/edit_assets', $data);
    }


    public function Update_Assets($id=null)
    {
        $data = array(
            "as_name"       =>$this->input->post('assetsname'),
            "as_sp_name"    =>$this->input->post('supplier_name'),
            "as_qty"        =>$this->input->post('qty'),
            "as_rate"       =>$this->input->post('rate'),
            "unit_valuation"=>$this->input->post('unit_valuation') ?? 0.00,
            "valuation"     =>$this->input->post('valuation') ?? 0.00,
            "as_amount"     =>$this->input->post('amount'),
            "as_note"       =>$this->input->post('note'),
        );
        $up = $this->db->where('as_id',$id)->update('tbl_assets',$data );
        if($up):
            echo json_encode(TRUE); 
        else: return false; endif;
    }


    public function Assets_delete($id=null)
    {
        $data = array( 'status' => 'd' );
        $up = $this->db->where('as_id',$id)->update('tbl_assets',$data );
        if($up):
            echo json_encode(TRUE); 
        else: return false; endif;
    }


    public function getAssetsCost()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' 
        && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and ass.as_date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->buy_or_sale) && $data->buy_or_sale != ''){
            $clauses .= " and ass.buy_or_sale = '$data->buy_or_sale'";
        }

        $assets = $this->db->query("
            select ass.* from tbl_assets ass
                where ass.status = 'a'
                and ass.branchid= " . $this->session->userdata('BRANCHid') . "
                $clauses
        ")->result();

        $cost = array_reduce($assets, function($prev, $curr){ return $prev + $curr->as_amount;});

        $res = [
            'cost' => $cost,
            'assets' => $assets
        ];

        echo json_encode($res);
    }

    public function assetsReport()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Assets Report";
        $data['content'] = $this->load->view('Administrator/assets/assets_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getGroupAssets()
    {
        $assets = $this->db->query("
            SELECT as_name as group_name
            from tbl_assets
            where status = 'a'
            and branchid = '$this->brunch'
            group by as_name
        ")->result();

        echo json_encode($assets);
    }

    public function getAssetsReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = '';

        if (isset($data->asset) && $data->asset != '') {
            $clauses .= " and a.as_name = '$data->asset'";
        }
        
        $assets = $this->mt->assetsReport($clauses);

        echo json_encode($assets);
    }

}
