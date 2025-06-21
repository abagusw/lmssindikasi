<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>

<div class="row">
  <div class="container py-4">
    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <a href="<?= base_url()?>master/course" class="text-decoration-none me-2">&larr; Back</a>
        <span class="fw-bold">Preview Course</span>
        <span class="badge bg-secondary ms-2">Draft</span>
      </div>
    </div>

    <!-- Content Layout -->
    <div class="row g-4">
      <!-- Left Panel: Basic Information -->
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <form id="formAddCourse">
            <div class="card-body">
              <h5 class="card-title mb-3">Basic Information</h5>

              <!-- Cover Image -->
              <div class="mb-3 position-relative">
                <img id='img_pic_cover' src="<?=base_url()?>uploads/course/<?=$getData['cover']; ?>" class="img-fluid rounded" alt="Cover">
                <button class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">✕</button>
              </div>

              <!-- Title -->
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?=$getData['judul']; ?>" disabled required>
              </div>
              <?php
              if($getData['kategori'] == '0'){
                $kategori = "Foundational";
              }else{
                $kategori = "Advance Course";
              }?>
              <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?=$kategori; ?>" disabled required>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" maxlength="200" disabled><?=$getData['deskripsi']; ?></textarea>
              </div>

              <!-- Topic, Start & End Date -->
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Topic</label>
                  <input type="text" id="topic" name="topic" class="form-control" value="<?=$getData['topic']; ?>" disabled>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Start date</label>
                  <input type="date" id="start_date" name="start_date" class="form-control" value="<?=$getData['start_date']; ?>" disabled>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">End date</label>
                  <input type="date" id="end_date" name="end_date" class="form-control" value="<?=$getData['end_date']; ?>" disabled>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>

      <!-- Right Panel: Assign Lesson -->
      <div class="col-lg-4">
        <div class="card shadow-sm h-100">
<!--           <div class="card-body d-flex flex-column justify-content-center text-center">
            <h5 class="card-title mb-3">Assign Lesson</h5>
            <p class="text-muted mb-1">No lesson added</p>
            <p class="text-muted">Start adding your lesson to be included on a course</p>
            <button class="btn btn-outline-primary mt-3">+ Add New</button>
          </div> -->
          <?php
          foreach($getLesson as $gLes){
            $key = ApiKeyGhost; // Ganti dengan API key kamu
            $url = URLGhost."/ghost/api/content/posts/?key=$key&filter=uuid:[".$gLes['uuid']."]&limit=1";

            $client = \Config\Services::curlrequest();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);
            if (!empty($data['posts'][0])) {
                $title = $data['posts'][0]['title'];
               // echo 'Judul: ' . $title;
            } else {
               // echo 'Data tidak ditemukan.';
            }

            if($data['posts'][0]['visibility'] == 'public'){
              $spVi = '<span class="badge bg-success">Public</span>';
            }else{
              $spVi = '<span class="badge bg-secondary">Private</span>';
            }

            ?>
            <div class="lesson-card">
              <div class="lesson-left">
                <a href=" <?= esc($data['posts'][0]['url']) ?> " target="_blank"><span>☰</span></a>
                <span class="badge rounded-pill badge-active"><?= $spVi; ?></span>
                <span><?= $title; ?></span>
              </div>
              <a data-bs-toggle="modal" data-bs-target="#deleteModal"  onclick="confirmDeleteCourseLesson(<?= $gLes['id'] ?>)" class="btn btn-sm delete-btn">X</a>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>


</div>

<?php echo view("master/course/jsCourse"); ?>

<?= $this->renderSection('master/course/jsCourse') ?>
<?= $this->endSection(); ?>