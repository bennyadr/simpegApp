<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class staff extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_pegawai'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('member/staff_model');
		$this->load->model ('setup/tupoksi_model');
		$this->load->model ('member/penilaian_tupoksi_model');
		$this->load->model ('member/penilaian_prilaku_model');
		$this->load->model ('setup/skpd_model');
		$this->load->model ('setup/pegawai_model');
		$this->load->model ('setup/position_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:pegawai_nip','max_length[50]');
		$this->form_validation->set_rules('nama', 'lang:pegawai_nama','max_length[100]');
		$this->form_validation->set_rules('kelamin', 'lang:pegawai_kelamin', 'required|max_length[1]');
		
		return $this->form_validation->run();
	}
	
	/* Setup Property column */
	public function inputSetting($data){
		$this->data['nip'] = array(
				'name'  => 'nip',
				'id'    => 'nip',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'nomor induk pegawai',
				'value' => $data['nip'],
		);
		$this->data['nama'] = array(
				'name'  => 'nama',
				'id'    => 'nama',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'gelar di depan',
				'value' => $data['nama'],
		);
		$this->data['kelamin'] = array(
				'name'  => 'kelamin',
				'id'    => 'kelamin',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kelamin'],
		);
		$this->data['kd_position'] = array(
				'name'  => 'kd_position',
				'id'    => 'kd_position',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kd_position'],
		);
		$this->data['kd_skpd'] = array(
				'name'  => 'kd_skpd',
				'id'    => 'kd_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kd_skpd'],
		);
		$this->data['nama_position'] = array(
				'name'  => 'nama_position',
				'id'    => 'nama_position',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['nama_position'],
		);
		return $this->data;
	}
	
	public function index() {
		
		if ( ! $this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */

			$config = array ();
			$config ["base_url"] = base_url () . "member/staff/index";
			$config ["total_rows"] = $this->staff_model->record_count ();
			$config ["per_page"] = 25;
			$config ["uri_segment"] = 4;
			$choice = $config ["total_rows"] / $config ["per_page"];
			$config ["num_links"] = 5;
			
			// config css for pagination
			$config ['full_tag_open'] = '<ul class="pagination">';
			$config ['full_tag_close'] = '</ul>';
			$config ['first_link'] = 'First';
			$config ['last_link'] = 'Last';
			$config ['first_tag_open'] = '<li>';
			$config ['first_tag_close'] = '</li>';
			$config ['prev_link'] = 'Previous';
			$config ['prev_tag_open'] = '<li class="prev">';
			$config ['prev_tag_close'] = '</li>';
			$config ['next_link'] = 'Next';
			$config ['next_tag_open'] = '<li>';
			$config ['next_tag_close'] = '</li>';
			$config ['last_tag_open'] = '<li>';
			$config ['last_tag_close'] = '</li>';
			$config ['cur_tag_open'] = '<li class="active"><a href="#">';
			$config ['cur_tag_close'] = '</a></li>';
			$config ['num_tag_open'] = '<li>';
			$config ['num_tag_close'] = '</li>';
			
			if ($this->uri->segment ( 4 ) == "") {
				$data ['number'] = 0;
			} else {
				$data ['number'] = $this->uri->segment ( 4 );
			}
			
			$this->pagination->initialize ( $config );
			$page = ($this->uri->segment ( 4 )) ? $this->uri->segment ( 4 ) : 0;
			
			$this->data ['staff'] = $this->staff_model->fetchAll($config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->member_render('member/staff/index', $this->data);
		}
	}
	
	public function find(){
		
		
		if ( ! $this->ion_auth->logged_in() )
		{
			redirect('auth/login', 'refresh');
		}
		else {
			if($this->input->post('submit')){
				$column = $this->input->post('column');
				$query = $this->input->post('data');
				
				$option = array(
					'user_column'=>$column,
					'user_data'=>$query
				);
				$this->session->set_userdata($option);
			}else{
			   $column = $this->session->has_userdata('user_column');
			   $query = $this->session->has_userdata('user_data');
			}
			
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */
		
			$config = array ();
			$config ["base_url"] = base_url () . "member/staff/find";
			$config ["total_rows"] = $this->staff_model->search_count($column,$query);
			$config ["per_page"] = 25;
			$config ["uri_segment"] = 4;
			$choice = $config ["total_rows"] / $config ["per_page"];
			$config ["num_links"] = 5;
				
			// config css for pagination
			$config ['full_tag_open'] = '<ul class="pagination">';
			$config ['full_tag_close'] = '</ul>';
			$config ['first_link'] = 'First';
			$config ['last_link'] = 'Last';
			$config ['first_tag_open'] = '<li>';
			$config ['first_tag_close'] = '</li>';
			$config ['prev_link'] = 'Previous';
			$config ['prev_tag_open'] = '<li class="prev">';
			$config ['prev_tag_close'] = '</li>';
			$config ['next_link'] = 'Next';
			$config ['next_tag_open'] = '<li>';
			$config ['next_tag_close'] = '</li>';
			$config ['last_tag_open'] = '<li>';
			$config ['last_tag_close'] = '</li>';
			$config ['cur_tag_open'] = '<li class="active"><a href="#">';
			$config ['cur_tag_close'] = '</a></li>';
			$config ['num_tag_open'] = '<li>';
			$config ['num_tag_close'] = '</li>';
				
			if ($this->uri->segment ( 4 ) == "") {
				$data ['number'] = 0;
			} else {
				$data ['number'] = $this->uri->segment ( 4 );
			}
				
			$this->pagination->initialize ( $config );
			$page = ($this->uri->segment ( 4 )) ? $this->uri->segment ( 4 ) : 0;
				
			$this->data ['staff'] = $this->staff_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->member_render('member/staff/index', $this->data);
		}
	}
	
	public function detail($nip=null,$skpd=null,$position=null){
		
		if ( ! $this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */
		
			$config = array ();
			$config ["base_url"] = base_url () . "member/staff/detail/".$nip.'/'.$skpd.'/'.$position.'/';
			$config ["total_rows"] = $this->penilaian_tupoksi_model->record_countByMonth($nip,$skpd,$position,date('m'));
			$config ["per_page"] = 25;
			$config ["uri_segment"] = 7;
			$choice = $config ["total_rows"] / $config ["per_page"];
			$config ["num_links"] = 8;
				
			// config css for pagination
			$config ['full_tag_open'] = '<ul class="pagination">';
			$config ['full_tag_close'] = '</ul>';
			$config ['first_link'] = 'First';
			$config ['last_link'] = 'Last';
			$config ['first_tag_open'] = '<li>';
			$config ['first_tag_close'] = '</li>';
			$config ['prev_link'] = 'Previous';
			$config ['prev_tag_open'] = '<li class="prev">';
			$config ['prev_tag_close'] = '</li>';
			$config ['next_link'] = 'Next';
			$config ['next_tag_open'] = '<li>';
			$config ['next_tag_close'] = '</li>';
			$config ['last_tag_open'] = '<li>';
			$config ['last_tag_close'] = '</li>';
			$config ['cur_tag_open'] = '<li class="active"><a href="#">';
			$config ['cur_tag_close'] = '</a></li>';
			$config ['num_tag_open'] = '<li>';
			$config ['num_tag_close'] = '</li>';
				
			if ($this->uri->segment ( 7 ) == "") {
				$data ['number'] = 0;
			} else {
				$data ['number'] = $this->uri->segment ( 7 );
			}
				
			$this->pagination->initialize ( $config );
			$page = ($this->uri->segment ( 7 )) ? $this->uri->segment ( 7 ) : 0;
				
			$this->data ['bln'] = $this->penilaian_tupoksi_model->fetchByMonth($nip,$skpd,$position,date('m'));
			$this->data ['harian'] = $this->penilaian_tupoksi_model->fetchByDate($nip,$skpd,$position,date('m'), $config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links();
			$this->template->member_render('member/staff/detail', $this->data);
		}
	}
	
	public function kinerja($nip=null,$skpd=null,$position=null){
		if($this->input->post('submit')){
			$data = null;
			$qid = $this->input->post('qid');
			$nilai = $this->input->post('nilai');
			$max = count($qid);
			for($i=0;$i<=$max;$i++){
				$data =array('qid'=>$qid[$i],'nilai'=>$nilai[$i]);
				$this->penilaian_tupoksi_model->updateByQid($data);
			}
			redirect('member/staff/index');
		}else{
			$this->data ['list_tupoksi'] = $this->penilaian_tupoksi_model->penilaianKinerja($nip,date('Y-m-d'),$skpd,$position);
			$this->template->member_render('member/staff/kinerja', $this->data);
		}
	}
	
	public function prilaku($nip=null,$skpd=null,$position=null){
		if($this->input->post('submit')){
			$data= array(
				'nip'=>$nip,
				'kd_skpd'=>$skpd,
				'kd_position'=>$position,
				'tanggal'=>date('Y-m-d'),
				'orientasi_pelayanan'=>$this->input->post('orientasi_pelayanan'),
				'integritas'=>$this->input->post('integritas'),
				'komitmen'=>$this->input->post('komitmen'),
				'disiplin'=>$this->input->post('disiplin'),
				'kerjasama'=>$this->input->post('kerjasama'),
				'kepemimpinan'=>$this->input->post('kepemimpinan'),
				'guidance'=>$this->input->post('guidance')
			);
			$this->penilaian_prilaku_model->create($data);
			redirect('member/staff/index');
		}else{
			$this->data['skpd'] = $this->skpd_model->getName($skpd);
			$this->data['nama'] = $this->pegawai_model->getName($nip);
			$this->data['jabatan'] = $this->position_model->getPositionByNip($nip,$skpd);
			$this->template->member_render('member/staff/prilaku',$this->data);
		}
	}
	
}