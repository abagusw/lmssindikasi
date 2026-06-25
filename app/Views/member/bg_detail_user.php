<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php

use function PHPUnit\Framework\stringContains;

$uri = service('uri');

$flag = $uri->getSegment(3); ?>

<?php
function tanggal_indonesia($tanggal)
{
  if (empty($tanggal)) {
    return '';
  }

  $bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
  ];
  // check if $tanggal is containing time, sample format 'YYYY-MM-DD HH:MM:SS'
  if (strpos($tanggal, ':') !== false) {
    $tanggal = explode(' ', $tanggal)[0];
  }

  $pecah = explode('-', $tanggal); // Format: Y-m-d
  $tahun = $pecah[0];
  $bulanNama = $bulan[$pecah[1]];
  $hari = $pecah[2];

  return $hari . ' ' . $bulanNama . ' ' . $tahun;
}

if ($getData['flag_active'] == 0) {
  $stSpan = "<span class='badge bg-secondary'>Pending</span>";
  //$btnSpan = "<button class='btn btn-warning' onclick=\"kirimEmail(".$getData['id'].", '".base_url('email/kirimEmailApprove/'.$getData['id'])."')\">Resend Activation</button>";
  $btnSpan = "<button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $getData['id'] . "," . $getData['flag_active'] . ")>Resend Activation</button>";
  $lblStrong = "<strong>Pending account activation</strong><br>
          <small class='text-muted'>This user hasn’t activated their account. You can resend the activation email if needed.</small>";
} elseif ($getData['flag_active'] == 1) {
  $stSpan = "<span class='badge bg-primary'>Active</span>";
  $btnSpan = "<button class='btn btn-outline-danger'>Reset Password</button><button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $getData['id'] . "," . $getData['flag_active'] . ")>Deactivate Account</button>";
  $lblStrong = "This account is active";
} else {
  $stSpan = "<span class='badge bg-danger'>Deactivated</span>";
  $btnSpan = "<button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(" . $getData['id'] . "," . $getData['flag_active'] . ")>Reactivate Account</button>";
  $lblStrong = "<strong>This account is deactivated</strong><br>
          <small class='text-muted'>This user no longer has access to the system. You can reactive the account at any time from this page.</small>";
}

?>
<div class="row">
  <!-- Tab Switch Button -->
  <div class="container-fluid py-3">
    <!-- Breadcrumb and Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <a href="<?= base_url() ?>member/user/1" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Back</a>
        <h4 class="mt-2 mb-0"><?= $getData['nama_lengkap'] ?> <?= $stSpan ?></h4>
        <small class="text-muted">Once active, membership number for this user will appear here</small>
      </div>
      <div>
        <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
        <?= $btnSpan; ?>
      </div>
    </div>

    <!-- Top Summary Boxes -->
    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <div class="border rounded p-3 bg-white h-100">
          <div class="d-flex justify-content-between">
            <div>
              <small class="text-muted">Next Payment</small>
              <div class="fs-5 fw-bold">N/A</div>
            </div>
            <i class="bi bi-calendar-date fs-4 text-muted"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="border rounded p-3 bg-white h-100">
          <div class="d-flex justify-content-between">
            <div>
              <small class="text-muted">Total Payment</small>
              <div class="fs-5 fw-bold">Rp0</div>
            </div>
            <i class="bi bi-info-circle fs-4 text-muted"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Section -->
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 sidebar mb-3">
        <button class="btn btn-light active" id="btnProfile"><i class="bi bi-person me-2"></i>Profile</button>
        <button class="btn btn-light" id="btnPayment"><i class="bi bi-clock-history me-2"></i>Payment history</button>
      </div>

      <!-- Content -->
      <div class="col-md-9">
        <!-- Alert -->
        <div class="alert alert-custom d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-info-circle-fill text-primary me-2"></i>
            <?= $lblStrong; ?>
          </div>
          <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Data Diri -->
        <div class="card" id="profileSection">
          <div class="card-header">
            <div class="card-title">Data Diri</div>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label">Nama lengkap</label>
                <input type="text" class="form-control" value="<?php echo $getData['nama_lengkap'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nama pilihan</label>
                <input type="text" class="form-control" value="<?php echo $getData['nama_panggilan'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Alamat email</label>
                <input type="email" class="form-control" value="<?php echo $getData['email'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nomor ponsel</label>
                <input type="text" class="form-control" value="<?php echo $getData['no_hp'] ?>" readonly>
              </div>
              <?php
              if ($getData['jenis_kelamin'] == 0) {
                $jk = "Perempuan";
              } else {
                $jk = "Laki - laki";
              }
              ?>
              <div class="col-md-6">
                <label class="form-label">Gender</label>
                <input type="text" class="form-control" value="<?php echo $jk ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Tempat lahir (Kota)</label>
                <input type="text" class="form-control" value="<?php echo $getData['tempat_lahir_name'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Tanggal lahir</label>
                <input type="text" class="form-control" value="<?php echo tanggal_indonesia($getData['tanggal_lahir']) ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Kota domisili</label>
                <input type="text" class="form-control" value="<?php echo $getData['domisili_name'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Pendidikan terakhir</label>
                <input type="text" class="form-control" value="" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Disabilitas</label>
                <input type="text" class="form-control" value="<?php echo $getData['disabilitas'] ?>" readonly>
              </div>
              <?php if (!empty($getData['disabilitas_lainnya'])): ?>
                <div class="col-md-6">
                  <label class="form-label">Disabilitas Lainnya</label>
                  <input type="text" class="form-control" value="<?php echo $getData['disabilitas_lainnya'] ?>" readonly>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Informasi Pekerjaan -->
        <div class="card mt-3" id="pekerjaanSection">
          <div class="card-header">
            <div class="card-title">Informasi Pekerjaan</div>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label">Instansi / Perusahaan / Pemberi Kerja</label>
                <input type="text" class="form-control" value="<?php echo $getData['instansi'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Profesi / Jenis Pekerjaan</label>
                <input type="text" class="form-control" value="<?php echo $getData['profesi'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Status Ketenagakerjaan</label>
                <input type="text" class="form-control" value="<?php echo $getData['status_ketenagakerjaan'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Keahlian</label>
                <input type="text" class="form-control" value="<?php echo $getData['keahlian'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Bahasa</label>
                <input type="text" class="form-control" value="<?php echo $getData['bahasa'] ?>" readonly>
              </div>
              <div class="col-md-12">
                <label class="form-label">Deskripsi Pekerjaan</label>
                <textarea class="form-control" rows="3" readonly><?php echo $getData['deskripsi_pekerjaan'] ?></textarea>
              </div>
              <div class="col-md-12">
                <label class="form-label">Masalah Ketenagakerjaan</label>
                <input type="text" class="form-control" value="<?php echo $getData['masalah_ketenagakerjaan'] ?>" readonly>
              </div>
              <?php if (!empty($getData['masalah_ketenagakerjaan_lain'])): ?>
                <div class="col-md-12">
                  <label class="form-label">Masalah Ketenagakerjaan Lainnya</label>
                  <textarea class="form-control" rows="2" readonly><?php echo $getData['masalah_ketenagakerjaan_lain'] ?></textarea>
                </div>
              <?php endif; ?>
              <?php if (!empty($getData['jenis_masalah_lainnya'])): ?>
                <div class="col-md-12">
                  <label class="form-label">Jenis Masalah Lainnya</label>
                  <textarea class="form-control" rows="2" readonly><?php echo $getData['jenis_masalah_lainnya'] ?></textarea>
                </div>
              <?php endif; ?>
              <div class="col-md-12">
                <label class="form-label">Alasan Bergabung Sindikasi</label>
                <textarea class="form-control" rows="3" readonly><?php echo $getData['alasan_bergabung_sindikasi'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- BPJS & Media Sosial -->
        <div class="card mt-3">
          <div class="card-header">
            <div class="card-title">BPJS & Media Sosial</div>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label">Nomor BPJS Ketenagakerjaan</label>
                <input type="text" class="form-control" value="<?php echo $getData['bpjstk'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Status Anggota BPJS TK</label>
                <input type="text" class="form-control" value="<?php echo $getData['status_anggota_bpjstk'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nomor BPJS Kesehatan</label>
                <input type="text" class="form-control" value="<?php echo $getData['bpjsks'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Status Anggota BPJS Kesehatan</label>
                <input type="text" class="form-control" value="<?php echo $getData['status_anggota_bpjsks'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bi bi-instagram me-1"></i>Instagram</label>
                <input type="text" class="form-control" value="<?php echo $getData['link_instagram'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bi bi-twitter-x me-1"></i>Twitter / X</label>
                <input type="text" class="form-control" value="<?php echo $getData['link_twitter'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bi bi-facebook me-1"></i>Facebook</label>
                <input type="text" class="form-control" value="<?php echo $getData['link_facebook'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="bi bi-linkedin me-1"></i>LinkedIn</label>
                <input type="text" class="form-control" value="<?php echo $getData['link_linkedin'] ?>" readonly>
              </div>
            </div>
          </div>
        </div>

        <!-- Keanggotaan & Pernyataan -->
        <div class="card mt-3">
          <div class="card-header">
            <div class="card-title">Keanggotaan & Pernyataan</div>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label">Nomor Anggota</label>
                <input type="text" class="form-control" value="<?php echo $getData['nomor_anggota'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Tanggal Aktivasi</label>
                <input type="text" class="form-control" value="<?php echo tanggal_indonesia($getData['activation_date']) ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Pakta Integritas</label>
                <input type="text" class="form-control" value="<?php echo ($getData['pakta_integritas'] != null || $getData['pakta_integritas'] != '') ? 'Sudah Disetujui' : 'Belum Disetujui' ?>" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Pernyataan Keanggotaan</label>
                <input type="text" class="form-control" value="<?php echo ($getData['pernyataan_keanggotaan'] != null || $getData['pernyataan_keanggotaan'] != '') ? 'Sudah Disetujui' : 'Belum Disetujui' ?>" readonly>
              </div>
              <div class="col-md-12">
                <label class="form-label">Biografi</label>
                <textarea class="form-control" rows="4" readonly><?php echo $getData['biografi'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Payment Section (Initially Hidden) -->
        <div id="paymentSection" style="display: none;">
          <!-- 	      <h5 class="card-title">Riwayat Pembayaran</h5>
	      <p>Belum ada riwayat pembayaran.</p> -->
          <div class="col-lg-12">
            <table id="example" class="table table-bordered table-striped table-hover align-middle">
              <thead>
                <tr>
                  <th>Payment Type</th>
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Payment Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <!-- <tfoot>
			              <tr>
			                  <th>#</th>
			                  <th>Fullname</th>
			                  <th>Email</th>
			                  <th>City Domicile</th>
			                  <th>Job Title</th>
			                  <th>Date Registration</th>
			                  <th>Date Approval</th>
			                  <th>Status</th>
			                  <th>Action</th>
			              </tr>
			          </tfoot> -->
            </table>
          </div>
        </div>

      </div>
    </div>


  </div>
  <script type="text/javascript">
    var table;
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ambil token dari meta tag
        }
      });

      //datatables
      table = $('#example').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
          "url": "<?php echo base_url('member/getpaymentDetailUser') ?>",
          "type": "POST",
          "data": function(d) {
            d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
          },

        },


        "columnDefs": [{
          "targets": [0],
          "orderable": false,
        }, ],

      });

    });
  </script>
  <script>
    const btnProfile = document.getElementById('btnProfile');
    const btnPayment = document.getElementById('btnPayment');
    const profileSection = document.getElementById('profileSection');
    const paymentSection = document.getElementById('paymentSection');

    btnProfile.addEventListener('click', function() {
      profileSection.style.display = 'block';
      paymentSection.style.display = 'none';
      btnProfile.classList.add('active');
      btnPayment.classList.remove('active');
    });

    btnPayment.addEventListener('click', function() {
      profileSection.style.display = 'none';
      paymentSection.style.display = 'block';
      btnProfile.classList.remove('active');
      btnPayment.classList.add('active');
    });

    <?php if ($paymentHistory == 'true') {
    ?>
      btnPayment.click();
    <?php } ?>
  </script>
  <script>
    function kirimEmail(id, url) {
      $.ambiance({
        message: "Email sukses dikirim",
        type: "success",
        fade: false
      });
      $.ajax({
        type: 'POST',
        data: {
          url: url,
          id: id
        },
        url: "<?php echo base_url('member/kirimEmail') ?>",
        async: false,
        dataType: 'JSON',
        success: function(msg) {
          location.reload();

          // if(response.msg == 0){
          //   $.ambiance({message: "Email sukses dikirim",
          //     type: "success",
          //     fade: false});

          // }else{
          //   $.ambiance({message: "Email gagal dikirim",
          //     type: "error",
          //     fade: false});
          // }
        }

      });
    }

    function confirmStatusData(id, flag) {
      if (flag == 0) {
        $("#resendActivationLabel").html("Resend Activation");
        $("#btnStatusData").html("Resend");
      } else if (flag == 1) {
        $("#resendActivationLabel").html("Confirm Deactivation");
        $("#btnStatusData").html("Deactivate");
      } else {
        $("#resendActivationLabel").html("Confirm Account Reactivation");
        $("#btnStatusData").html("Reactive");
      }
      $.ajax({
        type: 'POST',
        data: {
          flag: flag,
          id: id
        },
        url: "<?php echo base_url('member/confirmStatusData') ?>",
        async: false,
        dataType: 'JSON',
        success: function(msg) {
          $("#bodyModalStatusData").html(msg.msg);
          if (flag == 0) {
            //jika status pending maka kiirm email saja (resend)
            $("#btnStatusData").attr('onclick', 'kirimEmail(' + id + ',' + msg.url + ')');
          } else {
            $("#btnStatusData").attr('onclick', 'ubahStatusDataUser(' + id + ',' + flag + ')');
            //ubahStatusDataUser(id,flag);
          };
        }

      });
    }

    function ubahStatusDataUser(id, flag) {
      if (flag == '2') {
        flag = '1'
      } else if (flag == '1') {
        flag = '2'
      } else {
        flag = '0';
      }
      $.ajax({
        type: 'POST',
        data: {
          flag: flag,
          id: id
        },
        url: "<?php echo base_url('member/ubahStatusDataUser') ?>",
        async: false,
        dataType: 'JSON',
        success: function(response) {
          if (response.msg == 0) {
            $.ambiance({
              message: "Status sukses diupdate",
              type: "success",
              fade: false
            });
            location.reload();
          } else {
            $.ambiance({
              message: "Status gagal diupdate",
              type: "error",
              fade: false
            });
          }
        }

      });

    }
  </script>
  <?= $this->endSection(); ?>