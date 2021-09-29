<?php
global $mysqli;

$mysqli = new PDO('mysql:host=' . IP_SRV . ';dbname='. SQL_DB , SQL_USER,SQL_PASS);
$mysqli->exec("SET NAMES UTF8");