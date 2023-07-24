<?php

session_start();

$server = 'localhost';
$username = 'root';
$password = '';
$db_name = 'gymflex';

$conn = mysqli_connect($server, $username, $password, $db_name);


if(!$conn) {
    die('Connection with database failed. Try later!');
} else {
    "Uspesna konekcija";
}
?>
