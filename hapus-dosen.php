<?php
require 'koneksi.php';
require 'kelola_data.php';


$id_dosen = $_GET['id'];

if (hapusDosen($id_dosen)  > 0) {

    header('location: data_dosen.php');
}
