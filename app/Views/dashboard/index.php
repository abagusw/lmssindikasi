<?= $this->extend('templates/app'); ?>

<?= $this->section('content'); ?>

<style>
/* ===== Scoped styling khusus dashboard ===== */
.dash{
  --bg-grad-1:#f8fafc;        /* terang */
  --bg-grad-2:#eef2ff;
  --card-grad-1:#ffffff;
  --card-grad-2:#f8fafc;
  --card-border:#e5e7eb;
  --txt-muted:#64748b;         /* slate-500 */
  --txt-strong:#0f172a;        /* slate-900 */
  --primary:#6366f1;           /* indigo-500 */
  --secondary:#06b6d4;         /* cyan-500 */
  --accent:#22c55e;            /* green-500 */
  --shadow:0 14px 30px rgba(2,6,23,.08);

  background:
    radial-gradient(900px 500px at -10% -10%, rgba(99,102,241,.10), transparent 60%),
    radial-gradient(800px 400px at 110% 0%, rgba(34,197,94,.12), transparent 55%),
    linear-gradient(180deg, var(--bg-grad-1), var(--bg-grad-2));
  padding: .25rem 0 1rem;
  border-radius: 18px;
}

.dash h5{
  font-weight: 800; letter-spacing:.3px; color: var(--txt-strong);
}

/* Card umum */
.dash .card{
  border:1px solid var(--card-border);
  border-radius: 18px;
  background: linear-gradient(180deg, var(--card-grad-1), var(--card-grad-2));
  box-shadow: var(--shadow);
}
.dash .card:hover{ transform: translateY(-2px); transition: .18s ease; }

/* KPI */
.dash .card-metric .text-muted{ color: var(--txt-muted) !important; text-transform: uppercase; letter-spacing:.6px }
.dash .card-metric .fs-2{ 
  background: linear-gradient(90deg, var(--primary), var(--secondary));
  -webkit-background-clip:text; background-clip:text; color: transparent;
}

/* Top 10 list */
.dash .label-col{ width:72%; color:#0f172a }
.dash .value-col{ width:28%; text-align:right; color:#0f172a }
.dash .mini-bar{ height:10px; border-radius:999px; background:#eef2ff; overflow:hidden; }
.dash .mini-bar>span{ 
  display:block; height:100%;
  background: linear-gradient(90deg, var(--secondary), var(--primary));
}

/* Header section registration */
.dash .fw-semibold{ color:#0f172a }

/* Tweak shadow-sm agar lebih lembut */
.shadow-sm{ box-shadow: var(--shadow) !important; }

@media (prefers-color-scheme: dark){
  .dash{
    --bg-grad-1:#0b1229; --bg-grad-2:#0f172a;
    --card-grad-1:rgba(255,255,255,.06);
    --card-grad-2:rgba(255,255,255,.03);
    --card-border:rgba(255,255,255,.12);
    --txt-muted:#94a3b8; --txt-strong:#e2e8f0;
    --shadow:0 18px 40px rgba(2,6,23,.45);
  }
  .dash .label-col, .dash .value-col{ color: var(--txt-strong); }
  .dash .mini-bar{ background: rgba(255,255,255,.12); }
}
</style>

<div class="dash">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
// gunakan warna dari CSS variables supaya konsisten tema
const css = getComputedStyle(document.querySelector('.dash'));
const c1  = css.getPropertyValue('--primary').trim()   || '#6366f1';
const c2  = css.getPropertyValue('--secondary').trim() || '#06b6d4';
const grid = 'rgba(100,116,139,.25)';

// gradient fill lembut
const ctx = document.getElementById('regChart').getContext('2d');
const grad1 = ctx.createLinearGradient(0,0,0,160); grad1.addColorStop(0, c1); grad1.addColorStop(1, 'rgba(99,102,241,0)');
const grad2 = ctx.createLinearGradient(0,0,0,160); grad2.addColorStop(0, c2); grad2.addColorStop(1, 'rgba(6,182,212,0)');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($monthLabels) ?>,
    datasets: [
      {
        label: 'Register',
        data: <?= json_encode($seriesRegister) ?>,
        borderColor: c1,
        backgroundColor: grad1,
        fill: true,
        tension: 0.35,
        borderWidth: 3,
        pointRadius: 2.5,
        pointHoverRadius: 4
      },
      {
        label: 'Active Member',
        data: <?= json_encode($seriesActive) ?>,
        borderColor: c2,
        backgroundColor: grad2,
        fill: true,
        tension: 0.35,
        borderWidth: 3,
        pointRadius: 2.5,
        pointHoverRadius: 4
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
        labels: { color: '#0f172a' }
      },
      tooltip: {
        backgroundColor: 'rgba(15,23,42,.92)',
        borderColor: 'rgba(148,163,184,.35)',
        borderWidth: 1,
        padding: 10
      }
    },
    scales: {
      x: { ticks: { color: '#0f172a' }, grid: { color: grid } },
      y: { beginAtZero: true, ticks: { precision:0, color:'#0f172a' }, grid: { color: grid } }
    }
  }
});
</script>

<?= $this->endSection(); ?>
