<?php
class Application_side extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->load->view('application_side/index');
    }
}
