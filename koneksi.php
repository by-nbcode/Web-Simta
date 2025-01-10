<?php

// koneksi dengan DBMS (xampp)

// siapkan variabel
$host = 'localhost';
$username = 'root';
$password = '';
$nama_database = 'db_ta';

// konek ke daatabase
$koneksi = mysqli_connect($host, $username, $password, $nama_database);

// cek koneksi database
if (!$koneksi) {

    echo '<script>
        alert("Database tidak ditemukan");
        </script>';
}
