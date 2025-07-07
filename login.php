<?php 


require 'koneksi.php'; 

 


$email = $_POST['email']; 

$password = $_POST['password']; 

 

if (empty($email) || empty($password)) { 

    die("Error: Email dan password harus diisi!"); 

} 

 


$sql = "SELECT id_pengguna, nama_lengkap, email, password, role FROM pengguna WHERE email = ?"; 

$stmt = mysqli_prepare($koneksi, $sql); 

 

if ($stmt) { 

    mysqli_stmt_bind_param($stmt, "s", $email); 

    mysqli_stmt_execute($stmt); 

    $result = mysqli_stmt_get_result($stmt); 

    $user = mysqli_fetch_assoc($result); 

 



    if ($user && password_verify($password, $user['password'])) { 

        $_SESSION['id_pengguna'] = $user['id_pengguna']; 

        $_SESSION['nama_lengkap'] = $user['nama_lengkap']; 

        $_SESSION['role'] = $user['role']; 

 



        if ($user['role'] == 'admin') { 

            header("Location: dashboard_admin.php"); 

            exit(); 

        } else { 

            header("Location: dashboard_user.php"); 

            exit(); 

        } 

    } else { 



        echo "Login gagal! Email atau password salah."; 

        header("Refresh: 2; URL=index.php"); 

    } 

 

    mysqli_stmt_close($stmt); 

} else { 

    echo "Error: Gagal mempersiapkan statement. " . mysqli_error($koneksi); 

} 

 

mysqli_close($koneksi); 

?> 