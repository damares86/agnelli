<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";
require '../vendor/autoload.php';        // If installed via composer

use PhpOffice\PhpSpreadsheet\IOFactory;

/* ===============================
   VALIDAZIONE INPUT
================================ */

if (
    empty($_POST['anno']) ||
    empty($_POST['mese_inizio']) ||
    empty($_POST['mese_fine']) ||
    empty($_POST['attivita']) ||
    !isset($_FILES['xslx_file'])
) {
    die("Dati mancanti");
}

// prendo il nome dell'attività
$attivita    = $_POST['attivita'];

// compongo il nome della tabella listino
$dat->table = "dat_listino_$attivita";

// recupero i dati della tabella listino e li metto in un array di array
$products = $dat->showAll('id');
$listinoMap = [];

while ($row = $products->fetch(PDO::FETCH_ASSOC)) {

    $key = $row['categoria'] . '|' . $row['tabella'] . '|' . $row['fascia'];

    $listinoMap[$key] = [
        'prezzo_pubblico' => $row['prezzo_pubblico'], // stringa DECIMAL
        'prezzo_dat'      => $row['prezzo_dat'],
    ];
}

// leggo il file excel
$spreadsheet = IOFactory::load($_FILES['xslx_file']['tmp_name']);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray(null, true, true, true);

// ciclo i dati del file excel

$datiDaInserire = [];
$ordine = 1;
foreach ($rows as $index => $row) {

    // salta intestazione
    if ($index === 1 || $index === 2) {
        continue;
    }

    // salta righe vuote / totali
    if (empty($row['A']) || empty($row['E'])) {
        continue;
    }

    $categoria = trim($row['A']);
    $tabella   = (int) $row['B'];
    $fascia    = (int) $row['C'];
    $quantita  = (int) $row['E'];

    $key = $categoria . '|' . $tabella . '|' . $fascia;

    if (!isset($listinoMap[$key])) {
        // opzionale: log errore
        continue;
    }

    $datiDaInserire[] = [
        'ordine'           => $ordine++,
        'categoria'        => $categoria,
        'tabella'          => $tabella,
        'fascia'           => $fascia,
        'quantita'         => $quantita,
        'prezzo_pubblico'  => $listinoMap[$key]['prezzo_pubblico'],
        'prezzo_dat'       => $listinoMap[$key]['prezzo_dat'],
    ];
}

// prendo i dati per comporre il nome della tabella
$anno        = (int) $_POST['anno'];
$meseInizio  = $_POST['mese_inizio'];
$meseFine    = $_POST['mese_fine'];

$tableName = "{$anno}_{$meseInizio}_{$meseFine}_{$attivita}";

$sqlCreate = "
CREATE TABLE IF NOT EXISTS `$tableName` (

    id INT AUTO_INCREMENT PRIMARY KEY,
    ordine INT NOT NULL,
    categoria VARCHAR(255) NOT NULL,
    tabella INT NOT NULL,
    fascia INT NOT NULL,
    quantita INT NOT NULL,

    prezzo_dat DECIMAL(10,2) NOT NULL,
    prezzo_pubblico DECIMAL(10,3) NOT NULL,

    -- prezzo_dat * quantita
    totale_dat DECIMAL(12,2)
        AS (quantita * prezzo_dat) STORED,

    -- prezzo pubblico - prezzo dat
    prezzo_lordo_agnelli DECIMAL(10,2)
        AS (prezzo_pubblico - prezzo_dat) STORED,

    -- prezzo lordo / 1.10
    prezzo_netto_agnelli DECIMAL(10,2)
        AS ((prezzo_pubblico - prezzo_dat) / 1.10) STORED,

    -- prezzo netto * quantita
    totale_agnelli DECIMAL(12,2)
        AS (quantita * ((prezzo_pubblico - prezzo_dat) / 1.10)) STORED,

    -- totale agnelli * 1.22
    totale_agnelli_ivato DECIMAL(12,2)
        AS (quantita * ((prezzo_pubblico - prezzo_dat) / 1.10) * 1.22) STORED

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

$db->exec($sqlCreate);

$sqlInsert = "
INSERT INTO `$tableName`
(ordine, categoria, tabella, fascia, quantita, prezzo_dat, prezzo_pubblico)
VALUES
(:ordine, :categoria, :tabella, :fascia, :quantita, :prezzo_dat, :prezzo_pubblico)
";

$stmt = $db->prepare($sqlInsert);
$errors = 0;

if ($attivita == "scuola") {

    // inserisco il totale dei caffè dei salesiani
    $caffeSalesiani    = $_POST['salesiani'];

    $prezzoCaffeSalesiani = ($listinoMap['SALESIANI|1|1']['prezzo_pubblico'])*1.10;
 
    $salesiani = [
        'ordine' => 0,
        'categoria'        => 'SALESIANI',
        'tabella'          => 1,
        'fascia'           => 1,
        'quantita'         => $caffeSalesiani,
        'prezzo_pubblico'  => $prezzoCaffeSalesiani,
        'prezzo_dat'       => $listinoMap['SALESIANI|1|1']['prezzo_dat'],
    ];

    if (!$stmt->execute($salesiani)) {
        $errors++;
        echo "sdtop";
        exit;
    }

    // inserisco tutti i dati del file excel su db
    foreach ($datiDaInserire as $riga) {
/*         if ($riga['categoria'] == 'SALESIANI') {
            continue;
        } */
        if (!$stmt->execute($riga)) {
            $errors++;
        }
    }
} else {
    foreach ($datiDaInserire as $riga) {
        if (!$stmt->execute($riga)) {
            $errors++;
        }
    }
}

$msg = $errors == 0 ? '&msg=dataIns' : '&err=errDataIns';

header("Location: ../index.php?p=allDat$msg");
exit;
