<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

// cek tombol ubah status
if (isset($_POST['simpan'])) {

    if (tambahSyaratTA($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}
// cek tombol ubah status
if (isset($_POST['update_proyek'])) {

    if (ubahProgresMonitoring($_POST) > 0) {

        $suksess_ubah = true;
    } else {

        $error_ubah = true;
    }
}

if ($_SESSION['role'] == 'Dosen') {
    // data user
    $data_user = tampilData("SELECT * FROM tb_user");
    // data Mahasiswa
    $data_mahasiswa  = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user");

    // data proyek akhir (TA)
    $data_monitoring = tampilData("SELECT * FROM monitoring_proyek JOIN tb_mahasiswa ON monitoring_proyek.id_mhs = tb_mahasiswa.id_mhs JOIN tb_ta ON monitoring_proyek.id_mhs = tb_ta.id_mhs WHERE status_ta = 'Disetujui' || status_ta = 'Selesai' ");
}

if ($_SESSION['role'] == 'Mahasiswa') {

    // data profile mahasiswa
    $profile_mhs  = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user WHERE tb_user.id_user = $_SESSION[id_user]");

    // data monitoring portal Siswa
    $id_mhs = $profile_mhs[0]['id_mhs'];
    $progres_siswa = tampilData("SELECT * FROM monitoring_proyek JOIN tb_mahasiswa ON monitoring_proyek.id_mhs = tb_mahasiswa.id_mhs JOIN tb_ta ON monitoring_proyek.id_mhs = tb_ta.id_mhs WHERE tb_mahasiswa.id_mhs = $id_mhs || status_ta = 'Disetujui' || status_ta = 'Selesai'");
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
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <!-- bootstrap icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="<?= ($_SESSION['role'] == 'Dosen') ? 'sidebar-icon-only' : '' ?>   ">
    <div class="container-scroller">

        <!-- navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="images/logo.svg" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="ti-info-alt mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="ti-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="ti-user mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        2 days ago
                                    </p>
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

            <!-- sidebar portal Dosen -->
            <?php if ($_SESSION['role'] == 'Dosen') : ?>
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_proyek_akhir.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Proyek Akhir (TA)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="monitoring_proyek.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Monitoring Proyek</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_jadwal.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Jadwal Bimbingan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah anda ingin meninggalkan portal ? ')">
                                <i class="icon-ban menu-icon"></i>
                                <span class="menu-title">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Monitoring Proyek</h3>
                                        <h6 class="font-weight-normal mb-0">Monitoring progres proyek TA Prodi Sistem Informasi tahun 2024</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-md px-2">
                                <?php if (isset($suksess_ubah)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek telah diupdate !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error_ubah)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek gagal diupdate !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>


                                <!-- -------------------------------- -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg">
                                                <div class="table-responsive">
                                                    <table class="display expandable-table" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>Judul Proyek (TA)</th>
                                                                <th>Progres</th>
                                                                <th>Keterangan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no = 1;
                                                            foreach ($data_monitoring as $monitoring) : ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td><?= $monitoring['nama_mhs'] ?></td>
                                                                    <td><?= $monitoring['judul_ta'] ?></td>
                                                                    <td>
                                                                        <?= $monitoring['progres'] ?>%
                                                                        <div class="progress">
                                                                            <div class="progress-bar <?= ($monitoring['progres'] <= 40) ? 'bg-danger' : (($monitoring['progres'] <= 50) ? 'bg-warning' : 'bg-success') ?>"
                                                                                role="progressbar" style="width: <?= $monitoring['progres'] ?>%;" aria-valuemax="100"></div>
                                                                        </div>

                                                                    </td>
                                                                    <td><?= $monitoring['keterangan'] ?></td>
                                                                    <td>
                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                                                            <button type="button" class="btn btn-info rounded-0 p-0 px-1 py-1" data-toggle="modal" data-target="#detail<?= $monitoring['id_monitoring'] ?>">Detail</button>


                                                                            </button>
                                                                            <a href="hapus-monitoring.php?id=<?= $monitoring['id_monitoring'] ?>" onclick="return confirm('Ingin menghapus data ini ??')" class="btn btn-danger rounded-0 p-0 px-1 py-1">Hapus</a>
                                                                        </div>
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



                        <!-- Modal detail monitoring proyek-->
                        <?php foreach ($data_monitoring as $monitoring) : ?>
                            <div class="modal fade" id="detail<?= $monitoring['id_monitoring'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Detail Monitoring Proyek TA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                <input type="hidden" name="id_monitoring" value="<?= $monitoring['id_monitoring'] ?>">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-10 my-2">
                                                        <div class="row mb-2">
                                                            <div class="col-lg-6">
                                                                <small>Nama Mahasiswa</small>
                                                                <p class="m-0 font-weight-bold text-uppercase"><?= $monitoring['nama_mhs'] ?></p>
                                                            </div>
                                                        </div>
                                                        <table class="table table-sm table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center bg-primary text-white" colspan="5">PERSYARATAN</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">SK Akademik</th>
                                                                    <th class="text-center">SK Keuangan</th>
                                                                    <th class="text-center">Laporan</th>
                                                                    <th class="text-center">PPT</th>
                                                                    <th class="text-center">Proyek</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center"><input type="checkbox" name=""></td>
                                                                    <td class="text-center"><input type="checkbox" name=""></td>
                                                                    <td class="text-center"><input type="checkbox" name=""></td>
                                                                    <td class="text-center"><input type="checkbox" name=""></td>
                                                                    <td class="text-center"><input type="checkbox" name=""></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="row border-bottom mt-2">
                                                            <div class="col-lg-6">
                                                                <small>Bukti Persyaratan</small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">SK Akademik</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <img src="" style="width: 50px; height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">SK Keuangan</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <img src="" style="width: 50px; height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">Laporan Dokumentasi</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <img src="" style="width: 50px; height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">Presentasi (PPT)</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <img src="" style="width: 50px; height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="row border-bottom mt-2">
                                                            <div class="col-lg-6">
                                                                <small>Link Github Proyek</small>
                                                                <p class="text-dark font-weight-bold"><a href="" target="_blank"> -</a></p>
                                                            </div>
                                                        </div>

                                                        <div class="row border-bottom mt-2">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Progres TA</label>
                                                                    <input type="text" name="progres" value="<?= $monitoring['progres'] ?> " class="form-control form-control-sm" placeholder="0 - 100">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="">Keterangan</label>
                                                                    <input type="text" name="ket" value="<?= $monitoring['keterangan'] ?>" class="form-control form-control-sm" placeholder="Keterangan">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah" class="btn btn-success">Update & Simpan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <!-- akhir modal -->




                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                        </div>
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
            <?php endif ?>
            <!-- akhir konten -->

            <!-- sidebar portal Dosen -->
            <?php if ($_SESSION['role'] == 'Mahasiswa') : ?>
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_proyek_akhir.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Pengajuan Proyek</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="monitoring_proyek.php" aria-expanded=" false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Progres Proyek</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_jadwal.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Jadwal Bimbingan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Apakah anda ingin meninggalkan portal ? ')">
                                <i class="icon-ban menu-icon"></i>
                                <span class="menu-title">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-md-10 grid-margin">
                                <div class="row">
                                    <div class="col-10 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Syarat Ujian Proyek TA</h3>
                                        <h6 class="font-weight-normal mb-0">Lengkapi data-data persyaratan ujian proyek TA</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10 px-2">
                                <?php if (isset($suksess)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Berkas telah diupload !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek gagal diupdate !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($suksess_ubah)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Progress proyek telah diupdate !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error_ubah)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek gagal diupdate !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <!-- -------------------------------- -->
                                <div class="card rounded-0">
                                    <div class="card-body">

                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="id_mhs" value="<?= $progres_siswa[0]['id_mhs'] ?>">

                                                    <input type="hidden" name="id_monitoring" value="<?= $progres_siswa[0]['id_monitoring'] ?>">
                                                    <input type="hidden" name="progres" value="<?= $progres_siswa[0]['progres'] ?>">
                                                    <input type="hidden" name="ket" value="<?= $progres_siswa[0]['keterangan'] ?>">
                                                    <div class="row justify-content-center my-2 border-bottom">
                                                        <div class="col-lg-6 ">
                                                            <small>Upload SK Akademik</small>
                                                            <input type="file" name="sk_ak" class="form-control form-control-sm my-2 border-0">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <small>Upload SK Keuangan</small>
                                                            <input type="file" name="sk_ku" class="form-control form-control-sm my-2 border-0">
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2 border-bottom">
                                                        <div class="col-lg-6">
                                                            <small>File Laporan</small>
                                                            <input type="file" name="laporan" class="form-control form-control-sm my-2 border-0">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <small>File Presentasi (PPT)</small>
                                                            <input type="file" name="ppt" class="form-control form-control-sm my-2 border-0">
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2 mb-4 border-bottom">
                                                        <div class="col-lg-6">
                                                            <small>Proyek ( Program )</small>
                                                            <select name="proyek" class="form-control">
                                                                <option value="Berjalan">Berjalan</option>
                                                                <option value="Error">Error</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <small>Link GIT / Github</small>
                                                            <textarea name="git" class="form-control mb-2" placeholder="Link Github.."><?= $progres_siswa[0]['git_link'] ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2 mt-4">
                                                        <div class="col-lg">
                                                            <a href="monitoring_proyek.php" class="btn btn-sm btn-danger rounded-sm" name="update_proyek" type="submit">Kembali</a>
                                                            <button class="btn btn-sm btn-success rounded-sm" name="simpan" type="submit">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- akhir konten -->

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