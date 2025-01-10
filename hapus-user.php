<?php
require 'koneksi.php';
require 'kelola_data.php';


$id_user = $_GET['id'];

if (hapusUser($id_user)  > 0) {

    header('location: data_user.php');
}
