<?php
include('./koneksi.php');
$id = $_POST['id'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama = $_POST['agama'];
$alamat = $_POST['alamat'];
$sekolah_asal = $_POST['sekolah_asal'];

$query = "UPDATE siswa SET nama='$nama', jenis_kelamin='$jenis_kelamin', agama='$agama', alamat='$alamat', sekolah_asal='$sekolah_asal' WHERE id = '$id'";
mysqli_query($koneksi, $query);
session_start();
$_SESSION['msg'] = "Berhasil ubah siswa!";
header('location:index.php');
?>