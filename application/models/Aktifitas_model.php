<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktifitas_model extends CI_Model {
    private $table = 'aktifitas';
    public function __construct() {
        parent::__construct();
    }

    public function all(){
        return $this->db->get($this->table);
    }

    public function detail($id) {
        return $this->db->get_where($this->table, $id);
    }

    public function add($data){
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    public function update($data, $where) {
        $this->db->where($where);
        $this->db->update($this->table, $data);
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete($this->table);
    }
}
