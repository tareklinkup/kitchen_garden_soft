<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Website extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }

        $this->load->model('Model_table', 'mt', true);
    }

    public function pending_order()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Pending Orders";
        $data['content'] = $this->load->view('Administrator/Website/pending_order', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function processing_order()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "On Processing Orders";
        $data['content'] = $this->load->view('Administrator/Website/processing_order', $data, true);
        $this->load->view('Administrator/index', $data);
    }


    public function published_category()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Published Category";
        $data['content'] = $this->load->view('Administrator/Website/published_category', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_published_category()
    {
        try {
            $category = $this->input->post('publishid_category');
            $query = $this->db->query("insert into published_categories(name)values('$category')");
            $data = 'true';
        } catch (\Throwable $th) {
            $data = 'false';
        }
        echo json_encode($data);
    }

    public function published_category_delete()
    {
        try {
            $id = $this->input->post('deleted');
            $query = $this->db->query("delete from published_categories where id = $id");
            $data = 'true';
        } catch (\Throwable $th) {
            $data = 'false';
        }
        echo json_encode($data);
    }


    public function delete_published()
    {
        $res = ['success' => false, 'message' => 'Something went wrong !'];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $id = $data->publishedId;
            $query = $this->db->query("delete from 	product_publisheds where id = $id");
            $res = ['success' => true, 'message' => 'Successfully Deleted!'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }

    public function edit_published_category($id)
    {
        $data['title'] = "Published Category";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/Website/edit_published_category', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function published_product()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Published Product";
        $data['content'] = $this->load->view('Administrator/Website/published_product', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function get_publisheds()
    {
        $data = $this->db->query("
            select
                p.*,
                pro.Product_Name product_name,
                pc.name
            from product_publisheds p
            left join published_categories pc on pc.id = p.published_category_id
            left join tbl_product pro on pro.Product_SlNo = p.product_id
            
        ")->result();

        echo json_encode($data);
    }

    public function get_published_category()
    {
        $data = $this->db->query("select published_categories.* from published_categories")->result();
        echo json_encode($data);
    }

    public function add_published()
    {
        $res = ['success' => false, 'message' => ''];

        try {
            $data = json_decode($this->input->raw_input_stream);
            $exits = $this->db->query("select * from product_publisheds where product_id = $data->product_id and published_category_id = $data->published_category_id")->num_rows();
            if ($exits > 0) {
                $res = ['success' => false, 'message' => 'Already Exists!'];
            } else {
                $start_date = $data->start_date;
                $end_date = $data->end_date;
                if ($data->published_category_id == 1) {
                    $is_deal = 1;
                } else {
                    $is_deal = 0;
                    $end_date = '2080-01-01';
                }
                $query = $this->db->query("insert product_publisheds(product_id,published_category_id,is_deal,start_date,end_date)values($data->product_id,$data->published_category_id,$is_deal,'$start_date','$end_date')");
                $res = ['success' => true, 'message' => 'Suceessfully Inserted'];
            }
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }
        echo json_encode($res);
    }

    public function update_published()
    {
        $res = ['success' => false, 'message' => ''];

        try {
            $data = json_decode($this->input->raw_input_stream);
            $exits = $this->db->query("select * from product_publisheds where id != $data->id and product_id = $data->product_id and published_category_id = $data->published_category_id")->num_rows();
            if ($exits > 0) {
                $res = ['success' => false, 'message' => 'Already Exists!'];
            } else {
                $start_date = $data->start_date;
                $end_date = $data->end_date;
                if ($data->published_category_id == 1) {
                    $is_deal = 1;
                } else {
                    $is_deal = 0;
                    $end_date = '2080-01-01';
                }
                $query = $this->db->query("update product_publisheds set product_id = $data->product_id,published_category_id = $data->published_category_id,is_deal = $is_deal,start_date = '$start_date', end_date = '$end_date' where id=$data->id");
                $res = ['success' => true, 'message' => 'Suceessfully Updated'];
            }
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }
        echo json_encode($res);
    }

    public function status_published()
    {
        $res = ['success' => false, 'message' => ''];

        try {
            $data = json_decode($this->input->raw_input_stream);
            $exits = $this->db->query("select * from product_publisheds where id = $data->publishedId and status = 1")->num_rows();
            if ($exits > 0) {
                $query = $this->db->query("update product_publisheds set status = 0 where id = $data->publishedId");
            } else {
                $query = $this->db->query("update product_publisheds set status = 1 where id = $data->publishedId");
            }
            $res = ['success' => true, 'message' => 'Suceessfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }

    public function way_order()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "On The Way Orders";
        $data['content'] = $this->load->view('Administrator/Website/way_order', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function delivered_order()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Delivered Orders";
        $data['content'] = $this->load->view('Administrator/Website/delivered_order', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function getOrders()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clause = "";
        if (isset($data->saleFrom) && $data->saleFrom != '') {
            $clause .= " and sm.sale_from = '$data->saleFrom'";
        }
        $orders = $this->db->query("
            select
                sm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile 
            from tbl_salesmaster sm
            left join tbl_customer c on c.Customer_SlNo = sm.SalseCustomer_IDNo 
            where sm.Status = '$data->status' $clause
        ")->result();

        echo json_encode($orders);
    }

    public function getOrdersRecord()
    {
        $data = json_decode($this->input->raw_input_stream);
        $res['orders'] = $this->db->query(
            "select       
            o.*,
            c.*
            from orders o
            join customers c on c.id = o.customer_id 
            where o.id = $data->orderId"

        )->row();
        $orderDetails = $this->db->query("
            select 
                od.*,
                p.Product_Code,
                p.Product_Name,
                p.ProductCategory_ID,
                pc.ProductCategory_Name,
                o.*,
                c.*
            from order_details od
            join tbl_product p on p.Product_SlNo = od.product_id
            join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            join orders o on o.id = od.order_id
            join customers c on c.id = o.customer_id 
            where o.id = $data->orderId")->result();
        $res['orderDetails'] = $orderDetails;
        echo json_encode($res);
    }

    public function updateOrders()
    {

        try {
            $this->db->trans_begin();
            $data = json_decode($this->input->raw_input_stream);
            if ($data->status == 'a') {

                $od = $this->db->query("select SaleDetails_SlNo, Product_IDNo, SaleDetails_TotalQuantity from tbl_saledetails where SaleMaster_IDNo = $data->orderId")->result();

                foreach ($od as $item) {
                    $inventory = $this->db->query("select * from tbl_currentinventory where product_id = $item->Product_IDNo")->num_rows();
                    if ($inventory == 0) {
                        $res = ['success' => false, 'message' => 'Please Purchase First'];
                        echo json_encode($res);
                        exit;
                    }
                }
                foreach ($od as $item) {
                    $inventory = $this->db->query("update tbl_currentinventory 
                    set sales_quantity = sales_quantity + $item->SaleDetails_TotalQuantity
                    where product_id = $item->Product_IDNo");
                }
                $this->db->query("update tbl_saledetails set Status = 'a' where SaleMaster_IDNo = $data->orderId");
            }
            $orders = $this->db->query("
                update tbl_salesmaster set Status = '$data->status'
                where SaleMaster_SlNo = '$data->orderId'
            ");
            $this->db->trans_commit();
            $res = ['success' => true, 'message' => 'Successfully Updated'];
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            $res = ['success' => false, 'message' => 'Updated Failed'];
        }

        echo json_encode($res);
    }
    //orders

    public function order_invoice_print($orderId)
    {
        $data['title'] = "Order Invoice";
        $data['orderId'] = $orderId;
        $data['content'] = $this->load->view('Administrator/Website/order_invoice', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    //slider
    public function slider()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Slider Entry";
        $data['content'] = $this->load->view('Administrator/Website/add_slider', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function imagegallery()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Image Gallery";
        $data['content'] = $this->load->view('Administrator/Website/add_gallery', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function ourshape()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Our Chef";
        $data['content'] = $this->load->view('Administrator/Website/our_shape', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function ourclient()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Our Client";
        $data['content'] = $this->load->view('Administrator/Website/our_client', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function get_banners()
    {
        $banners = $this->db->query("
            select
                b.*
            from banners b
            where b.status = 'a'
        ")->result();
        echo json_encode($banners);
    }

    public function get_image_gallery()
    {
        // $branch_id = $this->session->userdata('BRANCHid');
        $banners = $this->db->query("select * from photo_galleries")->result();
        echo json_encode($banners);
    }
    public function get_shape()
    {
        $branch_id = $this->session->userdata('BRANCHid');
        $shapes = $this->db->query("
             select
                 s.*
             from shapes s
             where s.status = 'a' and branch_id = '$branch_id'
         ")->result();
        echo json_encode($shapes);
    }
    public function get_client()
    {
        $branch_id = $this->session->userdata('BRANCHid');
        $shapes = $this->db->query("
             select
                 c.*
             from clients c
             where c.branch_id = '$branch_id'
         ")->result();
        echo json_encode($shapes);
    }

    public function add_banners()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));

            $banners = $this->db->query("
            insert into banners(title,offer_link)values('$data->title','$data->offer_link')
        ");

            $bannerId = $this->db->insert_id();

            if (!empty($_FILES['image'])) {
                $config['upload_path'] = './uploads/banners/';
                $config['allowed_types'] = 'gif|jpg|png';

                $imageName = time() . $bannerId;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/banners/' . $imageName;
                $config['new_image'] = './uploads/banners/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 1350;
                $config['height']   = 340;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $imageName = time() . $bannerId . $this->upload->data('file_ext');

                $this->db->query("update banners set image = ? where id = ?", [$imageName, $bannerId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Inserted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }

        echo json_encode($res);
    }

    public function add_image_gallery()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $branch_id = $this->session->userdata('BRANCHid');
            $this->db->query("insert into photo_galleries(title)values('$data->title')");

            $imageId = $this->db->insert_id();

            if (!empty($_FILES['image'])) {
                $currentDirectory = getcwd();
                $dir = "/uploads/imageGallery/";
                $filename = time()."-".$_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);                 
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);

                $this->db->query("update photo_galleries set image = ? where id = ?", [$filename, $imageId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Inserted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }

        echo json_encode($res);
    }

    public function add_shapes()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $branch_id = $this->session->userdata('BRANCHid');
            $this->db->query("
            insert into shapes(name,designation,facebook,twitter,instagram,linkedin,branch_id)values('$data->name','$data->designation','$data->facebook','$data->twitter','$data->instagram','$data->linkedin',$branch_id)
        ");

            $imageId = $this->db->insert_id();

            if (!empty($_FILES['image'])) {
                $currentDirectory = getcwd();
                $dir = "/uploads/shape/";
                $filename = $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);                 
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath); 
                $this->db->query("update shapes set image = ? where id = ?", [$filename, $imageId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Inserted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }

        echo json_encode($res);
    }
    public function add_clients()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $branch_id = $this->session->userdata('BRANCHid');
            $this->db->query("
            insert into clients(name,website_link, branch_id)values('$data->name','$data->website_link',$branch_id)
        ");

            $imageId = $this->db->insert_id();

            if (!empty($_FILES['image'])) {
                $currentDirectory = getcwd();
                $dir = "/uploads/client/";
                $filename = $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);                 
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath); 
                $this->db->query("update clients set image = ? where id = ?", [$filename, $imageId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Inserted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }

        echo json_encode($res);
    }

    public function update_banners()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));

            $banners = $this->db->query("
            update banners set title = '$data->title', offer_link = '$data->offer_link' where id = $data->id
        ");

            $bannerId = $data->id;

            if (!empty($_FILES['image'])) {
                $imagePath = './uploads/banners/' . $data->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $config['upload_path'] = './uploads/banners/';
                $config['allowed_types'] = 'gif|jpg|png';

                $imageName = time() . $bannerId;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/banners/' . $imageName;
                $config['new_image'] = './uploads/banners/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 1350;
                $config['height']   = 340;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $imageName = time() . $bannerId . $this->upload->data('file_ext');
                $this->db->query("update banners set image = ? where id = ?", [$imageName, $bannerId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }
    public function update_image_gallery()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));

            $this->db->query("update photo_galleries set title = '$data->title' where id = '$data->id' ");

            $bannerId = $data->id;

            if (!empty($_FILES['image'])) {
                $imagePath = './uploads/imageGallery/' . $data->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $currentDirectory = getcwd();
                $dir = "/uploads/imageGallery/";
                $filename = time()."-".$_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);                 
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath); 

                $this->db->query("update photo_galleries set image = ? where id = ?", [$filename, $bannerId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }

    public function update_shapes()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $branch_id = $this->session->userdata('BRANCHid');
            $this->db->query("
                update shapes set name = '$data->name', designation = '$data->designation', facebook = '$data->facebook', twitter = '$data->twitter', instagram = '$data->instagram', linkedin = '$data->linkedin' where id = $data->id and branch_id = $branch_id
            ");

            $shapeId = $data->id;

            if (!empty($_FILES['image'])) {
                $imagePath = './uploads/shape/' . $data->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $currentDirectory = getcwd();
                $dir = "/uploads/shape/";
                $filename = $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);                 
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);

                $this->db->query("update shapes set image = ? where id = ?", [$filename, $shapeId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }
    public function update_clients()
    {
        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));
            $branch_id = $this->session->userdata('BRANCHid');
            $this->db->query("
                update clients set name = '$data->name', website_link = '$data->website_link' where id = $data->id and branch_id = $branch_id
            ");

            $clientId = $data->id;

            if (!empty($_FILES['image'])) {
                $imagePath = './uploads/client/' . $data->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $currentDirectory = getcwd();
                $dir = "/uploads/client/";
                $filename = $_FILES['image']["name"];
                $uploadPath = $currentDirectory . $dir . basename($filename);                 
                move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);

                $this->db->query("update clients set image = ? where id = ?", [$filename, $clientId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }
    public function delete_banner()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $banners = $this->db->query("select image from banners where id = $data->bannerId")->row();
            $imagePath = './uploads/banners/' . $banners->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $banners = $this->db->query("delete from banners where id = $data->bannerId");
            $res = ['success' => true, 'message' => 'Successfully Deleted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }

    public function delete_shape()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $banners = $this->db->query("select image from shapes where id = $data->shapeId")->row();
            $imagePath = './uploads/shape/' . $banners->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $banners = $this->db->query("delete from shapes where id = $data->shapeId");
            $res = ['success' => true, 'message' => 'Successfully Deleted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }
    public function delete_client()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $clients = $this->db->query("select image from clients where id = $data->clientId")->row();
            $imagePath = './uploads/client/' . $clients->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $clients = $this->db->query("delete from clients where id = $data->clientId");
            $res = ['success' => true, 'message' => 'Successfully Deleted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }
    public function delete_image_gallery()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $banners = $this->db->query("select image from photo_galleries where id = $data->galleryId")->row();
            $imagePath = './uploads/imageGallery/' . $banners->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $banners = $this->db->query("delete from photo_galleries where id = $data->galleryId");
            $res = ['success' => true, 'message' => 'Successfully Deleted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }
    public function ad()
    {
        $data['title'] = "Ad Entry";
        $data['content'] = $this->load->view('Administrator/Website/add_ad', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function get_ads()
    {

        $ads = $this->db->query("
            select
                a.*
            from ads a
        ")->result();
        echo json_encode($ads);
    }

    public function add_ads()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));

            $ads = $this->db->query("
            insert into ads(title,offer_link,position)values('$data->title','$data->offer_link','$data->position')
        ");

            $adId = $this->db->insert_id();

            if (!empty($_FILES['image'])) {
                $config['upload_path'] = './uploads/adss/';
                $config['allowed_types'] = 'gif|jpg|png';

                $imageName = time() . $adId;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/adss/' . $imageName;
                $config['new_image'] = './uploads/adss/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 420;
                $config['height']   = 180;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $imageName = time() . $adId . $this->upload->data('file_ext');

                $this->db->query("update ads set image = ? where id = ?", [$imageName, $adId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Inserted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Inserted Failed!'];
        }

        echo json_encode($res);
    }


    public function update_ad()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->post('data'));

            $ads = $this->db->query("
            update ads set title = '$data->title', offer_link = '$data->offer_link', position = '$data->position' where id = $data->id
        ");

            $adId = $data->id;

            if (!empty($_FILES['image'])) {
                $imagePath = './uploads/adss/' . $data->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $config['upload_path'] = './uploads/adss/';
                $config['allowed_types'] = 'gif|jpg|png';

                $imageName = time() . $adId;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/adss/' . $imageName;
                $config['new_image'] = './uploads/adss/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 420;
                $config['height']   = 180;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $imageName = time() . $adId . $this->upload->data('file_ext');
                $this->db->query("update ads set image = ? where id = ?", [$imageName, $adId]);
            }
            $res = ['success' => true, 'message' => 'Successfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }

    public function delete_ads()
    {

        $res = ['success' => false, 'message' => 'Something went wrong'];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $ads = $this->db->query("select image from ads where id = $data->adId")->row();
            $imagePath = './uploads/adss/' . $ads->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $ads = $this->db->query("delete from ads where id = $data->adId");
            $res = ['success' => true, 'message' => 'Successfully Deleted'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Deleted Failed!'];
        }
        echo json_encode($res);
    }

    public function status_ads()
    {
        $res = ['success' => false, 'message' => ''];

        try {
            $data = json_decode($this->input->raw_input_stream);
            $exits = $this->db->query("select * from ads where id = $data->adId and status = 'a' ")->num_rows();
            if ($exits > 0) {
                $query = $this->db->query("update ads set status = 'd' where id = $data->adId");
            } else {
                $query = $this->db->query("update ads set status = 'a' where id = $data->adId");
            }
            $res = ['success' => true, 'message' => 'Suceessfully Updated'];
        } catch (\Throwable $th) {
            $res = ['success' => false, 'message' => 'Updated Failed!'];
        }

        echo json_encode($res);
    }

    public function get_orders_stock()
    {
        $order_stock = $this->db->query("
            select
                od.id,
                od.quantity as order_qty,
                od.product_name	as product_name,
                od.product_id as product_id,
                o.invoice_no as invoice_no,
                o.customer_name as customer_name,
                o.created_at as order_date,
                o.customer_mobile as customer_mobile,                
                ifnull(ci.purchase_quantity, 0) as purchase_quantity,
                ifnull(ci.purchase_return_quantity, 0) as purchase_return_quantity,
                ifnull(ci.sales_quantity, 0) as sales_quantity,
                ifnull(ci.sales_return_quantity, 0) as sales_return_quantity,
                ifnull(ci.damage_quantity, 0) as damage_quantity,
                ifnull(ci.transfer_from_quantity , 0) as transfer_from_quantity,
                ifnull(ci.transfer_to_quantity, 0) as transfer_to_quantity,
                ifnull((select (purchase_quantity + sales_return_quantity + transfer_to_quantity) - (sales_quantity + purchase_return_quantity + damage_quantity + transfer_from_quantity)), 0) as current_quantity
            from orders o, order_details od
            left join tbl_currentinventory ci on ci.product_id = od.product_id
            where o.status != 'd' and o.id = od.order_id
        ")->result();
        echo json_encode($order_stock);
    }

    public function get_product_stock_status()
    {
        $order_stock = $this->db->query("
        select p.Product_SlNo,p.Product_Code,p.Product_Name,
        ifnull(ci.purchase_quantity, 0) as purchase_quantity,
        ifnull(ci.purchase_return_quantity, 0) as purchase_return_quantity,
        ifnull(ci.sales_quantity, 0) as sales_quantity,
        ifnull(ci.sales_return_quantity, 0) as sales_return_quantity,
        ifnull(ci.damage_quantity, 0) as damage_quantity,
        ifnull(ci.transfer_from_quantity , 0) as transfer_from_quantity,
        ifnull(ci.transfer_to_quantity, 0) as transfer_to_quantity,
        ifnull((select (purchase_quantity + sales_return_quantity + transfer_to_quantity) - (sales_quantity + purchase_return_quantity + damage_quantity + transfer_from_quantity)), 0) as current_quantity,
        
        (select ifnull(sum(od.quantity),0)
         from order_details od
         LEFT JOIN orders o on o.id = od.order_id
         where od.product_id = p.Product_SlNo
         and o.status != 'd'
         ) as order_qty                
        
        from tbl_product p
        left join tbl_currentinventory ci on ci.product_id = p.Product_SlNo
        WHERE p.status = 'a'
           
        ")->result();
        echo json_encode($order_stock);
    }
}
