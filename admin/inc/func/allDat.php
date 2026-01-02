<?php
// recupero tutte le tabelle del database
$sql = "
SELECT table_name
FROM information_schema.tables
WHERE table_schema = DATABASE()
";

$stmt = $db->query($sql);
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

// filtro solo quelle yyyy_mm_mm
$datTables = [];

foreach ($tables as $table) {
  if (preg_match('/^\d{4}_\d{2}_\d{2}$/', $table)) {
    $datTables[] = $table;
  }
}

// recupero i dati dalle tabelle selezionate
$risultati = [];

foreach ($datTables as $table) {

  $sql = "SELECT * FROM `$table` ORDER BY categoria, tabella, fascia";
  $stmt = $db->query($sql);

  $risultati[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// conversione mesi
$mesi = [
  '01' => 'Gennaio',
  '02' => 'Febbraio',
  '03' => 'Marzo',
  '04' => 'Aprile',
  '05' => 'Maggio',
  '06' => 'Giugno',
  '07' => 'Luglio',
  '08' => 'Agosto',
  '09' => 'Settembre',
  '10' => 'Ottobre',
  '11' => 'Novembre',
  '12' => 'Dicembre',
];
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Tutte le fatture Dat Caffè</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Tutte le fatture Dat Caffè
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>
<section class="section">
  </div>
  <div class="card shadow">
    <div class="card-header">
      <div class="card-body">
        <h4 class="card-title">Fatture</h4>
        <table class="table" id="table">
          <thead>
            <tr>
              <th>Periodo</th>
              <th>Importo da fatturare</th>
              <th>Importo ivato</th>
              <th><?= $common_actions ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($risultati as $table => $righe) {

              // split nome tabella
              [$anno, $meseInizio, $meseFine] = explode('_', $table);

              $nomeMeseInizio = $mesi[$meseInizio] ?? 'Mese sconosciuto';
              $nomeMeseFine   = $mesi[$meseFine]   ?? 'Mese sconosciuto';

              $totaleNetto = 0;
              $caffeSalesiani  = 0;

              foreach ($righe as $riga) {

                /*
                $importoSenzaIva += $riga['totale_agnelli'];                
                $importoIvato    += $riga['totale_agnelli_ivato'];
                echo $riga['categoria'].' ('.$riga['quantita'].') =>'. $riga['totale_agnelli'] .' | '. $riga['totale_agnelli_ivato'].'<br>';
                */
                // intercetto SALESIANI
                if ($riga['categoria'] === 'SALESIANI') {
                  $caffeSalesiani += $riga['totale_dat'];
                   // echo '++++++++++ caffè salesiani => '.$riga['totale_dat'].'<br>';
                }
                $totaleNetto +=
                  ($riga['prezzo_pubblico'] - $riga['prezzo_dat'])
                  / 1.10
                  * $riga['quantita'];
              }

              //echo 'Importo totale  => ' . $importoSenzaIva . '<br>';
              
              // tolgo il caffè dei salesiani e arrotondo
              $totaleNetto -= $caffeSalesiani;
              $totaleNetto = round($totaleNetto, 2);

              // calcolo l'importo ivato
              $totaleIvato = round($totaleNetto * 1.22, 2);
              
              //echo 'Importo da fatturare => ' . $importoDaFatturare;

            ?>
              <tr>
                <td><?= $nomeMeseInizio ?> - <?= $nomeMeseFine ?> <?= $anno ?></td>
                <td>
                  <?= number_format($totaleNetto, 2, ',', '.') ?> €
                </td>
                <td>
                  <?= number_format($totaleIvato, 2, ',', '.') ?>
                </td>
                <td>
                  <a href="index.php?p=editAccount&idToMod=<?= $row['id'] ?>" class="btn icon btn-success shadow edit-link" data-base-url="index.php?p=editAccount&idToMod=<?= $row['id'] ?>">
                    <i class="bi bi-search"></i>
                  </a>

                  &nbsp; &nbsp;
                  <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i>
                  </a>
                  <!--Danger theme Modal -->
                  <div class="modal fade text-left" id="danger<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-danger">
                          <h5 class="modal-title white" id="myModalLabel120">
                            <?= $common_modal_title_sure ?>
                          </h5>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          Se continui eliminerai questa fattura definitivamente.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                          </button>
                          <span class="d-none d-sm-block"><a href="core/mngAccounts.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
                              <?= $common_modal_confirm ?>
                            </a></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>


          </tbody>
        </table>
      </div>
    </div>
</section>