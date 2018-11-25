<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hadist extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('hadist_model');
	}

	public function index()	{
		$data['hadist'] = $this->hadist_model->all()->result();
		$this->resource_views();
		$this->load->view('hadist/index', $data);
	}

	public function add_data(){
		$perihal 	= $this->input->post('perihal');
		$isi 		= $this->input->post('isi');
		$riwayat 	= $this->input->post('riwayat');

		$data = array(
			'perihal' => $perihal,
			'isi' => $isi,
			'riwayat' => $riwayat
		);
		$insert = $this->hadist_model->add($data);
		redirect('hadist/index');
	}

    public function edit($id) {
        $where = array('id' => $id);
        $data['hadist'] = $this->hadist_model->detail($where)->result();
        $this->resource_views();
        $this->load->view('hadist/edit',$data);
    }

    public function update_data(){
		$id			= $this->input->post('id');
		$perihal 	= $this->input->post('perihal');
		$isi 		= $this->input->post('isi');
		$riwayat 	= $this->input->post('riwayat');

		$data = array(
			'perihal' => $perihal,
			'isi' => $isi,
			'riwayat' => $riwayat
		);

        $where = array(
            'id' => $id
        );

        $this->hadist_model->update($data, $where);
        redirect('hadist/index');
    }

    public function delete_data($id){
        $where = array('id' => $id);
        $this->hadist_model->delete($where);
        redirect('hadist/index');
    }


	private function resource_views(){
		$this->load->view('resources/navbar');
		$this->load->view('resources/sidenav');
	}
}
