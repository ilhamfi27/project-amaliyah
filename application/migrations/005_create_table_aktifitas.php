<?php
class Migration_create_table_aktifitas extends CI_Migration{
    
    public function __construct() {
        $this->load->dbforge();
    }

    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 3,
                    'auto_increment' => TRUE
                ), 
                'amaliyah' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 30
                ), 
                'kategori' => array(
                    'type' => 'CHAR',
                    'constraint' => 1
                ), 
                'kode_aktifitas' => array(
                    'type' => 'CHAR',
                    'constraint' => 20
                )
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('aktifitas', TRUE);
    }

    public function down(){
        $this->dbforge->drop_table('aktifitas', TRUE);
    }
}
