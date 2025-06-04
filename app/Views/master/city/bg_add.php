<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-primary card-outline mb-4">
      <!--begin::Header-->
      <div class="card-header">
        <div class="card-title"><?php echo $title; ?></div>
      </div>

      <!--end::Header-->
      <!--begin::Form-->
      <form id="formAddDataMaster">
        <!--begin::Body-->
        <div class="card-body">
          <div class="mb-3">
            <label for="pilih_Branch" class="form-label">Pilih Branch</label>
            <select class="form-control select2" id="cmbBranch" name="cmbBranch" required />
              <option value="" selected disabled>Pilih Branch</option>
              <?php
              foreach($getDataBranch as $dataBranch){
                echo "<option value=".$dataBranch['id'].">".$dataBranch['name']."</option>";
              }?>
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required />
          </div>
        </div>
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          
        </div>
        <!--end::Footer-->
      </form>
      <!--end::Form-->
    </div>
  </div>
  <!--end::Col-->
</div>


<script type="text/javascript">
$('#formAddDataMaster').submit(function(e){
        //var formAddKaryawan = $('#formAddKaryawan').serialize(); 
        e.preventDefault(); 

        var form = this;
        $.ajax({
            type: 'POST',
            data:  new FormData(form),
            url: "<?php echo base_url('master/simpanCity')?>",
            async: false,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(response) {
              if(response.msg == 0){
                top.location.href="<?php echo base_url('master/city')?>";

                $.ambiance({message: "Data sukses disimpan",
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

})


</script>
<?= $this->endSection(); ?>