<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="container my-4">
    <!-- Summary Cards -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Total Course <i class="fas fa-book"></i></div>
          <div class="value"><?= $countAllCourse; ?></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Publish Course <i class="fas fa-paper-plane"></i></div>
          <div class="value"><?= $countPublishCourse; ?></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Draft Course <i class="fas fa-stop"></i></div>
          <div class="value"><?= $countDraftCourse; ?></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Total Participant <i class="fas fa-user"></i></div>
          <div class="value"><?= $countAllParticipant; ?></div>
        </div>
      </div>
    </div>
    </div>


  <div class="col-lg-12">
    <table id="example"class="table table-bordered table-striped table-hover align-middle">
          <thead>
              <tr>
                  <th>Title</th>
                  <th>Registered</th>
                  <th>Completed</th>
                  <th>Publish Date</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($getData as $course): ?>
                <tr>
                    <td>
                        <div style="font-weight: 500;"><?= esc($course['judul']) ?></div>
                        <div style="font-size: 13px; color: #6c757d;"><?= date('d M Y', strtotime($course['start_date'])) . ' - ' . date('d M Y', strtotime($course['end_date'])) ?></div>
                    </td>
                    <td><?= esc($course['total_analytic']) ?></td>
                    <td><?= esc($course['total_participant']) ?></td>
                    <td><?=  date('d M Y', strtotime($course['updated_at'])) ?></td>
                    <td><div class="d-flex gap-2">
                          <a href="<?php echo base_url("master/course_analytic_participant/".$course['id']."") ?>" class="btn btn-outline-secondary rounded shadow-sm">
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