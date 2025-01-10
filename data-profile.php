<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';






if (isset($_POST['simpan'])) {

    if (ubahProfileUser($_POST) > 0) {

        $sukses = true;
    } else {

        $error = true;
    }
}


$data_user = tampilData("SELECT * FROM tb_user WHERE id_user = $_SESSION[id_user]")[0];

if ($_SESSION['role'] == 'Dosen') {

    $dosen = tampilData("SELECT * FROM tb_dosen JOIN tb_user ON tb_dosen.id_user = tb_user.id_user WHERE tb_user.id_user = $_SESSION[id_user]")[0];
}

// jika yang login adalah mahasiswa
if ($_SESSION['role'] == 'Mahasiswa') {


    $mhs = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user WHERE tb_user.id_user = $_SESSION[id_user]")[0];
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

            <!-- tampilan Sidebar dan Konten Portal ADMIN-->
            <?php if ($_SESSION['role'] == 'Admin') : ?>
                <!-- <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_mahasiswa.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Data Mahasiswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_dosen.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Data Dosen</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_jadwal.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Jadwal Bimbingan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_user.php" aria-expanded="false" aria-controls="auth">
                                <i class="icon-head menu-icon"></i>
                                <span class="menu-title">Data User</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('Apakah anda ingin meninggalkan portal ? ')">
                                <i class="icon-ban menu-icon"></i>
                                <span class="menu-title">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav> -->

                <!-- sidebar -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_mahasiswa.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-users"></i>
                                <span class="menu-title mx-3">Data Mahasiswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_dosen.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-user"></i>
                                <span class="menu-title mx-3">Data Dosen</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link" href="data_jadwal.php" aria-expanded="false" aria-controls="auth">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span class="menu-title mx-3">Jadwal Bimbingan</span>
                        </a>
                    </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="data_user.php" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="menu-title mx-3">Data User</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('Apakah anda ingin meninggalkan portal ? ')">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="menu-title mx-3">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- akhir sidebar -->
            <?php endif ?>

            <?php if ($_SESSION['role'] == 'Admin') : ?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row  ">
                            <div class="col-md grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Profile Saya</h3>
                                        <h6 class="font-weight-normal mb-0">Data profile user</h6>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="justify-content-end d-flex">
                                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    </i> Today (<?= date('d, m,  Y') ?>)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <?php if (isset($sukses)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data telah diupdate!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data GAGAL diupdate!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <div class="card shadow-sm border-0 p-2 my-2">
                                    <form action="" method="post">
                                        <input type="hidden" name="id_user" value="<?= $data_user['id_user'] ?>">
                                        <input type="hidden" name="password" value="<?= $data_user['password'] ?>">
                                        <input type="hidden" name="role" value="<?= $data_user['role'] ?>">
                                        <div class="row mt-3 justify-content-center">
                                            <div class="col-lg-3">
                                                <h5 class="mt-3">Username</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <input type="text" name="username" class="form-control font-weight-bold" value="<?= $data_user['username'] ?>">
                                            </div>
                                        </div>
                                        <div class="row my-1 mt-2 justify-content-center">
                                            <div class="col-lg-8 mt-3">
                                                <h4>Ubah Password</h4>
                                            </div>
                                        </div>

                                        <div class="row mt-3 justify-content-center">
                                            <div class="col-lg-3">
                                                <h5 class="mt-3">Password Sebelumnya</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <input type="text" name="password" class="form-control" placeholder="Masukkan password sebelumnya" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3 justify-content-center">
                                            <div class="col-lg-3">
                                                <h5 class="mt-3">Password Baru</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <input type="text" name="password_2" class="form-control" placeholder="Masukkan password baru" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3 justify-content-center">
                                            <div class="col-lg-3">

                                            </div>
                                            <div class="col-lg-5">
                                                <button class="btn btn-success rounded-lg" name="simpan" type="submit">Simpan</button>
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
    <!-- -------------------------------------------------------- -->


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
                <div class="row  ">
                    <div class="col-md grid-margin">
                        <div class="row">
                            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h3 class="font-weight-bold">Profile Saya</h3>
                                <h6 class="font-weight-normal mb-0">Data profile user</h6>
                            </div>
                            <div class="col-12 col-xl-4">
                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            </i> Today (<?= date('d, m,  Y') ?>)
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <?php if (isset($sukses)) : ?>
                            <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                <strong> Data telah diupdate!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif ?>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                <strong> Data GAGAL diupdate!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif ?>
                        <div class="card shadow-sm border-0 rounded-0 p-2 my-2">
                            <div class="row justify-content-center mt-3 my-2">
                                <div class="col-lg-4">
                                    <small>NIP</small>
                                    <h5 class="my-2"><?= $dosen['nip'] ?></h5>
                                </div>
                                <div class="col-lg-4">
                                    <small>Nama Lengkap</small>
                                    <h5 class="my-2"><?= $dosen['nama_dosen'] ?></h5>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3 my-2">
                                <div class="col-lg-8">
                                    <small>Email</small>
                                    <h5 class="my-2"><?= $dosen['email'] ?></h5>
                                </div>
                            </div>
                            <form action="" method="post">
                                <input type="hidden" name="id_user" value="<?= $data_user['id_user'] ?>">
                                <input type="hidden" name="password" value="<?= $data_user['password'] ?>">
                                <input type="hidden" name="role" value="<?= $data_user['role'] ?>">
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-3">
                                        <h5 class="mt-3">Username</h5>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" name="username" class="form-control font-weight-bold" value="<?= $data_user['username'] ?>">
                                    </div>
                                </div>
                                <div class="row my-1 mt-2 justify-content-center">
                                    <div class="col-lg-8 mt-3">
                                        <h4>Ubah Password</h4>
                                    </div>
                                </div>

                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-3">
                                        <h5 class="mt-3">Password Sebelumnya</h5>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" name="password" class="form-control" placeholder="Masukkan password sebelumnya" required>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-3">
                                        <h5 class="mt-3">Password Baru</h5>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" name="password_2" class="form-control" placeholder="Masukkan password baru" required>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-3">

                                    </div>
                                    <div class="col-lg-5">
                                        <button class="btn btn-success rounded-lg" name="simpan" type="submit">Simpan</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <!-- -------------------------------------------------------- -->

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
                                <h3 class="font-weight-bold">Porofile Saya</h3>
                                <h6 class="font-weight-normal mb-0">Detail Data Profile</h6>
                            </div>
                            <div class="col-12 col-xl-4">
                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            </i> Today (<?= date('d, m,  Y') ?>)
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <?php if (isset($sukses)) : ?>
                            <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                <strong> Data telah diupdate!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif ?>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                <strong> Data GAGAL diupdate!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif ?>

                        <form action="" method="post">
                            <div class="card shadow-sm border-0 p-2 px-3 my-2 rounded-0">
                                <div class="row my-2 mt-3 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Nama Lengkap</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['nama_mhs'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">NIM</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['nim'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Jenis Kelamin</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['jenis_kelamin'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Agama</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['agama'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Program Studi</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['prodi'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Angkatan</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['angkatan'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Status</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-white font-weight-bold bg-success px-2"> <?= $mhs['status'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-lg-5">
                                        <p class="text-muted">Email</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-dark font-weight-bold"> : <?= $mhs['email'] ?></p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-10">
                                        <p class="text-muted text-dark font-weight-bold mx-4">DATA USER</p>
                                    </div>
                                </div>

                                <input type="hidden" name="id_user" value="<?= $mhs['id_user'] ?>">
                                <input type="hidden" name="role" value="<?= $mhs['role'] ?>">
                                <input type="hidden" name="password" value="<?= $mhs['password'] ?>">
                                <div class="row mx-4">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <small>Username</small>
                                            <input type="text" name="username" class="form-control form-control-sm border-0" value="<?= $mhs['username'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <small>Masukkan Password Lama</small>
                                            <input type="password" name="password" class="form-control form-control-sm border-0" placeholder="Password Lama...">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mx-4">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <small>Masukkan Pasword Baru</small>
                                            <input type="password" name="password_2" class="form-control form-control-sm border-0" placeholder="Password Baru...">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mx-4 mt-3">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <button class="btn btn-sm btn-success rounded-lg" name="simpan" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->

        </div>
    <?php endif ?>
    <!-- -------------------------------------------------------- -->

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