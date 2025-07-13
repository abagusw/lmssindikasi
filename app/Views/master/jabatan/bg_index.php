<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php $uri = service('uri');
                
$flag = $uri->getSegment(2); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="d-flex justify-content-start mb-3">
      <a href="<?= base_url() ?>master/add_jabatan" class="btn btn-success btn-sm"><i class='bi bi-add me-1'></i>Tambah Data</a>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach($getData as $data){
                  $no++;
                  echo"
                  <tr>
                    <td>$no</td>
                    <td>".$data['name']."</td>
                    <td>
                      <div class='d-flex gap-2'>
                        <a href='".base_url("master/edit_jabatan/".$data['id']."")."' class='btn btn-sm btn-primary'>
                          <i class='bi bi-pencil-square me-1'></i> Edit
                        </a>
                        <a href='#!' class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal'  onclick='confirmDeleteJabatan(".$data['id'].")'>
                          <i class='bi bi-trash me-1'></i> Delete
                        </a>
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
<script>
  function confirmDeleteJabatan(id){
      $('#btnDelete').attr('onclick', 'hapusDataJabatan('+id+')');
  }

  function hapusDataJabatan(id){
    //alert(id);
        $.ajax({
            type: 'POST',
            data:  {id:id},
            url: "<?php echo base_url('master/hapusDataJabatan')?>",
            dataType: 'JSON',
            success: function(response) {
              if(response.msg == 0){
                top.location.href="<?php echo base_url('master/jabatan')?>";
                $.ambiance({message: "Data sukses dihapus",
                  type: "success",
                  fade: false});
                
              }else if(response.msg == 2){
                $.ambiance({message: response.desc,
                  type: "error",
                  fade: false});
              }else{
                $.ambiance({message: "Another Error !",
                  type: "error",
                  fade: false});
              }
            }

        });
  }
</script>
<?= $this->endSection(); ?>