<?php 

// Hubungkan ke database 

require 'koneksi.php'; 

 

// Ambil data dari form 

$nama_lengkap = $_POST['nama_lengkap']; 

$email = $_POST['email']; 

$password = $_POST['password']; 

 

// Validasi sederhana (pastikan tidak ada yang kosong) 

if (empty($nama_lengkap) || empty($email) || empty($password)) { 

    die("Error: Semua field harus diisi!"); 

} 

 

// **Penting: Hash password sebelum disimpan ke database** 

// Ini adalah praktik keamanan yang sangat penting. 

$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

 

// Siapkan query SQL untuk memasukkan data (menggunakan prepared statements untuk keamanan) 

$sql = "INSERT INTO pengguna (nama_lengkap, email, password, role) VALUES (?, ?, ?, 'user')"; 

 

$stmt = mysqli_prepare($koneksi, $sql); 

 

if ($stmt) { 

    // Bind parameter ke query 

    mysqli_stmt_bind_param($stmt, "sss", $nama_lengkap, $email, $hashed_password); 

 

    // Eksekusi query 

    if (mysqli_stmt_execute($stmt)) { 

        echo "Registrasi berhasil! Silakan login."; 

        // Redirect ke halaman index setelah 2 detik 

        header("Refresh: 2; URL=index.php"); 

    } else { 

        // Cek jika error karena email sudah ada 

        if (mysqli_errno($koneksi) == 1062) { // 1062 adalah kode error untuk duplicate entry 

            echo "Error: Email sudah terdaftar. Silakan gunakan email lain."; 

        } else { 

            echo "Error: Registrasi gagal. " . mysqli_error($koneksi); 

        } 

    } 

 

    // Tutup statement 

    mysqli_stmt_close($stmt); 

} else { 

    echo "Error: Gagal mempersiapkan statement. " . mysqli_error($koneksi); 

} 

 

// Tutup koneksi 

mysqli_close($koneksi); 

?> 