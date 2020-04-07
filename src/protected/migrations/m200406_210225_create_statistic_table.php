<?php

class m200406_210225_create_statistic_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('tbl_statistic', array(
            'id' => 'pk',
            'remote_host' => 'integer UNSIGNED NOT NULL',
            'remote_user' => 'string',
            'time' => 'datetime NOT NULL',
            'method' => 'string NOT NULL',
            'request' => 'text NOT NULL',
            'protocol' => 'string NOT NULL',
            'status' => 'integer NOT NULL',
            'bytes' => 'integer NOT NULL',
            'referer' => 'string',
            'user_agent' => 'string NOT NULL',
        ));

        $this->createIndex(
            'idx_statistic_remote_host',
            'tbl_statistic',
            'remote_host'
        );

        $this->createIndex(
            'idx_statistic_time',
            'tbl_statistic',
            'time'
        );
    }

    public function down()
    {
        $this->dropIndex('idx_statistic_remote_host', 'tbl_statistic');
        $this->dropIndex('idx_statistic_time', 'tbl_statistic');
        $this->dropTable('tbl_statistic');
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
