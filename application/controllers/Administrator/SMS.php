<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SMS extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }

        $this->load->model('Model_table', 'mt', true);
        $this->load->model('SMS_model', 'sms', true);
    }
    public function index(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Send SMS";
        $data['content'] = $this->load->view('Administrator/SMS/sms', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function sendSms() {
        $res = ['success'=>false, 'message'=>''];
        $data = json_decode($this->input->raw_input_stream);

        $result = $this->sms->sendSms($data->number, $data->smsText);

        if(!$result){
            $res = ['success'=>false, 'message'=>'SMS not sent'];   
            echo json_encode($res);
            exit;
        }

        $smsLog = array(
            'number' => $data->number,
            'sms_text' => $data->smsText,
            'sent_by' => $this->session->userdata('userId'),
            'sent_datetime' => date('Y-m-d h:i:s')
        );

        $this->db->insert('tbl_sms', $smsLog);

        $res = ['success'=>true, 'message'=>'SMS sent successfully']; 
        echo json_encode($res);
    }

    public function sendBulkSms(){
        $res = ['success'=>false, 'message'=>''];
        $data = json_decode($this->input->raw_input_stream);

        $result = $this->sms->sendBulkSms($data->numbers, $data->smsText);

        if(!$result){
            $res = ['success'=>false, 'message'=>'SMS not sent'];   
            echo json_encode($res);
            exit;
        }

        foreach($data->numbers as $number){
            $smsLog = array(
                'number' => $number,
                'sms_text' => $data->smsText,
                'sent_by' => $this->session->userdata('userId'),
                'sent_datetime' => date('Y-m-d h:i:s')
            );

            $this->db->insert('tbl_sms', $smsLog);
        }

        $res = ['success'=>true, 'message'=>'SMS sent successfully']; 
        echo json_encode($res);
    }

    public function smsSettings(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }

        $data['title'] = "SMS Settings";
        $data['content'] = $this->load->view("Administrator/SMS/sms_settings", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function getSmsSettings(){
        $settings = $this->db->query("
            select * from tbl_sms_settings limit 1
        ")->row();

        echo json_encode($settings);
    }

    public function saveSmsSettings(){
        $res = ['success'=>false, 'message'=>'Nothing'];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $count = $this->db->query("select * from tbl_sms_settings")->num_rows();        
            $settings = (array)$data;
            if($count == 0){
                $this->db->insert('tbl_sms_settings', $settings);
            } else {
                $this->db->update('tbl_sms_settings', $settings);
            }

            $res = ['success'=>true, 'message'=>'Saved successfully'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }
}
