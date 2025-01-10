<?php
require 'koneksi.php';
require 'kelola_data.php';


$id_monitoring = $_GET['id'];

if (hapusMonitoring($id_monitoring)  > 0) {

    header('location: monitoring_proyek.php');
}
