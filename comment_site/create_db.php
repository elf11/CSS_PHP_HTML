<?php
require_once 'idiorm.php';
ORM::configure('sqlite:./db_table.sqlite');

ORM::get_db()->exec('DROP TABLE IF EXISTS pw_comments;');
ORM::get_db()->exec(
        'CREATE TABLE pw_comments (' .
        'usr_id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
        'usr_username VARCHAR(256), ' .
        'usr_email TEXT, ' .
        'com_publish_date DATETIME, ' .
        'artid INTEGER, ' .
        'usr_mes VARCHAR(100) )');
?>