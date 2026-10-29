<?php

##############    Damares    ###############
#   Estensione Timbrature - import file    #
#   Access Control Log (.xls / .xlsx/.csv) #
############################################

require '../vendor/autoload.php';
require __DIR__ . "/coreConfig.php";
require_once __DIR__ . '/timbratureImport.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$employee->table = "employee";
$punch->table = "punch";

/* ---------- cancellazione timbrature di un mese ---------- */
if (filter_input(INPUT_GET, "monthToDel")) {
    list($y, $m) = explode('-', filter_input(INPUT_GET, "monthToDel"));
    $punch->deleteMonth((int) $y, (int) $m);
    header("Location: ../index.php?p=importTimbrature&msg=punchDel");
    exit;
}

if (empty($_FILES['file']['tmp_name'])) {
    header("Location: ../index.php?p=importTimbrature&err=noFile");
    exit;
}

$originalName = $_FILES['file']['name'];
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
    header("Location: ../index.php?p=importTimbrature&err=badFormat");
    exit;
}

/* il file viene copiato con la sua estensione, serve al reader */
$tmp = sys_get_temp_dir() . '/timbrature_' . uniqid() . '.' . $ext;
move_uploaded_file($_FILES['file']['tmp_name'], $tmp);

try {
    $reader = IOFactory::createReaderForFile($tmp);
    $reader->setReadDataOnly(true);
    $rows = $reader->load($tmp)->getActiveSheet()->toArray(null, true, false, false);
} catch (Exception $e) {
    @unlink($tmp);
    header("Location: ../index.php?p=importTimbrature&err=readFail");
    exit;
}
@unlink($tmp);

/* ---------- individuazione delle colonne dall'intestazione ---------- */
$header = timbratureColumns($rows);
if ($header === null) {
    header("Location: ../index.php?p=importTimbrature&err=badColumns");
    exit;
}

$idx = $header['columns'];
$headerRow = $header['row'];

/* ---------- importazione ---------- */
$imported = 0;
$skipped = 0;
$created = [];
$cache = [];

foreach ($rows as $i => $r) {
    if ($i <= $headerRow) continue;

    $record = timbratureRecord($r, $idx);
    if ($record === null) {
        $skipped++;
        continue;
    }

    $name = $record['name'];
    $badge = $record['badge'];
    $date = $record['date'];
    $time = $record['time'];

    $key = strtolower($name) . '|' . $badge;

    if (!isset($cache[$key])) {
        $row = $employee->findByBadgeOrName($badge, $name);
        if (!$row) {
            $newId = $employee->quickCreate($name, $badge);
            $cache[$key] = $newId;
            $created[] = $name;
        } else {
            $cache[$key] = (int) $row['id'];
            /* aggiorno il badge se in anagrafica mancava */
            if ($badge !== '' && empty($row['badge'])) {
                $employee->id = $row['id'];
                $employee->badge = $badge;
                $employee->update(['badge'], 'id');
            }
        }
    }

    if ($punch->add($cache[$key], $date, $time, $originalName)) {
        $imported++;
    } else {
        $skipped++;
    }
}

$_SESSION['timbrature_import'] = [
    'imported' => $imported,
    'skipped'  => $skipped,
    'created'  => $created,
    'file'     => $originalName,
];

header("Location: ../index.php?p=importTimbrature&msg=punchImported");
exit;
