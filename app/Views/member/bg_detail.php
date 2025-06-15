<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php $uri = service('uri');
                
$flag = $uri->getSegment(2); ?>

<?php
function tanggal_indonesia($tanggal)
{
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

      <?php if($getData['flag'] == 1){
        $stLb = "<div class='alert alert-info' role='alert'>
          Member has been approved.
        </div>";
      }elseif($getData['flag'] == 2){
        $stLb = "<div class='alert alert-danger' role='alert'>
         Member has been rejected</a>.
        </div>";
      }else{
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
          if($getData['jenis_kelamin'] == 0){
            $jk = "Perempuan";
          }else{
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
              <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo $getData['tempat_lahir'] ?>" readonly />
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
              <input type="text" class="form-control" id="domisili" name="domisili" value="<?php echo $getData['domisili'] ?>" readonly />
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Subsektor</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="subsektor" name="subsektor" value="<?php echo $getData['subsektor'] ?>" readonly />
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
        </div>
        <?php
        if($getData['flag'] == 0){
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