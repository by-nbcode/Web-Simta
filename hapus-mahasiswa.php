<?php
require 'koneksi.php';
require 'kelola_data.php';


$id_mhs = $_GET['id'];

if (hapusMahasiswa($id_mhs)  > 0) {

    header('location: data_mahasiswa.php');
}
