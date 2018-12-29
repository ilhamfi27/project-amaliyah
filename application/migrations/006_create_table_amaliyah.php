<?php
class Migration_create_table_amaliyah extends CI_Migration{
    
    public function __construct() {
        $this->load->dbforge();
    }
    
    public function up(){
        $timestamp = "CURRENT_TIMESTAMP";
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'auto_increment' => TRUE
                ), 
                'id_user' => array(
                    'type' => 'INT',
                    'constraint' => 5
                ), 
                'id_aktifitas' => array(
                    'type' => 'INT',
                    'constraint' => 3
                ), 
                'status' => array(
                    'type' => 'CHAR',
                    'constraint' => 1
                ), 
                'waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP', 
                'tanggal datetime DEFAULT CURRENT_TIMESTAMP',
                'CONSTRAINT fk_id_user_amaliyah FOREIGN KEY (id_user) REFERENCES users(id)',
                'CONSTRAINT fk_id_aktifitas_amaliyah FOREIGN KEY (id_aktifitas) REFERENCES aktifitas(id)'
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('amaliyah', TRUE);
    }

    public function down(){
        $this->dbforge->drop_table('amaliyah', TRUE);
    }
}
