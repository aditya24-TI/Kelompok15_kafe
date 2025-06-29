x<?php 

// Selalu mulai session di awal 

session_start(); 

 

// Hapus semua variabel session 

$_SESSION = array(); 

 

// Hancurkan session 

session_destroy(); 

 

// Redirect ke halaman login (index.php) 

header("Location: index.php"); 

exit(); 

?> 