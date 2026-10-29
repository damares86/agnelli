<?php

/* Funzioni senza accesso al DB, condivise dall'import e dai test. */
function timbratureColumns(array $rows)
{
    $aliases = [
        'name' => ['name', 'nome'],
        'user' => ['id utente', 'user id', 'nr. utente'],
        'date' => ['date', 'data'],
        'time' => ['time', 'ora'],
        'datetime' => ['data/ora', 'data / ora', 'date/time'],
    ];
    foreach ($rows as $i => $row) {
        $idx = array_fill_keys(array_keys($aliases), null);
        $headers = [];
        foreach ($row as $c => $value) {
            $header = strtolower(trim(str_replace(["\xEF\xBB\xBF", "\xC2\xA0"], ['', ' '], (string) $value)));
            $headers[$c] = preg_replace('/\s+/', ' ', $header);
        }
        foreach ($aliases as $key => $names) {
            foreach ($names as $name) {
                $column = array_search($name, $headers, true);
                if ($column !== false) {
                    $idx[$key] = $column;
                    break;
                }
            }
        }
        if ($idx['name'] !== null && ($idx['datetime'] !== null || ($idx['date'] !== null && $idx['time'] !== null))) {
            return ['row' => $i, 'columns' => $idx];
        }
    }
    return null;
}

function timbratureDateTime($value, $combined = false)
{
    if ($value === null || trim((string) $value) === '') return null;
    if (is_numeric($value)) {
        if ((float) $value < 1) return null;
        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value);
        } catch (\Exception $e) {
            return null;
        }
    }
    $value = trim((string) $value);
    $formats = $combined
        ? ['Y-m-d H:i:s', 'Y-m-d H:i', 'Y-m-d\TH:i:s', 'd/m/Y H:i:s', 'd/m/Y H:i', 'd-m-Y H:i:s', 'd-m-Y H:i']
        : ['Y-m-d', 'd/m/Y', 'd-m-Y'];
    foreach ($formats as $format) {
        $date = \DateTime::createFromFormat('!' . $format, $value, new \DateTimeZone('UTC'));
        $errors = \DateTime::getLastErrors();
        if ($date !== false && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) return $date;
    }
    return null;
}

function timbratureTime($value)
{
    if ($value === null || trim((string) $value) === '') return null;
    if (is_numeric($value)) {
        if ((float) $value < 0) return null;
        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
    if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?$/', trim((string) $value), $m)) {
        $seconds = isset($m[3]) ? (int) $m[3] : 0;
        if ((int) $m[1] < 24 && (int) $m[2] < 60 && $seconds < 60) {
            return sprintf('%02d:%02d:%02d', $m[1], $m[2], $seconds);
        }
    }
    return null;
}

function timbratureRecord(array $row, array $idx)
{
    $name = isset($row[$idx['name']]) ? preg_replace('/\s+/', ' ', trim((string) $row[$idx['name']])) : '';
    $badge = $idx['user'] !== null && isset($row[$idx['user']]) ? trim((string) $row[$idx['user']]) : '';
    if ($idx['datetime'] !== null) {
        $stamp = timbratureDateTime(isset($row[$idx['datetime']]) ? $row[$idx['datetime']] : null, true);
        $time = $stamp ? $stamp->format('H:i:s') : null;
    } else {
        $stamp = timbratureDateTime(isset($row[$idx['date']]) ? $row[$idx['date']] : null);
        $time = timbratureTime(isset($row[$idx['time']]) ? $row[$idx['time']] : null);
    }
    if ($name === '' || !$stamp || $time === null) return null;
    return ['name' => $name, 'badge' => $badge, 'date' => $stamp->format('Y-m-d'), 'time' => $time];
}