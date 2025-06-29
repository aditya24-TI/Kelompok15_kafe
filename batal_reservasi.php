	<?php 

require 'koneksi.php'; 

 

// Proteksi halaman 

if (!isset($_SESSION['id_pengguna']) || $_SERVER['REQUEST_METHOD'] !== 'POST') { 

    die("Akses tidak sah."); 

} 

 

$id_pengguna = $_SESSION['id_pengguna']; 

$id_reservasi = $_POST['id_reservasi']; 

 

// Mulai transaksi 

mysqli_begin_transaction($koneksi); 

 

try { 

    // Langkah 1: Ubah status reservasi menjadi 'dibatalkan' 

    // Pastikan hanya pemilik reservasi yang bisa membatalkan 

    $sql1 = "UPDATE reservasi SET status_reservasi = 'dibatalkan' WHERE id_reservasi = ? AND id_pengguna = ?"; 

    $stmt1 = mysqli_prepare($koneksi, $sql1); 

    mysqli_stmt_bind_param($stmt1, "ii", $id_reservasi, $id_pengguna); 

    mysqli_stmt_execute($stmt1); 

 

    // Cek apakah update berhasil (apakah ada baris yang terpengaruh) 

    if (mysqli_stmt_affected_rows($stmt1) == 0) { 

        throw new Exception("Reservasi tidak ditemukan atau Anda tidak berhak membatalkannya."); 

    } 

 

    // Langkah 2: Dapatkan id_meja dari reservasi yang dibatalkan 

    $sql_get_meja = "SELECT id_meja FROM reservasi WHERE id_reservasi = ?"; 

    $stmt_get_meja = mysqli_prepare($koneksi, $sql_get_meja); 

    mysqli_stmt_bind_param($stmt_get_meja, "i", $id_reservasi); 

    mysqli_stmt_execute($stmt_get_meja); 

    $result_meja = mysqli_stmt_get_result($stmt_get_meja); 

    $meja = mysqli_fetch_assoc($result_meja); 

    $id_meja = $meja['id_meja']; 

 

    // Langkah 3: Ubah status meja kembali menjadi 'tersedia' 

    $sql2 = "UPDATE meja SET status = 'tersedia' WHERE id_meja = ?"; 

    $stmt2 = mysqli_prepare($koneksi, $sql2); 

    mysqli_stmt_bind_param($stmt2, "i", $id_meja); 

    mysqli_stmt_execute($stmt2); 

     

    // Jika semua query berhasil, commit transaksi 

    mysqli_commit($koneksi); 

     

    echo "Reservasi berhasil dibatalkan."; 

    header("Refresh: 2; URL=reservasi_saya.php"); 

 

} catch (Exception $e) { 

    // Jika terjadi error, rollback semua perubahan 

    mysqli_rollback($koneksi); 

    echo "Gagal membatalkan reservasi: " . $e->getMessage(); 

} 

 

// Tutup statement 

mysqli_stmt_close($stmt1); 

mysqli_stmt_close($stmt_get_meja); 

mysqli_stmt_close($stmt2); 

mysqli_close($koneksi); 

 

?> 