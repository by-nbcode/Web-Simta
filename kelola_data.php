<?php
//  panggil file koneksi
require 'koneksi.php';


// tampil data
function tampilData($query)
{

    global $koneksi;

    $data =  mysqli_query($koneksi, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($data)) {

        $rows[] = $row;
    }

    return $rows;
}


// KELOLA DATA USER
// tambah user
function tambahUser($data)
{

    global $koneksi;

    // ambil data user

    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = $data['role'];

    // insert ke tabel user

    mysqli_query($koneksi, "INSERT INTO tb_user VALUES('', '$username', '$password', '$role') ");


    return mysqli_affected_rows($koneksi);
}
// ubah user
function ubahUser($data)
{

    global $koneksi;

    // ambil data user

    $username = $data['username'];
    $role = $data['role'];
    $password = $data['password'];
    $id_user = $data['id_user'];

    // insert ke tabel user
    mysqli_query($koneksi, "UPDATE tb_user SET 
                                            username = '$username',
                                            password = '$password', 
                                            role = '$role' WHERE  id_user = $id_user ");



    return mysqli_affected_rows($koneksi);
}

// ubah profile user
function ubahProfileUser($data)
{

    global $koneksi;

    $username = $data['username'];
    $password = $data['password'];
    $role = $data['role'];
    $password_2 = $data['password_2'];
    $id_user = $data['id_user'];

    $user = tampilData("SELECT * FROM tb_user WHERE id_user = $id_user")[0];

    // cek kesamaan password
    if (password_verify($password, $user['password'])) {

        // enkripsi password
        $password_baru =  password_hash($password_2, PASSWORD_DEFAULT);

        mysqli_query($koneksi, "UPDATE tb_user SET 
                                    username = '$username',
                                    password = '$password_baru', 
                                    role = '$role' WHERE id_user = $id_user ");

        return mysqli_affected_rows($koneksi);
    } else {

        echo '   <script>
            alert("Password lama tidak sesuai !!");
            </script>';
    }
}

// hapus user
function hapusUser($id_user)
{

    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM tb_user WHERE id_user = $id_user ");

    return mysqli_affected_rows($koneksi);
}
// ---------------------------------------------------------------------


// KELOLA DATA DOSEN
function tambahDosen($data)
{
    global $koneksi;
    // ambil data dosen
    $nip = $data['nip'];
    $nama_lengkap = $data['nama_lengkap'];
    $email = $data['email'];
    $id_user = $data['id_user'];

    // insert ke tabel dosen
    mysqli_query($koneksi, "INSERT INTO tb_dosen VALUES('', '$nip', '$nama_lengkap', '$email', '$id_user') ");

    return mysqli_affected_rows($koneksi);
}

// ubah dosen
function ubahDosen($data)
{

    global $koneksi;
    // ambil data dosen
    $nip = $data['nip'];
    $nama_lengkap = $data['nama_lengkap'];
    $email = $data['email'];
    $id_user = $data['id_user'];
    $id_dosen = $data['id_dosen'];

    // update data dari tabel dosen
    mysqli_query($koneksi, "UPDATE tb_dosen SET nip = '$nip', 
                                                nama_dosen = '$nama_lengkap',
                                                email = '$email',
                                                id_user = '$id_user' WHERE id_dosen = $id_dosen ");

    return mysqli_affected_rows($koneksi);
}

// hapus dosen
function hapusDosen($id_dosen)
{

    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM tb_dosen WHERE id_dosen = $id_dosen ");

    return mysqli_affected_rows($koneksi);
}
// ---------------------------------------------------------------------

// KELOLA DATA MAHASISWA
function tambahMahasiswa($data)
{
    global $koneksi;
    // ambil data mahasiswa
    $nim = $data['nim'];
    $nama_mhs = $data['nama_mhs'];
    $prodi = $data['prodi'];
    $angkatan = $data['angkatan'];
    $jk = $data['jk'];
    $status = $data['status'];
    $agama = $data['agama'];
    $email = $data['email'];
    $id_user = $data['id_user'];

    // insert ke tabel mahsiswa
    mysqli_query($koneksi, "INSERT INTO tb_mahasiswa VALUES('', '$nim', '$nama_mhs', '$prodi', '$angkatan', '$jk', '$status', '$agama', '$email', '$id_user') ");

    return mysqli_affected_rows($koneksi);
}

// ubah Mahasiswa
function ubahMahasiswa($data)
{
    global $koneksi;
    // ambil data mahasiswa
    $nim = $data['nim'];
    $nama_mhs = $data['nama_mhs'];
    $prodi = $data['prodi'];
    $angkatan = $data['angkatan'];
    $jk = $data['jk'];
    $status = $data['status'];
    $agama = $data['agama'];
    $email = $data['email'];
    $id_user = $data['id_user'];
    $id_mhs = $data['id_mhs'];

    // update data dari tabel mahasiswa
    mysqli_query($koneksi, "UPDATE tb_mahasiswa SET nim = '$nim',
                                                    nama_mhs = '$nama_mhs',
                                                    prodi = '$prodi',
                                                    angkatan = '$angkatan',
                                                    jenis_kelamin = '$jk',
                                                    status = '$status',
                                                    agama = '$agama',
                                                    email = '$email',
                                                    id_user = '$id_user' WHERE id_mhs = $id_mhs");
    return mysqli_affected_rows($koneksi);
}
// hapus Mahasiswa
function hapusMahasiswa($id_mhs)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM tb_mahasiswa WHERE id_mhs = $id_mhs ");

    return mysqli_affected_rows($koneksi);
}
// ---------------------------------------------------------------------
// KELOLA DATA JADWAL BIMBINGAN
function tambahJadwal($data)
{
    global $koneksi;

    // ambil data jadwal
    $id_mhs = $data['id_mhs'];
    $id_dosen = $data['id_dosen'];
    $tanggal = $data['tanggal'];
    $waktu = $data['waktu'];
    $hari = $data['hari'];
    $status = $data['status'];

    // insert ke tabel jadwal bimbingan
    mysqli_query($koneksi, "INSERT INTO tb_jadwal_bimbingan VALUES('', '$id_mhs', '$id_dosen', '$tanggal', '$waktu', '$hari', '$status')");

    return mysqli_affected_rows($koneksi);
}

// ubah jadwal
function ubahJadwal($data)
{
    global $koneksi;
    // ambil data jadwal
    $id_mhs = $data['id_mhs'];
    $id_dosen = $data['id_dosen'];
    $tanggal = $data['tanggal'];
    $waktu = $data['waktu'];
    $hari = $data['hari'];
    $status = $data['status'];
    $id_jb = $data['id_jb'];

    // update tabel jadwal bimbingan
    mysqli_query($koneksi, "UPDATE tb_jadwal_bimbingan SET id_mhs = '$id_mhs',      
                                                            id_dosen = '$id_dosen',
                                                            tanggal = '$tanggal',
                                                            waktu = '$waktu',
                                                            hari = '$hari',
                                                            status_jb = '$status'
                                                
                                                            WHERE id_jb = $id_jb");

    return mysqli_affected_rows($koneksi);
}
// hapus jadwal
function hapusJadwal($id_jadwal)
{

    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM tb_jadwal_bimbingan WHERE id_jb = $id_jadwal ");

    return mysqli_affected_rows($koneksi);
}
// ---------------------------------------------------------------------

// ---------------------------------------------------------------------
// KELOLA DATA PROYEK AKHIR (TA)
// KELOLA DATA PROYEK AKHIR (TA)
function tambahProyekTa($data)
{
    global $koneksi;

    // Ambil data proyek TA dari form
    $id_mhs = $data['id_mhs'];
    $judul_ta = $data['judul_ta'];
    $tgl = $data['tgl'];
    $status = 'Menunggu Persetujuan';
    $tim = $data['tim']; // Kelompok atau Individu

    // Insert data ke tabel proyek TA
    mysqli_query($koneksi, "INSERT INTO tb_ta (id_mhs, judul_ta, tanggal_pegajuan, tim, status_ta) 
                            VALUES ('$id_mhs', '$judul_ta', '$tgl', '$tim', '$status')");


    return mysqli_affected_rows($koneksi);
}


// ubah proyek ta
function ubahProyekTa($data)
{
    global $koneksi;

    // ambil data pryek ta
    $id_mhs = $data['id_mhs'];
    $judul_ta = $data['judul_ta'];
    $tgl = $data['tgl'];
    $status = $data['status_ta'];
    $id_ta = $data['id_ta'];

    // update tabel jadwal bimbingan
    mysqli_query($koneksi, "UPDATE tb_ta SET id_mhs = '$id_mhs',      
                                             judul_ta = '$judul_ta',
                                             tanggal_pegajuan = '$tgl',
                                             status_ta = '$status' WHERE id_ta = $id_ta");

    return mysqli_affected_rows($koneksi);
}
// ubah proyek ta
function ubahStatusProyek($data)
{
    global $koneksi;

    // ambil data proyek TA
    $status = $data['status_ta'];
    $id_ta = $data['id_ta'];
    $id_mhs = $data['id_mhs'];

    // update tabel proyek TA
    $ubah_status = mysqli_query($koneksi, "UPDATE tb_ta SET status_ta = '$status' WHERE id_ta = $id_ta");

    // Insert ke tabel monitoring hanya jika status 'Disetujui'
    if ($status === 'Disetujui') {
        mysqli_query($koneksi, "INSERT INTO monitoring_proyek VALUES ('', '$id_mhs', '', '', '', '', '', '', '', '')");
    }

    return mysqli_affected_rows($koneksi);
}
// hapus proyek ta
function hapusProyekTa($id_ta)
{

    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM tb_ta WHERE id_ta = $id_ta ");

    return mysqli_affected_rows($koneksi);
}
// ---------------------------------------------------------------------

// ---------------------------------------------------------------------
// KELOLA DATA MONITORING PROYEK TA
function ubahProgresMonitoring($data)
{
    global $koneksi;

    // ambil data pryek ta
    $progres = $data['progres'];
    $ket = $data['ket'];
    $id_monitoring = $data['id_monitoring'];

    // update tabel monitoring
    mysqli_query($koneksi, "UPDATE monitoring_proyek SET progres = '$progres', keterangan = '$ket' WHERE id_monitoring = $id_monitoring");

    return mysqli_affected_rows($koneksi);
}
// tambah syarat
function tambahSyaratTA($data)
{
    global $koneksi;

    // Ekstrak data dari array $data
    $id_mhs = $data['id_mhs'];
    $proyek = $data['proyek'];
    $git = $data['git'];
    $progres = $data['progres'];
    $ket = $data['ket'];
    $id_monitoring = $data['id_monitoring'];

    // Fungsi untuk mengunggah satu file
    function uploadFile($file, $target_dir, $allowed_types = ['pdf', 'docx', 'pptx', 'jpg', 'jpeg', 'png'])
    {
        // Generate nama file unik menggunakan uniqid() dan ekstensi file
        $unique_filename = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadOk = 1;
        $target_file = $target_dir . $unique_filename;

        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Kembalikan hanya nama file, bukan path lengkap
                return $unique_filename;
            } else {
                return false;
            }
        }
    }

    // Proses unggah file SK Akademik
    $target_dir_sk_ak = "file_ta/sk_akademik/";
    $sk_ak  =  uploadFile($_FILES['sk_ak'], $target_dir_sk_ak);

    // Proses unggah file SK Keuangan
    $target_dir_sk_ku = "file_ta/sk_keuangan/";
    $sk_ku =   uploadFile($_FILES['sk_ku'], $target_dir_sk_ku);

    // Proses unggah file Laporan
    $target_dir_laporan = "file_ta/laporan/";
    $laporan =  uploadFile($_FILES['laporan'], $target_dir_laporan);

    // Proses unggah file PPT
    $target_dir_ppt = "file_ta/ppt/";
    $ppt =  uploadFile($_FILES['ppt'], $target_dir_ppt);


    // Simpan data ke database
    mysqli_query($koneksi, "UPDATE monitoring_proyek SET id_mhs = '$id_mhs',
                                                          sk_akademik = '$sk_ak',
                                                          sk_keuangan = '$sk_ku',
                                                          laporan = '$laporan',
                                                          ppt = '$ppt',
                                                          proyek = '$proyek',
                                                          git_link = '$git',
                                                          progres = '$progres',
                                                          keterangan = '$ket'

                                                          WHERE id_monitoring = $id_monitoring");

    return mysqli_affected_rows($koneksi);
}
function hapusMonitoring($id_monitoring)
{

    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM monitoring_proyek WHERE id_monitoring = $id_monitoring ");

    return mysqli_affected_rows($koneksi);
}


// ---------------------------------------------------------------------








// MENGHITUNG DATA
function totalMahasiswa()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa")->num_rows;
}
// memghitung toal data user
function totalUser()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM tb_user")->num_rows;
}
// memghitung toal data Dosen
function totalDosen()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM tb_dosen")->num_rows;
}
// memghitung toal data pengajuan proyek TA
function totalPengajuanTa()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM tb_ta")->num_rows;
}
// memghitung toal data jadwal bimbingan
function totalJadwal()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM tb_jadwal_bimbingan")->num_rows;
}
// memghitung toal proyek yang telah selesai
function totalSelesai()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM monitoring_proyek WHERE progres = 100")->num_rows;
}
// memghitung toal proyek yang sedang mengerjakan
function totalProses()
{

    global $koneksi;

    return mysqli_query($koneksi, "SELECT * FROM monitoring_proyek WHERE progres < 100 ")->num_rows;
}
