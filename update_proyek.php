<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

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
    $progres_siswa = tampilData("SELECT * FROM monitoring_proyek JOIN tb_mahasiswa ON monitoring_proyek.id_mhs = tb_mahasiswa.id_mhs JOIN tb_ta ON monitoring_proyek.id_mhs = tb_ta.id_mhs WHERE tb_mahasiswa.id_mhs = $id_mhs")[0];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="<?= ($_SESSION['role'] == 'Dosen') ? 'sidebar-icon-only' : '' ?>   ">
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
        <!-- akhir navba -->


        <div class="container-fluid page-body-wrapper">

            <!-- sidebar portal Mahasiswa -->
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
                        <li class="nav-item active">
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
                                    <div class="col-10 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Update Progress Proyek</h3>
                                        <h6 class="font-weight-normal mb-0">Update progres pengerjaan dan perkembangan proyek anda</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10 px-2">
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
                                            <div class="col-lg-6">
                                                <form action="" method="post">
                                                    <input type="hidden" name="id_monitoring" value="<?= $progres_siswa['id_monitoring'] ?>">
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">

                                                            <small>Update progres Proyek</small>
                                                            <input type="text" name="progres" class="form-control form-control-sm font-weight-bold my-2" value="<?= $progres_siswa['progres'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Update Ket sesuai Perkembangan Proyek</small>
                                                            <input type="text" name="ket" class="form-control form-control-sm font-weight-bold my-2" value="<?= $progres_siswa['keterangan'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <a href="monitoring_proyek.php" class="btn btn-sm btn-danger rounded-sm" name="update_proyek" type="submit">Kembali</a>
                                                            <button class="btn btn-sm btn-success rounded-sm" name="update_proyek" type="submit">Simpan & Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- akhir konten -->

                    </div>

                </div>
            <?php endif ?>

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