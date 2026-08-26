<?php

##############    Damares    ###############
#   Estensione Timbrature - export xlsx    #
#   una scheda per ogni dipendente         #
############################################

require '../vendor/autoload.php';
require __DIR__ . "/coreConfig.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$employee->table = "employee";
$punch->table = "punch";

$month = filter_input(INPUT_GET, "month");           // formato YYYY-MM
if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
    header("Location: ../index.php?p=importTimbrature&err=noMonth");
    exit;
}

list($year, $mon) = array_map('intval', explode('-', $month));
$onlyEmployee = filter_input(INPUT_GET, "employee_id") ? (int) filter_input(INPUT_GET, "employee_id") : null;

$employees = $employee->allEmployees(true);
if ($onlyEmployee) {
    $employees = array_values(array_filter($employees, function ($e) use ($onlyEmployee) {
        return (int) $e['id'] === $onlyEmployee;
    }));
}

$data = $punch->monthGrouped($year, $mon, $onlyEmployee);

$giorni = [1 => 'Lunedì', 2 => 'Martedì', 3 => 'Mercoledì', 4 => 'Giovedì', 5 => 'Venerdì', 6 => 'Sabato', 7 => 'Domenica'];
$mesi = [1 => 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

$spreadsheet = new Spreadsheet();
$spreadsheet->removeSheetByIndex(0);

$daysInMonth = (int) date('t', mktime(0, 0, 0, $mon, 1, $year));
$usedTitles = [];

foreach ($employees as $emp) {

    /* nome scheda: max 31 caratteri e senza caratteri vietati */
    $title = preg_replace('/[\\\\\/\?\*\[\]:]/', ' ', $emp['name']);
    $title = trim(mb_substr($title, 0, 28));
    $base = $title;
    $n = 1;
    while (in_array(strtolower($title), $usedTitles)) {
        $title = $base . ' ' . (++$n);
    }
    $usedTitles[] = strtolower($title);

    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($title === '' ? 'Dipendente' : $title);

    $sheet->setCellValue('A1', $emp['name']);
    $sheet->mergeCells('A1:J1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

    $sheet->setCellValue('A2', $mesi[$mon] . ' ' . $year);
    $sheet->mergeCells('A2:J2');
    $sheet->getStyle('A2')->getFont()->setBold(true);

    $headers = ['Data', 'Giorno', 'Entrata 1', 'Uscita 1', 'Entrata 2', 'Uscita 2', 'Entrata 3', 'Uscita 3', 'Ore lavorate', 'Ore contratto',  'Note'];
    $col = 1;
    foreach ($headers as $h) {
        $sheet->setCellValueByColumnAndRow($col, 4, $h);
        $col++;
    }
    $sheet->getStyle('A4:L4')->getFont()->setBold(true);
    $sheet->getStyle('A4:L4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DDEBF7');

    $r = 5;
    $totWorked = 0;
    $totContract = 0;

    for ($d = 1; $d <= $daysInMonth; $d++) {

        $dateStr = sprintf('%04d-%02d-%02d', $year, $mon, $d);
        $iso = (int) date('N', strtotime($dateStr));
        $contract = Employee::contractHours($emp, $iso);
        $times = isset($data[$emp['id']][$dateStr]) ? $data[$emp['id']][$dateStr] : [];

        /* salto i giorni non lavorativi senza timbrature */
        if ($contract <= 0 && empty($times)) {
            continue;
        }

        $day = Punch::buildDay($times);

        $sheet->setCellValue("A$r", date('d/m/Y', strtotime($dateStr)));
        $sheet->setCellValue("B$r", $giorni[$iso]);

        for ($p = 0; $p < 3; $p++) {
            $in = isset($day['pairs'][$p][0]) ? substr($day['pairs'][$p][0], 0, 5) : '';
            $out = isset($day['pairs'][$p][1]) && $day['pairs'][$p][1] ? substr($day['pairs'][$p][1], 0, 5) : '';
            $sheet->setCellValueByColumnAndRow(3 + $p * 2, $r, $in);
            $sheet->setCellValueByColumnAndRow(4 + $p * 2, $r, $out);
        }

        $workedHours = $day['hours'];
        $contractHours = $contract;
        $diffHours = $workedHours - $contractHours;

        $sheet->setCellValue("I$r", $workedHours / 24);
        $sheet->setCellValue("J$r", $contractHours / 24);

        $note = [];
        if ($day['odd']) $note[] = 'Timbratura dispari (manca uscita)';
        if (count($times) > 6) $note[] = 'Oltre 3 coppie: ' . count($times) . ' timbrature';
        if (empty($times) && $contractHours > 0) $note[] = 'Assente / nessuna timbratura';
        $sheet->setCellValue("L$r", implode(' - ', $note));

        if (!empty($note)) {
            $sheet->getStyle("A$r:L$r")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF2CC');
        }

        $totWorked += $workedHours;
        $totContract += $contractHours;
        $r++;
    }

    $last = $r - 1;
    $sheet->setCellValue("H$r", 'TOTALE');
    $sheet->setCellValue("I$r", $last >= 5 ? "=SUM(I5:I$last)" : 0);
    $sheet->setCellValue("J$r", $last >= 5 ? "=SUM(J5:J$last)" : 0);
    $sheet->setCellValue("K$r", "=I$r-J$r");
    $sheet->getStyle("H$r:L$r")->getFont()->setBold(true);
    $sheet->getStyle("H$r:L$r")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E2EFDA');

    $r += 2;
    $sheet->setCellValue("A$r", 'Ore lavorate (hh:mm)');
    $sheet->setCellValue("C$r", Punch::hhmm($totWorked));
    $sheet->setCellValue("E$r", 'Saldo (hh:mm)');
    $sheet->setCellValue("G$r", Punch::hhmm($totWorked - $totContract));
    $sheet->getStyle("A$r:G$r")->getFont()->setBold(true);

    $sheet->getStyle("I5:K" . ($last + 1))->getNumberFormat()->setFormatCode('[hh]:mm;-[hh]:mm');
    $sheet->getStyle("A4:L" . ($last + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle("C5:H" . $last)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    foreach (range('A', 'L') as $c) {
        $sheet->getColumnDimension($c)->setAutoSize(true);
    }
    $sheet->freezePane('A5');
}

if ($spreadsheet->getSheetCount() === 0) {
    $spreadsheet->createSheet()->setTitle('Nessun dato');
}
$spreadsheet->setActiveSheetIndex(0);

$filename = 'Timbrature_' . $mesi[$mon] . '_' . $year . '.xlsx';

if (ob_get_length()) {
    ob_end_clean();
}
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
