<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
	}
	
	// =========================== BATAS =========================== 
	public function FindData()
	{
		$data = array('success' => false ,'message'=>array(),'data' =>array());

		$where_field = $this->input->post('where_field');
		$where_value = $this->input->post('where_value');
		$table 		 = $this->input->post('table');
		
		if ($where_field == '') {
			$rs = $this->ModelsExecuteMaster->GetData($table);
		}
		else{
			$where = array(
				$where_field => $where_value
			);
			$rs = $this->ModelsExecuteMaster->FindData($where,$table);
		}
		if ($rs){
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['success'] = false;
			$data['message'] = 'Gagal Mengambil data';
		}
		echo json_encode($data);
	}
	public function remove()
	{
		$data = array('success' => false ,'message'=>array(),'data' =>array());
		
		$table = $this->input->post('table');
		$field = $this->input->post('field');
		$value = $this->input->post('value');
		
		try {
			$where = array(
				$field	=> $value
			);
			$rs = $this->ModelsExecuteMaster->DeleteData($where,$table);
			$data['success'] = true;
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}
		echo json_encode($data);
	}
	public function read()
	{
		$data = array('success' => false ,'message'=>array(),'data' =>array());

		$table = $this->input->post('table');
		
		try {
			$rs = $this->ModelsExecuteMaster->GetData($table);
			if ($rs){
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = 'Gagal Mengambil data '.$e->getMessage();
		}
		echo json_encode($data);
	}
}