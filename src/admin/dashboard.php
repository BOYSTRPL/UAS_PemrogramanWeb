<?php

$title = 'Dashboard';

require '../../public/app.php';

require '../layouts/header.php';

require '../layouts/navAdmin.php';

// Mengambil jumlah data dari database
$jumlah_pengaduan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan"))['total'];
$jumlah_tanggapan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tanggapan"))['total'];
$jumlah_masyarakat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM masyarakat"))['total'];

// Query untuk menjalankan looping generate
$query = "SELECT * FROM (( tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan )
                          INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas )";
$result = mysqli_query($conn, $query);

?>

<!-- Card untuk jumlah pengaduan -->
<div class="row mb-3">
  <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="300">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col ml-3">
            <div class="h5 mb-0 font-weight-bold text-info"><?= $jumlah_pengaduan; ?> Pengaduan</div>
          </div>
          <i class="fas fa-comment fa-2x text-gray-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card untuk jumlah tanggapan -->
  <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="700">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col ml-3">
            <div class="h5 mb-0 font-weight-bold text-primary"><?= $jumlah_tanggapan; ?> Tanggapan</div>
          </div>
          <i class="fas fa-comments fa-2x text-gray-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card untuk jumlah akun masyarakat -->
  <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="700">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col ml-3">
            <div class="h5 mb-0 font-weight-bold text-dark"><?= $jumlah_masyarakat; ?> Akun masyarakat</div>
          </div>
          <i class="fas fa-users fa-2x text-gray-500"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Looping untuk detail data -->
<?php while ($row = mysqli_fetch_assoc($result)) : ?>
  <div class="col-6">
    <div class="card shadow mb-4" data-aos="fade-up">
      <!-- Card Content - Collapse -->
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h6 class="m-0 font-weight-bold text-primary mt-2">NIK : <?= $row['nik']; ?></h6>
          </div>
          <div class="col-6">
            <div class="d-sm-flex align-items-center justify-content-end">
              <a href="generate_pdf.php?id_tanggapan=<?= $row['id_tanggapan']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>
          </div>
        </div>
      </div>
      <div class="collapse show" id="generate">
        <div class="card-body">
          <div class="row">
            <div class="col-4">
              <h6 class="text-primary font-weight-bold">Foto : <img src="../../assets/img/img-buat-laporan.svg" width="50" alt=""></h6>
            </div>
            <div class="col-8">
              <h6> <span class="text-primary font-weight-bold">Tanggal Pengaduan :</span> <?= $row['tgl_pengaduan']; ?></h6>
              <h6> <span class="text-primary font-weight-bold">Tanggal Tanggapan :</span> <?= $row['tgl_tanggapan']; ?></h6>
            </div>
          </div>
          <hr class="bg-primary">
          <h6><span class="text-primary font-weight-bold">Laporan :</span> <?= $row['isi_laporan']; ?></h6>
          <h6><span class="text-primary font-weight-bold">Tanggapan :</span> <?= $row['tanggapan']; ?></h6>
          <hr class="bg-primary">
          <div class="row">
            <div class="col-8 mt-2">
              <h5> <span class="text-primary font-weight-bold">Di tanggapi dari :</span> <?= $row['nama_petugas']; ?></h5>
            </div>
            <div class="col-4">
              <div class="d-flex justify-content-end">
                <a href="preview.php?id_tanggapan=<?= $row['id_tanggapan']; ?>" class="btn btn-outline-primary">Preview</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>

<?php require '../layouts/footer.php'; ?>
