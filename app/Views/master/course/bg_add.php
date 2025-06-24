<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>

<div class="row">
  <div class="container py-4">
    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <a href="<?= base_url()?>master/course" class="text-decoration-none me-2">&larr; Back</a>
        <span class="fw-bold">Add New Course</span>
        <span class="badge bg-secondary ms-2">Draft</span>
      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" onclick="simpanCourse(0)">Save</button>
        <!-- <button class="btn btn-warning text-white" onclick="simpanCourse(1)">Save & Publish</button> -->
      </div>
    </div>

    <!-- Content Layout -->
    <div class="row g-4">
      <!-- Left Panel: Basic Information -->
      <div class="col-lg-12">
        <div class="card shadow-sm">
          <form id="formAddCourse">
            <div class="card-body">
              <h5 class="card-title mb-3">Basic Information</h5>

              <!-- Cover Image -->
              <div class="mb-3 position-relative">
                <img id='img_pic_cover' src="<?=base_url()?>public/assets_admin/images/upload-icon.jpg" class="img-fluid rounded" alt="Cover" onclick="click_picture('pic_cover')" style="cursor:pointer;">
                <input type="file" class="pic_product"  name="pic_cover" id="pic_cover" style="opacity: 0.0;width:1px; height:1px" OnChange=javascript:picture_upload_cover(this.id,image_high_cover,image_tumb_cover)>
                <input id="image_high_cover" name="image_high_cover" type="hidden"/>
                <input id="image_tumb_cover" name="image_tumb_cover" type="hidden"/>
                <input id="gambar_default_cover" type="hidden" name="gambar_default_cover" value="1">
                <button class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">✕</button>
              </div>

              <!-- Title -->
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" id="judul" name="judul" class="form-control" required>
              </div>

              <!-- Category -->
              <div class="mb-3">
                <label class="form-label">Category</label>
                <select id="cmbCategory" name="cmbCategory" class="form-select">
                  <option selected disabled>Category</option>
                  <option value="0">Foundational</option>
                  <option value="1">Advance Course</option>
                </select>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" maxlength="200"></textarea>
              </div>

              <!-- Topic, Start & End Date -->
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Topic</label>
                  <!-- <input type="text" id="topic" name="topic" class="form-control"> -->
                  <select id="topic" name="topic" class="form-select">
                  <option selected disabled>Pilih Topic</option>
                    <?php foreach($getDataCouseTopic as $topic){
                    echo"
                  <option value=".$topic['id'].">".$topic['name']."</option>
                  ";}?>
                </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Start date</label>
                  <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">End date</label>
                  <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>


<!--       <div class="col-lg-4">
        <div class="card shadow-sm h-100">
          <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5>Assign Lesson</h5>
              <a href="#!" data-bs-toggle='modal' data-bs-target='#lessonModal' class="text-danger text-decoration-none">+ Add New</a>
            </div>
            <div class="lesson-card">
              <div class="lesson-left">
                <span class="drag-icon">☰</span>
                <span class="badge rounded-pill badge-active">Active</span>
                <span>Pemahaman Tentang Kontrak Kerja dan...</span>
              </div>
              <button class="btn btn-sm delete-btn">X</button>
            </div>

            <div class="lesson-card">
              <div class="lesson-left">
                <span class="drag-icon">☰</span>
                <span class="badge rounded-pill badge-inactive">Inactive</span>
                <span>Pemahaman Tentang Kontrak Kerja dan...</span>
              </div>
              <button class="btn btn-sm delete-btn">X</button>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>


</div>


<!-- Modal -->
<!-- <div class="modal fade" id="lessonModal" tabindex="-1" aria-labelledby="lessonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="lessonModalLabel">Daftar Lesson</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="lessonTable" class="table table-hover align-middle table-bordered rounded shadow-sm">
            <thead class="table-light">
              <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="simpanLesson" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </div>
</div> -->


<?php echo view("master/course/jsCourse"); ?>

<?= $this->renderSection('master/course/jsCourse') ?>
<?= $this->endSection(); ?>