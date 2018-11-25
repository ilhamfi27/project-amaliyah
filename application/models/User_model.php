<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model {
    private $table = 'users';
    public function __construct() {
        parent::__construct();
    }

    public function all(){
        $this->db->select('
            `users`.`id`,
            `users`.`username`,
            `users`.`nama`,
            `users`.`jenis_kelamin`,
            `prodi`.`nama` AS nama_prodi
        ');
        $this->db->from($this->table);
        $this->db->join('prodi','prodi.id = users.id_prodi');
        $this->db->where('admin', 'f');
        return $this->db->get();
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

    public function cek_admin_login($where){
        return $this->db->get_where($this->table, $where);
    }
}
