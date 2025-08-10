<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>

<div class="row">
  <div class="container py-4">
    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <a href="<?= base_url()?>master/course" class="text-decoration-none me-2">&larr; Back</a>
        <span class="fw-bold">Edit Course</span>

        <?php if($getData['status'] == 0){
          ?>
          <span class="badge bg-secondary ms-2">Draft</span>
        <?php }elseif ($getData['status'] == 1) { ?>
          <span class="badge bg-primary ms-2">Published</span><?php }else{?>
         <span class="badge bg-danger ms-2">Withdrawn</span><?php } ?>   

      </div>
      <div>
        <button class="btn btn-outline-secondary me-2" onclick="simpanCourseEdit(<?= $getData['id']; ?>)">Save</button>
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
              <?php
              if($getData['cover'] == ''){
                $cover = "".base_url()."public/assets_admin/images/upload-icon.jpg";
              }else{
                $cover = "".base_url()."uploads/course/".$getData['cover']."";
              }?>
              <div class="mb-3 position-relative">
                <img id='img_pic_cover' src="<?= $cover ?>" class="img-fluid rounded" alt="Cover" onclick="click_picture('pic_cover')" style="cursor:pointer;">
                <input type="file" class="pic_product"  name="pic_cover" id="pic_cover" style="opacity: 0.0;width:1px; height:1px" OnChange=javascript:picture_upload_cover(this.id,image_high_cover,image_tumb_cover)>
                <input id="image_high_cover" name="image_high_cover" type="hidden"/>
                <input id="image_tumb_cover" name="image_tumb_cover" type="hidden"/>
                <input id="gambar_default_cover" type="hidden" name="gambar_default_cover" value="1">
                <button class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">✕</button>
              </div>

              <!-- Title -->
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?=$getData['judul']; ?>" required>
              </div>
              <?php
              if($getData['kategori'] == '0'){
                $slctd = "selected";
              }else{
                $slctd = "selected";
              }?>
              <div class="mb-3">
                <label class="form-label">Category</label>
                <select id="cmbCategory" name="cmbCategory" class="form-select">
                  <option selected disabled>Category</option>
                  <option value="0" <?php if($getData['kategori'] == '0'){echo "selected";}?>>Foundational</option>
                  <option value="1" <?php if($getData['kategori'] == '1'){echo "selected";}?>>Advance Course</option>
                </select>
                <small class="form-text text-warning">
                  Menambah course category <strong>foundational</strong> akan menimpa course foundational yang sedang aktif di web member
                </small>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" maxlength="200"><?=$getData['deskripsi']; ?></textarea>
              </div>

              <!-- Topic, Start & End Date -->
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Topic</label>
                  <!-- <input type="text" id="topic" name="topic" class="form-control" value="<?=$getData['topic']; ?>"> -->
                  <select id="topic" name="topic" class="form-select">
                    <option selected disabled>Pilih Topic</option>
                      <?php foreach($getDataCouseTopic as $topic){
                      echo"
                    <option value=".$topic['id']." ";if($topic['id'] == $getData['topic']){echo "selected"; } echo">".$topic['name']."</option>
                    ";}?>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Start date</label>
                  <input type="date" id="start_date" name="start_date" class="form-control" value="<?=$getData['start_date']; ?>">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">End date</label>
                  <input type="date" id="end_date" name="end_date" class="form-control" value="<?=$getData['end_date']; ?>">
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


</div>

<?php echo view("master/course/jsCourse"); ?>

<?= $this->renderSection('master/course/jsCourse') ?>
<?= $this->endSection(); ?>