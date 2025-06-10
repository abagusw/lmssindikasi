<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="container my-4">
    <!-- Summary Cards -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Total Revenue <i class="fas fa-money-bill"></i></div>
          <div class="value">Rp70,000,000</div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Total Registration Payment <i class="fas fa-money-bill"></i></div>
          <div class="value">Rp30,000,000</div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Total Member Dues <i class="fas fa-money-bill"></i></div>
          <div class="value">Rp30,000,000</div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card-box">
          <div class="label">Total Donation <i class="fas fa-money-bill"></i></div>
          <div class="value">Rp10,000,000</div>
        </div>
      </div>
    </div>

    <!-- Filter Inputs -->
    <div class="row g-2 mb-4">
      <div class="col-12 col-sm-6 col-md-2">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <div class="col-12 col-sm-6 col-md-2">
        <select class="form-control">
          <option>Payment Type</option>
        </select>
      </div>
      <div class="col-12 col-sm-6 col-md-2">
        <select class="form-control">
          <option>Method</option>
        </select>
      </div>
      <div class="col-12 col-sm-6 col-md-2">
        <select class="form-control">
          <option>Status</option>
        </select>
      </div>
      <div class="col-12 col-sm-6 col-md-4">
        <input type="text" class="form-control" placeholder="dd/mm/yyyy - dd/mm/yyyy">
      </div>
    </div>
    </div>


  <div class="col-lg-12">
    <table id="example"class="table table-bordered table-striped table-hover align-middle">
          <thead>
              <tr>
                  <th>Payment Type</th>
                  <th>User</th>
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Payment Date</th>
                  <th>Status</th>
                  <th>Action</th>
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
                "url": "<?php echo base_url('payment/getPayment')?>",
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