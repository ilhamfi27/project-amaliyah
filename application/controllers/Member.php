<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()	{
		$data['member'] = $this->user_model->all()->result();
		$this->resource_views();
		$this->load->view('member/index', $data);
	}

    public function delete_data($id){
        $where = array('id' => $id);
        $this->user_model->delete($where);
        redirect('member/index');
    }

	private function resource_views(){
		$this->load->view('resources/navbar');
		$this->load->view('resources/sidenav');
	}
}
