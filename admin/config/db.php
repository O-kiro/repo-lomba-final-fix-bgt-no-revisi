<?php
// Koneksi ke database
$host = "localhost";
$user = "root"; // username MySQL lo
$pass = "";     // password MySQL lo
$db   = "sekolah_db"; // nama database

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Debug ringan
// var_dump($conn); // uncomment kalo mau cek koneksi
?>
