<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()	{
		$this->load->view('resources/navbar');
		$this->load->view('resources/sidenav');
		$this->load->view('dashboard/index');
	}
}
