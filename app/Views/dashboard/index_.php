<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>
  <h5 class="mb-3">DASHBOARD</h5>

  <div class="row g-3">
    <div class="col-md-4">
      <div class="card card-metric shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Total Register</div>
          <div class="fs-2 fw-bold"><?= number_format($totalRegister) ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-metric shadow-sm">
        <div class="card-body">
          <div class="text-muted small">Total Active Member</div>
          <div class="fs-2 fw-bold"><?= number_format($totalActive) ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-metric shadow-sm">
        <div class="card-body">
          <div class="text-muted small">New Register This Month</div>
          <div class="fs-2 fw-bold"><?= number_format($newRegisterMonth) ?></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mt-2">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-2 fw-semibold">Top 10 City Active Member</div>
          <?php foreach ($topCities as $row): ?>
            <?php
              $max = max(array_column($topCities,'total')) ?: 1;
              $pct = round($row['total']*100/$max,2);
            ?>
            <div class="d-flex align-items-center mb-2">
              <div class="label-col small text-truncate me-2"><?= esc($row['label']) ?></div>
              <div class="value-col small"><?= number_format($row['total']) ?></div>
            </div>
            <div class="mini-bar mb-2"><span style="width:<?= $pct ?>%"></span></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-2 fw-semibold">Top 10 Member Job Title</div>
          <?php foreach ($topProfesi as $row): ?>
            <?php
              $max2 = max(array_column($topProfesi,'total')) ?: 1;
              $pct2 = round($row['total']*100/$max2,2);
            ?>
            <div class="d-flex align-items-center mb-2">
              <div class="label-col small text-truncate me-2"><?= esc($row['label']) ?></div>
              <div class="value-col small"><?= number_format($row['total']) ?></div>
            </div>
            <div class="mini-bar mb-2"><span style="width:<?= $pct2 ?>%"></span></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm mt-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="fw-semibold">Registration</div>
        <form method="get">
          <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
            <?php $yNow = (int)date('Y'); for($y=$yNow-4;$y<=$yNow;$y++): ?>
              <option value="<?= $y ?>" <?= $y===$year?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </form>
      </div>
      <canvas id="regChart" height="110"></canvas>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('regChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($monthLabels) ?>,
    datasets: [
      {
        label: 'Register',
        data: <?= json_encode($seriesRegister) ?>,
        tension: 0.35,
        borderWidth: 2,
        pointRadius: 2
      },
      {
        label: 'Active Member',
        data: <?= json_encode($seriesActive) ?>,
        tension: 0.35,
        borderWidth: 2,
        pointRadius: 2
      }
    ]
  },
  options: {
    responsive: true,
    plugins: { legend: { position: 'top' } },
    scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
  }
});
</script>
<?= $this->endSection(); ?>