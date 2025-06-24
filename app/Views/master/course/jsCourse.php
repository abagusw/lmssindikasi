<script>
  function confirmAddLesson(id){
    if ($.fn.DataTable.isDataTable('#lessonTable')) {
      $('#lessonTable').DataTable().clear().destroy();
    }
    const table = $('#lessonTable').DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        data: {id:id},
        url: '<?= base_url("master/getDatalesson") ?>',
        type: 'GET'
      },
      columns: [
        { data: 'check', orderable: false, searchable: false },
        { data: 'title' },
        { data: 'image', orderable: false, searchable: false },
        { data: 'status' },
        { data: 'url', orderable: false, searchable: false }
      ]
    });

    $('#checkAll').on('change', function () {
      $('.lesson-check').prop('checked', this.checked);
    });

    $('#simpanLesson').on('click', function () {
        let uuids = [];
        $('.lesson-check:checked').each(function () {
          uuids.push($(this).data('uuid'));
        });

        if (uuids.length === 0) {
          $.ambiance({message: "Tidak ada data yang dicentang.",
                  type: "error",
                  fade: false});
        } else {
          let uuidString = uuids.join(',');
          //console.log('UUID yang dipilih:', uuidString);
          //alert('UUID yang dipilih (dipisah koma):\n' + uuidString);
          $.ajax({
              type: 'POST',
              data: {uuidString:uuidString,id:id},
              url: "<?php echo base_url('master/simpanLessonCourse')?>",
              async: false,
              dataType: 'JSON',
              success: function(response) {
                if(response.msg == 0){
                  top.location.href="<?php echo base_url('master/course')?>";

                  $.ambiance({message: "Data sukses disimpan",
                    type: "success",
                    fade: false});
                  
                }else{
                  $.ambiance({message: "Data gagal disimpan",
                    type: "error",
                    fade: false});
                }
              }

          });
        }
      });
  }
</script>

<script>
  function viewLesson(id){
    $("#divLessonTable").html("Loading .....");
        $.ajax({
            type: 'POST',
            data: {id:id},
            url: "<?php echo base_url('master/getDatalessonByCourse')?>",
            async: false,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(response) {
              $("#divLessonTable").html(response.html);
            }

        });
  }
</script>
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

        if (!judul || !cmbCategory || !deskripsi || !topic || !start_date || !end_date) {
            $.ambiance({
                message: "Harap lengkapi semua field yang wajib diisi!",
                type: "error",
                fade: false
            });
            return; // hentikan proses
        }

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

function simpanCourseEdit(id){
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
            data: {id:id,gambar_default_cover:gambar_default_cover,judul:judul,cmbCategory:cmbCategory,deskripsi:deskripsi,topic:topic,start_date:start_date,end_date:end_date,image_high_cover:image_high_cover,image_tumb_cover:image_tumb_cover},
            url: "<?php echo base_url('master/simpanCourseEdit')?>",
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




  function confirmDeleteCourseLesson(id){
      $('#btnDelete').attr('onclick', 'hapusCourseLesson('+id+')');
  }

  function hapusCourseLesson(id){
    //alert(id);
        $.ajax({
            type: 'POST',
            data:  {id:id},
            url: "<?php echo base_url('master/hapusCourseLesson')?>",
            dataType: 'JSON',
            success: function(response) {
              if(response.msg == 0){
                location.reload();
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


  function confirmStatusData(id,flag){
      if(flag == 1){
        $("#resendActivationLabel").html("Confirm Publish");
        $("#btnStatusData").html("Publish");
        $("#bodyModalStatusData").html("<p>Are you sure you want to publish this course ?</p>");
      }else{
        $("#resendActivationLabel").html("Confirm Withdraw");
        $("#btnStatusData").html("Withdraw");
        $("#bodyModalStatusData").html("<p>Are you sure you want to withdraw this course ??</p>");
      }
      $("#btnStatusData").attr('onclick','ubahStatusCourse('+flag+','+id+')');
     
    }
    function ubahStatusCourse(flag,id){
        $.ajax({
            type: 'POST',
            data: {flag:flag,id:id},
            url: "<?php echo base_url('master/ubahStatusCourse')?>",
            async: false,
            dataType: 'JSON',
            success: function(response) {
              if(response.msg == 0){
                location.reload();

                $.ambiance({message: "Data sukses disimpan",
                  type: "success",
                  fade: false});
                
              }else{
                $.ambiance({message: "Data gagal disimpan",
                  type: "error",
                  fade: false});
              }
            }

        });
    }
</script>