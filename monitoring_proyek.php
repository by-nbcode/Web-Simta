<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

// cek tombol ubah status
if (isset($_POST['ubah'])) {

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
    $profile_mhs  = tampilData("SELECT * FROM tb_mahasiswa JOIN tb_user ON tb_mahasiswa.id_user = tb_user.id_user WHERE tb_user.id_user = $_SESSION[id_user]")[0];
    $id_mhs = $profile_mhs['id_mhs'];

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
    <!-- bootstrap icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- fontawesome -->
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
        <!-- akhir navbar -->



        <div class="container-fluid page-body-wrapper">

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
            <!-- sidebar portal Dosen -->
            <?php if ($_SESSION['role'] == 'Dosen') : ?>
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

                            <?php
                            // data untuk centang persyaratan TA
                            $sk_ak = $monitoring['sk_akademik'];
                            $sk_ku = $monitoring['sk_keuangan'];
                            $laporan = $monitoring['laporan'];
                            $ppt = $monitoring['ppt'];

                            ?>

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

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center"><input type="checkbox" <?= ($sk_ak != null) ? 'checked' : '' ?>></td>
                                                                    <td class="text-center"><input type="checkbox" <?= ($sk_ku != null) ? 'checked' : '' ?>></td>
                                                                    <td class="text-center"><input type="checkbox" <?= ($laporan != null) ? 'checked' : '' ?>></td>
                                                                    <td class="text-center"><input type="checkbox" <?= ($ppt != null) ? 'checked' : '' ?>></td>

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
                                                                <?php if ($sk_ak != null) : ?>
                                                                    <a href="file_ta/sk_akademik/<?= $monitoring['sk_akademik'] ?>" download='SK Akademik <?= $monitoring['nama_mhs'] ?>' class="badge bg-success text-white rounded-lg mt-3"> <i class="bi bi-download"></i> Unduh File</a>
                                                                <?php else : ?>
                                                                    <p class="mt-3 text-danger">File berlum tersedia</p>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">SK Keuangan</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <?php if ($sk_ku != null) : ?>
                                                                    <a href="file_ta/sk_keuangan/<?= $monitoring['sk_keuangan'] ?>" download='SK Keuangan <?= $monitoring['nama_mhs'] ?>' class="badge bg-success text-white rounded-lg mt-3"> <i class="bi bi-download"></i> Unduh File</a>
                                                                <?php else: ?>
                                                                    <p class="mt-3 text-danger">File berlum tersedia</p>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">Laporan Dokumentasi</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <?php if ($laporan != null) : ?>
                                                                    <a href="file_ta/laporan/<?= $monitoring['laporan'] ?>" download='Laporan TA <?= $monitoring['nama_mhs'] ?>' class="badge bg-success text-white rounded-lg mt-3"> <i class="bi bi-download"></i> Unduh File</a>
                                                                <?php else : ?>
                                                                    <p class="mt-3 text-danger">File berlum tersedia</p>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 my-1">
                                                                <p class="font-weight-bold text-dark mt-3">Presentasi (PPT)</p>
                                                            </div>
                                                            <div class="col-lg-6 my-1">
                                                                <?php if ($ppt != null) : ?>
                                                                    <a href="file_ta/ppt/<?= $monitoring['ppt'] ?>" download='Presentasi PPT <?= $monitoring['nama_mhs'] ?>' class="badge bg-success text-white rounded-lg mt-3"> <i class="bi bi-download"></i> Unduh File</a>
                                                                <?php else : ?>
                                                                    <p class="mt-3 text-danger">File berlum tersedia</p>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                        <div class="row border-bottom mt-2">
                                                            <div class="col-lg-6">
                                                                <small>Link Github Proyek</small>
                                                                <?php if ($monitoring['git_link'] != null) : ?>
                                                                    <p class="text-dark font-weight-bold"><a href="" target="_blank"> <?= $monitoring['git_link'] ?></a></p>
                                                                <?php else : ?>
                                                                    <p class="mt-3 text-danger">Link berlum tersedia</p>
                                                                <?php endif ?>
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
                </div>
            <?php endif ?>
            <!-- akhir konten -->

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
                                    <div class="col-10 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Progress Proyek</h3>
                                        <h6 class="font-weight-normal mb-0">Progres pengerjaan proyek TA</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10 px-2">
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
                                <div class="card rounded-0">
                                    <div class="card-body">

                                        <div class="row justify-content-center">


                                            <?php if (!empty($progres_mhs)) : ?>
                                                <div class="col-lg-6">
                                                    <div class="card-header text-center">
                                                        <p class="m-0 font-weight-bold">Detail data Proyek TA</p>
                                                    </div>

                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Nama Lengkap</small>
                                                            <h4 class="my-2"><?= $progres_mhs[0]['nama_mhs'] ?></h4>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Judul Proyek</small>
                                                            <h4 class="my-2"><?= $progres_mhs[0]['judul_ta'] ?></h4>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Progres Pengerjaan (%)</small>
                                                            <h4 class="my-2">

                                                                <div class="progress" style="height: 20px;">
                                                                    <span class="progress-bar progress-bar-striped <?= ($progres_mhs[0]['progres'] <= 40) ? 'bg-danger' : (($progres_mhs[0]['progres'] <= 50) ? 'bg-warning' : 'bg-success') ?>" role="progressbar" style="width:  <?= $progres_mhs[0]['progres'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <?= $progres_mhs[0]['progres'] ?>%</span>
                                                                </div>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-10">
                                                            <small>Keterangan</small>
                                                            <h4 class="my-2"><?= $progres_mhs[0]['keterangan'] ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php

                                                // data untuk centang persyaratan TA
                                                $sk_ak = $progres_mhs[0]['sk_akademik'];
                                                $sk_ku = $progres_mhs[0]['sk_keuangan'];
                                                $laporan = $progres_mhs[0]['laporan'];
                                                $ppt = $progres_mhs[0]['ppt'];
                                                $proyek = $progres_mhs[0]['proyek'];
                                                $git_link = $progres_mhs[0]['git_link'];


                                                ?>
                                                <div class="col-lg-6">
                                                    <div class="card-header text-center">
                                                        <p class="m-0 font-weight-bold">Persyaratan Proyek TA</p>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-5">
                                                            <small>SK Akademik</small>
                                                            <h4 class="my-2">
                                                                <?php if ($sk_ak != null) : ?>
                                                                    <input type="checkbox" class="mt-1" <?= ($sk_ak != null) ? 'checked' : '' ?>>
                                                                    <a href="file_ta/sk_akademik/<?= $progres_mhs[0]['sk_akademik'] ?>" download="SK Akademik" class="badge mx-2 bg-success text-white rounded-lg"><i class="bi bi-download"></i> Unduh</a>
                                                                <?php else : ?>
                                                                    <p class="mt-2 text-danger">File belum tersedia</p>
                                                                <?php endif ?>
                                                            </h4>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <small>SK Keuangan</small>
                                                            <?php if ($sk_ku != null) : ?>
                                                                <h4 class="my-2 mx-3"> <input type="checkbox" <?= ($sk_ku != null) ? 'checked' : '' ?>>
                                                                    <a href="file_ta/sk_keuangan/<?= $progres_mhs[0]['sk_keuangan'] ?>" download="SK Keuangan" class="badge mx-2 bg-success text-white rounded-lg"><i class="bi bi-download"></i> Unduh</a>
                                                                </h4>
                                                            <?php else: ?>
                                                                <p class="mt-2 text-danger">File belum tersedia</p>
                                                            <?php endif ?>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-5">
                                                            <small>File Laporan Documentasi</small>
                                                            <?php if ($laporan != null) : ?>
                                                                <h4 class="my-2"> <input type="checkbox" <?= ($laporan != null) ? 'checked' : '' ?>>
                                                                    <a href="file_ta/laporan/<?= $progres_mhs[0]['laporan'] ?>" download="Laporan Dokumentasi TA" class="badge mx-2 bg-success text-white rounded-lg"><i class="bi bi-download"></i> Unduh</a>
                                                                </h4>
                                                            <?php else : ?>
                                                                <p class="mt-2 text-danger">File belum tersedia</p>
                                                            <?php endif ?>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <small>File Presentasi (PPT) </small>
                                                            <?php if ($ppt != null) : ?>
                                                                <h4 class="my-2 mx-3"> <input type="checkbox" <?= ($ppt != null) ? 'checked' : '' ?>>
                                                                    <a href="file_ta/ppt/<?= $progres_mhs[0]['ppt'] ?>" download="File Presentasi PPT" class="badge mx-2 bg-success text-white rounded-lg"><i class="bi bi-download"></i> Unduh</a>
                                                                </h4>
                                                            <?php else : ?>
                                                                <p class="mt-2 text-danger">File belum tersedia</p>
                                                            <?php endif ?>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center my-2">
                                                        <div class="col-lg-5">
                                                            <small>Proyek (Program)</small>
                                                            <p class="my-2"><?= $progres_mhs[0]['proyek'] ?></p>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <small>Link Github Proyek </small>
                                                            <?php if ($git_link != null) : ?>
                                                                <p class="my-2"> <a href="" target="_blank"> <?= $progres_mhs[0]['git_link'] ?></a> </p>
                                                            <?php else : ?>
                                                                <p class="mt-2 text-danger">Link belum tersedia</p>
                                                            <?php endif ?>
                                                        </div>
                                                    </div>

                                                    <div class="row my-2">
                                                        <div class="col-lg text-center mt-2">
                                                            <form action="" method="post">

                                                                <div class="form-group">
                                                                    <a href="update_proyek.php" class="btn btn-sm btn-primary rounded-lg" name="submit" type="submit">Update Progress</a>
                                                                    <a href="upload_berkas.php" class="btn btn-sm btn-success rounded-lg" name="submit" type="submit">Lengkapi Persyaratan TA</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>


                                            <?php else : ?>
                                                <p>Data progress belum tersedia!</p>
                                            <?php endif ?>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            <?php endif  ?>

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