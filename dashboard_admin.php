<?php 

require 'koneksi.php'; 

 


if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] != 'admin') { 

    header("Location: index.php"); 

    exit(); 

} 

 


 


$result_pengguna = mysqli_query($koneksi, "SELECT COUNT(id_pengguna) AS total_pengguna FROM pengguna"); 

$stat_pengguna = mysqli_fetch_assoc($result_pengguna)['total_pengguna']; 

 
$result_meja = mysqli_query($koneksi, "SELECT COUNT(id_meja) AS total_meja FROM meja"); 

$stat_meja = mysqli_fetch_assoc($result_meja)['total_meja']; 

 

$result_reservasi = mysqli_query($koneksi, "SELECT COUNT(id_reservasi) AS reservasi_aktif FROM reservasi WHERE status_reservasi = 'aktif'"); 

$stat_reservasi_aktif = mysqli_fetch_assoc($result_reservasi)['reservasi_aktif']; 

 

$result_tamu = mysqli_query($koneksi, "SELECT SUM(jumlah_orang) AS total_tamu FROM reservasi WHERE status_reservasi = 'aktif'"); 

$stat_total_tamu = mysqli_fetch_assoc($result_tamu)['total_tamu'] ?? 0; 

 

?> 

<!DOCTYPE html> 

<html lang="id"> 

<head> 

    <meta charset="UTF-8"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <title>Admin Dashboard - Kafe</title> 

    <link rel="stylesheet" href="css/style.css"> 

</head> 

<body> 

    <div class="dashboard-container"> 

        <div class="header"> 

            <h1>Admin Dashboard</h1> 

            <a href="logout.php" class="btn btn-logout">Logout</a> 

        </div> 

 

        <div class="admin-nav"> 

            <a href="dashboard_admin.php" class="btn btn-nav active">Dashboard</a> 

            <a href="kelola_meja.php" class="btn btn-nav">Kelola Meja</a> 

            <a href="lihat_semua_reservasi.php" class="btn btn-nav">Lihat Reservasi</a> 

        </div> 

 

        <h2>Statistik Kafe Saat Ini</h2> 

        <div class="stats-container"> 

            <div class="stat-card"> 

                <h3>Total Pengguna</h3> 

                <p><?php echo $stat_pengguna; ?></p> 

            </div> 

            <div class="stat-card"> 

                <h3>Total Meja</h3> 

                <p><?php echo $stat_meja; ?></p> 

            </div> 

            <div class="stat-card"> 

                <h3>Reservasi Aktif</h3> 

                <p><?php echo $stat_reservasi_aktif; ?></p> 

            </div> 

            <div class="stat-card"> 

                <h3>Total Tamu (Aktif)</h3> 

                <p><?php echo $stat_total_tamu; ?></p> 

            </div> 

        </div> 

         

        <div style="margin-top: 40px;"> 

            <p>Selamat datang di panel admin. Dari sini, Anda dapat mengelola data meja dan melihat semua reservasi yang masuk.</p> 

        </div> 

    </div> 

</body> 

</html> 