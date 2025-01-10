<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

// cek tombol simpan
if (isset($_POST['simpan'])) {
    if (tambahMahasiswa($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}

// cek tombol update
if (isset($_POST['ubah'])) {

    if (ubahMahasiswa($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}

// data user
$data_user = tampilData("SELECT * FROM tb_user");




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

            <!-- sidebar -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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

            <!-- konten -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Tambah data Mahasiswa</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg text-right px-5">
                            <a href="data_mahasiswa.php" class="btn btn-sm btn-info my-1">Kembali</a>
                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="row">

                            <div class="col-lg">
                                <?php if (isset($suksess)) : ?>
                                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data mahasiswa berhasil ditambahkan !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                                        <strong> Data mahasiswa gagal ditambahkan !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif ?>

                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                                                    <div class="col-sm-9">
                                                        <select name="nim" id="id_user" class="form-control text-dark">
                                                            <option value=""> pilih NIM</option>
                                                            <?php $no = 1;
                                                            foreach ($data_user as $user) : ?>
                                                                <option value="<?= $user['username'] ?>">( <?= $no++ ?> ) - <?= $user['username'] ?> </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="nama_mhs" class="form-control" id="nama" placeholder="Nama Mahasiswa">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jk" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                                    <div class="col-sm-9">
                                                        <select name="jk" id="jk" class="form-control">
                                                            <option value=""> pilih </option>
                                                            <option value="Laki-Laki"> Laki-Laki </option>
                                                            <option value="Perempuan"> Perempuan </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodi" class="col-sm-3 col-form-label">Prodi</label>
                                                    <div class="col-sm-9">
                                                        <select name="prodi" id="prodi" class="form-control">
                                                            <option value=""> pilih </option>
                                                            <option value="Sistem Informasi" selected> Sistem Informasi </option>
                                                            <option value="Teknik Informatika"> Teknik Informatika </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                    <div class="col-sm-9">
                                                        <select name="status" id="status" class="form-control">
                                                            <option value=""> pilih </option>
                                                            <option value="Aktif" selected> Aktif</option>
                                                            <option value="Nonaktif"> Nonaktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="angakatan" class="col-sm-3 col-form-label">Angakatan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="angakatan" name="angkatan" value="2020">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="agama" class="col-sm-3 col-form-label">Agama</label>
                                                    <div class="col-sm-9">
                                                        <select name="agama" id="agama" class="form-control">
                                                            <option value=""> pilih </option>
                                                            <option value="Islam"> Islam </option>
                                                            <option value="Kristen"> Kristen </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodi" class="col-sm-3 col-form-label">Username</label>
                                                    <div class="col-sm-9">
                                                        <select name="id_user" id="id_user" class="form-control">
                                                            <option value=""> pilih </option>
                                                            <?php $no = 1;
                                                            foreach ($data_user as $user) : ?>
                                                                <option value="<?= $user['id_user'] ?>"> ( <?= $no++ ?> ) - <?= $user['username'] ?> </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg text-right">
                                                        <button class="btn btn-warning">Cancel</button>
                                                        <button type="submit" name="simpan" class="btn btn-success mr-2">SIMPAN</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
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