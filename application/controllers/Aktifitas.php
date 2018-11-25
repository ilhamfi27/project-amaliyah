<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktifitas extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('aktifitas_model');
	}

	public function index()	{
		$data['aktifitas'] = $this->aktifitas_model->all()->result();
		$this->resource_views();
		$this->load->view('aktifitas/index',$data);
	}

	public function add_data(){
		$amaliyah 			= $this->input->post('amaliyah');
		$kategori 			= $this->input->post('kategori');
		$kode_aktifitas 	= $this->input->post('kode_aktifitas');

		$data = array(
			'amaliyah' 			=> $amaliyah,
			'kategori' 			=> $kategori,
			'kode_aktifitas' 	=> $kode_aktifitas
		);
		$this->aktifitas_model->add($data);
		redirect('aktifitas/index');
	}

    public function edit($id) {
        $where = array('id' => $id);
        $data['aktifitas'] = $this->aktifitas_model->detail($where)->result();
        $this->resource_views();
        $this->load->view('aktifitas/edit',$data);
    }

    public function update_data(){
		$id					= $this->input->post('id');
		$amaliyah 			= $this->input->post('amaliyah');
		$kategori 			= $this->input->post('kategori');
		$kode_aktifitas 	= $this->input->post('kode_aktifitas');

		$data = array(
			'amaliyah' 			=> $amaliyah,
			'kategori' 			=> $kategori,
			'kode_aktifitas' 	=> $kode_aktifitas
		);

        $where = array(
            'id' => $id
        );

        $this->aktifitas_model->update($data, $where);
        redirect('aktifitas/index');
    }

    public function delete_data($id){
        $where = array('id' => $id);
        $this->aktifitas_model->delete($where);
        redirect('aktifitas/index');
    }

	private function resource_views(){
		$this->load->view('resources/navbar');
		$this->load->view('resources/sidenav');
	}
}
