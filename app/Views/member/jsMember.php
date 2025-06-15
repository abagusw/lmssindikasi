<script type="text/javascript">
    var table;
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ambil token dari meta tag
            }
        });
        //datatables
        table = $('#example').DataTable({ 
            
            "processing": true, 
            "serverSide": true, 
            "order": [], 
             
            "ajax": {
                "url": "<?php echo base_url('member/getDataMemberReg')?>",
                "type": "POST",
                "data": function(d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                },

            },
 
             
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
 
        });
 
    });
</script>


<script>

	function confirmStatusData(id,flag){
      if(flag == 1){
        $("#resendActivationLabel").html("Confirm Approve");
        $("#btnStatusData").html("Approve");
        $("#bodyModalStatusData").html("<p>Are you sure you want to approve this users account?</p>");
      }else{
        $("#resendActivationLabel").html("Confirm Rejected");
        $("#btnStatusData").html("Reject");
        $("#bodyModalStatusData").html("<p>Are you sure you want to rejected this users account?</p>");
      }
      $("#btnStatusData").attr('onclick','ubahStatus('+flag+','+id+')');
     
    }
    function ubahStatus(flag,id){
        $.ajax({
            type: 'POST',
            data: {flag:flag,id:id},
            url: "<?php echo base_url('member/ubahStatus')?>",
            async: false,
            dataType: 'JSON',
            success: function(response) {
              if(response.msg == 0){
                top.location.href="<?php echo base_url('member/registration')?>";

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