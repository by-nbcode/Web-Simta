<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

// cek tombol simpan
if (isset($_POST['simpan'])) {
    if (tambahJadwal($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}

// cek tombol update
if (isset($_POST['ubah'])) {

    if (ubahJadwal($_POST) > 0) {

        $suksess_ubah = true;
    } else {

        $error_ubah = true;
    }
}

// data dosen
$data_dosen = tampilData("SELECT * FROM tb_dosen JOIN tb_user ON tb_dosen.id_user = tb_user.id_user");
// data Mahasiswa
$data_mahasiswa  = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user");
// data jadwal
$data_jadwal = tampilData("SELECT * FROM tb_jadwal_bimbingan JOIN tb_mahasiswa ON tb_jadwal_bimbingan.id_mhs = tb_mahasiswa.id_mhs JOIN tb_dosen ON tb_jadwal_bimbingan.id_dosen = tb_dosen.id_dosen ");

if ($_SESSION['role'] == 'Dosen') {

    $id_user = $_SESSION['id_user'];
    $dosen = tampilData("SELECT * FROM tb_dosen JOIN tb_user ON tb_dosen.id_user = tb_user.id_user WHERE tb_dosen.id_user = $id_user")[0];


    $data_jadwal = tampilData("SELECT * FROM tb_jadwal_bimbingan JOIN tb_mahasiswa ON tb_jadwal_bimbingan.id_mhs = tb_mahasiswa.id_mhs JOIN tb_dosen ON tb_jadwal_bimbingan.id_dosen = tb_dosen.id_dosen WHERE tb_dosen.id_user = $_SESSION[id_user]");
}

if ($_SESSION['role'] == 'Mahasiswa') {
    // data user dan  mahasiswa
    $id_user = $_SESSION['id_user'];
    $mhs = tampilData("SELECT * FROM tb_user JOIN tb_mahasiswa ON tb_user.id_user = tb_mahasiswa.id_user WHERE tb_user.id_user = $id_user ");

    $data_jadwal = tampilData("SELECT * FROM tb_jadwal_bimbingan JOIN tb_mahasiswa ON tb_jadwal_bimbingan.id_mhs = tb_mahasiswa.id_mhs JOIN tb_dosen ON tb_jadwal_bimbingan.id_dosen = tb_dosen.id_dosen WHERE tb_mahasiswa.id_user = $_SESSION[id_user]");
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Simta</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="container-scroller">


        <!-- navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" /></a>
                <a class="navbar-brand brand-logo mr-5" href="index.html"> SIMTA</a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Data Profile</p>
                            <a class="dropdown-item preview-item" href="data-profile.php">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="bi bi-person-circle mx-2"></i>
                                    </div>
                                </div>

                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">
                                        Profile Saya
                                    </h6>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- akhir navbar -->



        <div class="container-fluid page-body-wrapper">

            <!-- tampilan Sidebar dan Konten Portal DOSEN-->
            <?php if ($_SESSION['role'] == 'Dosen') : ?>
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fa-solid fa-chart-line"></i>
                                <span class="menu-title mx-3">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_proyek_akhir.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-list-check"></i>
                                <span class="menu-title mx-3">Proyek Akhir (TA)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="monitoring_proyek.php" aria-expanded=" false" aria-controls="auth">
                                <i class="fa-solid fa-check-to-slot"></i>
                                <span class="menu-title mx-3">Monitoring Proyek</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_jadwal.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-calendar-plus"></i>
                                <span class="menu-title mx-3">Jadwal Bimbingan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah anda ingin meninggalkan portal ? ')">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="menu-title mx-3">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif ?>

            <?php if ($_SESSION['role'] == 'Dosen') : ?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Jadwal Bimbingan</h3>
                                        <h6 class="font-weight-normal mb-0">Kelola data jadwal Bimbingan Proyek Akhir</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg text-right px-5">
                                <button class="btn btn-sm btn-success my-1" name="submit" type="button" data-toggle="modal" data-target="#tambah">Tambah Jadwal Bimbingan</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg px-4">
                                <!-- alert -->
                                <?php if (isset($suksess)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong>Jadwal bimbingan berhasil ditetapkan!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong>Jadwal bimbingan gagal ditetapkan!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>

                                <?php if (isset($suksess_ubah)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong>Jadwal bimbingan berhasil diubah!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error_ubah)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong>Jadwal bimbingan gagal diubah!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <!-- akhir alert -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="display expandable-table" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Mahasiswa</th>
                                                                <th>Dosen Pembimbing</th>
                                                                <th>Hari / Tgl</th>
                                                                <th>Waktu</th>
                                                                <th>Status</th>
                                                                <th class="text-center">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no = 1;
                                                            foreach ($data_jadwal as $jadwal) : ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td><?= $jadwal['nama_mhs'] ?></td>
                                                                    <td><?= $jadwal['nama_dosen'] ?></td>
                                                                    <td><?= $jadwal['hari'] ?>, <?= date('d/m/Y', strtotime($jadwal['tanggal'])) ?></td>
                                                                    <td><?= date('H:i', strtotime($jadwal['waktu'])) ?></td>
                                                                    <td><?= $jadwal['status_jb'] ?></td>
                                                                    <td class="text-center">
                                                                        <a href="" class="text-success mx-2" data-toggle="modal" data-target="#edit<?= $jadwal['id_jb'] ?>">Edit</a>
                                                                        <a href="hapus-jadwal.php?id=<?= $jadwal['id_jb'] ?>" class="text-danger mx-2">Hapus</a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <!-- Modal tambah Jadwal-->
                        <div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Jadwal Bimbingan Proyek Akhir</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <input type="hidden" name="id_dosen" value="<?= $dosen['id_dosen'] ?>">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Mahasiswa</label>
                                                <select name="id_mhs" class="form-control form-control-sm">
                                                    <option value=""> - pilih - </option>
                                                    <?php foreach ($data_mahasiswa as $mhs) : ?>
                                                        <option value="<?= $mhs['id_mhs'] ?>"> <?= $mhs['nama_mhs'] ?> </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hari</label>
                                                <select name="hari" class="form-control">
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Tanggal</label>
                                                        <input type="date" name="tanggal" placeholder="Tanggal Bimbingan" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Waktu</label>
                                                        <input type="time" name="waktu" placeholder="Waktu Bimbingan" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- akhir modal -->

                        <?php foreach ($data_jadwal as $jadwal) : ?>
                            <!-- Modal Edit Jadwal-->
                            <div class="modal fade" id="edit<?= $jadwal['id_jb'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Edit Jadwal Bimbingan Proyek Akhir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_dosen" value="<?= $jadwal['id_dosen'] ?>">
                                            <input type="hidden" name="id_jb" value="<?= $jadwal['id_jb'] ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nama Mahasiswa</label>
                                                    <select name="id_mhs" class="form-control form-control-sm text-dark font-weight-bold">
                                                        <option value=""> - pilih - </option>
                                                        <?php foreach ($data_mahasiswa as $mhs) : ?>
                                                            <option value="<?= $mhs['id_mhs'] ?>" <?= ($jadwal['id_mhs'] == $mhs['id_mhs']) ? 'selected' : '' ?>> <?= $mhs['nama_mhs'] ?> </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Hari</label>
                                                    <select name="hari" class="form-control font-weight-bold text-dark">
                                                        <option value="Senin" <?= ($jadwal['hari']  == 'Senin') ? 'selected' :  '' ?>>Senin</option>
                                                        <option value="Selasa" <?= ($jadwal['hari']  == 'Selasa') ? 'selected' :  '' ?>>Selasa</option>
                                                        <option value="Rabu" <?= ($jadwal['hari']  == 'Rabu') ? 'selected' :  '' ?>>Rabu</option>
                                                        <option value="Kamis" <?= ($jadwal['hari']  == 'Kamis') ? 'selected' :  '' ?>>Kamis</option>
                                                        <option value="Jumat" <?= ($jadwal['hari']  == 'Jumat') ? 'selected' :  '' ?>>Jumat</option>
                                                        <option value="Sabtu" <?= ($jadwal['hari']  == 'Sabtu') ? 'selected' :  '' ?>>Sabtu</option>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Tanggal</label>
                                                            <input type="date" name="tanggal" placeholder="Tanggal Bimbingan" class="form-control form-control-sm text-dark font-weight-bold" value="<?= $jadwal['tanggal'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Waktu</label>
                                                            <input type="time" name="waktu" placeholder="Waktu Bimbingan" class="form-control form-control-sm text-dark font-weight-bold" value="<?= $jadwal['waktu'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Status</label>
                                                    <select name="status" class="form-control text-dark font-weight-bold">
                                                        <option value="Diterima" <?= ($jadwal['status_jb'] == 'Diterima') ? 'selected' : ''  ?>>Diterima</option>
                                                        <option value="Ditolak" <?= ($jadwal['status_jb'] == 'Ditolak') ? 'selected' : ''  ?>>Ditolak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah" class="btn btn-success">Simpan & Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- akhir modal -->
                        <?php endforeach ?>


                    </div>
                </div>
            <?php endif ?>
            <!-- ----------------------------------------------------- -->

            <!-- tampilan Sidebar dan Konten Portal MAHASISWA-->
            <?php if ($_SESSION['role'] == 'Mahasiswa') : ?>
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fa-solid fa-chart-line"></i>
                                <span class="menu-title mx-3">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_proyek_akhir.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-file-pen"></i>
                                <span class="menu-title mx-3">Pengajuan Proyek</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="monitoring_proyek.php" aria-expanded=" false" aria-controls="auth">
                                <i class="fa-solid fa-chart-simple"></i>
                                <span class="menu-title mx-3">Progres Proyek</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_jadwal.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-calendar"></i>
                                <span class="menu-title mx-3">Jadwal Bimbingan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah anda ingin meninggalkan portal ? ')">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="menu-title mx-3">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif ?>

            <?php if ($_SESSION['role'] == 'Mahasiswa') : ?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-md-10 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Jadwal Bimbingan</h3>
                                        <h6 class="font-weight-normal mb-0">Data jadwal bimbingan proyek TA </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">

                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-lg text-right">
                                        <button class="btn btn-sm btn-success rounded-lg" name="submit" type="button" data-toggle="modal" data-target="#tambah">Ajukan Jadwal Bimbingan</button>
                                    </div>
                                </div>
                                <?php if (isset($suksess)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show my-2" role="alert">
                                        <strong>Jadwal bimbingan berhasil diajukan (Silahkan tunggu konfirmasi dari dosen pembimbing anda)</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show my-2" role="alert">
                                        <strong>Jadwal bimbingan gagal diajukan!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <div class="card shadow-sm border-0 p-2 my-2 rounded-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Dosen Pembimbing</th>
                                                    <th>Status</th>
                                                    <th>Jadwal Bimbingan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($data_jadwal)) : ?>
                                                    <?php $no =  2;
                                                    foreach ($data_jadwal as $jadwal) : ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= $jadwal['nama_mhs'] ?></td>
                                                            <td><?= $jadwal['nama_dosen'] ?></td>
                                                            <td><?= $jadwal['status_jb'] ?></td>
                                                            <td><?= $jadwal['hari'] ?>, <?= date('d/m/y', strtotime($jadwal['hari'])) ?> : <?= $jadwal['waktu'] ?> </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center"> <small>Jadwal bimbingan belum tersedia!</small></td>
                                                    </tr>

                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal tambah Jadwal-->
                            <div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Jadwal Bimbingan Proyek Akhir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_dosen" value="<?= $dosen['id_dosen'] ?>">
                                            <div class="modal-body">

                                                <input type="hidden" name="id_mhs" value="<?= $mhs[0]['id_mhs'] ?>">
                                                <input type="hidden" name="status" value="Menunggu Konfirmasi Dosen">

                                                <div class="form-group">
                                                    <label for="">Dosen Pembimbing</label>
                                                    <select name="id_dosen" class="form-control">
                                                        <?php foreach ($data_dosen as $dosen) : ?>
                                                            <option value="<?= $dosen['id_dosen'] ?>"><?= $dosen['nama_dosen'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Hari</label>
                                                    <select name="hari" class="form-control">
                                                        <option value="Senin">Senin</option>
                                                        <option value="Selasa">Selasa</option>
                                                        <option value="Rabu">Rabu</option>
                                                        <option value="Kamis">Kamis</option>
                                                        <option value="Jumat">Jumat</option>
                                                        <option value="Sabtu">Sabtu</option>
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Tanggal</label>
                                                            <input type="date" name="tanggal" placeholder="Tanggal Bimbingan" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Waktu</label>
                                                            <input type="time" name="waktu" placeholder="Waktu Bimbingan" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- akhir modal -->
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <!-- ----------------------------------------------------- -->

        </div>

    </div>

    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <script src="js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->
</body>

</html>