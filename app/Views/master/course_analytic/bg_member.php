<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="container my-4">
    <!-- Summary Cards -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Participant <i class="fas fa-book"></i></div>
          <div class="value"><?= 0 ?></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Completed <i class="fas fa-paper-plane"></i></div>
          <div class="value"><?= 0 ?></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">In Progress <i class="fas fa-stop"></i></div>
          <div class="value"><?= 0 ?></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Completion Rate <i class="fas fa-user"></i></div>
          <div class="value"><?= 0 ?></div>
        </div>
      </div>
    </div>
    </div>


  <div class="col-lg-12">
    <table id="example"class="table table-bordered table-striped table-hover align-middle">
          <thead>
              <tr>
                  <th>Fullname</th>
                  <th>Register Date</th>
                  <th>Completed Date</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($getData as $data): ?>
                <tr>
                    <td>
                        <?= esc($data['nama_lengkap']) ?>
                    </td>
                    <td><?=  date('d M Y', strtotime($data['created_at'])) ?></td>
                    <td><?=  date('d M Y', strtotime($data['updated_at'])) ?></td>
                    <td></td>
                    <td><div class="d-flex gap-2">
                          <a href="" class="btn btn-outline-secondary rounded shadow-sm">
                            <i class="fas fa-eye"></i>
                          </a>

                          <a class="btn btn-outline-secondary rounded shadow-sm">
                            <i class="fas fa-download"></i>
                          </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
    </table>
  </div>
  <!--end::Col-->
</div>

<?= $this->endSection(); ?>