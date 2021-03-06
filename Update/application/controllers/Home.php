<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

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
	public function index()
	{
		$this->load->view('dashboard');
	}
	// --------------------------------------- Master ----------------------------------------------------
	public function mapel()
	{
		$this->load->view('mastermapel');
	}
	public function kelas()
	{
		$this->load->view('masterkelas');
	}
	public function guru()
	{
		$this->load->view('daftarguru');
	}
	public function siswa()
	{
		$this->load->view('daftarsiswa');
	}
	public function pembelajaran()
	{
		$this->load->view('daftarpembelajaran');
	}
	public function soal()
	{
		$this->load->view('daftarmanagementsoal');
	}
	public function addsoal($value)
	{
		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$value),'topiksoal');
		$data['topikid'] = $value;
		$data['topikname'] = $rs->row()->Keterangan;
		$data['loadtype'] = '1'; // 1: add soal. 2: preview soal
		$this->load->view('addsoal',$data);	
	}
	public function viewsoal($value)
	{
		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$value),'topiksoal');
		$data['topikid'] = $value;
		$data['topikname'] = $rs->row()->Keterangan;
		$data['loadtype'] = '2'; // 1: add soal. 2: preview soal
		$this->load->view('addsoal',$data);	
	}
	public function jawabsoal($value)
	{
		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$value),'topiksoal');
		$data['topikid'] = $value;
		$data['topikname'] = $rs->row()->Keterangan;
		$data['loadtype'] = '1'; // 1: Jawab soal. 2: Koreksi soal
		$this->load->view('jawabsoal',$data);	
	}
	public function koreksisoal($value,$key)
	{
		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$value),'topiksoal');
		$data['topikid'] = $value;
		$data['topikname'] = $rs->row()->Keterangan;
		$data['loadtype'] = '2'; // 1: Jawab soal. 2: Koreksi soal
		$data['NISN'] = $key;
		$this->load->view('jawabsoal',$data);	
	}
	public function reviewpeserta($value)
	{
		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$value),'topiksoal');
		$data['topikid'] = $value;
		$data['topikname'] = $rs->row()->Keterangan;
		$data['loadtype'] = '1'; // 1: Jawab soal. 2: Koreksi soal
		$this->load->view('daftarpesertaujian',$data);	
	}
}
