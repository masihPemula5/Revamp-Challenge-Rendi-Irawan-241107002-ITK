<html>
    <head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    *{
        font-family: sans-serif;
    }
</style>
    </head>
</html>

<?php
session_start();
include 'db.php'; 

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];


    $query = "DELETE FROM users WHERE username = '$username'";
    if (mysqli_query($conn, $query)) {
  
        session_destroy();
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Akun berhasil dihapus!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal menghapus akun!',
                text: '" . mysqli_error($conn) . "',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>

