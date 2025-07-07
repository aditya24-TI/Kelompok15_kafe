<?php 


session_start(); 

 


if (isset($_SESSION['id_pengguna'])) { 

    if ($_SESSION['role'] == 'admin') { 

        header("Location: dashboard_admin.php"); 

        exit(); 

    } else { 

        header("Location: dashboard_user.php"); 

        exit(); 

    } 

} 

?> 

<!DOCTYPE html> 

<html lang="id"> 

<head> 

    <meta charset="UTF-8"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <title>Selamat Datang di Kafe Kami</title> 

    <link rel="stylesheet" href="css/style.css"> 

</head> 

<body> 

 

    <div class="container"> 

        <div class="form-wrapper"> 

            <h2>Registrasi Pengguna Baru</h2> 

            <form action="register.php" method="POST"> 

                <div class="input-group"> 

                    <label for="reg_nama">Nama Lengkap</label> 

                    <input type="text" id="reg_nama" name="nama_lengkap" required> 

                </div> 

                <div class="input-group"> 

                    <label for="reg_email">Email</label> 

                    <input type="email" id="reg_email" name="email" required> 

                </div> 

                <div class="input-group"> 

                    <label for="reg_password">Password</label> 

                    <input type="password" id="reg_password" name="password" required> 

                </div> 

                <button type="submit" class="btn">Register</button> 

            </form> 

        </div> 

 

        <div class="form-wrapper"> 

            <h2>Login</h2> 

            <form action="login.php" method="POST"> 

                <div class="input-group"> 

                    <label for="login_email">Email</label> 

                    <input type="email" id="login_email" name="email" required> 

                </div> 

                <div class="input-group"> 

                    <label for="login_password">Password</label> 

                    <input type="password" id="login_password" name="password" required> 

                </div> 

                <button type="submit" class="btn">Login</button> 

            </form> 

        </div> 

    </div> 

 

</body> 

</html> 