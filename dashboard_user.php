<?php 


require 'koneksi.php'; 

 



if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] != 'user') { 

    header("Location: index.php"); 

    exit(); 

} 

 

$id_pengguna = $_SESSION['id_pengguna']; 

$nama_lengkap = $_SESSION['nama_lengkap']; 

?> 

<!DOCTYPE html> 

<html lang="id"> 

<head> 

    <meta charset="UTF-8"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <title>Dashboard Pengguna - Reservasi Meja</title> 

    <link rel="stylesheet" href="css/style.css"> 

</head> 

<body> 

 

    <div class="dashboard-container"> 

        <div class="header"> 

            <h1>Selamat Datang, <?php echo htmlspecialchars($nama_lengkap); ?>!</h1> 

            <div> 

                <a href="reservasi_saya.php" class="btn btn-info">Reservasi Saya</a>  

                <a href="logout.php" class="btn btn-logout">Logout</a> 

            </div> 

        </div> 

 

        <h2>Daftar Meja Kafe</h2> 

        <table class="data-table"> 

            <thead> 

                <tr> 

                    <th>Nomor Meja</th> 

                    <th>Kapasitas</th> 

                    <th>Status</th> 

                </tr> 

            </thead> 

            <tbody> 

                <?php 


                $sql = "SELECT nomor_meja, kapasitas, status FROM meja ORDER BY nomor_meja ASC"; 

                $result = mysqli_query($koneksi, $sql); 

                while ($meja = mysqli_fetch_assoc($result)) { 

                    echo "<tr>"; 

                    echo "<td>" . htmlspecialchars($meja['nomor_meja']) . "</td>"; 

                    echo "<td>" . htmlspecialchars($meja['kapasitas']) . " orang</td>"; 


                    if ($meja['status'] == 'tersedia') { 

                        echo "<td><span class='status status-tersedia'>" . ucfirst($meja['status']) . "</span></td>"; 

                    } else { 

                        echo "<td><span class='status status-dipesan'>" . ucfirst($meja['status']) . "</span></td>"; 

                    } 

                    echo "</tr>"; 

                } 

                ?> 

            </tbody> 

        </table> 

 

        <hr> 

 

        <h2>Buat Reservasi Baru</h2> 

        <div class="form-wrapper-dashboard"> 

            <form action="buat_reservasi.php" method="POST"> 

                <div class="input-group"> 

                    <label for="id_meja">Pilih Meja (hanya yang tersedia)</label> 

                    <select name="id_meja" id="id_meja" required> 

                        <option value="">-- Pilih Nomor Meja --</option> 

                        <?php 


                        $sql_meja_tersedia = "SELECT id_meja, nomor_meja, kapasitas FROM meja WHERE status = 'tersedia' ORDER BY nomor_meja ASC"; 

                        $result_meja_tersedia = mysqli_query($koneksi, $sql_meja_tersedia); 

                        while ($meja = mysqli_fetch_assoc($result_meja_tersedia)) { 

                            echo "<option value='" . $meja['id_meja'] . "'>" . htmlspecialchars($meja['nomor_meja']) . " (Kapasitas: " . $meja['kapasitas'] . " orang)</option>"; 

                        } 

                        ?> 

                    </select> 

                </div> 

                <div class="input-group"> 

                    <label for="waktu_reservasi">Waktu Reservasi</label> 

                    <input type="datetime-local" id="waktu_reservasi" name="waktu_reservasi" required> 

                </div> 

                <div class="input-group"> 

                    <label for="jumlah_orang">Jumlah Orang</label> 

                    <input type="number" id="jumlah_orang" name="jumlah_orang" min="1" required> 

                </div> 

                <button type="submit" class="btn">Buat Reservasi</button> 

            </form> 

        </div> 

    </div> 

 

</body> 

</html> 