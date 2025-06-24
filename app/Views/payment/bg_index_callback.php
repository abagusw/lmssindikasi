<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="container my-4">
    <!-- Summary Cards -->


    <div class="col-lg-12">
      <table id="example"class="table table-bordered table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>Transaction Status</th>
                    <th>Payment Type</th>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>VA Number</th>
                    <th>Bank</th>
                    <th>URL</th>
                    <th>Token</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <!-- <tfoot>
                <tr>
                    <th>#</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>City Domicile</th>
                    <th>Job Title</th>
                    <th>Date Registration</th>
                    <th>Date Approval</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot> -->
      </table>
    </div>
    <!--end::Col-->
</div>


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
                "url": "<?php echo base_url('payment/getPaymentCallBack')?>",
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
<?= $this->endSection(); ?>