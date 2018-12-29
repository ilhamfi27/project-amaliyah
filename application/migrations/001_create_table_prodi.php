<?php
class Migration_create_table_prodi extends CI_Migration{
    public function __construct() {
		parent::__construct();
        $this->load->dbforge();
    }

    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 2,
                    'auto_increment' => TRUE
                ), 
                'nama' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 40
                )
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('prodi', TRUE);
    }

    public function down(){
        $this->dbforge->drop_table('prodi');
    }
}
