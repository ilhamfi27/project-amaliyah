<?php
class Migration_create_table_user extends CI_Migration{
    public function __construct() {
        $this->load->dbforge();
    }

    /*
        CREATE TABLE `users` (
        `id` int(5) NOT NULL,
        `username` varchar(30) NOT NULL,
        `password` varchar(32) DEFAULT NULL,
        `admin` char(1) DEFAULT 'f'
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    */

    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'auto_increment' => TRUE
                ), 
                'username' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 30
                ), 
                'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 32
                ), 
                'admin' => array(
                    'type' => 'CHAR',
                    'constraint' => 1,
                    'default' => 'f'
                )
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users', TRUE);
    }

    public function down(){
        $this->dbforge->drop_table('users', TRUE);
    }
}
