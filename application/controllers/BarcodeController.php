<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarcodeController extends CI_Controller {

	public function barcode_create($id){
		$this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128','image', array('text'=>$id), array());
	}
	
}
