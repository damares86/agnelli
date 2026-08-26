<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Aggiungi dipendente</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php"><?= $common_dashboard ?></a></li>
          <li class="breadcrumb-item"><a href="index.php?p=allEmployees">Dipendenti</a></li>
          <li class="breadcrumb-item active" aria-current="page">Aggiungi</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="row">
    <div class="col-md-8 col-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="card-title">Dati dipendente</h4>
        </div>
        <div class="card-body">
          <form class="form form-horizontal" action="core/mngEmployee.php" method="POST" data-parsley-validate>
            <input type="hidden" name="operation" value="add">

            <div class="row">
              <div class="col-md-3"><label>Nome <span class="text-danger">*</span></label></div>
              <div class="col-md-9">
                <div class="form-group">
                  <input type="text" class="form-control" name="name" placeholder="Nome e cognome" data-parsley-required="true">
                </div>
              </div>

              <div class="col-md-3"><label>Badge / User ID</label></div>
              <div class="col-md-9">
                <div class="form-group">
                  <input type="text" class="form-control" name="badge" placeholder="Es. 01">
                  <small class="text-muted">Codice presente nella colonna "User ID" del file timbrature (facoltativo).</small>
                </div>
              </div>

              <div class="col-md-3"><label>Ore settimanali</label></div>
              <div class="col-md-9">
                <div class="row">
                  <?php foreach (['h_mon' => 'Lunedì', 'h_tue' => 'Martedì', 'h_wed' => 'Mercoledì', 'h_thu' => 'Giovedì', 'h_fri' => 'Venerdì'] as $f => $l) { ?>
                    <div class="col">
                      <label class="form-label"><?= $l ?></label>
                      <input type="number" step="0.25" min="0" max="24" class="form-control text-center" name="<?= $f ?>" value="8">
                    </div>
                  <?php } ?>
                </div>
                <small class="text-muted">Formato decimale: 6.5 = 6 ore e 30 minuti. Usa 0 per i giorni non lavorativi.</small>
              </div>

              <div class="col-md-3 mt-3"><label>Note</label></div>
              <div class="col-md-9 mt-3">
                <textarea class="form-control" name="notes" rows="3"></textarea>
              </div>

              <div class="col-md-3 mt-3"><label>Attivo</label></div>
              <div class="col-md-9 mt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                </div>
              </div>

              <div class="col-12 d-flex justify-content-end mt-4">
                <a href="index.php?p=allEmployees" class="btn btn-light-secondary me-2">Annulla</a>
                <button type="submit" class="btn btn-primary">Salva</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
