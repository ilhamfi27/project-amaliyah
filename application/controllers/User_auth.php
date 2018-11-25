<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_auth extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()	{
		$this->load->view('user_auth/login');
    }

	public function user_login() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array (
			'username' => $username,
			'password' => md5($password)
		);
        $user = $this->user_model->cek_admin_login($where);
        $num_row = $user->num_rows();
        $user_data = $user->row();
        if ($user->num_rows() > 0) {
			$data_session = array(
				'username' 	=> $username,
                'id'		=> $user_data->id,
                'nama'      => $user_data->nama
			);
			$this->session->set_userdata($data_session);
			redirect('dashboard/index');
		} else {
			redirect('user_auth/index');
		}
    }
    
    public function logout(){
        $data_session = array(
            'username' 	=> $username,
            'id'		=> $user_data->id,
            'nama'      => $user_data->nama
        );
        $this->session->unset_userdata($data_session);
        $this->session->sess_destroy();
        redirect('user_auth/index');
    }
}
