<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php $uri = service('uri');

$flag = $uri->getSegment(2); ?>

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
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-warning card-outline mb-4">
      <!--begin::Header-->
      <div class="card-header">
        <div class="card-title">Member Detail</div>
      </div>

      <?php if ($getData['flag'] == 1) {
        $stLb = "<div class='alert alert-info' role='alert'>
          Member has been approved.
        </div>";
      } elseif ($getData['flag'] == 2) {
        $stLb = "<div class='alert alert-danger' role='alert'>
         Member has been rejected</a>.
        </div>";
      } else {
        $stLb = "";
      }

      ?>

      <?php echo $stLb;  ?>

      <!--end::Header-->
      <!--begin::Form-->
      <form>
        <!--begin::Body-->
        <div class="card-body">
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $getData['nama_lengkap'] ?>" />
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Pilihan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="<?php echo $getData['nama_panggilan'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">TNI Polri BIN</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="status_anggota" name="status_anggota" value="<?php echo $getData['status_anggota'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email" value="<?php echo $getData['email'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Nomor Ponsel</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $getData['no_hp'] ?>" readonly />
            </div>
          </div>
          <?php
          if ($getData['jenis_kelamin'] == 0) {
            $jk = "Perempuan";
          } else {
            $jk = "Laki - laki";
          }
          ?>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Gender</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $jk ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Gender Lainnya</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="jenis_kelamin_lainnya" name="jenis_kelamin_lainnya" value="<?php echo $getData['jenis_kelamin_lainnya'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Tempat Lahir</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo $getData['tempat_lahir_name'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo tanggal_indonesia($getData['tanggal_lahir']) ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Domisili</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="domisili" name="domisili" value="<?php echo $getData['domisili_name'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Subsektor</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="subsektor" name="subsektor" value="<?php echo $getData['subsektor_name'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Instansi/Perusahaan/Pemberi Kerja</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="instansi" name="instansi" value="<?php echo $getData['instansi'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Profesi/Jenis Pekerjaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="profesi" name="profesi" value="<?php echo $getData['profesi'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="status_ketenagakerjaan" class="col-sm-2 col-form-label">Status Ketenagakerjaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="status_ketenagakerjaan" name="status_ketenagakerjaan" value="<?php echo $getData['status_ketenagakerjaan'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="keahlian" class="col-sm-2 col-form-label">Keahlian</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="keahlian" name="keahlian" value="<?php echo $getData['keahlian'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="bahasa" class="col-sm-2 col-form-label">Bahasa</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="bahasa" name="bahasa" value="<?php echo $getData['bahasa'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="deskripsi_pekerjaan" class="col-sm-2 col-form-label">Deskripsi Pekerjaan</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="3" readonly><?php echo $getData['deskripsi_pekerjaan'] ?></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <label for="masalah_ketenagakerjaan" class="col-sm-2 col-form-label">Masalah Ketenagakerjaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="masalah_ketenagakerjaan" name="masalah_ketenagakerjaan" value="<?php echo $getData['masalah_ketenagakerjaan'] ?>" readonly />
            </div>
          </div>
          <?php if (!empty($getData['masalah_ketenagakerjaan_lain'])): ?>
            <div class="row mb-3">
              <label for="masalah_ketenagakerjaan_lain" class="col-sm-2 col-form-label">Masalah Ketenagakerjaan Lainnya</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="masalah_ketenagakerjaan_lain" name="masalah_ketenagakerjaan_lain" rows="2" readonly><?php echo $getData['masalah_ketenagakerjaan_lain'] ?></textarea>
              </div>
            </div>
          <?php endif; ?>
          <?php if (!empty($getData['jenis_masalah_lainnya'])): ?>
            <div class="row mb-3">
              <label for="jenis_masalah_lainnya" class="col-sm-2 col-form-label">Jenis Masalah Lainnya</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="jenis_masalah_lainnya" name="jenis_masalah_lainnya" rows="2" readonly><?php echo $getData['jenis_masalah_lainnya'] ?></textarea>
              </div>
            </div>
          <?php endif; ?>
          <div class="row mb-3">
            <label for="alasan_bergabung_sindikasi" class="col-sm-2 col-form-label">Alasan Bergabung Sindikasi</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="alasan_bergabung_sindikasi" name="alasan_bergabung_sindikasi" rows="3" readonly><?php echo $getData['alasan_bergabung_sindikasi'] ?></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <label for="disabilitas" class="col-sm-2 col-form-label">Disabilitas</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="disabilitas" name="disabilitas" value="<?php echo $getData['disabilitas'] ?>" readonly />
            </div>
          </div>
          <?php if (!empty($getData['disabilitas_lainnya'])): ?>
            <div class="row mb-3">
              <label for="disabilitas_lainnya" class="col-sm-2 col-form-label">Disabilitas Lainnya</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="disabilitas_lainnya" name="disabilitas_lainnya" value="<?php echo $getData['disabilitas_lainnya'] ?>" readonly />
              </div>
            </div>
          <?php endif; ?>

          <hr class="my-3">
          <h6 class="text-muted mb-3">BPJS</h6>
          <div class="row mb-3">
            <label for="bpjstk" class="col-sm-2 col-form-label">Nomor BPJS Ketenagakerjaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="bpjstk" name="bpjstk" value="<?php echo $getData['bpjstk'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="status_anggota_bpjstk" class="col-sm-2 col-form-label">Status Anggota BPJS TK</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="status_anggota_bpjstk" name="status_anggota_bpjstk" value="<?php echo $getData['status_anggota_bpjstk'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="bpjsks" class="col-sm-2 col-form-label">Nomor BPJS Kesehatan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="bpjsks" name="bpjsks" value="<?php echo $getData['bpjsks'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="status_anggota_bpjsks" class="col-sm-2 col-form-label">Status Anggota BPJS Kesehatan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="status_anggota_bpjsks" name="status_anggota_bpjsks" value="<?php echo $getData['status_anggota_bpjsks'] ?>" readonly />
            </div>
          </div>

          <hr class="my-3">
          <h6 class="text-muted mb-3">Media Sosial</h6>
          <div class="row mb-3">
            <label for="link_instagram" class="col-sm-2 col-form-label"><i class="bi bi-instagram me-1"></i>Instagram</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="link_instagram" name="link_instagram" value="<?php echo $getData['link_instagram'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="link_twitter" class="col-sm-2 col-form-label"><i class="bi bi-twitter-x me-1"></i>Twitter / X</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="link_twitter" name="link_twitter" value="<?php echo $getData['link_twitter'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="link_facebook" class="col-sm-2 col-form-label"><i class="bi bi-facebook me-1"></i>Facebook</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="link_facebook" name="link_facebook" value="<?php echo $getData['link_facebook'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="link_linkedin" class="col-sm-2 col-form-label"><i class="bi bi-linkedin me-1"></i>LinkedIn</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="link_linkedin" name="link_linkedin" value="<?php echo $getData['link_linkedin'] ?>" readonly />
            </div>
          </div>

          <hr class="my-3">
          <h6 class="text-muted mb-3">Keanggotaan</h6>
          <div class="row mb-3">
            <label for="nomor_anggota" class="col-sm-2 col-form-label">Nomor Anggota</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nomor_anggota" name="nomor_anggota" value="<?php echo $getData['nomor_anggota'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="activation_date" class="col-sm-2 col-form-label">Tanggal Aktivasi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="activation_date" name="activation_date" value="<?php echo tanggal_indonesia($getData['activation_date']) ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="pakta_integritas" class="col-sm-2 col-form-label">Pakta Integritas</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="pakta_integritas" name="pakta_integritas" value="<?php echo ($getData['pakta_integritas'] != null || $getData['pakta_integritas'] != '') ? 'Sudah Disetujui' : 'Belum Disetujui' ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="pernyataan_keanggotaan" class="col-sm-2 col-form-label">Pernyataan Keanggotaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="pernyataan_keanggotaan" name="pernyataan_keanggotaan" value="<?php echo ($getData['pernyataan_keanggotaan'] != null || $getData['pernyataan_keanggotaan'] != '') ? 'Sudah Disetujui' : 'Belum Disetujui' ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="biografi" class="col-sm-2 col-form-label">Biografi</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="biografi" name="biografi" rows="4" readonly><?php echo $getData['biografi'] ?></textarea>
            </div>
          </div>
        </div>
        <?php
        if ($getData['flag'] == 0) {
        ?>
          <!--end::Body-->
          <!--begin::Footer-->
          <div class="card-footer">
            <a class="btn btn-danger" href="#!" data-bs-toggle="modal" data-bs-target="#modalStatusData" onclick="confirmStatusData(<?php echo $getData['id']; ?>,2)">Reject</a>
            <a class="btn btn-primary" href="#!" data-bs-toggle="modal" data-bs-target="#modalStatusData" onclick="confirmStatusData(<?php echo $getData['id']; ?>,1)">Approve</a>

          </div> <?php } ?>
        <!--end::Footer-->
      </form>
      <!--end::Form-->
    </div>
  </div>
  <!--end::Col-->
</div>



<?php echo view("member/jsMember"); ?>

<?= $this->renderSection('member/jsMember') ?>
<?= $this->endSection(); ?>