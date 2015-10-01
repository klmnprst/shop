<?php


$host     = 'localhost';
$dbname   = 'shop';
$user     = 'root';
$password = '';



$db = mysqli_connect($host, $user, $password, $dbname);
if (mysqli_connect_errno($db)) {
    echo "Не удалось подключиться к db: " . mysqli_connect_error();
} else {
	mysqli_set_charset ($db, "UTF8");
	global $db;
}



