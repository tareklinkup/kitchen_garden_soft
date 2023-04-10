<?php
/**
 * Created by PhpStorm.
 * User: Arup
 * Date: 11/29/2018
 * Time: 3:33 PM
 */

class HR_model extends CI_Model
{
	public $BRANCHid;

	public function __construct()
	{
		$this->BRANCHid=$this->session->userdata('BRANCHid');
	}

	public function get_all_employee_list($status = 'all')
	{
		$clause = '';
		switch ($status) {
			case 'all':
				$clause = " and e.status != 'd'";
				break;

			case 'active':
				$clause = " and e.status = 'a'";
				break;

			case 'deactive':
				$clause = " and e.status = 'p'";
				break;
			
			default:
				$clause = '';
				break;
		}
		$res = $this->db->query("
			select 
				e.*,
				dp.Department_Name,
				ds.Designation_Name
			from tbl_employee e 
			join tbl_department dp on dp.Department_SlNo = e.Department_ID
			join tbl_designation ds on ds.Designation_SlNo = e.Designation_ID
			where e.Employee_brinchid = ?
			$clause
			order by e.Employee_SlNo desc
		", $this->BRANCHid)->result();

		if($res){
			return $res;
		}else{
			return false;
		}
	}
}