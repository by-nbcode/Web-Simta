<?php

// panggil file koneksi
session_start();
require 'koneksi.php';


session_destroy();
header('location: index.php');
