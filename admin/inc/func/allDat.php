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

/* ===============================
   FUNZIONE CALCOLO FATTURA
================================ */
function calcolaFattura(array $righe): array
{
  $totaleNetto = 0;
  $totaleIvato = 0;
  $caffeSalesiani = 0;

  foreach ($righe as $riga) {

    $nettoRiga =
      ($riga['prezzo_pubblico'] - $riga['prezzo_dat'])
      / 1.10
      * $riga['quantita'];

    if ($riga['categoria'] === 'SALESIANI') {
      $caffeSalesiani += $nettoRiga * 1.10;
      continue;
    }

    $totaleNetto += $nettoRiga;
    $totaleIvato += $nettoRiga * 1.22;
  }
  
  $totaleNettoFinale = $totaleNetto - $caffeSalesiani;
  $totaleIvatoFinale = $totaleIvato - ($caffeSalesiani * 1.22);

  return [
    'netto'     => round($totaleNettoFinale, 2),
    'ivato'     => round($totaleIvatoFinale, 2),
    'salesiani' => round($caffeSalesiani, 2),
  ];
}
?>

<div class="page-title">
  <h3>Tutte le fatture Dat Caffè</h3>
</div>

<section class="section">
  <div class="card shadow">
    <div class="card-body">
      <h4 class="card-title">Fatture</h4>

      <table class="table" id="table">
        <thead>
          <tr>
            <th>Periodo</th>
            <th>Attività</th>
            <th>Importo da fatturare</th>
            <th>Importo ivato</th>
            <th>Azioni</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $num = 0;
          $modali = '';

          foreach ($risultati as $table => $righe):

            [$anno, $meseInizio, $meseFine, $attivita] = explode('_', $table);
            $attivita = ucfirst($attivita);

            $nomeMeseInizio = $mesi[$meseInizio] ?? 'Mese sconosciuto';
            $nomeMeseFine   = $mesi[$meseFine] ?? 'Mese sconosciuto';

            $fattura = calcolaFattura($righe);
          ?>

            <tr>
              <td><?= $nomeMeseInizio ?> - <?= $nomeMeseFine ?> <?= $anno ?></td>
              <td><?= htmlspecialchars($attivita) ?></td>
              <td><?= number_format($fattura['netto'], 2, ',', '.') ?> €</td>
              <td><?= number_format($fattura['ivato'], 2, ',', '.') ?> €</td>
              <td>
                <button class="btn btn-success"
                  data-bs-toggle="modal"
                  data-bs-target="#detail<?= $num ?>">
                  Dettaglio
                </button>
              </td>
            </tr>

          <?php
            $modali .= '
<div class="modal fade" id="detail' . $num . '" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          Fattura DAT – ' . $nomeMeseInizio . ' / ' . $nomeMeseFine . ' ' . $anno . '
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Categoria</th>
                <th>Tab.</th>
                <th>Fascia</th>
                <th>Q.tà</th>
                <th>Prezzo DAT</th>
                <th>Totale DAT</th>
                <th>Prezzo Pubblico</th>
                <th>Totale Netto</th>
                <th>Totale Ivato</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($righe as $riga) {

              $totaleDat = $riga['prezzo_dat'] * $riga['quantita'];

              $nettoRiga =
                ($riga['prezzo_pubblico'] - $riga['prezzo_dat'])
                / 1.10
                * $riga['quantita'];

              $ivatoRiga = $nettoRiga * 1.22;

              $modali .= '
  <tr>
    <td>' . htmlspecialchars($riga['categoria']) . '</td>
    <td>' . $riga['tabella'] . '</td>
    <td>' . $riga['fascia'] . '</td>
    <td>' . $riga['quantita'] . '</td>
    <td>' . number_format($riga['prezzo_dat'], 2, ',', '.') . '</td>
    <td>' . number_format($totaleDat, 2, ',', '.') . '</td>
    <td>' . number_format($riga['prezzo_pubblico'], 2, ',', '.') . '</td>
    <td>' . number_format($nettoRiga, 2, ',', '.') . '</td>
    <td>' . number_format($ivatoRiga, 2, ',', '.') . '</td>
  </tr>';
            }



            $modali .= '
            </tbody>
            <tfoot>
              <tr class="fw-bold">
                <td colspan="6" class="text-end">Importo totale da fatturare</td>
                <td colspan="2">' . number_format($fattura['netto'], 2, ',', '.') . ' €</td>
              </tr>
              <tr class="fw-bold">
                <td colspan="6" class="text-end">Importo totale ivato</td>
                <td colspan="2">' . number_format($fattura['ivato'], 2, ',', '.') . ' €</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <a href="core/export_fattura.php?table=' . urlencode($table) . '"
           class="btn btn-success" target="_blank">Esporta XLSX</a>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>

    </div>
  </div>
</div>';

            $num++;
          endforeach;
          ?>


        </tbody>
      </table>

      <?= $modali ?>
    </div>
  </div>
</section>