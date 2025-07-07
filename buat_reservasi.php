<?php 

require 'koneksi.php'; 

 

// Pastikan user sudah login 

if (!isset($_SESSION['id_pengguna'])) { 

    die("Akses ditolak. Silakan login terlebih dahulu."); 

} 

 

// Ambil data dari form 

$id_pengguna = $_SESSION['id_pengguna']; 

$id_meja = $_POST['id_meja']; 

$waktu_reservasi = $_POST['waktu_reservasi']; 

$jumlah_orang = $_POST['jumlah_orang']; 

 

// Validasi input 

if (empty($id_meja) || empty($waktu_reservasi) || empty($jumlah_orang)) { 

    die("Error: Semua field reservasi harus diisi."); 

} 

 


$sql = "CALL BuatReservasi(?, ?, ?, ?)"; 

$stmt = mysqli_prepare($koneksi, $sql); 

 

if ($stmt) { 


    mysqli_stmt_bind_param($stmt, "iisi", $id_pengguna, $id_meja, $waktu_reservasi, $jumlah_orang); 

 


    if (mysqli_stmt_execute($stmt)) { 

        echo "Reservasi berhasil dibuat! Anda akan dialihkan kembali ke dashboard."; 

         



         

        header("Refresh: 3; URL=dashboard_user.php"); 

    } else { 

        echo "Error: Gagal membuat reservasi. " . mysqli_stmt_error($stmt); 

    } 

 

    mysqli_stmt_close($stmt); 

} else { 

    echo "Error: Gagal mempersiapkan statement. " . mysqli_error($koneksi); 

} 

 

mysqli_close($koneksi); 

?> 