<?php
/*
 *      koneksi.php
 *      Melakukan koneksi ke database
 */
$user = "root";
$host = "localhost";
$pass = "ahmadafandi";
$db = "simdes";
mysql_connect($host,$user,$pass) or die("koneksi gagal");
mysql_select_db($db) or die("database tidak ditemukan");
?>
