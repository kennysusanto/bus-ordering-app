<?php
$namaLengkap = $_POST['namaLengkap'];
$nomorIdentitas = $_POST['nomorIdentitas'];
$nomorHP = $_POST['nomorHP'];
$kelas = $_POST['kelas'];
$jadwalKeberangkatan = $_POST['jadwalKeberangkatan'];
$jumlahPenumpang = $_POST['jumlahPenumpang'];
$jumlahPenumpangLansia = $_POST['jumlahPenumpangLansia'];
$hargaTiket = $_POST['hargaTiket'];
$totalBayar = $_POST['totalBayar'];

$stringTest = $namaLengkap . ' ' . $nomorIdentitas . ' ' . $nomorHP . ' ' . $kelas . ' ' . $jadwalKeberangkatan . ' ' . $jumlahPenumpang . ' ' . $jumlahPenumpangLansia . ' ' . $hargaTiket . ' ' . $totalBayar;
echo $stringTest;
?>