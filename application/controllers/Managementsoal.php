<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managementsoal extends CI_Controller {

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
	public function readtopik()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$id = $this->input->post('id');
		$username = $this->session->userdata('username');

		// var_dump($username);
		if ($id != "") {
			$sql = "SELECT 
						a.*,b.id KodeMapel,b.NamaMapel,
						c.id KodeKelas,c.NamaKelas,
						d.NamaGuru,Cast(a.Waktu AS Time) WaktuSoal,
						ROUND(time_to_sec(Waktu)) InMinutes,
						COALESCE(e.Jml,0) Jml,
						ROUND(e.Nilai,2) Nilai
					FROM topiksoal a
					LEFT JOIN tmapel b on a.MapelID = b.id
					LEFT JOIN tkelas c on a.KelasID = c.id
					LEFT JOIN tguru d on a.NIKGuru  =d.NomorIndukGuru
					LEFT JOIN (
						SELECT 
							x.topikID,
							COUNT(*) Jml,
							SUM(COALESCE(x.Score,0)) / COUNT(*) Nilai
						FROM tjawaban x
						GROUP BY x.topikID
					) e on a.id = e.topikID
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
				d.NamaGuru,Cast(a.Waktu AS Time) WaktuSoal,
				ROUND(time_to_sec(Waktu)) InMinutes,
				COALESCE(e.Jml,0) Jml,
				ROUND(e.Nilai,2) Nilai
			FROM topiksoal a
			LEFT JOIN tmapel b on a.MapelID = b.id
			LEFT JOIN tkelas c on a.KelasID = c.id
			LEFT JOIN tguru d on a.NIKGuru  =d.NomorIndukGuru
			LEFT JOIN (
				SELECT 
					x.topikID,
					COUNT(*) Jml,
					SUM(COALESCE(x.Score,0)) / COUNT(*) Nilai
				FROM tjawaban x
				GROUP BY x.topikID
			) e on a.id = e.topikID
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
	public function CRUDTopik()
	{
		$data = array('success' => false ,'message'=>array());

		$KodeSoal = $this->input->post('KodeSoal');
		$MapelID = $this->input->post('MapelID');
		$KelasID = $this->input->post('KelasID');
		$NIKGuru = $this->input->post('NIKGuru');
		$Waktu = $this->input->post('Waktu');
		$Keterangan = $this->input->post('Keterangan');

		$Createdby = $this->session->userdata('NamaUser');
		$Createdon =  date("Y-m-d h:i:sa");

		$exploder_Mapel = explode("|",$MapelID);
		$exploder_Kelas = explode("|",$KelasID);
		$exploder_Guru = explode("|",$NIKGuru);

		$id = $this->input->post('id');
		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeSoal'	=> $KodeSoal,
			'MapelID'	=> $exploder_Mapel[0],
			'KelasID'	=> $exploder_Kelas[0],
			'NIKGuru'	=> $exploder_Guru[0],
			'Waktu'		=> $Waktu,
			'Createdby'	=> $Createdby,
			'Createdon'	=> $Createdon,
			'Keterangan'=> $Keterangan
		);

		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'topiksoal');
				if ($rs) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					
					goto jump;
				}
			} catch (\Exception $e) {
				jump:
				$data['message'] = "Gagal Menambah Topik";
				$this->db->trans_rollback();
			}
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'topiksoal');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate(array('isActive'=>0),array('id'=> $id),'topiksoal');
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
	public function CRUDSoal()
	{
		$data = array('success' => false ,'message'=>array());
		$topikID = $this->input->post('topikID');
		$LineNum = 0;
		$DeskripsiSoal = $this->input->post('DeskripsiSoal');
		$Image = $this->input->post('Image');
		
		$Createdby = $this->session->userdata('NamaUser');
		$Createdon =  date("Y-m-d h:i:sa");
		$id = $this->input->post('id');
		$formtype = $this->input->post('formtype');

		$param = array(
			'topikID' 		=> $topikID,
			'LineNum' 		=> $LineNum,
			'DeskripsiSoal' => $DeskripsiSoal,
			'Image' 		=> $Image,
			'Createdby' 	=> $Createdby,
			'Createdon' 	=> $Createdon
		);

		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'tsoal');
				if ($rs) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					
					goto jump;
				}
			} catch (\Exception $e) {
				jump:
				$data['message'] = "Gagal Menambah Topik";
				$this->db->trans_rollback();
			}
		}
		elseif ($formtype == 'edit') {
			$param = array(
				'topikID' 		=> $topikID,
				'LineNum' 		=> $LineNum,
				'DeskripsiSoal' => $DeskripsiSoal,
				'Image' 		=> $Image
			);
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tsoal');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate(array('isActive'=>0),array('id'=> $id),'tsoal');
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
	public function readsoal()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$id = $this->input->post('id');
		$topikID = $this->input->post('topikID');

		if ($topikID == '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$id,'isActive'=>1),'tsoal');
		}
		else{
			$rs = $this->db->query('SELECT a.id,a.topikID,a.DeskripsiSoal,b.NISN,b.SoalID,
				b.Jawaban,b.Score,b.AnswerTime
			 FROM tsoal a 
				LEFT JOIN tjawaban b on b.SoalID = a.id
			where a.topikID = '.$topikID.' AND a.isActive =1 order by Createdon ASC');
		}

		if ($rs->num_rows()) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = "Row Empty";
		}
		echo json_encode($data);
	}
	public function CRUDJawab()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$NISN = $this->session->userdata('username');

		$SoalID = $this->input->post('SoalID');
		$Jawaban = $this->input->post('Jawaban');
		$Score = $this->input->post('Score');;
		$AnswerTime = $this->input->post('AnswerTime');
		$topikid = $this->input->post('topikid');
		$Status = $this->input->post('Status');

		$param = array(
			'NISN'			=>$NISN,
			'SoalID'		=>$SoalID,
			'Jawaban'		=>$Jawaban,
			'Score'			=>$Score,
			'AnswerTime'	=>$AnswerTime,
			'topikid'		=>$topikid,
			'Status'		=>$Status
		);

		$this->db->trans_begin();
			try {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'tjawaban');
				if ($rs) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$data['success'] = true;
					$data['message'] = 'Gagal Menambahkan Jawaban';
					goto jump;
				}
			} catch (Exception $e) {
				jump:
				$this->db->trans_rollback();
			}
		echo json_encode($data);
	}
	public function RemoveJawab()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$NISN = $this->session->userdata('username');
		$topikid = $this->input->post('topikid');

		$param = array(
			'NISN'			=>$NISN,
			'topikid'		=>$topikid
		);
		$this->db->trans_begin();
		try {
			$JawabanCount = $this->ModelsExecuteMaster->FindData(array('NISN'=>$NISN,'topikid'=>$topikid),'tjawaban');
			if ($JawabanCount->num_rows() > 0) {
				$removingdata = $this->ModelsExecuteMaster->DeleteData(array('NISN'=>$NISN,'topikid'=>$topikid),'tjawaban');
				if ($removingdata) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$data['success'] = true;
					$data['message'] = 'Gagal Remove Row';
					goto jump;
				}
			}
			else{
				$data['success'] = true;

			}
		} catch (Exception $e) {
			jump:
			$this->db->trans_rollback();
		}
		echo json_encode($data);
	}
	public function GetPeserta()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$username = $this->session->userdata('username');
		$topikid = $this->input->post('topikid');

		$SQL = 'SELECT 
					DISTINCT c.NISN,c.NamaSiswa,d.NamaKelas,b.id,Round(x.Nilai,2) Nilai
				FROM tjawaban a
				INNER JOIN topiksoal b on a.topikID = b.id
				INNER JOIN tsiswa c on a.NISN = c.NISN
				INNER JOIN tkelas d on c.KelasID = d.id
				LEFT JOIN (
					SELECT x.topikID,x.NISN,SUM(x.Score) / count(*) Nilai FROM tjawaban x
					GROUP by x.topikID,x.NISN
				) x on x.topikID = a.topikID AND x.NISN = a.NISN
				WHERE a.`Status` = 1 AND b.id = '.$topikid ;
		$rs = $this->ModelsExecuteMaster->FindData(array('NomorIndukGuru'=>$username),'tguru');
		if ($rs->num_rows() > 0) {
			$SQL .= " AND a.NIKGuru = '".$username."' ";
		}
		$rs = $this->db->query($SQL);
		$data['success'] = true;
		$data['data'] = $rs->result();

		echo json_encode($data);
	}
	public function GetJawaban()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$NISN = $this->input->post('NISN');
		$topikID = $this->input->post('topikID');

		$rs = $this->ModelsExecuteMaster->FindData(array('NISN'=>$NISN,'TopikID'=>$topikID),'tjawaban');
		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}
	public function UpdateNilai()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		
		$NISN = $this->input->post('NISN');
		$topikID = $this->input->post('TopikID');
		$jawabid = $this->input->post('id');
		$point = $this->input->post('point');

		$where = array(
			'NISN'		=> $NISN,
			'TopikID'	=> $topikID,
			'id'		=> $jawabid
		);
		$this->db->trans_begin();
		try {
			$rs = $this->ModelsExecuteMaster->ExecUpdate(array('Score'=>$point),$where,'tjawaban');
			if ($rs) {
				$this->db->trans_commit();
				$data['success'] = true;
			}
			else{
				$data['message'] = 'Gagal Update Score';
				goto jump;
			}
		} catch (Exception $e) {
			jump:
			$this->db->trans_rollback();
		}
		echo json_encode($data);
	}
}
