<?php 

require 'koneksi.php'; 

 

// Proteksi halaman admin 

if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] != 'admin' || !isset($_POST['action'])) { 

    die("Akses tidak sah."); 

} 

 

$action = $_POST['action']; 

 

switch ($action) { 

    case 'tambah': 

        $nomor_meja = $_POST['nomor_meja']; 

        $kapasitas = $_POST['kapasitas']; 

        $sql = "INSERT INTO meja (nomor_meja, kapasitas) VALUES (?, ?)"; 

        $stmt = mysqli_prepare($koneksi, $sql); 

        mysqli_stmt_bind_param($stmt, "si", $nomor_meja, $kapasitas); 

        if(mysqli_stmt_execute($stmt)){ 

            echo "Meja baru berhasil ditambahkan."; 

        } else { 

            echo "Gagal menambahkan meja."; 

        } 

        break; 

 

    case 'update': 

        $id_meja = $_POST['id_meja']; 

        $nomor_meja = $_POST['nomor_meja']; 

        $kapasitas = $_POST['kapasitas']; 

        $sql = "UPDATE meja SET nomor_meja = ?, kapasitas = ? WHERE id_meja = ?"; 

        $stmt = mysqli_prepare($koneksi, $sql); 

        mysqli_stmt_bind_param($stmt, "sii", $nomor_meja, $kapasitas, $id_meja); 

        if(mysqli_stmt_execute($stmt)){ 

            echo "Data meja berhasil diperbarui."; 

        } else { 

            echo "Gagal memperbarui data meja."; 

        } 

        break; 

 

    case 'delete': 

        $id_meja = $_POST['id_meja']; 

        // Catatan: Jika ada foreign key constraint dengan ON DELETE RESTRICT, 

        // Anda tidak bisa menghapus meja yang sedang aktif direferensikan. 

        // Opsi ON DELETE CASCADE pada tabel reservasi kita mengatasi ini. 

        $sql = "DELETE FROM meja WHERE id_meja = ?"; 

        $stmt = mysqli_prepare($koneksi, $sql); 

        mysqli_stmt_bind_param($stmt, "i", $id_meja); 

        if(mysqli_stmt_execute($stmt)){ 

            echo "Meja berhasil dihapus."; 

        } else { 

            echo "Gagal menghapus meja. Mungkin meja ini terkait dengan reservasi aktif."; 

        } 

        break; 

 

    default: 

        echo "Aksi tidak dikenal."; 

        break; 

} 

 

// Redirect kembali ke halaman kelola meja 

header("Refresh: 2; URL=kelola_meja.php"); 

exit(); 

?> 