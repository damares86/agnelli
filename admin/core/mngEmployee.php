<?php

##############    Damares    ###############
#   Estensione Timbrature - gestione       #
#   anagrafica dipendenti                  #
############################################

require __DIR__ . "/coreConfig.php";

$employee->table = "employee";

/* ---------- cancellazione ---------- */
if (filter_input(INPUT_GET, "idToDel")) {

    $employee->id = filter_input(INPUT_GET, "idToDel");

    if ($employee->delete('id')) {
        header("Location: ../index.php?p=allEmployees&msg=employeeDel");
        exit;
    }
    header("Location: ../index.php?p=allEmployees&err=employeeNoDel");
    exit;
}

$operation = filter_input(INPUT_POST, "operation");

/* ---------- salvataggio rapido di tutte le ore dalla tabella ---------- */
if ($operation == "bulkHours") {

    $hours = isset($_POST['h']) && is_array($_POST['h']) ? $_POST['h'] : [];

    foreach ($hours as $id => $days) {
        $employee->id     = (int) $id;
        $employee->h_mon  = str_replace(',', '.', $days['mon']);
        $employee->h_tue  = str_replace(',', '.', $days['tue']);
        $employee->h_wed  = str_replace(',', '.', $days['wed']);
        $employee->h_thu  = str_replace(',', '.', $days['thu']);
        $employee->h_fri  = str_replace(',', '.', $days['fri']);
        $employee->update(['h_mon', 'h_tue', 'h_wed', 'h_thu', 'h_fri'], 'id');
    }

    header("Location: ../index.php?p=allEmployees&msg=employeeEditSucc");
    exit;
}

/* ---------- valori comuni add/edit ---------- */
function fillEmployee($employee)
{
    $employee->name   = filter_input(INPUT_POST, "name");
    $employee->badge  = filter_input(INPUT_POST, "badge") ? filter_input(INPUT_POST, "badge") : '';
    $employee->notes  = filter_input(INPUT_POST, "notes") ? filter_input(INPUT_POST, "notes") : '';
    $employee->active = filter_input(INPUT_POST, "active") ? 1 : 0;

    foreach (['mon', 'tue', 'wed', 'thu', 'fri'] as $d) {
        $field = "h_$d";
        $val = filter_input(INPUT_POST, $field);
        $employee->$field = $val !== null && $val !== '' ? str_replace(',', '.', $val) : 0;
    }
}

if (filter_input(INPUT_POST, "idToMod")) {

    $employee->id = filter_input(INPUT_POST, "idToMod");
    fillEmployee($employee);

    if ($employee->update($employee->fields(), 'id')) {
        header("Location: ../index.php?p=allEmployees&msg=employeeEditSucc");
        exit;
    }
    header("Location: ../index.php?p=allEmployees&err=employeeEditFail");
    exit;

} else if ($operation == "add") {

    fillEmployee($employee);

    if ($employee->insert($employee->fields())) {
        header("Location: ../index.php?p=allEmployees&msg=employeeSucc");
        exit;
    }
    header("Location: ../index.php?p=allEmployees&err=employeeFail");
    exit;
}

header("Location: ../index.php?p=allEmployees&err=noPost");
exit;
