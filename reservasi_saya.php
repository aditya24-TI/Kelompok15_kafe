<?php 

require 'koneksi.php'; 

 

// Proteksi halaman 

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

    <title>Riwayat Reservasi Saya</title> 

    <link rel="stylesheet" href="css/style.css"> 

</head> 

<body> 

    <div class="dashboard-container"> 

        <div class="header"> 

            <h1>Riwayat Reservasi - <?php echo htmlspecialchars($nama_lengkap); ?></h1> 

            <div> 

                <a href="dashboard_user.php" class="btn">Buat Reservasi Baru</a> 

                <a href="logout.php" class="btn btn-logout">Logout</a> 

            </div> 

        </div> 

 

        <h2>Daftar Reservasi Anda</h2> 

        <table class="data-table"> 

            <thead> 

                <tr> 

                    <th>Nomor Meja</th> 

                    <th>Waktu Reservasi</th> 

                    <th>Jumlah Orang</th> 

                    <th>Status</th> 

                    <th>Aksi</th> 

                </tr> 

            </thead> 

            <tbody> 

                <?php 

                // Query data dari VIEW, difilter berdasarkan id_pengguna yang login 

                $sql = "SELECT id_reservasi, nomor_meja, waktu_reservasi, jumlah_orang, status_reservasi  

                        FROM v_detail_reservasi  

                        WHERE id_pengguna = ?  

                        ORDER BY waktu_reservasi DESC"; 

                 

                $stmt = mysqli_prepare($koneksi, $sql); 

                mysqli_stmt_bind_param($stmt, "i", $id_pengguna); 

                mysqli_stmt_execute($stmt); 

                $result = mysqli_stmt_get_result($stmt); 

 

                if (mysqli_num_rows($result) > 0) { 

                    while ($reservasi = mysqli_fetch_assoc($result)) { 

                        echo "<tr>"; 

                        echo "<td>" . htmlspecialchars($reservasi['nomor_meja']) . "</td>"; 

                        echo "<td>" . htmlspecialchars(date('d M Y, H:i', strtotime($reservasi['waktu_reservasi']))) . "</td>"; 

                        echo "<td>" . htmlspecialchars($reservasi['jumlah_orang']) . " orang</td>"; 

                        echo "<td>" . ucfirst(htmlspecialchars($reservasi['status_reservasi'])) . "</td>"; 

                        echo "<td>"; 

                        // Tampilkan tombol batal HANYA jika statusnya 'aktif' 

                        if ($reservasi['status_reservasi'] == 'aktif') { 

                            echo "<form action='batal_reservasi.php' method='POST' onsubmit='return confirm(\"Apakah Anda yakin ingin membatalkan reservasi ini?\");'>"; 

                            echo "<input type='hidden' name='id_reservasi' value='" . $reservasi['id_reservasi'] . "'>"; 

                            echo "<button type='submit' class='btn btn-cancel'>Batalkan</button>"; 

                            echo "</form>"; 

                        } else { 

                            echo "-"; 

                        } 

                        echo "</td>"; 

                        echo "</tr>"; 

                    } 

                } else { 

                    echo "<tr><td colspan='5' style='text-align:center;'>Anda belum memiliki riwayat reservasi.</td></tr>"; 

                } 

                ?> 

            </tbody> 

        </table> 

    </div> 

</body> 

</html> 