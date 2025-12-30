<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

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

$anno        = (int) $_POST['anno'];
$meseInizio  = $_POST['mese_inizio'];
$meseFine    = $_POST['mese_fine'];
$attivita    = $_POST['attivita'];

/*
- prendo il nome dell'attività
- compongo il nome della tabella listino
- recupero i dati della tabella listino e li metto in un array di array
- mentre ciclo i dati del file excel calcolo in tempo reale i totali 
- nel frontend devo aprire una finestra con la tabella di dettaglio e il relativo risultato
*/

$dat->table = "dat_listino_$attivita";
$products = $dat->showAll('id');
$listino = [];
while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $listino[] = array($row);
}

for($idx=0;$idx<count($listino);$idx++){
    print_r($listino[$idx][0]['categoria']);
    echo ' - ';
    print_r($listino[$idx][0]['fascia']);
    echo ' - ';
    print_r($listino[$idx][0]['tabella']);
    echo '<br>';
}

exit;

/* ===============================
   NOME TABELLA
   dat_yyyy_mm_mm
================================ */

$tableName = sprintf(
    "dat_%d_%02d_%02d",
    $anno,
    $meseInizio,
    $meseFine
);


/* ===============================
   CREAZIONE TABELLA
================================ */

$sqlCreate = "
CREATE TABLE IF NOT EXISTS `$tableName` (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    data DATE,
    descrizione VARCHAR(255),
    importo DECIMAL(10,2),
    attivita VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

$db->exec($sqlCreate);

/* ===============================
   LETTURA FILE XLSX
================================ */

if ($_FILES['xslx_file']['error'] !== UPLOAD_ERR_OK) {
    die("Errore upload file");
}

$tmpFile = $_FILES['xslx_file']['tmp_name'];

try {
    $spreadsheet = IOFactory::load($tmpFile);
} catch (Exception $e) {
    die("File XLSX non valido");
}

$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray(null, true, true, true);

/* ===============================
   INSERT DATI
================================ */

$sqlInsert = "
INSERT INTO `$tableName`
(data, descrizione, importo, attivita)
VALUES
(:data, :descrizione, :importo, :attivita)
";

$stmt = $db->prepare($sqlInsert);

$db->beginTransaction();

try {

    foreach ($rows as $index => $row) {

        // salta intestazione
        if ($index === 1) {
            continue;
        }

        // salta righe vuote
        if (empty($row['A'])) {
            continue;
        }

        $stmt->execute([
            ':data'        => date('Y-m-d', strtotime($row['A'])),
            ':descrizione' => trim($row['B']),
            ':importo'     => (float) str_replace(',', '.', $row['C']),
            ':attivita'    => $attivita
        ]);
    }

    $db->commit();
    echo "Importazione completata. Tabella creata: <b>$tableName</b>";
} catch (Exception $e) {
    $db->rollBack();
    die("Errore importazione: " . $e->getMessage());
}
