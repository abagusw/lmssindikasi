<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>

<div class="row">

	<div class="container">

	  <!-- Header -->
	  <div class="d-flex justify-content-between align-items-center mb-3">
	    <div>
	      <h4 class="mb-0">Course</h4>
	      <small class="text-muted">Manage your course catalog</small>
	    </div>
	    <a href="<?= base_url()?>master/add_course" class="btn btn-warning text-white">+ Add new</a>
	  </div>

	  <!-- Filter Controls -->
	  <div class="row g-2 mb-3">
	    <div class="col-md-3">
	      <input type="text" class="form-control" id="filterCari" name="filterCari" placeholder="🔍 Search">
	    </div>
	    <div class="col-md-2">
	      <select id="filterCategory" name="filterCategory" class="form-select">
                <option selected disabled>Category</option>
                <option value="0">Foundational</option>
                <option value="1">Advance Course</option>
          </select>
	    </div>
	    <div class="col-md-2">
	      <select id="filterStatus" name="filterStatus" class="form-select">
                <option selected disabled>Status</option>
                <option value="0">Draft</option>
                <option value="1">Published</option>
                <option value="2">Withdrawn</option>
          </select>
	    </div>
	    <div class="col-md-3">
	      <input type="text" class="form-control" id="filterDate" placeholder="20/05/2020 - 20/05/2020">
	    </div>
	  </div>

	  <!-- Table Header -->
	 <!--  <div class="d-flex justify-content-between align-items-center mb-2">
	    <div>
	      <select class="form-select form-select-sm w-auto d-inline-block">
	        <option selected>Rows per page: 10</option>
	      </select>
	      <span class="ms-2 small text-muted">Showing 1-10 from 1,085 item(s)</span>
	    </div>
	    <div>
	      <select class="form-select form-select-sm w-auto">
	        <option selected>Sort: Newest</option>
	      </select>
	    </div>
	  </div> -->

	  <!-- Course Table -->
	  <div class="table-responsive">
	    <table class="table align-middle bg-white table-hover" id="courseTable">
	      <thead class="table-light">
	        <tr>
	          <th>Judul</th>
	          <th>Category </th>
	          <th>Assigned Lesson</th>
	          <th>Participant</th>
	          <th>Created Date</th>
	          <th>Status</th>
	          <th class="text-end">Action</th>
	        </tr>
	      </thead>
	      <tbody>

	        <!-- Tambahkan baris lainnya sesuai kebutuhan -->
	      </tbody>
	    </table>
	  </div>
	</div>
</div>

	<script>
		$(document).ready(function() {
		  var table = $('#courseTable').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: {
		      url: "<?= site_url('master/getDataCourse') ?>",
		      type: "POST",
		      data: function(d) {
		        d.filterCategory = $('#filterCategory').val();;
		        d.filterStatus = $('#filterStatus').val();
		        d.date_range = $('#filterDate').val();
		        d.filterCari = $('#filterCari').val();
		      }
		    },
		    columns: [
        	  //{ data: 'no', orderable: false, searchable: false }, // <== fix di sini
		      { data: 'judul' },
		      { data: 'category' },
		      { data: 'assigned_lesson' },
		      { data: 'participant' },
		      { data: 'created_date' },
		      { data: 'status' },
		      { data: 'action', orderable: false, searchable: false }
		    ]
		  });

		  // Trigger reload when filter changes
		  $('#filterCategory, #filterStatus, #filterDate, #filterCari').on('change keyup', function() {
		    table.draw();
		  });
		});
	</script>

	<script>
	$('#filterDate').daterangepicker({
	    autoUpdateInput: false,
	    locale: { cancelLabel: 'Clear' }
	});

	$('#filterDate').on('apply.daterangepicker', function(ev, picker) {
	    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY')).change();
	});

	$('#filterDate').on('cancel.daterangepicker', function(ev, picker) {
	    $(this).val('').change();
	});
	</script>
<?= $this->endSection(); ?>