<?php
$mysql_host = 'localhost';
$mysql_user = 'u850068608_spvahini';
$mysql_password = '%codingV&67';
$mysql_db = 'u850068608_spvahini';
$response = array();

	
if ($connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_db;", "$mysql_user", "$mysql_password", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_FOUND_ROWS => true))) {
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Unable to connect to database';
    die(json_encode($response));
}
