<?php
class Migration_insert_user_data_to_table_user extends CI_Migration{
    public function up(){
        $this->db->query("INSERT INTO `users`(`id`,`username`, `password`, `admin`) VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','t')");
    }

    public function down(){
        $this->db->query("DELETE FROM `users` WHERE `id`=1");
    }
}
