<?php 

require 'koneksi.php'; 

 

// Proteksi halaman admin 

if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] != 'admin') { 

    header("Location: index.php"); 

    exit(); 

} 

 

// Logika untuk mode edit: Cek apakah ada parameter 'edit' di URL 

$edit_mode = false; 

$meja_to_edit = null; 

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) { 

    $edit_mode = true; 

    $id_meja_edit = $_GET['edit']; 

     

    // Ambil data meja yang akan diedit dari database 

    $sql_edit = "SELECT id_meja, nomor_meja, kapasitas FROM meja WHERE id_meja = ?"; 

    $stmt_edit = mysqli_prepare($koneksi, $sql_edit); 

    mysqli_stmt_bind_param($stmt_edit, "i", $id_meja_edit); 

    mysqli_stmt_execute($stmt_edit); 

    $result_edit = mysqli_stmt_get_result($stmt_edit); 

    $meja_to_edit = mysqli_fetch_assoc($result_edit); 

 

    // Jika data tidak ditemukan, matikan mode edit 

    if (!$meja_to_edit) { 

        $edit_mode = false; 

    } 

} 

?> 

<!DOCTYPE html> 

<html lang="id"> 

<head> 

    <meta charset="UTF-8"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <title>Kelola Meja - Admin</title> 

    <link rel="stylesheet" href="css/style.css"> 

</head> 

<body> 

    <div class="dashboard-container"> 

        <div class="header"> 

            <h1>Kelola Meja</h1> 

            <a href="logout.php" class="btn btn-logout">Logout</a> 

        </div> 

         

        <div class="admin-nav"> 

            <a href="dashboard_admin.php" class="btn btn-nav">Dashboard</a> 

            <a href="kelola_meja.php" class="btn btn-nav active">Kelola Meja</a> 

            <a href="lihat_semua_reservasi.php" class="btn btn-nav">Lihat Reservasi</a> 

        </div> 

 

        <div class="form-wrapper-dashboard" style="margin-top: 20px;"> 

            <h3><?php echo $edit_mode ? 'Edit Meja' : 'Tambah Meja Baru'; ?></h3> 

            <form action="proses_meja.php" method="POST"> 

                <input type="hidden" name="action" value="<?php echo $edit_mode ? 'update' : 'tambah'; ?>"> 

                 

                <?php if ($edit_mode): ?> 

                    <input type="hidden" name="id_meja" value="<?php echo $meja_to_edit['id_meja']; ?>"> 

                <?php endif; ?> 

 

                <div class="input-group"> 

                    <label for="nomor_meja">Nomor Meja</label> 

                    <input type="text" id="nomor_meja" name="nomor_meja" value="<?php echo $edit_mode ? htmlspecialchars($meja_to_edit['nomor_meja']) : ''; ?>" required> 

                </div> 

                <div class="input-group"> 

                    <label for="kapasitas">Kapasitas (Orang)</label> 

                    <input type="number" id="kapasitas" name="kapasitas" min="1" value="<?php echo $edit_mode ? htmlspecialchars($meja_to_edit['kapasitas']) : ''; ?>" required> 

                </div> 

                <button type="submit" class="btn"><?php echo $edit_mode ? 'Update Meja' : 'Tambah Meja'; ?></button> 

                 

                <?php if ($edit_mode): ?> 

                    <a href="kelola_meja.php" class="btn btn-cancel" style="text-decoration: none;">Batal Edit</a> 

                <?php endif; ?> 

            </form> 

        </div> 

         

        <hr> 

 

        <h2>Daftar Meja Terdaftar</h2> 

        <table class="data-table"> 

            <thead> 

                <tr> 

                    <th>Nomor Meja</th> 

                    <th>Kapasitas</th> 

                    <th>Status Saat Ini</th> 

                    <th style="width: 20%;">Aksi</th> 

                </tr> 

            </thead> 

            <tbody> 

                <?php 

                $sql_list = "SELECT id_meja, nomor_meja, kapasitas, status FROM meja ORDER BY nomor_meja ASC"; 

                $result_list = mysqli_query($koneksi, $sql_list); 

                while ($meja = mysqli_fetch_assoc($result_list)) { 

                    $status_class = strtolower(htmlspecialchars($meja['status'])); 

                    echo "<tr>"; 

                    echo "<td>" . htmlspecialchars($meja['nomor_meja']) . "</td>"; 

                    echo "<td>" . htmlspecialchars($meja['kapasitas']) . " orang</td>"; 

                    echo "<td><span class='status status-" . $status_class . "'>" . ucfirst($meja['status']) . "</span></td>"; 

                    echo "<td class='action-buttons'>"; 

                    // Tombol Edit mengarahkan ke halaman ini lagi dengan parameter GET 

                    echo "<a href='kelola_meja.php?edit=" . $meja['id_meja'] . "' class='btn btn-info'>Edit</a> "; 

                    // Tombol Delete berada dalam form terpisah 

                    echo "<form action='proses_meja.php' method='POST' onsubmit='return confirm(\"Yakin ingin menghapus meja ini? Reservasi terkait juga akan terhapus.\")' style='display:inline-block;'>"; 

                    echo "<input type='hidden' name='action' value='delete'>"; 

                    echo "<input type='hidden' name='id_meja' value='" . $meja['id_meja'] . "'>"; 

                    echo "<button type='submit' class='btn btn-logout'>Delete</button>"; 

                    echo "</form>"; 

                    echo "</td>"; 

                    echo "</tr>"; 

                } 

                ?> 

            </tbody> 

        </table> 

    </div> 

</body> 

</html> x