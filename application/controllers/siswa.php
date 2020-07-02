<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

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
		$NISN = $this->input->post('NISN');
		if ($id != "") {
			$sql = "SELECT a.*,b.id KodeKelas,b.NamaKelas FROM tsiswa a
				LEFT JOIN tkelas b on a.KelasID = b.id
				WHERE a.isActive = 1 AND a.id = ".$id."";
		}
		else{
			if ($NISN != "") {
				$sql = "SELECT a.*,b.id KodeKelas,b.NamaKelas FROM tsiswa a
					LEFT JOIN tkelas b on a.KelasID = b.id
					WHERE a.isActive = 1 AND a.NISN ='".$NISN."'";
			}
			else{
				$sql = "SELECT a.*,b.id KodeKelas,b.NamaKelas FROM tsiswa a
					LEFT JOIN tkelas b on a.KelasID = b.id
					WHERE a.isActive = 1";
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

		$NISN 			= $this->input->post("NISN");
		$NIS 			= $this->input->post("NIS");
		$NamaSiswa 		= $this->input->post("NamaSiswa");
		$KelasID 		= $this->input->post("KelasID");
		$TempatLahir 	= $this->input->post("TempatLahir");
		$TanggalLahir 	= $this->input->post("TanggalLahir");
		$Gender 		= $this->input->post("Gender");
		$Alamat 		= $this->input->post("Alamat");
		$Email 			= $this->input->post("Email");
		$NoTlp 			= $this->input->post("NoTlp");
		$Agama 			= $this->input->post("Agama");
		$Foto 			= $this->input->post("image");
		$LastUpdatedby 	= $this->session->userdata('NamaUser');

		$exploder = explode("|",$KelasID[0]);

		$id = $this->input->post('id');
		$formtype = $this->input->post('formtype');

		$param = array(
			'NISN' 			=> $NISN,
			'NIS' 			=> $NIS,
			'NamaSiswa' 	=> $NamaSiswa,
			'KelasID' 		=> $exploder[0],
			'TempatLahir' 	=> $TempatLahir,
			'TanggalLahir' 	=> $TanggalLahir,
			'Gender' 		=> $Gender,
			'Alamat' 		=> $Alamat,
			'Email' 		=> $Email,
			'NoTlp' 		=> $NoTlp,
			'Agama' 		=> $Agama,
			'LastUpdatedby' => $LastUpdatedby,
			'LastUpdatedon' => date("Y-m-d h:i:sa"),
			'Foto' 			=> $Foto
		);
		$paramuser = array(
			'username'		=> $NISN,
			'nama'			=> $NamaSiswa,
			'password'		=> $this->encryption->encrypt($NISN),
			'createdby'		=> $LastUpdatedby,
			'createdon'		=> date("Y-m-d h:i:sa")
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'tsiswa');
				if ($rs) {
					// $data['success'] = true;
					$rsuser = $this->ModelsExecuteMaster->ExecInsert($paramuser,'users');
					if ($rsuser) {
						$xuser = $this->ModelsExecuteMaster->FindData(array('username'=>$NISN),'users');
						// var_dump($xuser->num_rows());
						if ($xuser) {
							$insert = array(
								'userid' 	=> $xuser->row()->id,
								'roleid'	=> 3,
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
				
			}
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tsiswa');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate(array('isActive'=>0),array('id'=> $id),'tsiswa');
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