<?php
require '../vendor/autoload.php';

// check if the user is logged in
require __DIR__."/coreConfig.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

    $nettoRiga = round($nettoRiga, 2); // 🔥 arrotondo qui

    if ($riga['categoria'] === 'SALESIANI') {
      $caffeSalesiani += $nettoRiga;
      continue;
    }

    $totaleNetto += $nettoRiga;
    $totaleIvato += round($nettoRiga * 1.22, 2);
  }
  
  $totaleNetto = $totaleNetto - $caffeSalesiani ;
  $totaleIvato = $totaleIvato - ($caffeSalesiani*1.22) ;

  return [
    'netto'     => round($totaleNetto, 2),
    'ivato'     => round($totaleIvato, 2),
    'salesiani' => round($caffeSalesiani, 2),
  ];
}


/* function calcolaFattura(array $righe): array
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
      $caffeSalesiani += $nettoRiga;
      continue;
    }

    $totaleNetto += $nettoRiga;
    $totaleIvato += $nettoRiga * 1.22;
  }

  return [
    'netto'     => round($totaleNetto, 2),
    'ivato'     => round($totaleIvato, 2),
    'salesiani' => round($caffeSalesiani, 2),
  ];
} */

$table = $_GET['table'] ?? '';
if (!preg_match('/^\d{4}_\d{2}_\d{2}_.+$/', $table)) {
    die('Tabella non valida');
}

// recupero dati
$stmt = $db->query("SELECT * FROM `$table` ORDER BY ordine");
$righe = $stmt->fetchAll(PDO::FETCH_ASSOC);

$fattura = calcolaFattura($righe);

// spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->fromArray([
    ['Categoria', 'Tabella', 'Fascia', 'Quantità', 'Prezzo DAT', 'Prezzo Pubblico', 'Totale Netto', 'Totale Ivato']
], null, 'A1');

$row = 2;

foreach ($righe as $riga) {

    $netto =
        ($riga['prezzo_pubblico'] - $riga['prezzo_dat'])
        / 1.10
        * $riga['quantita'];

    $ivato = $netto * 1.22;

    $sheet->fromArray([
        $riga['categoria'],
        $riga['tabella'],
        $riga['fascia'],
        $riga['quantita'],
        $riga['prezzo_dat'],
        $riga['prezzo_pubblico'],
        round($netto, 2),
        round($ivato, 2),
    ], null, "A$row");

    $row++;
}

// totali
$row += 1;
$sheet->setCellValue("F$row", "Importo totale da fatturare");
$sheet->setCellValue("G$row", $fattura['netto']);

$row++;
$sheet->setCellValue("F$row", "Importo totale ivato");
$sheet->setCellValue("G$row", $fattura['ivato']);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=fattura_$table.xlsx");

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;