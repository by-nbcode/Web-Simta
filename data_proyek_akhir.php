<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

// cek tombol simpan
if (isset($_POST['simpan'])) {
    if (tambahProyekTa($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}

// cek tombol update
if (isset($_POST['ubah_status'])) {

    if (ubahStatusProyek($_POST) > 0) {

        $suksess_ubah_status = true;
    } else {

        $error_ubah_status = true;
    }
}

// cek tombol ubah status
if (isset($_POST['ubah'])) {

    if (ubahProyekTa($_POST) > 0) {

        $suksess_ubah = true;
    } else {

        $error_ubah = true;
    }
}


// data user
$data_user = tampilData("SELECT * FROM tb_user");
// data Mahasiswa
$data_mahasiswa  = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user");
// data proyek akhir (TA)
$data_proyek = tampilData("SELECT * FROM tb_ta JOIN tb_mahasiswa ON tb_ta.id_mhs = tb_mahasiswa.id_mhs ORDER BY id_ta DESC");

// data user dan  mahasiswa
$id_user = $_SESSION['id_user'];
$mhs = tampilData("SELECT * FROM tb_user JOIN tb_mahasiswa ON tb_user.id_user = tb_mahasiswa.id_user WHERE tb_user.id_user = $id_user ");

$mhs_proyek = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_ta ON tb_mahasiswa.id_mhs = tb_ta.id_mhs WHERE tb_mahasiswa.id_user = $id_user");

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
    <!-- bootstrap icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="container-scroller">

        <!-- navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="images/logo-mini.svg" alt="logo" /></a>
                <a class="navbar-brand brand-logo mr-5" href="dashboard.php"> SIMTA</a>
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

            <!-- tampilan sidebar dan Konten portal DOSEN -->
            <?php if ($_SESSION['role'] == "Dosen") : ?>
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
                                        <h3 class="font-weight-bold">Daftar Mahasiswa</h3>
                                        <h6 class="font-weight-normal mb-0">Daftar Mahasiswa tingkat akhir dengan Judul proyek akhir (TA)</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg text-right px-5">
                                <button type="button" class="btn btn-sm btn-success my-1" data-toggle="modal" data-target="#tambah">Tambah Proyek TA</button>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-md px-2">
                                <!-- alert -->

                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA gagal ditambahkan !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($suksess_ubah)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA berhasil diubah !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error_ubah)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA gagal diubah !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>

                                <?php if (isset($suksess_ubah_status)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Status Proyek telah di tetapkan !!</strong>
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
                                                                <th>NIM</th>
                                                                <th class="text-center">Nama</th>
                                                                <th class="text-center">Judul Proyek (TA)</th>
                                                                <th class="text-center">Tgl Pengajuan</th>
                                                                <th class="text-center">Group</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no = 1;
                                                            foreach ($data_proyek as $proyek) : ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td><?= $proyek['nim'] ?></td>
                                                                    <td><?= $proyek['nama_mhs'] ?></td>
                                                                    <td><?= $proyek['judul_ta'] ?></td>
                                                                    <td><?= $proyek['tanggal_pegajuan'] ?></td>
                                                                    <td><?= $proyek['tim'] ?></td>
                                                                    <td>
                                                                        <?php if ($proyek['status_ta'] == 'Menunggu Persetujuan') :  ?>
                                                                            <span class="text-warning">
                                                                                <?= $proyek['status_ta'] ?>
                                                                            </span>
                                                                        <?php endif ?>

                                                                        <?php if ($proyek['status_ta'] == 'Disetujui') :  ?>
                                                                            <span class="text-info">
                                                                                <?= $proyek['status_ta'] ?>
                                                                            </span>
                                                                        <?php endif   ?>

                                                                        <?php if ($proyek['status_ta'] == 'Ditolak') :  ?>
                                                                            <span class="text-danger">
                                                                                <i class="bi bi-x"></i>
                                                                                <?= $proyek['status_ta'] ?>
                                                                            </span>
                                                                        <?php endif   ?>

                                                                        <?php if ($proyek['status_ta'] == 'Selesai') :  ?>
                                                                            <span class="text-success">
                                                                                <i class="bi bi-check2-circle"></i>
                                                                                <?= $proyek['status_ta'] ?>
                                                                            </span>
                                                                        <?php endif   ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                                                            <button type="button" class="btn btn-success rounded-0 p-0 px-1 py-1" data-toggle="modal" data-target="#detail<?= $proyek['id_ta'] ?>">Detail</button>

                                                                            <button type="button" class="btn btn-warning p-0 px-2" data-toggle="modal" data-target="#edit<?= $proyek['id_ta'] ?>">Edit

                                                                            </button>
                                                                            <a href="hapus-proyek-ta.php?id=<?= $proyek['id_ta'] ?>" onclick="return confirm('Ingin menghapus data ini ??')" class="btn btn-danger rounded-0 p-0 px-1 py-1">Hapus</a>
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


                        <!-- Modal tambah proyek-->
                        <div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Proyek Akhir</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama">Nama Mahasiswa</label>
                                                <select name="id_mhs" class="form-control form-control-sm" required>
                                                    <option value=""> pilih </option>
                                                    <?php foreach ($data_mahasiswa as $mhs) : ?>
                                                        <option value="<?= $mhs['id_mhs'] ?>"> <?= $mhs['nama_mhs'] ?> </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="judul_ta">Judul Proyek Akhir</label>
                                                <textarea name="judul_ta" class="form-control" placeholder="Masukkan Judul Proyek..." required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="tim">Group (Kelompok atau Individu)</label>
                                                <select name="tim" class="form-control" id="group-select">
                                                    <option value="Kelompok">Kelompok</option>
                                                    <option value="Individu">Individu</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl">Tanggal Pengajuan</label>
                                                <input type="date" name="tgl" class="form-control" required>
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




                        <!-- Modal ubah proyek-->
                        <?php foreach ($data_proyek as $proyek) : ?>
                            <div class="modal fade" id="edit<?= $proyek['id_ta'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Edit data Proyek Akhir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ta" value="<?= $proyek['id_ta'] ?>">
                                            <input type="hidden" name="status_ta" value="<?= $proyek['status_ta'] ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="nama">Nama Mahasiswa</label>
                                                    <select name="id_mhs" class="form-control form-control-sm text-dark font-weight-bold">
                                                        <option value=""> pilih </option>
                                                        <?php foreach ($data_mahasiswa as $mhs) : ?>
                                                            <option value="<?= $mhs['id_mhs'] ?>" <?= ($proyek['id_mhs'] == $mhs['id_mhs']) ? 'selected' : '' ?>> <?= $mhs['nama_mhs'] ?> </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="judul_ta">Judul Proyek Akhir</label>
                                                    <textarea name="judul_ta" class="form-control tetx-dark font-weight-bold" required><?= $proyek['judul_ta'] ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tim">Group (Kelompok atau Individu)</label>
                                                    <select name="tim" class="form-control text-dark font-weight-bold" id="group-select">
                                                        <option value="Kelompok" <?= ($proyek['tim'] == 'Kelompok') ? 'selected' : ''  ?>>Kelompok</option>
                                                        <option value="Individu" <?= ($proyek['tim'] == 'Individu') ? 'selected' : ''  ?>>Individu</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl">Tanggal Pengajuan</label>
                                                    <input type="date" name="tgl" class="form-control text-dark font-weight-bold" value="<?= $proyek['tanggal_pegajuan'] ?>">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <!-- akhir modal -->

                        <!-- Modal detail proyek-->
                        <?php foreach ($data_proyek as $proyek) : ?>
                            <div class="modal fade" id="detail<?= $proyek['id_ta'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Detail Proyek Akhir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ta" value="<?= $proyek['id_ta'] ?>">
                                            <input type="hidden" name="id_mhs" value="<?= $proyek['id_mhs'] ?>">
                                            <div class="row m-0 mx-2 mt-2">
                                                <div class="col-lg">
                                                    <small class="text-muted">Nama Mahasiswa</small>
                                                    <h5 class="text-dark font-weight-500"><?= $proyek['nama_mhs'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2">
                                                <div class="col-lg">
                                                    <small class="text-muted">Judul Proyek (TA)</small>
                                                    <h5 class="text-dark font-weight-500"><?= $proyek['judul_ta'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2 border-bottom">
                                                <div class="col-lg">
                                                    <small class="text-muted">Status</small>
                                                    <h5 class="text-dark font-weight-500"><?= $proyek['status_ta'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2 mt-2">
                                                <div class="col-lg">
                                                    <p class="text-muted">Berikan tanggapan atau persetujuan terkait judul proyek (TA) yang diajukan. </p>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2 mt-2">
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <label for="">Tentukan Satatus Proyek (Disetujui, Ditolak atau Selesai)</label>
                                                        <select name="status_ta" class="form-control form-control-sm">
                                                            <option value=""> pilih </option>
                                                            <option value="Disetujui"> Disetujui </option>
                                                            <option value="Ditolak"> Ditolak </option>
                                                            <option value="Selesai"> Selesai </option>
                                                            <option value="Menunggu Persetujuan"> Menunggu Persetujuan </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah_status" class="btn btn-success">Update & Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <!-- content-wrapper ends -->
                </div>
            <?php endif ?>
            <!-- ----------------------------------------------------- -->

            <!-- tampilan sidebar dan Konten portal DOSEN -->
            <?php if ($_SESSION['role'] == "Mahasiswa") : ?>
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
                                        <h3 class="font-weight-bold">Pengajuan Proyek TA</h3>
                                        <h6 class="font-weight-normal mb-0">Detail data pengajuan </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (empty($mhs_proyek[0]['status_ta'])) : ?>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-right px-2 my-2">
                                    <button type="button" class="btn btn-sm btn-success my-1 rounded-lg" data-toggle="modal" data-target="#tambah">Tambah Proyek TA</button>
                                </div>
                            </div>
                        <?php else : ?>
                            <!--  -->
                        <?php endif ?>


                        <div class="row justify-content-center">
                            <div class="col-md-10 px-2">
                                <!-- alert -->
                                <?php if (isset($suksess)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA berhasil ditambahkan !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA gagal ditambahkan !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($suksess_ubah)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA berhasil diubah !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error_ubah)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data Proyek TA gagal diubah !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($suksess_ubah_status)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Status Proyek telah di tetapkan !!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <!-- -------------------------------- -->
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        <div class="row justify-content-center">

                                            <div class="col-lg-8 mt-2">
                                                <div class="row justify-content-center border-bottom ">
                                                    <div class="col-lg-5">
                                                        <small>NIM</small>
                                                        <h5><?= $mhs[0]['nim'] ?></h5>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <small>Nama Lengkap</small>
                                                        <h5><?= $mhs[0]['nama_mhs'] ?></h5>
                                                    </div>
                                                </div>
                                                <?php if (!empty($mhs_proyek)) : ?>

                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Judul Proyek TA</small>
                                                            <h5 class="mt-2"><?= $mhs_proyek[0]['judul_ta'] ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Tim Pengerjaan</small>
                                                            <h5 class="mt-2"><?= $mhs_proyek[0]['tim'] ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Tanggal Pengajuan</small>
                                                            <h5 class="mt-2"><?= $mhs_proyek[0]['tanggal_pegajuan'] ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Status</small>
                                                            <h5 class="mt-2"><span class="badge rounded-0 <?= ($mhs_proyek[0]['status_ta'] == 'Menunggu Persetujuan') ? 'bg-warning text-white' : (($mhs_proyek[0]['status_ta'] == 'Disetujui') ? 'bg-info text-white' : (($mhs_proyek[0]['status_ta'] == 'Ditolak') ? 'bg-danger text-white' : 'bg-success text-white')) ?> "><?= $mhs_proyek[0]['status_ta'] ?></span>
                                                            </h5>
                                                        </div>
                                                    </div>

                                                    <?php if ($mhs_proyek[0]['status_ta'] == 'Disetujui' || $mhs_proyek[0]['status_ta'] == 'Selesai') : ?>

                                                    <?php else : ?>
                                                        <div class=" row justify-content-center my-2">
                                                            <div class="col-lg-10">
                                                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                                                    <button type="button" class="btn  rounded-0 p-0 px-2 text-success" data-toggle="modal" data-target="#edit">Edit

                                                                    </button>
                                                                    <a href="hapus-proyek-ta.php?id=<?= $mhs_proyek[0]['id_ta'] ?>" onclick="return confirm('Ingin menghapus data ini ??')" class="btn text-danger rounded-0 p-0 px-1 py-1">Hapus</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    <?php endif ?>

                                                <?php else : ?>
                                                    <div class="row">
                                                        <div class="col-lg mt-4 text-center text-muted">
                                                            <small>Data pengajuan belum tersedia 📝</small>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            </div>


                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <!-- Modal tambah proyek-->
                        <div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Proyek Akhir</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_mhs" value="<?= $mhs[0]['id_mhs'] ?>">
                                            <div class="row border-bottom justify-content-center">
                                                <div class="col-lg-6 my-1">
                                                    <small>NIM</small>
                                                    <h5><?= $mhs[0]['nim'] ?></h5>
                                                </div>
                                                <div class="col-lg-6 my-1">
                                                    <small>Nama Lengkap</small>
                                                    <h5><?= $mhs[0]['nama_mhs'] ?></h5>
                                                </div>
                                            </div>

                                            <div class="form-group mt-3">
                                                <label for="judul_ta">Judul Proyek Akhir</label>
                                                <textarea name="judul_ta" class="form-control" placeholder="Masukkan Judul Proyek..." required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="tim">Group (Kelompok atau Individu)</label>
                                                <select name="tim" class="form-control" id="group-select">
                                                    <option value="Kelompok">Kelompok</option>
                                                    <option value="Individu">Individu</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl">Tanggal Pengajuan</label>
                                                <input type="date" name="tgl" class="form-control" required>
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



                        <!-- Modal ubah proyek-->
                        <?php foreach ($data_proyek as $proyek) : ?>
                            <div class="modal fade" id="edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Edit data Proyek Akhir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ta" value="<?= $proyek['id_ta'] ?>">
                                            <input type="hidden" name="status_ta" value="<?= $proyek['status_ta'] ?>">
                                            <input type="hidden" name="id_mhs" value="<?= $proyek['id_mhs'] ?>">
                                            <div class="modal-body">
                                                <div class="row border-bottom">
                                                    <div class="col-lg-6 my-1">
                                                        <small>NIM</small>
                                                        <h5><?= $proyek['nim'] ?></h5>
                                                    </div>
                                                    <div class="col-lg-6 my-1">
                                                        <small>Nama Lengkap</small>
                                                        <h5><?= $proyek['nama_mhs'] ?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="judul_ta">Judul Proyek Akhir</label>
                                                    <textarea name="judul_ta" class="form-control tetx-dark font-weight-bold" required><?= $proyek['judul_ta'] ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tim">Group (Kelompok atau Individu)</label>
                                                    <select name="tim" class="form-control text-dark font-weight-bold" id="group-select">
                                                        <option value="Kelompok" <?= ($proyek['tim'] == 'Kelompok') ? 'selected' : '' ?>>Kelompok</option>
                                                        <option value="Individu" <?= ($proyek['tim'] == 'Individu') ? 'selected' : '' ?>>Individu</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl">Tanggal Pengajuan</label>
                                                    <input type="date" name="tgl" class="form-control text-dark font-weight-bold" value="<?= $proyek['tanggal_pegajuan'] ?>">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <!-- akhir modal -->

                        <!-- Modal detail proyek-->
                        <?php foreach ($data_proyek as $proyek) : ?>
                            <div class="modal fade" id="detail<?= $proyek['id_ta'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Detail Proyek Akhir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ta" value="<?= $proyek['id_ta'] ?>">
                                            <input type="hidden" name="id_mhs" value="<?= $proyek['id_mhs'] ?>">
                                            <div class="row m-0 mx-2 mt-2">
                                                <div class="col-lg">
                                                    <small class="text-muted">Nama Mahasiswa</small>
                                                    <h5 class="text-dark font-weight-500"><?= $proyek['nama_mhs'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2">
                                                <div class="col-lg">
                                                    <small class="text-muted">Judul Proyek (TA)</small>
                                                    <h5 class="text-dark font-weight-500"><?= $proyek['judul_ta'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2 border-bottom">
                                                <div class="col-lg">
                                                    <small class="text-muted">Status</small>
                                                    <h5 class="text-dark font-weight-500"><?= $proyek['status_ta'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2 mt-2">
                                                <div class="col-lg">
                                                    <p class="text-muted">Berikan tanggapan atau persetujuan terkait judul proyek (TA) yang diajukan. </p>
                                                </div>
                                            </div>
                                            <div class="row m-0 mx-2 mt-2">
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <label for="">Tentukan Satatus Proyek (Disetujui, Ditolak atau Selesai)</label>
                                                        <select name="status_ta" class="form-control form-control-sm">
                                                            <option value=""> pilih </option>
                                                            <option value="Disetujui"> Disetujui </option>
                                                            <option value="Ditolak"> Ditolak </option>
                                                            <option value="Selesai"> Selesai </option>
                                                            <option value="Menunggu Persetujuan"> Menunggu Persetujuan </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah_status" class="btn btn-success">Update & Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <!-- akhir modal -->
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

    <script>
        // JavaScript untuk mengontrol tampilan form anggota
        document.getElementById('group-select').addEventListener('change', function() {
            var anggotaGroup = document.getElementById('anggota-group');
            if (this.value === 'Kelompok') {
                anggotaGroup.style.display = 'block'; // Tampilkan jika memilih kelompok
            } else {
                anggotaGroup.style.display = 'none'; // Sembunyikan jika memilih individu
            }
        });
    </script>
</body>

</html>