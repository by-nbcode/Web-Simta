<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';


// jika yang login adalah mahasiswa
if ($_SESSION['role'] == 'Mahasiswa') {


  $mhs = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user WHERE tb_user.id_user = $_SESSION[id_user]")[0];

  $id_mhs = $mhs['id_mhs'];

  // data monitoring portal Siswa
  $progres_mhs = tampilData("SELECT * FROM monitoring_proyek JOIN tb_mahasiswa ON monitoring_proyek.id_mhs = tb_mahasiswa.id_mhs JOIN tb_ta ON monitoring_proyek.id_mhs = tb_ta.id_mhs WHERE tb_mahasiswa.id_mhs = $id_mhs");
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
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item active">
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
      <?php endif ?>

      <?php if ($_SESSION['role'] == 'Admin') : ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Selamat datang <?= $_SESSION['role'] ?></h3>
                    <h6 class="font-weight-normal mb-0">Portal Pengelolaan data Mahasiswa</h6>
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
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                  <div class="card-people mt-auto">
                    <img src="images/dashboard/people.svg" alt="people">
                    <div class="weather-info">
                      <div class="d-flex">
                        <div>
                          <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                        </div>
                        <div class="ml-2">
                          <h4 class="location font-weight-normal">Indonesia</h4>
                          <h6 class="font-weight-normal">Ambon</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin transparent">
                <div class="row">
                  <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                      <div class="card-body">
                        <p class="mb-4">Total Mahasiswa</p>
                        <h4 class="fs-30 mb-2"><?= totalMahasiswa() ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                      <div class="card-body">
                        <p class="mb-4">Total Dosen</p>
                        <p class="fs-30 mb-2"><?= totalDosen() ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                      <div class="card-body">
                        <p class="mb-4">Total User</p>
                        <h4 class="fs-30 mb-2"><?= totalUser() ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                      <div class="card-body">
                        <p class="mb-4">Jadwal Bimbingan</p>
                        <h4 class="fs-30 mb-2"><?= totalJadwal() ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
      <?php endif ?>
      <!-- -------------------------------------------------------- -->


      <!-- tampilan Sidebar dan Konten Portal DOSEN-->
      <?php if ($_SESSION['role'] == 'Dosen') : ?>
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item active">
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
                    <h3 class="font-weight-bold">Portal Dosen</h3>
                    <h6 class="font-weight-normal mb-0">Monitoring Proyek Akhir</h6>
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
            <div class="row">
              <div class="col-md-3 col-6 mb-2">
                <div class="card card-light-danger">
                  <div class="card-body">
                    <p class="mb-4">Pengajuan TA</p>
                    <p class="fs-30 mb-2"><?= totalPengajuanTa() ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="card card-light-blue">
                  <div class="card-body">
                    <p class="mb-4">Telah Selesai</p>
                    <p class="fs-30 mb-2"><?= totalSelesai() ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="card card-dark-blue">
                  <div class="card-body">
                    <p class="mb-4">Proses Pengerjaan</p>
                    <p class="fs-30 mb-2"><?= totalProses() ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6 mb-2">
                <div class="card card-tale ">
                  <div class="card-body">
                    <p class="mb-4">Total Mahasiswa</p>
                    <p class="fs-30 mb-2"><?= totalMahasiswa() ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-lg-10">
                <h3>Selamat datang di Sistem Informasi Monitoring Proyek TA (SIMTA)</h3>
                <h5 class="my-4">Pengelolaan dan Monitoring Proyek TA Prodi Sistem Informasi tahun 2024. </h5>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
      <?php endif ?>
      <!-- -------------------------------------------------------- -->

      <!-- tampilan Sidebar dan Konten Portal MAHASISWA-->
      <?php if ($_SESSION['role'] == 'Mahasiswa') : ?>
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item active">
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
                    <h3 class="font-weight-bold">Portal Mahasiswa</h3>
                    <h6 class="font-weight-normal mb-0">Monitoring Proyek Akhir</h6>
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
                <div class="row">
                  <div class="col-md-4 col-6 mb-2">
                    <div class="card card-light-danger rounded-lg">
                      <div class="card-body">
                        <p class="mb-4">Pengajuan TA</p>
                        <p class="fs-30 mb-2"><?= totalPengajuanTa() ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-6">
                    <div class="card card-light-blue rounded-lg">
                      <div class="card-body">
                        <p class="mb-4">Telah Selesai</p>
                        <p class="fs-30 mb-2"><?= totalSelesai() ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-6">
                    <div class="card card-dark-blue rounded-lg">
                      <div class="card-body">
                        <p class="mb-4">Proses Pengerjaan</p>
                        <p class="fs-30 mb-2"><?= totalProses() ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">

              <div class="col-lg-10">
                <div class="card shadow-sm border-0 p-2 my-2 px-4 rounded-lg">
                  <p class="my-2 mt-3">Selamat datang <strong><?= $mhs['nama_mhs'] ?> </strong>👋👋 </p>
                  <h4 class="mt-2">Progress pengerjaan proyek akhir anda</h4>

                  <?php if ($progres_mhs) : ?>
                    <div class="row my-3">
                      <div class="col-lg-6">
                        <small class="text-muted">Judul Proyek TA</small>
                        <p class="font-weight-bold"><?= $progres_mhs[0]['judul_ta'] ?></p>
                      </div>
                      <div class="col-lg-6">
                        <small class="text-muted">Progres Pengerjaan</small>
                        <p class="font-weight-bold">
                        <p><?= $progres_mhs[0]['progres'] ?>%</p>
                        <div class="progress" style="height: 20px;">
                          <span class="progress-bar progress-bar-striped <?= ($progres_mhs[0]['progres'] <= 40) ? 'bg-danger' : (($progres_mhs[0]['progres'] <= 50) ? 'bg-warning' : 'bg-success') ?>" role="progressbar" style="width:  <?= $progres_mhs[0]['progres'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <?= $progres_mhs[0]['progres'] ?>%</span>
                        </div>
                        </p>
                      </div>
                    </div>
                  <?php else : ?>
                    <p class="text-muted my-3">Data proyek belum tersedia 📝 </p>
                  <?php endif ?>
                </div>
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