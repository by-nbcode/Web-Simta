<?php
//  panggil file koneksi
session_start();
require 'koneksi.php';

// jika login ditekan
if (isset($_POST['login'])) {

  // get username
  $username = $_POST['username'];
  $password = $_POST['password'];

  // query ke tabel user
  $data = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username' ");

  // cek ketersediaan username
  if (mysqli_num_rows($data)  > 0) {

    $user = mysqli_fetch_assoc($data);
    // cek password

    if (password_verify($password, $user['password'])) {

      // pindahkan ke dashboard
      $_SESSION['role'] = $user['role'];
      $_SESSION['id_user'] = $user['id_user'];
      $_SESSION['loggedin'] = true;
      header('location: dashboard.php');
    } else {

      $password_error = true;
    }
  } else {

    $username_error = true;
  }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Simta</title>
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
</head>

<body class="bg-white">
  <div class="container-scroller">
    <div class="container-fluid  full-page-wrapper">
      <div class="bg-white d-flex align-items-center auth px-0">
        <div class="row w-100 " style="height: 100vh; ">
          <div class="col-lg-6 mt-5 px-5">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo mt-5">
                <h3>Hallo ! Selamat datang di Sistem Informasi Monitoring Tugas Akhir (SIMTA)</h3>
              </div>
              <h6 class="font-weight-light">Silahkan Login</h6>

              <?php if (isset($username_error)) : ?>
                <div class="alert alert-danger border-0">
                  Username tidak ditemukan !!
                </div>
              <?php endif ?>
              <?php if (isset($password_error)) : ?>
                <div class="alert alert-danger border-0">
                  Username dan password tidak sesuai !!
                </div>
              <?php endif  ?>



              <form class="pt-3" method="post" action="">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" autocomplete="off">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" autocomplete="off">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="login">LOGIN</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-lg-6 d-none d-lg-flex">
            <img src="images/demo/banner.png" class="img-fluid" style="height: 100vh; object-fit: fill;">
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>