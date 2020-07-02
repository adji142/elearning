<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class guru extends CI_Controller {

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
		$NomorIndukGuru = $this->input->post('NomorIndukGuru');
		if ($id != "") {
			$sql = "SELECT a.*,b.id KodeMapel,b.NamaMapel FROM tguru a
				LEFT JOIN tmapel b on a.MapelDiAmpu = b.id
				WHERE a.isActive = 1 AND a.id = ".$id."";
		}
		else{
			if ($NomorIndukGuru != "") {
				$sql = "SELECT a.*,b.id KodeMapel,b.NamaMapel FROM tguru a
					LEFT JOIN tmapel b on a.MapelDiAmpu = b.id
					WHERE a.isActive = 1 AND a.NomorIndukGuru ='".$NomorIndukGuru."'";
			}
			else{
				$sql = "SELECT a.*,b.id KodeMapel,b.NamaMapel FROM tguru a
					LEFT JOIN tmapel b on a.MapelDiAmpu = b.id
					WHERE a.isActive = 1";
			}
			
		}
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

		$NomorIndukGuru = $this->input->post("NomorIndukGuru");
		$NamaGuru 		= $this->input->post("NamaGuru");
		$MapelDiAmpu 	= $this->input->post("MapelDiAmpu");
		$Email 			= $this->input->post("Email");
		$NoTlp 			= $this->input->post("NoTlp");
		$Alamat 		= $this->input->post("Alamat");
		$Foto 			= $this->input->post("image");
		$TempatLahir 	= $this->input->post("TempatLahir");
		$TanggalLahir 	= $this->input->post("TanggalLahir");
		$Gender 		= $this->input->post("Gender");
		$Agama 			= $this->input->post("Agama");
		$LastUpdatedby 	= $this->session->userdata('NamaUser');

		$exploder = explode("|",$MapelDiAmpu[0]);

		$id = $this->input->post('id');
		$formtype = $this->input->post('formtype');

		$param = array(
			'NomorIndukGuru'	=> $NomorIndukGuru,
			'NamaGuru'			=> $NamaGuru,
			'MapelDiAmpu'		=> $exploder[0],
			'Email'				=> $Email,
			'NoTlp'				=> $NoTlp,
			'Alamat'			=> $Alamat,
			'LastUpdatedby'		=> $LastUpdatedby,
			'LastUpdatedon'		=> date("Y-m-d h:i:sa"),
			'Foto'				=> $Foto,
			'TempatLahir'		=> $TempatLahir,
			'TanggalLahir'		=> $TanggalLahir,
			'Gender'			=> $Gender,
			'Agama'				=> $Agama
		);
		$paramuser = array(
			'username'		=> $NomorIndukGuru,
			'nama'			=> $NamaGuru,
			'password'		=> $this->encryption->encrypt($NomorIndukGuru),
			'createdby'		=> $LastUpdatedby,
			'createdon'		=> date("Y-m-d h:i:sa")
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'tguru');
				if ($rs) {
					$rsuser = $this->ModelsExecuteMaster->ExecInsert($paramuser,'users');
					if ($rsuser) {
						$xuser = $this->ModelsExecuteMaster->FindData(array('username'=>$NomorIndukGuru),'users');
						if ($xuser) {
							$insert = array(
								'userid' 	=> $xuser->row()->id,
								'roleid'	=> 2
							);
							$call_x = $this->ModelsExecuteMaster->ExecInsert($insert,'userrole');
							if ($call_x) {
								$this->db->trans_commit();
								$data['success'] = true;
							}
							else{
								$data['message'] = "Gagal Input Role User";
								goto jump;
							}
						}
						else{
							$data['message'] = "Gagal Mendapatkan Username";
							goto jump;
						}
					}
					else{
						$data['message'] = "Gagal Insert User";
						goto jump;
					}
				}
				else{
					$data['message'] = "Gagal Menambah Siswa";
					goto jump;
				}
			} catch (Exception $e) {
				jump:
				$this->db->trans_rollback();
				// $data['success'] = false;
				// $data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tguru');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate(array('isActive'=>0),array('id'=> $id),'tguru');
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
