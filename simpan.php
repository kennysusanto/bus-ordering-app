<?php
include('./koneksi.php');

$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama = $_POST['agama'];
$alamat = $_POST['alamat'];
$sekolah_asal = $_POST['sekolah_asal'];

$query = "INSERT INTO siswa(nama, jenis_kelamin, agama, alamat, sekolah_asal) VALUES('$nama', '$jenis_kelamin', '$agama', '$alamat', '$sekolah_asal')";

mysqli_query($koneksi, $query);
session_start();
$_SESSION['msg'] = 'Berhasil simpan siswa!';
header('location:index.php');
?>