<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
<?php $uri = service('uri');
                
$flag = $uri->getSegment(2); ?>
<div class="row">
  <!--begin::Col-->
  <div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 1-->
    <div class="small-box text-bg-primary">
      <div class="inner">
        <h3><?= $memberAll; ?></h3>
        <p>Total Register</p>
      </div>
      <svg
        class="small-box-icon"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
        ></path>
      </svg>
      <a
        href="#"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        More info <i class="bi bi-link-45deg"></i>
      </a>
    </div>
    <!--end::Small Box Widget 1-->
  </div>
  <!--end::Col-->
  <div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 2-->
    <div class="small-box text-bg-success">
      <div class="inner">
        <h3><?= $memberActive; ?></h3>
        <p>Active Member</p>
      </div>
      <svg
        class="small-box-icon"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
        ></path>
      </svg>
      <a
        href="<?= base_url() ?>member/1"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        More info <i class="bi bi-link-45deg"></i>
      </a>
    </div>
    <!--end::Small Box Widget 2-->
  </div>
  <!--end::Col-->
  <div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 3-->
    <div class="small-box text-bg-warning">
      <div class="inner">
        <h3>44</h3>
        <p>Other Stat</p>
      </div>
      <svg
        class="small-box-icon"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
        ></path>
      </svg>
      <a
        href="#"
        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        More info <i class="bi bi-link-45deg"></i>
      </a>
    </div>
    <!--end::Small Box Widget 3-->
  </div>
  <!--end::Col-->
  <div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 4-->
    <div class="small-box text-bg-danger">
      <div class="inner">
        <h3>65</h3>
        <p>Other Stat</p>
      </div>
      <svg
        class="small-box-icon"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          clip-rule="evenodd"
          fill-rule="evenodd"
          d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
        ></path>
        <path
          clip-rule="evenodd"
          fill-rule="evenodd"
          d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
        ></path>
      </svg>
      <a
        href="#"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        More info <i class="bi bi-link-45deg"></i>
      </a>
    </div>
    <!--end::Small Box Widget 4-->
  </div>

  <div class="col-lg-12">
    <table id="example"class="table table-bordered table-striped table-hover align-middle">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Email</th>
                  <th>City Domicile</th>
                  <th>Job Title</th>
                  <th>Register Date</th>"
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
<?= $this->endSection(); ?>