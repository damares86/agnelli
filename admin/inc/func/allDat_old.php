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
  if (preg_match('/^\d{4}_\d{2}_\d{2}_.+$/', $table)) {
    $datTables[] = $table;
  }
}

// recupero i dati dalle tabelle selezionate
$risultati = [];

foreach ($datTables as $table) {

  $sql = "SELECT * FROM `$table` ORDER BY ordine";
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
              <th>Attività</th>
              <th>Importo da fatturare</th>
              <th>Importo ivato</th>
              <th><?= $common_actions ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $num = 0;
            foreach ($risultati as $table => $righe) {

              // split nome tabella
            [$anno, $meseInizio, $meseFine,$attivita] = explode('_', $table);

/*               $parts = explode('_', $table);

              // primi 3 elementi fissi
              $anno       = $parts[0];
              $meseInizio = $parts[1];
              $meseFine   = $parts[2];

              // tutto il resto è l'attività (anche se un domani avrà underscore)
              $attivita = implode('_', array_slice($parts, 3)); */
              $attivita = ucfirst($attivita);

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
                <td><?= $attivita ?></td>
                <td>
                  <?= number_format($totaleNetto, 2, ',', '.') ?> €
                </td>
                <td>
                  <?= number_format($totaleIvato, 2, ',', '.') ?>
                </td>
                <td>
                  <button type="button" class="btn icon btn-success shadow edit-link" data-bs-toggle="modal" data-bs-target="#detail<?= $num ?>">
                    <i class="bi bi-search"></i>
                  </button>

                  &nbsp; &nbsp;
                  <!--<a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i>-->
                  </a>

                  <div class="modal fade text-left w-100" id="detail<?= $num ?>" tabindex="-1" aria-labelledby="myModalLabel20" style="display: none;" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel20">Dati fatturazione Dat Caffè (<?= $nomeMeseInizio ?> - <?= $nomeMeseFine ?> <?= $anno ?>)</h4>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class="table-responsive">
                            <table class="table" id="table">
                              <thead>
                                <tr>
                                  <th>Categoria</th>
                                  <th>Tab.</th>
                                  <th>Fascia</th>
                                  <th>Quantità</th>
                                  <th>Prezzo DAT</th>
                                  <th>Totale DAT</th>
                                  <th>Prezzo Lordo</th>
                                  <th>Prezzo Netto</th>
                                  <th>Totale Netto</th>
                                  <th>Totale Ivato</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $subTotaleNetto = 0;
                                $subTotaleIvato = 0;

                                foreach ($righe as $riga) {

                                  // calcoli coerenti (no arrotondamenti intermedi)
                                  $totaleNettoRiga =
                                    ($riga['prezzo_pubblico'] - $riga['prezzo_dat'])
                                    / 1.10
                                    * $riga['quantita'];

                                  $totaleIvatoRiga = $totaleNettoRiga * 1.22;

                                  // accumulo (escludo SALESIANI se vuoi)
                                  if ($riga['categoria'] !== 'SALESIANI') {
                                    $subTotaleNetto += $totaleNettoRiga;
                                    $subTotaleIvato += $totaleIvatoRiga;
                                  }
                                ?>
                                  <tr>
                                    <td><?= htmlspecialchars($riga['categoria']) ?></td>
                                    <td><?= $riga['tabella'] ?></td>
                                    <td><?= $riga['fascia'] ?></td>
                                    <td><?= $riga['quantita'] ?></td>
                                    <td><?= number_format($riga['prezzo_dat'], 2, ',', '.') ?></td>
                                    <td><?= $riga['totale_dat'] ?></td>
                                    <td><?= number_format($riga['prezzo_lordo_agnelli'], 2, ',', '.') ?></td>
                                    <td><?= number_format($riga['prezzo_netto_agnelli'], 2, ',', '.') ?></td>
                                    <td><?= number_format($totaleNettoRiga, 2, ',', '.') ?></td>
                                    <td><?= number_format($totaleIvatoRiga, 2, ',', '.') ?></td>
                                  </tr>
                                <?php 
                                } 
                                  $subTotaleNetto = $subTotaleNetto - $caffeSalesiani;
                                  $subTotaleIvato = $subTotaleIvato - ($caffeSalesiani*1.22);
                                ?>
                              </tbody>
                              <tfoot>
                                <tr class="fw-bold">
                                  <td colspan="6" class="text-end">Totale</td>
                                  <td><?= number_format($subTotaleNetto, 2, ',', '.') ?> €</td>
                                  <td><?= number_format($subTotaleIvato, 2, ',', '.') ?> €</td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>




                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Chiudi</span>
                          </button>

                        </div>
                      </div>
                    </div>
                  </div>


                </td>
              </tr>
            <?php
              $num++;
            }
            ?>


          </tbody>
        </table>
      </div>
    </div>
</section>