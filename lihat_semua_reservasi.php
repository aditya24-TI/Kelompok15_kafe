<?php 

require 'koneksi.php'; 

 


if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] != 'admin') { 

    header("Location: index.php"); 

    exit(); 

} 

 
 

$filter_status = ''; 

$sql_where = ''; 

if (isset($_GET['status']) && $_GET['status'] != '') { 

    $filter_status = $_GET['status']; 

    $sql_where = "WHERE status_reservasi = ?"; 

} 

 


$sql = "SELECT nama_pemesan, email, nomor_meja, waktu_reservasi, jumlah_orang, status_reservasi  

        FROM v_detail_reservasi  

        $sql_where 

        ORDER BY waktu_reservasi DESC"; 

 

$stmt = mysqli_prepare($koneksi, $sql); 

 


if ($sql_where != '') { 

    mysqli_stmt_bind_param($stmt, "s", $filter_status); 

} 

 

mysqli_stmt_execute($stmt); 

$result = mysqli_stmt_get_result($stmt); 

 

?> 

<!DOCTYPE html> 

<html lang="id"> 

<head> 

    <title>Semua Reservasi</title> 

    <link rel="stylesheet" href="css/style.css"> 

</head> 

<body> 

    <div class="dashboard-container"> 

        <div class="header"> 

            <h1>Semua Data Reservasi</h1> 

            <a href="logout.php" class="btn btn-logout">Logout</a> 

        </div> 

         

        <div class="admin-nav"> 

            <a href="dashboard_admin.php" class="btn btn-nav">Dashboard</a> 

            <a href="kelola_meja.php" class="btn btn-nav">Kelola Meja</a> 

            <a href="lihat_semua_reservasi.php" class="btn btn-nav active">Lihat Reservasi</a> 

        </div> 

         

        <form action="lihat_semua_reservasi.php" method="GET" class="filter-form"> 

            <label for="status">Filter berdasarkan status:</label> 

            <select name="status" id="status" onchange="this.form.submit()"> 

                <option value="">Semua Status</option> 

                <option value="aktif" <?php echo ($filter_status == 'aktif') ? 'selected' : ''; ?>>Aktif</option> 

                <option value="dibatalkan" <?php echo ($filter_status == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option> 

                <option value="selesai" <?php echo ($filter_status == 'selesai') ? 'selected' : ''; ?>>Selesai</option> 

            </select> 

        </form> 

 

        <table class="data-table"> 

            <thead> 

                <tr> 

                    <th>Nama Pemesan</th> 

                    <th>Email</th> 

                    <th>Nomor Meja</th> 

                    <th>Waktu Reservasi</th> 

                    <th>Jumlah Orang</th> 

                    <th>Status</th> 

                </tr> 

            </thead> 

            <tbody> 

                <?php 

                if (mysqli_num_rows($result) > 0) { 

                    while ($reservasi = mysqli_fetch_assoc($result)) { 

                        $status_class = strtolower(htmlspecialchars($reservasi['status_reservasi'])); 

                        echo "<tr>"; 

                        echo "<td>" . htmlspecialchars($reservasi['nama_pemesan']) . "</td>"; 

                        echo "<td>" . htmlspecialchars($reservasi['email']) . "</td>"; 

                        echo "<td>" . htmlspecialchars($reservasi['nomor_meja']) . "</td>"; 

                        echo "<td>" . htmlspecialchars(date('d M Y, H:i', strtotime($reservasi['waktu_reservasi']))) . "</td>"; 

                        echo "<td>" . htmlspecialchars($reservasi['jumlah_orang']) . " orang</td>"; 

                        echo "<td><span class='status status-" . $status_class . "'>" . ucfirst(htmlspecialchars($reservasi['status_reservasi'])) . "</span></td>"; 

                        echo "</tr>"; 

                    } 

                } else { 

                    echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada data reservasi yang cocok dengan filter.</td></tr>"; 

                } 

                ?> 

            </tbody> 

        </table> 

    </div> 

</body> 

</html> 