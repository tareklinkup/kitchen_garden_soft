<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Myclass extends CI_Model {
   public $Cap;
   public function CheckExtension($file){
        $ext = strtolower(end(explode(".", $file['name'])));
        if($ext == 'gif' || $ext == 'png' || $ext == 'jpg') {                      
           return $ext;            
        }
        return "No Image";
    }
    public function ChangeImage($file, $url, $name, $ext){
        $config = ImageConfig($url);            
        if($this->CheckExtension($file) != "") {
           unlink($name);            
           return $this->CheckExtension($file);            
        }
        return $ext;
    }
    
    public function UploadImage($field, $url, $name)
    {
        $config = ImageConfig($url); 
        $config['file_name'] = $name;
        $this->load->library('upload', $config); 
        $this->upload->do_upload($field);
    }
    public function ResizeImage($field, $url, $name){
      $config_manip = array(
            'image_library' => 'gd2',
            'source_image'  => "./uploads/products/{$this->input->post('image')}",
            'new_image'     => "./uploads/thums/{$this->input->post('image')}",
            'maintain_ratio'=> TRUE ,
            'create_thumb'  => TRUE ,
            'thumb_marker'  => '_thumb' ,
            'width'         => 150,
            'height'        => 150 
        );

        $this->load->library('upload', $config_manip);
        $this->image_lib->resize();
    }
    public function resize($file) {
      $config['image_library'] = 'gd2';
      $config['source_image'] =  './uploads/products/';
      $config['create_thumb'] = TRUE;
      $config['maintian_ratio'] = TRUE;
      $config['width'] = 100;
      $config['height'] = 100;
      $config['new_image'] = './uploads/thums/' . $file;

      $this->load->library('image_lib', $config);
      $this->image_lib->resize();

    }
    public function My_Thumbnail($field, $url, $name){  
        $config = ImageCrop($url); 
        $config['file_name'] = $name;
        $this->load->library('upload', $config); 
        $this->upload->do_upload($field);
    }
    /* public function My_Thumbnail($name)
    {    
       $conf['image_library'] = 'gd2';
       $conf['source_image']   = "uploads/thums/".$name;
       $conf['create_thumb'] = TRUE;
       $conf['maintain_ratio'] = FALSE;
       $conf['width']   = 100;
       $conf['height']  = 100;
       $this->load->library('image_lib', $conf); 
       $this->image_lib->resize();
       
    }*/
    public function MyCaptche()
    {
        $this->load->helper('captcha');
        $word = RandString(6);       
        $captcha = array(
            'word'          => $word,
            'img_path'      => './captcha/',
            'img_url'     =>  base_url().'captcha/',
            'font_path'     => './fonts/Plain_Squashed.ttf',
            'img_width'     => '170',
            'img_height'    =>'35',
            'expiration'    =>'600',
            'time'          =>time()
        );
        
        $expire = $captcha['time'] - $captcha['expiration'];   
        //echo $expire;
        $this->db->where('time < ', $expire);
        $this->db->delete('captcha');        
        
        $value = array(
            'time'         => $captcha['time'],
            'ip_address'   => $this->input->ip_address(),
            'word'         => $captcha['word']
        );
        
        //insert value in captcha table
        $this->db->insert('captcha', $value);
        
        $img = create_captcha($captcha);
        return $img['image'];
    }
    
    
    
    public function CheckCap(){
       $sql = "select * from captcha where word='".MS(str_replace(" ", "", $this->Cap))."'";
       $sql = mysql_query($sql);
       if(mysql_num_rows($sql) > 0){         
          return TRUE;
       }
       return FALSE;
    }
    
    public function Select(){
       $sql = "select * from captcha ORDER BY id DESC LIMIT 1";
       $sql = mysql_query($sql);
       while($d = mysql_fetch_row($sql)){         
          return $d[3];
       }
    }
}

?>
