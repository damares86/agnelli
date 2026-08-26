<?php
$employee->table = 'employee';
$punch->table = 'punch';

$months = $punch->availableMonths();
$emps = $employee->allEmployees(true);

$report = isset($_SESSION['timbrature_import']) ? $_SESSION['timbrature_import'] : null;
unset($_SESSION['timbrature_import']);

$mesi = [1 => 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Timbrature</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php"><?= $common_dashboard ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">Timbrature</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<?php if ($report) { ?>
  <div class="alert alert-success">
    File <b><?= htmlspecialchars($report['file']) ?></b> importato:
    <b><?= $report['imported'] ?></b> timbrature inserite, <b><?= $report['skipped'] ?></b> ignorate (duplicate o incomplete).
    <?php if (!empty($report['created'])) { ?>
      <br>Nuovi dipendenti creati automaticamente (controlla le ore in anagrafica):
      <b><?= htmlspecialchars(implode(', ', array_unique($report['created']))) ?></b>
    <?php } ?>
  </div>
<?php } ?>

<section class="section">
  <div class="row">

    <div class="col-md-6 col-12">
      <div class="card shadow">
        <div class="card-header"><h4 class="card-title">1. Carica il file del mese</h4></div>
        <div class="card-body">
          <form action="core/mngTimbrature.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label>File timbrature (.xls, .xlsx o .csv)</label>
              <input type="file" class="form-control" name="file" accept=".xls,.xlsx,.csv" required>
              <small class="text-muted d-block mt-2">
                Formato atteso: export "Access Control Log" con le colonne <code>Name</code>, <code>User ID</code>, <code>Date</code>, <code>Time</code>.
                I nominativi non presenti in anagrafica vengono creati con 8 ore al giorno.
                Il reimport dello stesso file non crea duplicati.
              </small>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-upload"></i> Importa</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-12">
      <div class="card shadow">
        <div class="card-header"><h4 class="card-title">2. Scarica il riepilogo Excel</h4></div>
        <div class="card-body">
          <?php if (empty($months)) { ?>
            <p class="text-muted mb-0">Nessuna timbratura in archivio: carica prima un file.</p>
          <?php } else { ?>
            <form action="core/export_timbrature.php" method="GET" target="_blank">
              <div class="form-group">
                <label>Mese</label>
                <select name="month" class="form-select" required>
                  <?php foreach ($months as $m) {
                    list($y, $mm) = explode('-', $m['ym']); ?>
                    <option value="<?= $m['ym'] ?>"><?= $mesi[(int)$mm] . ' ' . $y ?> (<?= $m['tot'] ?> timbrature)</option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group mt-3">
                <label>Dipendente</label>
                <select name="employee_id" class="form-select">
                  <option value="">Tutti (una scheda per dipendente)</option>
                  <?php foreach ($emps as $e) { ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['name']) ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="submit" class="btn btn-success mt-3"><i class="bi bi-file-earmark-excel"></i> Scarica Excel</button>
            </form>
          <?php } ?>
        </div>
      </div>
    </div>

  </div>

  <?php if (!empty($months)) { ?>
    <div class="card shadow">
      <div class="card-header"><h4 class="card-title">Mesi in archivio</h4></div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr><th>Mese</th><th>Timbrature</th><th class="text-end">Azioni</th></tr>
          </thead>
          <tbody>
            <?php foreach ($months as $m) {
              list($y, $mm) = explode('-', $m['ym']); ?>
              <tr>
                <td><?= $mesi[(int)$mm] . ' ' . $y ?></td>
                <td><?= $m['tot'] ?></td>
                <td class="text-end">
                  <a href="core/export_timbrature.php?month=<?= $m['ym'] ?>" class="btn btn-sm btn-success"><i class="bi bi-download"></i> Excel</a>
                  <a href="core/mngTimbrature.php?monthToDel=<?= $m['ym'] ?>" class="btn btn-sm btn-danger"
                     onclick="return confirm('Eliminare tutte le timbrature di questo mese?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php } ?>
</section>
