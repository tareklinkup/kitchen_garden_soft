<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Billing_model');
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
        date_default_timezone_set('Asia/Dhaka');
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['content'] = $this->load->view('Administrator/dashboard', $data, TRUE);
        $this->load->view('Administrator/master_dashboard', $data);
    }
    public function module($value)
    {
        $data['title'] = "Dashboard";

        $sdata['module'] = $value;
        $this->session->set_userdata($sdata);

        $data['content'] = $this->load->view('Administrator/dashboard', $data, TRUE);
        $this->load->view('Administrator/master_dashboard', $data);
    }
    public function khantrading()
    {
        $data['title'] = "Dashboard";
        $data['content'] = $this->load->view('Administrator/khantrading/dashboard', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function about_us()
    {
        $data['title'] = "About us";
        $data['content'] = $this->load->view('Administrator/about_us', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    // Product Category 

    public function getCategories()
    {
        $categories = $this->db->query("select * from tbl_productcategory where status = 'a'")->result();
        echo json_encode($categories);
    }

    public function add_category()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Add Category";
        $data['content'] = $this->load->view('Administrator/add_prodcategory', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function insert_category()
    {
        $catname = $this->input->post('catname');
        $brunch = $this->brunch;
        $query = $this->db->query("SELECT * from tbl_productcategory where category_branchid = '$brunch' AND ProductCategory_Name = '$catname'");
        if ($query->num_rows() > 0) {
            $this->db->query("update tbl_productcategory set status = 'a' where ProductCategory_SlNo = ?", $query->row()->ProductCategory_SlNo);
        } else {
            $data = array(
                "ProductCategory_Name"              => $this->input->post('catname', TRUE),
                "ProductCategory_Description"       => $this->input->post('catdescrip', TRUE),
                "status"                               => 'a',
                "AddBy"                              => $this->session->userdata("FullName"),
                "AddTime"                           => date("Y-m-d H:i:s"),
                "category_branchid"                 => $this->brunch
            );
            $this->mt->save_data('tbl_productcategory', $data);
            $success = 'Save Success';

            $id = $this->db->insert_id();

            if (!empty($_FILES['image']['name'])) {
                $currentDirectory = getcwd();
                $dir = "/uploads/productcategory/";
                $filename = time() . "-" . $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);
                $this->db->where('ProductCategory_SlNo', $id);
                $this->db->update('tbl_productcategory', array("image" => $filename));
            }
            echo json_encode($success);
        }
    }
    public function catedit($id)
    {
        $data['title'] = "Edit Category";
        //$fld = 'ProductCategory_SlNo';
        $data['selected'] = $this->Billing_model->select_by_id('tbl_productcategory', $id, 'ProductCategory_SlNo');
        $data['content'] = $this->load->view('Administrator/edit/category_edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function catupdate()
    {
        $id = $this->input->post('id');
        $old = $this->input->post("old");
        $catname = $this->input->post('catname');
        $brunch = $this->brunch;
        $query = $this->db->query("SELECT * from tbl_productcategory where category_branchid = '$brunch' AND ProductCategory_Name = '$catname' and ProductCategory_SlNo != '$id'");
        if ($query->num_rows() > 0) {
            $this->db->query("update tbl_productcategory set status = 'a' where ProductCategory_SlNo = ?", $query->row()->ProductCategory_SlNo);
        } else {

            $fld = 'ProductCategory_SlNo';
            $data = array(
                "ProductCategory_Name"              => $this->input->post('catname', TRUE),
                "ProductCategory_Description"       => $this->input->post('catdescrip', TRUE),
                "UpdateBy"                          => $this->session->userdata("FullName"),
                "UpdateTime"                        => date("Y-m-d H:i:s")
            );
            if (!empty($_FILES['image']['name'])) {
                $imagePath = './uploads/productcategory/' . $old;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $currentDirectory = getcwd();
                $dir = "/uploads/productcategory/";
                $filename = time() . "-" . $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);
                $this->db->where('ProductCategory_SlNo', $id);
                $this->db->update('tbl_productcategory', array("image" => $filename));
            }

            if ($this->mt->update_data("tbl_productcategory", $data, $id, $fld)) {
                $msg = true;
                echo json_encode($msg);
            }
        }
    }
    public function catdelete()
    {
        $id = $this->input->post('deleted');
        $fld = 'ProductCategory_SlNo';
        $this->mt->delete_data("tbl_productcategory", $id, $fld);
        $success = 'Delete Success';
        echo json_encode($success);
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // unit 
    public function unit()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Add Unit";
        $data['content'] = $this->load->view('Administrator/unit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function insert_unit()
    {
        $mail = $this->input->post('unitname');
        $query = $this->db->query("SELECT Unit_Name from tbl_unit where Unit_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $exists = false;
            echo json_encode($exists);
        } else {
            $data = array(
                "Unit_Name"              => $this->input->post('unitname', TRUE),
                "status"              => 'a',
                "AddBy"                  => $this->session->userdata("FullName"),
                "AddTime"                => date("Y-m-d H:i:s")
            );
            $succ =  $this->mt->save_data('tbl_unit', $data);
            if ($succ) {
                $msg = true;
                echo json_encode($msg);
            }
        }
    }
    public function unitedit($id)
    {
        $data['title'] = "Edit Unit";
        $fld = 'Unit_SlNo';
        $data['selected'] = $this->Billing_model->select_by_id('tbl_unit', $id, $fld);
        $data['content'] = $this->load->view('Administrator/edit/unit_edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function unitupdate()
    {
        $id = $this->input->post('id');
        $fld = 'Unit_SlNo';
        $data = array(
            "Unit_Name"                         => $this->input->post('unitname', TRUE),
            "UpdateBy"                          => $this->session->userdata("FullName"),
            "UpdateTime"                        => date("Y-m-d H:i:s")
        );
        if ($this->mt->update_data("tbl_unit", $data, $id, $fld)) {
            $msg = true;
            echo json_encode($msg);
        }
    }
    public function unitdelete()
    {
        $fld = 'Unit_SlNo';
        $id = $this->input->post('deleted');
        $this->mt->delete_data("tbl_unit", $id, $fld);
    }

    public function getUnits()
    {
        $units = $this->db->query("select * from tbl_unit where status = 'a'")->result();
        echo json_encode($units);
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //Area 
    public function area()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Add Area";
        $data['content'] = $this->load->view('Administrator/add_area', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function insert_area()
    {
        $district = $this->input->post('district');
        $query = $this->db->query("SELECT District_Name from tbl_district where District_Name = '$district'");
        if ($query->num_rows() > 0) {
            $exist = false;
            echo json_encode($exist);
        } else {
            $data = array(
                "District_Name"          => $this->input->post('district', TRUE),
                "AddBy"                  => $this->session->userdata("FullName"),
                "AddTime"                => date("Y-m-d H:i:s")
            );

            if ($this->mt->save_data('tbl_district', $data)) {
                $msg = true;
                echo json_encode($msg);
            }
            // $this->load->view('Administrator/ajax/district');
        }
    }
    public function areaedit($id)
    {
        $data['title'] = "Edit Unit";
        $fld = 'District_SlNo';
        $data['selected'] = $this->Billing_model->select_by_id('tbl_district', $id, $fld);
        $data['content'] = $this->load->view('Administrator/edit/district_edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function areaupdate()
    {
        $id = $this->input->post('id');
        $fld = 'District_SlNo';
        $data = array(
            "District_Name"                     => $this->input->post('district', TRUE),
            "UpdateBy"                          => $this->session->userdata("FullName"),
            "UpdateTime"                        => date("Y-m-d H:i:s")
        );
        if ($this->mt->update_data("tbl_district", $data, $id, $fld)) {
            $msg = true;
            echo json_encode($msg);
        }
        /* else {
                $sdata['district'] = 'Update is Faild';
            }
            $this->session->set_userdata($sdata);
            redirect("Administrator/Page/district"); */
    }
    public function areadelete()
    {
        $id = $this->input->post('deleted');
        $fld = 'District_SlNo';
        $this->mt->delete_data("tbl_district", $id, $fld);
        //$this->load->view('Administrator/ajax/district');
    }
    public function upaziladelete()
    {
        $id = $this->input->post('deleted');
        $this->db->where('id', $id);
        $this->db->delete('upazilas');
        //$this->load->view('Administrator/ajax/district');
    }

    // add upazila
    public function upazila()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Add Upazila";
        $data['content'] = $this->load->view('Administrator/add_upazila', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_upazila()
    {
        $upazila_id = $this->input->post('upazila_id');
        if (empty($upazila_id)) {
            $data = array(
                "name"          => $this->input->post('name', TRUE),
                "charge_amount"          => $this->input->post('charge_amount', TRUE),
                "district_id"          => $this->input->post('district_id', TRUE),
            );

            if ($this->mt->save_data('upazilas', $data)) {
                $msg = true;
                echo json_encode($msg);
            }
        } else {
            $data = array(
                "name"          => $this->input->post('name', TRUE),
                "charge_amount"          => $this->input->post('charge_amount', TRUE),
                "district_id"          => $this->input->post('district_id', TRUE),
            );

            if ($this->mt->update_data("upazilas", $data, $upazila_id, "id")) {
                $msg = true;
                echo json_encode($msg);
            }
        }
    }

    public function getDistricts()
    {
        $districts = $this->db->query("select * from tbl_district d where d.status = 'a'")->result();
        echo json_encode($districts);
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Country 
    public function add_country()
    {
        $data['title'] = "Add Country";
        $data['content'] = $this->load->view('Administrator/add_country', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_country()
    {
        $mail = $this->input->post('Country');
        $query = $this->db->query("SELECT CountryName from tbl_country where CountryName = '$mail'");

        if ($query->num_rows() > 0) {
            echo "F";
            //$this->load->view('Administrator/ajax/Country');
        } else {
            $data = array(
                "CountryName"          => $this->input->post('Country', TRUE),
                "AddBy"                  => $this->session->userdata("FullName"),
                "AddTime"                => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_country', $data);
            $this->load->view('Administrator/ajax/Country');
        }
    }
    public function fancybox_add_country()
    {
        $this->load->view('Administrator/products/fancybox_add_country');
    }
    public function fancybox_insert_country()
    {
        $mail = $this->input->post('Country');
        $query = $this->db->query("SELECT CountryName from tbl_country where CountryName = '$mail'");

        if ($query->num_rows() > 0) {
            echo "F";
        } else {
            $data = array(
                "CountryName"          => $this->input->post('Country', TRUE),
                "AddBy"                  => $this->session->userdata("FullName"),
                "AddTime"                => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_country', $data);
            $this->load->view('Administrator/products/ajax_Country');
        }
    }
    public function countryedit($id)
    {
        $data['title'] = "Edit Country";
        $fld = 'Country_SlNo';
        $data['selected'] = $this->mt->select_by_id('tbl_country', $id, $fld);
        $data['content'] = $this->load->view('Administrator/edit/country_edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function countryupdate()
    {
        $id = $this->input->post('id');
        $fld = 'Country_SlNo';
        $data = array(
            "CountryName"                     => $this->input->post('Country', TRUE),
            "UpdateBy"                          => $this->session->userdata("FullName"),
            "UpdateTime"                        => date("Y-m-d H:i:s")
        );
        $this->mt->update_data("tbl_country", $data, $id, $fld);
        $this->load->view('Administrator/ajax/Country');
    }
    public function countrydelete()
    {
        $id = $this->input->post('deleted');
        $fld = 'Country_SlNo';
        $this->mt->delete_data("tbl_country", $id, $fld);
        $this->load->view('Administrator/ajax/Country');
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //Company Profile

    public function getCompanyProfile()
    {
        $companyProfile = $this->db->query("select * from tbl_company order by Company_SlNo desc limit 1")->row();
        echo json_encode($companyProfile);
    }

    public function company_profile()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Company Profile";
        $data['selected'] = $this->db->query("
            select * from tbl_company order by Company_SlNo desc limit 1
        ")->row();
        $data['content'] = $this->load->view('Administrator/company_profile', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function company_profile_insert()
    {
        $id = $this->brunch;
        $inpt = $this->input->post('inpt', true);
        $fld = 'company_BrunchId';
        $this->load->library('upload');
        $config['upload_path'] = './uploads/company_profile_org/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10000';
        $config['image_width'] = '4000';
        $config['image_height'] = '4000';
        $this->upload->initialize($config);

        $data['Company_Name'] =  $this->input->post('Company_name', true);
        $data['Repot_Heading'] =  $this->input->post('Description', true);

        $xx = $this->mt->select_by_id("tbl_company", $id, $fld);

        if (!empty($_FILES['image']['name'])) {
            $imagePath = './uploads/website_image/' . $xx->websiteImage;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $currentDirectory = getcwd();
            $dir = "/uploads/website_image/";
            $filename = time() . "-" . $_FILES['image']["name"];
            $uploadPath = $currentDirectory . $dir . basename($filename);
            move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);
            $this->db->where('Company_SlNo', $inpt);
            $this->db->update('tbl_company', array("websiteImage" => $filename));
        }

        $image = $this->upload->do_upload('companyLogo');
        $images = $this->upload->data();

        if ($image != "") {
            if ($xx['Company_Logo_thum'] && $xx['Company_Logo_org']) {
                unlink("./uploads/company_profile_thum/" . $xx['Company_Logo_thum']);
                unlink("./uploads/company_profile_org/" . $xx['Company_Logo_org']);
            }
            $data['Company_Logo_org'] = $images['file_name'];

            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
            $config['new_image'] = 'uploads/' . 'company_profile_thum/' . $this->upload->file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 165;
            $config['height'] = 175;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $data['Company_Logo_thum'] = $this->upload->file_name;
        } else {

            $data['Company_Logo_org'] = $xx['Company_Logo_org'];
            $data['Company_Logo_thum'] = $xx['Company_Logo_thum'];
        }
        $data['print_type'] = $inpt;
        $data['company_BrunchId'] = $this->brunch;
        $this->mt->save_data("tbl_company", $data, $id, $fld);
        $id = '1';
        redirect('Administrator/Page/company_profile');
        //$this->load->view('Administrator/company_profile');
    }

    public function company_profile_Update()
    {
        $inpt = $this->input->post('inpt', true);
        $this->load->library('upload');
        $config['upload_path'] = './uploads/company_profile_org/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10000';
        $config['image_width'] = '4000';
        $config['image_height'] = '4000';
        $this->upload->initialize($config);

        $data['Company_Name'] =  $this->input->post('Company_name', true);
        $data['Repot_Heading'] =  $this->input->post('Description', true);

        $data["phone"]   = $this->input->post('phone', true);
        $data["facebook"] = $this->input->post('facebook', true);
        $data["instagram"] = $this->input->post('instagram', true);
        $data["youtube"]  = $this->input->post('youtube', true);
        $data["linkedin"] = $this->input->post('linkedin', true);
        $data["twitter"]  = $this->input->post('twitter', true);
        $data["map"]      = $this->input->post('map', true);
        $data["about_us"] = $this->input->post('about_us', true);
        $data["faq"]      = $this->input->post('faq', true);

        $xx = $this->db->query("select * from tbl_company order by Company_SlNo desc limit 1")->row();

        if (!empty($_FILES['websiteImage']['name'])) {
            $imagePath = './uploads/website_image/' . $xx->websiteImage;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $currentDirectory = getcwd();
            $dir = "/uploads/website_image/";
            $filename = time() . "-" . $_FILES['websiteImage']["name"];
            $uploadPath = $currentDirectory . $dir . basename($filename);
            move_uploaded_file($_FILES["websiteImage"]['tmp_name'], $uploadPath);
            $this->db->where('Company_SlNo', $xx->Company_SlNo);
            $this->db->update('tbl_company', array("websiteImage" => $filename));
        }

        if (!isset($_FILES['companyLogo']) || $_FILES['companyLogo']['error'] == UPLOAD_ERR_NO_FILE) {
            $data['print_type'] = $inpt;
            $this->db->update('tbl_company', $data);
            $id = '1';
            redirect('Administrator/Page/company_profile');
        } else {
            $image = $this->upload->do_upload('companyLogo');
            $images = $this->upload->data();

            if ($image != "") {
                if ($xx->Company_Logo_thum && $xx->Company_Logo_org) {
                    unlink("./uploads/company_profile_thum/" . $xx->Company_Logo_thum);
                    unlink("./uploads/company_profile_org/" . $xx->Company_Logo_org);
                }
                $data['Company_Logo_org'] = $images['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $config['new_image'] = 'uploads/' . 'company_profile_thum/' . $this->upload->file_name;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 165;
                $config['height'] = 175;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $data['Company_Logo_thum'] = $this->upload->file_name;
            } else {

                $data['Company_Logo_org'] = $xx->Company_Logo_org;
                $data['Company_Logo_thum'] = $xx->Company_Logo_thum;
            }

            $data['print_type'] = $inpt;
            $this->db->update('tbl_company', $data);
            $id = '1';
            redirect('Administrator/Page/company_profile');
        }
        //$this->load->view('Administrator/company_profile');
    }
    //^^^^^^^^^^^^^^^^^^^^^
    // Brunch Name

    public function getBranches()
    {
        $branches = $this->db->query("
            select 
            *,
            case status
                when 'a' then 'Active'
                else 'Inactive'
            end as active_status
            from tbl_brunch
        ")->result();
        echo json_encode($branches);
    }

    public function getCurrentBranch()
    {
        $branch = $this->Billing_model->company_branch_profile($this->brunch);
        echo json_encode($branch);
    }

    public function changeBranchStatus()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $status = $this->db->query("select * from tbl_brunch where brunch_id = ?", $data->branchId)->row()->status;
            $status = $status == 'a' ? 'd' : 'a';
            $this->db->set('status', $status)->where('brunch_id', $data->branchId)->update('tbl_brunch');
            $res = ['success' => true, 'message' => 'Status changed'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function brunch()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Add Brunch";
        $data['content'] = $this->load->view('Administrator/brunch/add_brunch', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function addBranch()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $branch = json_decode($this->input->raw_input_stream);

            $nameCount = $this->db->query("select * from tbl_brunch where Brunch_name = ?", $branch->name)->num_rows();
            if ($nameCount > 0) {
                $res = ['success' => false, 'message' => $branch->name . ' already exists'];
                echo json_encode($res);
                exit;
            }

            $newBranch = array(
                'Brunch_name' => $branch->name,
                'Brunch_title' => $branch->title,
                'Brunch_address' => $branch->address,
                'Brunch_sales' => '2',
                'add_by' => $this->session->userdata("FullName"),
                'add_time' => date('Y-m-d H:i:s'),
                'status' => 'a'
            );

            $this->db->insert('tbl_brunch', $newBranch);
            $res = ['success' => true, 'message' => 'Branch added'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBranch()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $branch = json_decode($this->input->raw_input_stream);

            $nameCount = $this->db->query("select * from tbl_brunch where Brunch_name = ? and brunch_id != ?", [$branch->name, $branch->branchId])->num_rows();
            if ($nameCount > 0) {
                $res = ['success' => false, 'message' => $branch->name . ' already exists'];
                echo json_encode($res);
                exit;
            }

            $newBranch = array(
                'Brunch_name' => $branch->name,
                'Brunch_title' => $branch->title,
                'Brunch_address' => $branch->address,
                'update_by' => $this->session->userdata("FullName")
            );

            $this->db->set($newBranch)->where('brunch_id', $branch->branchId)->update('tbl_brunch');
            $res = ['success' => true, 'message' => 'Branch updated'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function fancybox_add_brunch()
    {
        $this->load->view('brunch/fancybox_add_brunch');
    }
    public function fancybox_insert_brunch()
    {
        $mail = $this->input->post('Brunchname');
        $query = $this->db->query("SELECT Brunch_name from tbl_brunch where Brunch_name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/brunch', $data);
        } else {
            $string = $this->input->post('brunchaddress');
            $data = array(
                "Brunch_name"              => $this->input->post('Brunchname', TRUE),
                "Brunch_title"             => $this->input->post('brunchtitle', TRUE),
                "Brunch_address"           => htmlspecialchars($string),
                "Brunch_sales"             => $this->input->post('Access', TRUE)
            );
            $brid = $this->mt->save_date_id('tbl_brunch', $data);
            $branchData = array(
                "branch_id" => $brid
            );
            $this->mt->save_data('tbl_menuaccess', $branchData);

            $this->load->view('Administrator/ajax/fancybox_add_brunch');
        }
    }
    public function brunch_edit()
    {
        $id = $this->input->post('edit');
        $query = $this->db->query("SELECT * from tbl_brunch where brunch_id = '$id'");
        $data['selected'] = $query->row();
        $this->load->view('Administrator/edit/brunch_edit', $data);
    }
    public function brunch_update()
    {
        $id = $this->input->post('id');
        $fld = 'brunch_id';
        $string = $this->input->post('brunchaddress');
        //echo htmlspecialchars($string);
        //echo mysql_real_escape_string($string);
        $data = array(
            "Brunch_name"        => $this->input->post('Brunchname', TRUE),
            "Brunch_title"       => $this->input->post('brunchtitle', TRUE),
            "Brunch_address"     => htmlentities($string),
            "Brunch_sales"       => $this->input->post('Access', TRUE),
            "status"            => 'a'
        );
        if ($this->mt->update_data("tbl_brunch", $data, $id, $fld)) {
            $t = true;
            echo json_encode($t);
        }
    }
    public function brunch_delete()
    {
        $id = $this->input->post('deleted');
        if ($this->mt->delete_data("tbl_brunch", $id, 'brunch_id')) {
            $t = true;
            echo json_encode($t);
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^
    public function add_color()
    {
        $data['title'] = "Add color";
        $data['content'] = $this->load->view('Administrator/add_color', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Fancybox_add_color()
    {
        $data['title'] = "Add color";
        $this->load->view('Administrator/products/fancybox_color', $data);
    }
    public function insert_color()
    {
        $colorname = $this->input->post('colorname');
        $query = $this->db->query("SELECT color_name from tbl_color where color_name = '$colorname'");

        if ($query->num_rows() > 0) {
            $exits = false;
            echo json_encode($exits);
        } else {
            $data = array(
                "color_name"      => $this->input->post('colorname', TRUE),
                "status"          => 'a'

            );
            if ($this->mt->save_data('tbl_color', $data)) {
                $msg = true;
                echo json_encode($msg);
            }
        }
    }
    public function fancybox_insert_color()
    {
        $mail = $this->input->post('Country');
        $query = $this->db->query("SELECT color_name from tbl_color where color_name = '$mail'");

        if ($query->num_rows() > 0) {
            echo "F";
            //$this->load->view('ajax/Country');
        } else {
            $data = array(
                "color_name"          => $this->input->post('Country', TRUE)
            );
            $this->mt->save_data('tbl_color', $data);
            $this->load->view('Administrator/products/ajax_color');
        }
    }
    public function colordelete()
    {
        $id = $this->input->post('deleted');
        $fld = 'color_SiNo';
        $this->mt->delete_data("tbl_color", $id, $fld);
        echo "Success";
    }
    public function coloredit($id)
    {
        $data['title'] = "Edit Color";
        $fld = 'color_SiNo';
        $data['selected'] = $this->Billing_model->select_by_id('tbl_color', $id, $fld);
        $data['content'] = $this->load->view('Administrator/edit/edit_color', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function colorupdate()
    {
        $id = $this->input->post('id');
        $colorname = $this->input->post('colorname');
        $query = $this->db->query("SELECT color_name from tbl_color where color_name = '$colorname'");

        if ($query->num_rows() > 1) {
            $exits = false;
            echo json_encode($exits);
        } else {
            $fld = 'color_SiNo';
            $data = array(
                "color_name" => $this->input->post('colorname', TRUE)
            );
            if ($this->mt->update_data("tbl_color", $data, $id, $fld)) {
                $msg = true;
                echo json_encode($msg);
            }
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

    public function getBrands()
    {
        $brands = $this->db->query("select * from tbl_brand where status = 'a'")->result();
        echo json_encode($brands);
    }

    public function add_brand()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Add Brand";
        $data['brand'] =  $this->Billing_model->select_brand($this->brunch);
        $data['content'] = $this->load->view('Administrator/add_brand', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_brand()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $is_website = $data->is_website == true ? 1 : 0;
            $branchId = $this->session->userdata('BRANCHid');
            $exits = $this->db->query("select * from tbl_brand where brand_name = '$data->brand_name' and brand_branchid = $branchId")->num_rows();
            if ($exits > 0) {
                $res = ['success' => false, 'message' => 'Already Exists!'];
            } else {
                $brands = $this->db->query("insert into tbl_brand(brand_name, is_website,status)values('$data->brand_name',$is_website, 'a')");
                $brandId = $this->db->insert_id();
                if (!empty($_FILES['image'])) {
                    $config['upload_path'] = './uploads/brands/';
                    $config['allowed_types'] = 'gif|jpg|png';

                    $imageName = time() . $brandId;
                    $config['file_name'] = $imageName;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('image');
                    //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/brands/' . $imageName;
                    $config['new_image'] = './uploads/brands/';
                    $config['maintain_ratio'] = TRUE;
                    $config['width']    = 155;
                    $config['height']   = 70;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $imageName = time() . $brandId . $this->upload->data('file_ext');

                    $this->db->query("update tbl_brand set image = ? where brand_SiNo = ?", [$imageName, $brandId]);
                }
                $res = ['success' => true, 'message' => 'Successfully Inserted'];
            }
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }

        echo json_encode($res);
    }

    public function fancybox_add_brand()
    {
        $this->load->view('Administrator/products/fancybox_add_brand');
    }
    public function fancybox_insert_brand()
    {
        // $pCategory = $this->input->post('pCategory');
        $brand = $this->input->post('brand');
        //$query = $this->db->query("SELECT brand_name from tbl_brand where ProductCategory_SlNo = '$pCategory' && brand_name = '$brand'");
        $query = $this->db->query("SELECT brand_name from tbl_brand where brand_name = '$brand'");

        if ($query->num_rows() > 0) {
            echo "F";
            //$this->load->view('ajax/Country');
        } else {
            $data = array(
                //"ProductCategory_SlNo"          =>$this->input->post('pCategory', TRUE),
                "ProductCategory_SlNo"          => '0',
                "brand_name"          => $this->input->post('brand', TRUE)

            );
            $this->mt->save_data('tbl_brand', $data);
            $this->load->view('Administrator/products/ajax_Brand');
        }
    }
    public function branddelete()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->raw_input_stream);
            if ($data->image != "") {
                $imagePath = './uploads/brands/' . $data->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $this->db->where('brand_SiNo', $data->brandId);
            $this->db->delete('tbl_brand');

            $res = ['success' => true, 'message' => 'Successfully Deleted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }
    public function brandedit()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $is_website = $data->is_website == true ? 1 : 0;
            $branchId = $this->session->userdata('BRANCHid');
            $exits = $this->db->query("select * from tbl_brand where brand_SiNo != $data->brand_SiNo and brand_name = '$data->brand_name' and brand_branchid = $branchId")->num_rows();
            if ($exits > 0) {
                $res = ['success' => false, 'message' => 'Already Exists!'];
            } else {
                $brands = $this->db->query("update tbl_brand set brand_name = '$data->brand_name', is_website = $is_website, status = 'a' where brand_SiNo = $data->brand_SiNo");
                $brandId = $data->brand_SiNo;

                if (!empty($_FILES['image'])) {

                    $imagePath = './uploads/brands/' . $data->image;
                    if (file_exists($imagePath) && !empty($data->image)) {
                        unlink($imagePath);
                    }
                    $config['upload_path'] = './uploads/brands/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $imageName = time() . $brandId;
                    $config['file_name'] = $imageName;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('image');
                    //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/brands/' . $imageName;
                    $config['new_image'] = './uploads/brands/';
                    $config['maintain_ratio'] = TRUE;
                    $config['width']    = 155;
                    $config['height']   = 70;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $imageName = time() . $brandId . $this->upload->data('file_ext');
                    $this->db->query("update tbl_brand set image = ? where brand_SiNo = ?", [$imageName, $brandId]);
                }
                $res = ['success' => true, 'message' => 'Successfully Updated'];
            }
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }

    public function is_website_brands()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];

        try {
            $data = json_decode($this->input->raw_input_stream);
            $exits = $this->db->query("select * from tbl_brand where brand_SiNo = $data->brandId and is_website = 1 ")->num_rows();
            if ($exits > 0) {
                $query = $this->db->query("update tbl_brand set is_website = 0 where brand_SiNo = $data->brandId");
            } else {
                $query = $this->db->query("update tbl_brand set is_website = 1 where brand_SiNo = $data->brandId");
            }
            $res = ['success' => true, 'message' => 'Suceessfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }
    public function Update_brand()
    {
        $id = $this->input->post('id');
        $brandname = $this->input->post('brandname');
        $branch = $this->brunch;
        $query = $this->db->query("SELECT brand_name from tbl_brand where brand_branchid = '$branch' AND brand_name = '$brandname'");
        if ($query->num_rows() > 0) {
            $exist = false;
            echo json_encode($exist);
        } else {
            $fld = 'brand_SiNo';
            $data = array(
                "brand_name" => $this->input->post('brandname', TRUE)
            );
            $succ = $this->mt->update_data("tbl_brand", $data, $id, $fld);
            if ($succ) {
                $msg = true;
                echo json_encode($msg);
            }
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    public function add_bank()
    {
        $data['title'] = "Add Bank";
        $data['bank'] = $this->Billing_model->select_bank();
        $data['content'] = $this->load->view('Administrator/add_bank', $data, TRUE);
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

    public function insert_Bank()
    {
        $Bank_name = $this->input->post('Bank_name');
        $Branch = $this->input->post('Branch');
        $Account_Title = $this->input->post('Account_Title');
        $Account_No = $this->input->post('Account_No');
        $query = $this->db->query("SELECT Bank_name from tbl_bank where Bank_name = '$Bank_name'");

        if ($query->num_rows() > 0) {
            //echo "F";
            //$this->load->view('ajax/Country');
            $sdata['message'] = 'This Bank Name Allready Exists';
            $this->session->set_userdata($sdata);
            redirect('Administrator/Page/add_bank');
        } else {
            $data = array(
                "Bank_name"          => $Bank_name,
                "Branch"             => $Branch,
                "Account_Title"      => $Account_Title,
                "Account_No"         => $Account_No
            );
            $this->mt->save_data('tbl_bank', $data);
            redirect('Administrator/Page/add_bank');
            //$this->load->view('ajax/add_bank');
        }
    }
    public function fancybox_add_bank()
    {
        $this->load->view('Administrator/account/fancybox_add_bank');
    }
    public function fancyBox_insert_Bank()
    {
        $Bank = $this->input->post('Bank');
        $query = $this->db->query("SELECT Bank_name from tbl_Bank where Bank_name = '$Bank'");

        if ($query->num_rows() > 0) {
            echo "F";
        } else {
            $data = array(
                "Bank_name" => $Bank
            );
            $this->mt->save_data('tbl_Bank', $data);
            $this->load->view('Administrator/account/fancybox_select_add_bank');
        }
    }
    public function Bankdelete()
    {
        $id = $this->input->post('deleted');
        $fld = 'Bank_SiNo';
        $this->mt->delete_data("tbl_Bank", $id, $fld);
        echo "Success";
    }
    public function Bankedit($id)
    {
        $data['title'] = "Edit Bank";
        $fld = 'Bank_SiNo';
        $data['selected'] = $this->mt->select_by_id('tbl_Bank', $id, $fld);
        $data['content'] = $this->load->view('Administrator/edit/edit_Bank', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Update_Bank()
    {
        $Bank_SiNo = $this->input->post('Bank_SiNo');
        $Bank_name = $this->input->post('Bank_name');
        $Branch = $this->input->post('Branch');
        $Account_Title = $this->input->post('Account_Title');
        $Account_No = $this->input->post('Account_No');
        //$query = $this->db->query("SELECT Bank_name from tbl_Bank where Bank_name = '$Bank_name'");
        $query = $this->db->query("SELECT Bank_name from tbl_Bank where Bank_SiNo = '$Bank_SiNo'");

        if ($query->num_rows() > 1) {
            echo "F";
        } else {
            $fld = 'Bank_SiNo';
            $data = array(
                "Bank_name"                     => $Bank_name,
                "Branch"                        => $Branch,
                "Account_Title"                 => $Account_Title,
                "Account_No"                    => $Account_No
            );
            $this->mt->update_data("tbl_Bank", $data, $Bank_SiNo, $fld);
            echo "Success";
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

    public function select_brand_by_category($id)
    {
        $brand = $this->Billing_model->select_brand_by_category($id);
?>
        <option value="">Select Brand</option>
        <?php
        foreach ($brand as $vbrand) {
        ?>
            <option value="<?php echo $vbrand->brand_SiNo; ?>"><?php echo $vbrand->brand_name; ?></option>
        <?php
        }
    }

    public function select_category_by_brand($id)
    {
        if ($id == 'All') {
            $category = $this->Billing_model->select_category($this->session->userdata('BRANCHid'));
        ?>
            <select name="pCategory" id="pCategory" style="" class="chosen-select form-control"" required>
					<option value=" All">All</option>
                <?php
                foreach ($category as $vcategory) {
                ?>
                    <option value="<?php echo $vcategory->ProductCategory_SlNo; ?>"><?php echo $vcategory->ProductCategory_Name; ?></option>
                <?php } ?>
            </select>

        <?php
        } else {
            $category = $this->Billing_model->select_category_by_brand($id);
            //echo "<pre>";print_r($category );exit;
        ?>
            <select name="pCategory" id="pCategory" class="chosen-select form-control"" required>
						<option value=" no">Select Category</option>
                <?php
                foreach ($category as $vcategory) {
                ?>
                    <option value="<?php echo $vcategory->ProductCategory_SlNo; ?>"><?php echo $vcategory->ProductCategory_Name; ?></option>
                <?php
                } ?>
            </select>
        <?php
        }
    }

    public function select_category_by_branch($id)
    {
        $category = $this->Billing_model->select_category_by_branch($id);
        ?>
        <option value="All">Select All</option>
        <?php
        foreach ($category as $vcategory) {
        ?>
            <option value="<?php echo $vcategory->ProductCategory_SlNo; ?>"><?php echo $vcategory->ProductCategory_Name; ?></option>
<?php
        }
    }

    public function databaseBackup()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Database Backup";
        $data['content'] = $this->load->view('Administrator/database_backup', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getMotherApiContent()
    {
        $url = 'http://linktechbd.com/motherapi/index.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code == '200') {
            echo $response_json;
        } else {
            echo '';
        }
    }
}
