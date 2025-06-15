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
        <button class="btn btn-warning text-white" onclick="simpanCourse(1)">Save & Publish</button>
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
                  <input type="text" id="topic" name="topic" class="form-control">
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

      <!-- Right Panel: Assign Lesson -->
      <div class="col-lg-4">
        <div class="card shadow-sm h-100">
          <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5>Assign Lesson</h5>
              <a href="#" class="text-danger text-decoration-none">+ Add New</a>
            </div>

            <!-- Repeat this lesson card as needed -->
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
      </div>
    </div>
  </div>


</div>

<script>
function click_picture(file) {
   $('#'+file).click();
}

function picture_upload_cover(id,image_high,image_tumb){

   var URL     = window.URL || window.webkitURL;
   var input   = document.querySelector('#'+id);
   var preview = document.querySelector('#img_'+id);
   var img     = $(input).val();
   //alert(preview);
   $("#rotate_"+id).val('0');
    $('#img_'+id).animate({  transform: 0}, {
      step: function(now,rotate) {        
          $(this).css({
              '-webkit-transform':'rotate('+now+'deg)', 
              '-moz-transform':'rotate('+now+'deg)',
              'transform':'rotate('+now+'deg)'              
          });
      }
      });

    switch(img.substring(img.lastIndexOf('.') + 1).toLowerCase()){
        case 'jpg': case 'png':
        var dataURL = "data:image/png,"+encodeURIComponent(window.btoa(input.files[0]) );
      //  alert(URL.createObjectURL(input.files[0]));
       var fileURL = URL.createObjectURL(input.files[0]);
            preview.src = fileURL;
            //preview.src = dataURL;
  
            $('#rem_'+id).show();            
            $("#gambar_default_cover").val('0');
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var canvas        = document.createElement("canvas");
                    var ctx           = canvas.getContext("2d");

                    img = new Image();
                    img.onload=function(){
                          var MAX_WIDTH = 800;
                          var MAX_HEIGHT = 800;
                          var width = img.width;
                          var height = img.height;
                  
                          if (width > height) {
                            if (width > MAX_WIDTH) {
                              height *= MAX_WIDTH / width;
                              width = MAX_WIDTH;
                            }
                          } else {
                            if (height > MAX_HEIGHT) {
                              width *= MAX_HEIGHT / height;
                              height = MAX_HEIGHT;
                            }
                          }
                          canvas.width = width;
                          canvas.height = height;
                          var ctx = canvas.getContext("2d");
                          ctx.drawImage(img, 0, 0, width, height);
                          
                          image_high.value = canvas.toDataURL('image/png');
                          
                    }
                    img.src = e.target.result;
                    
                    img = new Image();
                    img.onload=function(){
                          var MAX_WIDTH = 300;
                          var MAX_HEIGHT = 300;
                          var width = img.width;
                          var height = img.height;
                  
                          if (width > height) {
                            if (width > MAX_WIDTH) {
                              height *= MAX_WIDTH / width;
                              width = MAX_WIDTH;
                            }
                          } else {
                            if (height > MAX_HEIGHT) {
                              width *= MAX_HEIGHT / height;
                              height = MAX_HEIGHT;
                            }
                          }
                          canvas.width = width;
                          canvas.height = height;
                          var ctx = canvas.getContext("2d");
                          ctx.drawImage(img, 0, 0, width, height);
                          
                          image_tumb.value = canvas.toDataURL('image/png');
                    }
                    img.src = e.target.result;
                    
                    input.files[0] = null;
                    input.value = "";
                }
                reader.readAsDataURL(input.files[0]);
            }
            
            break;
        default:
            $(input).val('');
            // error message here
      $.ambiance({message: "Format yang diijinkan .JPG/.PNG",
              type: "error",
              fade: false});
            break;
    }
}

function simpanCourse(flag){
        //var formAddKaryawan = $('#formAddKaryawan').serialize(); 
        var gambar_default_cover = $('#gambar_default_cover').val();
        var image_high_cover = $('#image_high_cover').val();
        var image_tumb_cover = $('#image_tumb_cover').val();
        var judul = $('#judul').val();
        var cmbCategory = $('#cmbCategory').val();
        var deskripsi = $('#deskripsi').val();
        var topic = $('#topic').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            type: 'POST',
            data: {flag:flag,gambar_default_cover:gambar_default_cover,judul:judul,cmbCategory:cmbCategory,deskripsi:deskripsi,topic:topic,start_date:start_date,end_date:end_date,image_high_cover:image_high_cover,image_tumb_cover:image_tumb_cover},
            url: "<?php echo base_url('master/simpanCourse')?>",
            async: false,
            dataType: 'JSON',
            success: function(response) {
              if(response.msg == 0){
                top.location.href="<?php echo base_url('master/course')?>";

                $.ambiance({message: "Data sukses disimpan",
                  type: "success",
                  fade: false});
                
              }else{
                $.ambiance({message: response.desc,
                  type: "error",
                  fade: false});
              }
            }

        });

}
</script>
<?= $this->endSection(); ?>