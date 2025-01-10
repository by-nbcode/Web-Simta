<?php
require 'koneksi.php';
require 'kelola_data.php';


$id_jadwal = $_GET['id'];

if (hapusJadwal($id_jadwal)  > 0) {

    header('location: data_jadwal.php');
}
