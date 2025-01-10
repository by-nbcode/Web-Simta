<?php
require 'koneksi.php';
require 'kelola_data.php';


$id_ta = $_GET['id'];

if (hapusProyekTa($id_ta)  > 0) {

    header('location: data_proyek_akhir.php');
}
