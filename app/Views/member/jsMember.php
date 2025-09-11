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


<script>
document.addEventListener('DOMContentLoaded', function() {
  const tableEl = document.getElementById('example');
  const checkAllEl = document.getElementById('checkAll');
  const btnApproveSelected = document.getElementById('btnApproveSelected');
  const approveNamesEl = document.getElementById('approveNames');
  const approveCountEl = document.getElementById('approveCount');
  const btnConfirmBulkApprove = document.getElementById('btnConfirmBulkApprove');

  function getRowChecks() {
    return Array.from(tableEl.querySelectorAll('tbody .row-check')).filter(cb => !cb.disabled);
  }
  function getSelected() {
    const cbs = getRowChecks().filter(cb => cb.checked);
    return cbs.map(cb => ({
      id: cb.getAttribute('data-id'),
      nama: cb.getAttribute('data-nama')
    }));
  }
  function updateActionButton() {
    const selected = getSelected();
    btnApproveSelected.disabled = selected.length === 0;
  }
  function updateCheckAllState() {
    const cbs = getRowChecks();
    const checked = cbs.filter(cb => cb.checked).length;
    checkAllEl.checked = (cbs.length > 0 && checked === cbs.length);
    checkAllEl.indeterminate = (checked > 0 && checked < cbs.length);
  }

  checkAllEl.addEventListener('change', () => {
    const cbs = getRowChecks();
    cbs.forEach(cb => { cb.checked = checkAllEl.checked; });
    updateActionButton();
    updateCheckAllState();
  });


  $('#example').on('draw.dt', function () {
    getRowChecks().forEach(cb => {
      cb.onchange = () => {
        updateActionButton();
        updateCheckAllState();
      };
    });
    // reset header checkbox setiap draw
    checkAllEl.checked = false;
    checkAllEl.indeterminate = false;
    updateActionButton();
  });

  btnApproveSelected.addEventListener('click', () => {
    const selected = getSelected();
    approveNamesEl.innerHTML = '';
    selected.forEach(item => {
      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.textContent = item.nama + ' (ID: ' + item.id + ')';
      approveNamesEl.appendChild(li);
    });
    approveCountEl.textContent = selected.length;
  });

  btnConfirmBulkApprove.addEventListener('click', async () => {
    $("#btnConfirmBulkApprove").html("mohon ditunggu sedang proses update data .... !");
    $("#btnConfirmBulkApprove").attr("dsiabled",true);
    const ids = getSelected().map(x => x.id);
    if (ids.length === 0) return;

    // OPTIONAL: sesuaikan CSRF kalau aktif
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    try {
      const resp = await fetch('<?= base_url("member/bulk-approve") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        'X-Requested-With': 'XMLHttpRequest',
        body: JSON.stringify({ ids: getSelected().map(x => x.id) })
       // body: JSON.stringify({ ids: getSelected().map(x => x.id) })
      });
      const data = await resp.json();
      if (!resp.ok || !data.ok) {
        alert('Gagal approve: ' + (data.message || resp.statusText));
        return;
      }

      // Sukses → reload DataTable & tutup modal
      $('#modalBulkApprove').modal('hide');
      $('#example').DataTable().ajax.reload(null, false); // stay on page
    } catch (e) {
      alert('Error: ' + e.message);
    }
  });
});
</script>
