<?php
// Detail koneksi database
$db_host = 'localhost';
$db_user = 'root';     // Sesuaikan dengan username database Anda
$db_pass = '';        // Sesuaikan dengan password database Anda
$db_name = 'db_kafe'; // Nama database Anda

// Membuat koneksi
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Membuat session untuk login
session_start();
?>