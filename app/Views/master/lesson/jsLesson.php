<script>
  function confirmDeleteCity(id){
      $('#btnDelete').attr('onclick', 'hapusDataCity('+id+')');
  }

  function hapusDataCity(id){
    //alert(id);
        $.ajax({
            type: 'POST',
            data:  {id:id},
            url: "<?php echo base_url('master/hapusDataCity')?>",
            dataType: 'JSON',
            success: function(response) {
              if(response.msg == 0){
                top.location.href="<?php echo base_url('master/city')?>";
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
        $("#resendActivationLabel").html("Confirm Activated");
        $("#btnStatusData").html("Activated");
        $("#bodyModalStatusData").html("<p>Are you sure you want to activated this lesson ?</p>");
      }else{
        $("#resendActivationLabel").html("Confirm Archived");
        $("#btnStatusData").html("Archived");
        $("#bodyModalStatusData").html("<p>Are you sure you want to archived this lesson ??</p>");
      }
      $("#btnStatusData").attr('onclick','ubahStatusLesson('+flag+','+id+')');
     
    }
    function ubahStatusLesson(flag,id){
        $.ajax({
            type: 'POST',
            data: {flag:flag,id:id},
            url: "<?php echo base_url('master/ubahStatusLesson')?>",
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