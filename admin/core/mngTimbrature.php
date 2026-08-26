<?php

##############    Damares    ###############
#   Estensione Timbrature - import file    #
#   Access Control Log (.xls / .xlsx/.csv) #
############################################

require '../vendor/autoload.php';
require __DIR__ . "/coreConfig.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as XlsDate;

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
$idx = ['name' => null, 'user' => null, 'date' => null, 'time' => null];
$headerRow = 0;

foreach ($rows as $i => $r) {
    foreach ($r as $c => $v) {
        $h = strtolower(trim((string) $v));
        if ($h === 'name') $idx['name'] = $c;
        if ($h === 'user id') $idx['user'] = $c;
        if ($h === 'date') $idx['date'] = $c;
        if ($h === 'time') $idx['time'] = $c;
    }
    if ($idx['name'] !== null && $idx['date'] !== null && $idx['time'] !== null) {
        $headerRow = $i;
        break;
    }
}

if ($idx['name'] === null || $idx['date'] === null || $idx['time'] === null) {
    header("Location: ../index.php?p=importTimbrature&err=badColumns");
    exit;
}

/* ---------- normalizzatori data/ora (accettano stringhe o seriali Excel) ---------- */
function normDate($v)
{
    if ($v === null || $v === '') return null;
    if (is_numeric($v)) {
        return XlsDate::excelToDateTimeObject($v)->format('Y-m-d');
    }
    $v = trim((string) $v);
    $ts = strtotime(str_replace('/', '-', $v));
    return $ts ? date('Y-m-d', $ts) : null;
}

function normTime($v)
{
    if ($v === null || $v === '') return null;
    if (is_numeric($v)) {
        return XlsDate::excelToDateTimeObject($v)->format('H:i:s');
    }
    $v = trim((string) $v);
    if (preg_match('/(\d{1,2}):(\d{2})(?::(\d{2}))?/', $v, $m)) {
        return sprintf('%02d:%02d:%02d', $m[1], $m[2], isset($m[3]) ? $m[3] : 0);
    }
    return null;
}

/* ---------- importazione ---------- */
$imported = 0;
$skipped = 0;
$created = [];
$cache = [];

foreach ($rows as $i => $r) {
    if ($i <= $headerRow) continue;

    $name  = isset($r[$idx['name']]) ? trim((string) $r[$idx['name']]) : '';
    $badge = $idx['user'] !== null && isset($r[$idx['user']]) ? trim((string) $r[$idx['user']]) : '';
    $date  = normDate(isset($r[$idx['date']]) ? $r[$idx['date']] : null);
    $time  = normTime(isset($r[$idx['time']]) ? $r[$idx['time']] : null);

    if ($name === '' || !$date || !$time) {
        $skipped++;
        continue;
    }

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
