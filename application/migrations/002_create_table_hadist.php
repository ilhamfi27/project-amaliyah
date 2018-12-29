<?php
class Migration_create_table_hadist extends CI_Migration{
    function __construct() {
        $this->load->dbforge();
    }

    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
                ), 
                'perihal' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ), 
                'isi' => array(
                    'type' => 'TEXT'
                ), 
                'riwayat' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255
                )
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('hadist', TRUE);
    }

    public function down(){
        $this->dbforge->drop_table('hadist', TRUE);
    }

}
