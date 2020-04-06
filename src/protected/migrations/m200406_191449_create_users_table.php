<?php

class m200406_191449_create_users_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('tbl_users', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',
        ));

        $this->createIndex(
            'idx_user_username',
            'tbl_users',
            'username',
            true
        );

        $this->insert('tbl_users', [
            'username' => 'admin',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ]);
    }

    public function down()
    {
        $this->dropIndex('idx_user_username', 'tbl_users');
        $this->dropTable('tbl_users');
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
