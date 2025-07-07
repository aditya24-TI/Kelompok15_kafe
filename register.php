<?php 



require 'koneksi.php'; 

 


$nama_lengkap = $_POST['nama_lengkap']; 

$email = $_POST['email']; 

$password = $_POST['password']; 

 


if (empty($nama_lengkap) || empty($email) || empty($password)) { 

    die("Error: Semua field harus diisi!"); 

} 

 



$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

 



$sql = "INSERT INTO pengguna (nama_lengkap, email, password, role) VALUES (?, ?, ?, 'user')"; 

 

$stmt = mysqli_prepare($koneksi, $sql); 

 

if ($stmt) { 



    mysqli_stmt_bind_param($stmt, "sss", $nama_lengkap, $email, $hashed_password); 

 



    if (mysqli_stmt_execute($stmt)) { 

        echo "Registrasi berhasil! Silakan login."; 


        header("Refresh: 2; URL=index.php"); 

    } else { 



        if (mysqli_errno($koneksi) == 1062) { 

            echo "Error: Email sudah terdaftar. Silakan gunakan email lain."; 

        } else { 

            echo "Error: Registrasi gagal. " . mysqli_error($koneksi); 

        } 

    } 

 



    mysqli_stmt_close($stmt); 

} else { 

    echo "Error: Gagal mempersiapkan statement. " . mysqli_error($koneksi); 

} 

 


mysqli_close($koneksi); 

?> 