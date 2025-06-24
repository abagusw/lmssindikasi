<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php $uri = service('uri');
                
$flag = $uri->getSegment(2); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="d-flex justify-content-start mb-3">
      <a href="<?= base_url() ?>master/sinkronLesson" class="btn btn-success btn-sm"><i class='bi bi-add me-1'></i>Sinkron Data</a>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Featured Image</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Update Date</th>
                    <th>Published Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach($getData as $data){
                  $no++;

                  if($data['feature_image'] == NULL || $data['feature_image'] == ''){
                    $image = "<span class='text-muted fst-italic'>Tidak ada</span>";
                  }else{
                    $image = "<img src=" . esc($data['feature_image']) . " width='100' height='60' style='border-radius:8px;'>";
                  }

                  if($data['visibility'] == 'public'){
                    $vis = "<span class='badge bg-success'>Public</span>";
                  }else{
                    $vis = "<span class='badge bg-secondary'>Private</span>";
                  }

                  if($data['flag'] == 0){
                    $flS = "<span class='badge bg-secondary'>Archived</span>";
                  }else{
                    $flS = "<span class='badge bg-success'>Active</span>";
                  }

                  echo"
                  <tr>
                    <td>$no</td>
                    <td>".$data['title']."</td>
                    <td>".$image."</td>
                    <td>".$flS."</td>
                    <td>".$data['created_at']."</td>
                    <td>".$data['updated_at']."</td>
                    <td>".$data['published_at']."</td>
                    <td>
                      <div class='d-flex gap-2'>
                        <a href=" . esc($data['url']) . " target='_blank' class='btn btn-sm btn-outline-primary'>🔗 Lihat</a>
                        ";
                      if($data['flag'] == 0){
                        echo"
                      <a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$data['id'].",1) class='btn btn-success btn-sm'>
                        <i class='bi bi-check-circle'></i> Activated
                      </a>";
                      }

                      if($data['flag'] == 1){
                        echo"
                      <a href='#!' data-bs-toggle='modal' data-bs-target='#modalStatusData' onclick=confirmStatusData(".$data['id'].",0) class='btn btn-secondary btn-sm'>
                        <i class='bi bi-archive'></i> Archived
                      </a>";}
                      echo"
                    </div>

                    </td>
                  </tr>
                  ";
                }
                ?>
            </tbody>
      </table>
    </div>
  </div>
  <!--end::Col-->
</div>
<?php echo view("master/lesson/jsLesson"); ?>

<?= $this->renderSection('master/lesson/jsLesson') ?>
<?= $this->endSection(); ?>