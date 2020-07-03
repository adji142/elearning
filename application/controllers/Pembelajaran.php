<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelajaran extends CI_Controller {

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
		$this->load->model('LoginMod');
	}
	public function read()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$id = $this->input->post('id');
		$username = $this->session->userdata('username');

		// var_dump($username);
		if ($id != "") {
			$sql = "SELECT 
						a.*,b.id KodeMapel,b.NamaMapel,
						c.id KodeKelas,c.NamaKelas,
						d.NamaGuru
					FROM tpembelajaran a
					LEFT JOIN tmapel b on a.MapelID = b.id
					LEFT JOIN tkelas c on a.KelasID = c.id
					LEFT JOIN tguru d on a.NIKGuru  =d.NomorIndukGuru
				WHERE a.isActive = 1 AND a.id = ".$id." ";
			$rs = $this->ModelsExecuteMaster->FindData(array('NomorIndukGuru'=>$username),'tguru');
			if ($rs->num_rows() > 0) {
				$sql .= " AND a.NIKGuru = '".$username."' ";
			}
			$rs_siswa = $this->ModelsExecuteMaster->FindData(array('NISN'=>$username),'tsiswa');
			if ($rs_siswa->num_rows()>0) {
				$sql .= " AND a.KelasID = ".$rs_siswa->row()->KelasID;
			}
		}
		else{
			$sql = "SELECT 
				a.*,b.id KodeMapel,b.NamaMapel,
				c.id KodeKelas,c.NamaKelas,
				d.NamaGuru
			FROM tpembelajaran a
			LEFT JOIN tmapel b on a.MapelID = b.id
			LEFT JOIN tkelas c on a.KelasID = c.id
			LEFT JOIN tguru d on a.NIKGuru  =d.NomorIndukGuru
			WHERE a.isActive = 1 ";

			$rs = $this->ModelsExecuteMaster->FindData(array('NomorIndukGuru'=>$username),'tguru');
			if ($rs->num_rows() > 0) {
				$sql .= " AND a.NIKGuru = '".$username."' ";
			}
			$rs_siswa = $this->ModelsExecuteMaster->FindData(array('NISN'=>$username),'tsiswa');
			
			if ($rs_siswa->num_rows()>0) {
				$sql .= " AND a.KelasID = ".$rs_siswa->row()->KelasID;
			}
		}
		// var_dump($sql);
		try {
			$rs = $this->db->query($sql);
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}	
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}
		echo json_encode($data);
	}
	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());

		$MapelID = $this->input->post('MapelID');
		$NIKGuru = $this->input->post('NIKGuru');
		$KelasID = $this->input->post('KelasID');
		$ShortDesc = $this->input->post('ShortDesc');
		$LongDesc = $this->input->post('LongDesc');
		$FileItem = $this->input->post('FileItem');
		$Createdby = $this->session->userdata('NamaUser');
		$Createdon =  date("Y-m-d h:i:sa");

		$exploder_Mapel = explode("|",$MapelID);
		$exploder_Kelas = explode("|",$KelasID);
		$exploder_Guru = explode("|",$NIKGuru);

		$id = $this->input->post('id');
		$formtype = $this->input->post('formtype');

		$param = array(
			'MapelID' => $exploder_Mapel[0],
			'NIKGuru' => $exploder_Guru[0],
			'KelasID' => $exploder_Kelas[0],
			'ShortDesc' => $ShortDesc,
			'LongDesc' => $LongDesc,
			'FileItem' => $FileItem,
			'Createdby' => $Createdby,
			'Createdon' => $Createdon
		);

		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'tpembelajaran');
				if ($rs) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$data['message'] = "Gagal Menambah Siswa";
					goto jump;
				}
			} catch (Exception $e) {
				jump:
				$this->db->trans_rollback();
			}
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tpembelajaran');
				if ($rs) {
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'delete') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate(array('isActive'=>0),array('id'=> $id),'tpembelajaran');
				if ($rs) {
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		else{
			$data['success'] = false;
			$data['message'] = "Invalid Form Type";
		}
		echo json_encode($data);
	}
}
