<?php

//  panggil file koneksi
session_start();
require 'koneksi.php';
require 'kelola_data.php';

// cek tombol simpan
if (isset($_POST['simpan'])) {
    if (tambahUser($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}

// cek tombol update
if (isset($_POST['ubah'])) {

    if (ubahUser($_POST) > 0) {

        $suksess = true;
    } else {

        $error = true;
    }
}

// data user
$data_user = tampilData("SELECT * FROM tb_user ORDER BY id_user DESC");



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

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
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
            <!-- akhir sidebar -->

            <!-- konten -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Data User</h3>
                                    <h6 class="font-weight-normal mb-0">Kelola data User</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg text-right px-5">
                            <button class="btn btn-sm btn-success my-1" name="submit" type="button" data-toggle="modal" data-target="#tambah">Tambah User</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="myTable" class="display expandable-table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Username</th>
                                                            <th>Role / Hak Akses</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        foreach ($data_user as $user) : ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= $user['username'] ?></td>
                                                                <td><?= $user['role'] ?></td>
                                                                <td class="text-center">

                                                                    <a href="" class="text-success mx-2" data-toggle="modal" data-target="#edit<?= $user['id_user'] ?>">Edit</a>
                                                                    <a href="hapus-user.php?id= <?= $user['id_user'] ?>" class="text-danger mx-2">Hapus</a>
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


                    <!-- Modal tambah user-->
                    <div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Tambah data User Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" name="username" placeholder="Username" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" placeholder="Password" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Role / Hak aksess</label>
                                            <select name="role" class="form-control form-control-sm">
                                                <option value=""> pilih </option>
                                                <option value="Admin"> Admin </option>
                                                <option value="Dosen"> Dosen </option>
                                                <option value="Mahasiswa" selected> Mahasiswa </option>
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

                    <!-- Modal edit user-->
                    <?php foreach ($data_user as $user) : ?>
                        <div class="modal fade" id="edit<?= $user['id_user'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Edit data User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                        <input type="hidden" name="password" value="<?= $user['password'] ?>">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username" value="<?= $user['username'] ?>" class="form-control form-control-sm font-weight-bold">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Role / Hak aksess</label>
                                                <select name="role" class="form-control form-control-sm font-weight-bold text-dark">
                                                    <option value=""> pilih </option>
                                                    <option value="Admin" <?= ($user['role'] == 'Admin') ? 'selected' : '' ?>> Admin </option>
                                                    <option value="Dosen" <?= ($user['role'] == 'Dosen') ? 'selected' : '' ?>> Dosen </option>
                                                    <option value="Mahasiswa" <?= ($user['role'] == 'Mahasiswa') ? 'selected' : '' ?>> Mahasiswa </option>
                                                </select>
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

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>