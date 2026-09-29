<?php
$listini = ['scuola' => 'Scuola', 'oratorio' => 'Oratorio', 'cinema' => 'Cinema'];
$tipo = filter_input(INPUT_GET, 'tipo');
if (!array_key_exists($tipo, $listini)) {
  $tipo = 'scuola';
}

$categoria = '';
$tabella = '';
$fascia = '';
$prezzo_pubblico = '';
$prezzo_dat = '';
?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3 class="d-inline">Aggiungi prodotto - listino <?= $listini[$tipo] ?></h3>
        <a href="index.php?p=allListini&tipo=<?= $tipo ?>" class="btn icon btn-info shadow mx-3 px-3">
          <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= $common_back ?>
        </a>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php"><?= $common_dashboard ?></a></li>
            <li class="breadcrumb-item"><a href="index.php?p=allListini&tipo=<?= $tipo ?>">Tutti i listini</a></li>
            <li class="breadcrumb-item active" aria-current="page">Aggiungi prodotto</li>
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
            <h4 class="card-title">Nuovo prodotto nel listino <b><?= $listini[$tipo] ?></b></h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form class="form form-horizontal" action="core/mngListino.php" method="POST" data-parsley-validate>
                <div class="form-body">
                  <div class="row">

                    <div class="col-md-3"><label>Categoria <span class="text-danger">*</span></label></div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input type="text" class="form-control" name="categoria" data-parsley-required="true" maxlength="255" value="<?= htmlspecialchars($categoria) ?>">
                      </div>
                    </div>

                    <div class="col-md-3"><label>Tabella <span class="text-danger">*</span></label></div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input type="number" step="1" class="form-control" name="tabella" data-parsley-required="true" value="<?= $tabella ?>">
                      </div>
                    </div>

                    <div class="col-md-3"><label>Fascia <span class="text-danger">*</span></label></div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input type="number" step="1" class="form-control" name="fascia" data-parsley-required="true" value="<?= $fascia ?>">
                      </div>
                    </div>

                    <div class="col-md-3"><label>Prezzo pubblico (&euro;) <span class="text-danger">*</span></label></div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input type="number" step="0.01" min="0" max="99.99" class="form-control" name="prezzo_pubblico" data-parsley-required="true" value="<?= $prezzo_pubblico ?>">
                      </div>
                    </div>

                    <div class="col-md-3"><label>Prezzo Dat (&euro;) <span class="text-danger">*</span></label></div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input type="number" step="0.01" min="0" max="99.99" class="form-control" name="prezzo_dat" data-parsley-required="true" value="<?= $prezzo_dat ?>">
                      </div>
                    </div>

                    <input type="hidden" name="operation" value="add">
                    <input type="hidden" name="tipo" value="<?= $tipo ?>">

                    <div class="col-12 d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary me-1 mb-1 shadow">Aggiungi prodotto</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
