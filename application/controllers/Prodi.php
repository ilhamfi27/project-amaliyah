<?php
defined('BASEPATH') OR exit("No direct script access allowed");

class Prodi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('prodi_model');
    }

    public function index() {
        $data['prodi'] = $this->prodi_model->all()->result();
        $this->resource_views();
        $this->load->view('prodi/index',$data);
    }

    public function add_data() {
        $nama = $this->input->post('nama');
        $data = array(
            'nama' => $nama
        );
        $this->prodi_model->add($data);
        redirect('prodi/index');
    }

    public function edit($id) {
        $where = array('id' => $id);
        $data['prodi'] = $this->prodi_model->detail($where)->result();
        $this->resource_views();
        $this->load->view('prodi/edit',$data);
    }

    public function update_data(){
        $nama = $this->input->post('nama');
        $id = $this->input->post('id');
        $data = array(
            'nama' => $nama
        );
        $where = array(
            'id' => $id
        );

        $this->prodi_model->update($data, $where);
        redirect('prodi/index');
    }

    public function delete_data($id){
        $where = array('id' => $id);
        $this->prodi_model->delete($where);
        redirect('prodi/index');
    }

	private function resource_views(){
		$this->load->view('resources/navbar');
		$this->load->view('resources/sidenav');
	}
}
