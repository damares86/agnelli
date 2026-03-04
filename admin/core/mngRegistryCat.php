<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

// check if there's a category to delete

$registry->table = "registry_category" ;

if (filter_input(INPUT_GET, "idToDel")) {

    $idToDel = filter_input(INPUT_GET, "idToDel");

    $registry->id = filter_input(INPUT_GET, "idToDel");

    if ($registry->delete('id')) {
        header("Location: ../index.php?p=allRegistryCat&msg=registryCatDel");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistryCat&err=registryCatNoDel");
        exit;
    }
}

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if (filter_input(INPUT_POST, "idToMod")) {

    $id = filter_input(INPUT_POST, "idToMod");
    $registry->id = $id ;
    $registry->name  = filter_input(INPUT_POST, "name");

    if ($registry->update(['name'],'id')) {
        header("Location: ../index.php?p=allRegistryCat&msg=registryCatEditSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistryCat&err=registryCatEditFail");
        exit;
    }

} else if ($operation == "add") {

    $registry->name  = filter_input(INPUT_POST, "name");
    

    if ($registry->insert(['name'])) {
        header("Location: ../index.php?p=allRegistryCat&msg=registryCatSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistryCat&err=registryCatFail");
        exit;
    }

} else {
    header("Location: ../index.php?p=allRegistryCat&err=noPost");
    exit;
}
