<?php

##############    Damares    ###############
#   Estensione Listini Dat Caffè           #
#   modifica / eliminazione voci listino   #
############################################

require __DIR__ . "/coreConfig.php";

$listini = ['scuola', 'oratorio', 'cinema'];

$tipo = filter_input(INPUT_GET, "tipo") ?: filter_input(INPUT_POST, "tipo");
if (!in_array($tipo, $listini, true)) {
    header("Location: ../index.php?p=allListini&err=noPost");
    exit;
}

// nome tabella solo da whitelist
$dat->table = "dat_listino_" . $tipo;
$back = "../index.php?p=allListini&tipo=" . $tipo;

/* ---------- eliminazione ---------- */
if (filter_input(INPUT_GET, "idToDel")) {

    $dat->id = (int) filter_input(INPUT_GET, "idToDel");

    if ($dat->delete('id')) {
        header("Location: $back&msg=listinoDel");
        exit;
    }
    header("Location: $back&err=listinoNoDel");
    exit;
}

/* ---------- aggiunta ---------- */
if (filter_input(INPUT_POST, "operation") == "add") {

    $dat->categoria       = trim(filter_input(INPUT_POST, "categoria"));
    $dat->tabella         = (int) filter_input(INPUT_POST, "tabella");
    $dat->fascia          = (int) filter_input(INPUT_POST, "fascia");
    $dat->prezzo_pubblico = str_replace(',', '.', filter_input(INPUT_POST, "prezzo_pubblico"));
    $dat->prezzo_dat      = str_replace(',', '.', filter_input(INPUT_POST, "prezzo_dat"));

    // Common::insert stampa la query: svuoto l'output per poter reindirizzare
    ob_start();
    $ok = $dat->insert(['categoria', 'tabella', 'fascia', 'prezzo_pubblico', 'prezzo_dat']);
    ob_end_clean();

    if ($ok) {
        header("Location: $back&msg=listinoSucc");
        exit;
    }
    header("Location: $back&err=listinoFail");
    exit;
}

/* ---------- modifica ---------- */
if (filter_input(INPUT_POST, "idToMod")) {

    $dat->id              = (int) filter_input(INPUT_POST, "idToMod");
    $dat->categoria       = trim(filter_input(INPUT_POST, "categoria"));
    $dat->tabella         = (int) filter_input(INPUT_POST, "tabella");
    $dat->fascia          = (int) filter_input(INPUT_POST, "fascia");
    $dat->prezzo_pubblico = str_replace(',', '.', filter_input(INPUT_POST, "prezzo_pubblico"));
    $dat->prezzo_dat      = str_replace(',', '.', filter_input(INPUT_POST, "prezzo_dat"));

    if ($dat->update(['categoria', 'tabella', 'fascia', 'prezzo_pubblico', 'prezzo_dat'], 'id')) {
        header("Location: $back&msg=listinoEditSucc");
        exit;
    }
    header("Location: $back&err=listinoEditFail");
    exit;
}

header("Location: $back&err=noPost");
exit;
