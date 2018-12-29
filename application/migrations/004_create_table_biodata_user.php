<?php
class Migration_create_table_biodata_user extends CI_Migration{
    public function __construct() {
        $this->load->dbforge();
    }

    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'auto_increment' => TRUE
                ), 
                'nama' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50
                ), 
                'nim' => array(
                    'type' => 'CHAR',
                    'constraint' => 10
                ), 
                'jenis_kelamin' => array(
                    'type' => 'CHAR',
                    'constraint' => 1
                ), 
                'id_prodi' => array(
                    'type' => 'int',
                    'constraint' => 2
                ), 
                'id_user' => array(
                    'type' => 'int',
                    'constraint' => 5
                ),
                'CONSTRAINT fk_id_prodi_biodata_user FOREIGN KEY (id_prodi) REFERENCES prodi(id)',
                'CONSTRAINT fk_id_user_biodata_user FOREIGN KEY (id_user) REFERENCES users(id)'
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('biodata_user', TRUE);
    }

    public function down(){
        $this->dbforge->drop_table('biodata_user', TRUE);
    }
}
