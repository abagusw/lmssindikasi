<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php $uri = service('uri');
                
$flag = $uri->getSegment(2); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Featured Image</th>
                    <th>Status</th>
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
                  echo"
                  <tr>
                    <td>$no</td>
                    <td>".$data['title']."</td>
                    <td>".$image."</td>
                    <td>".$vis."</td>
                    <td><a href=" . esc($data['url']) . " target='_blank' class='btn btn-sm btn-outline-primary'>🔗 Lihat</a></td>
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

<?= $this->endSection(); ?>