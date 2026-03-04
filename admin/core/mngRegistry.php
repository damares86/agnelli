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

if (filter_input(INPUT_GET, "idToDel")) {

    $idToDel = filter_input(INPUT_GET, "idToDel");
    $registry->table = "accounts";

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
    $registry->name  = filter_input(INPUT_POST, "name");
    $registry->company  = filter_input(INPUT_POST, "company");
    $registry->number  = filter_input(INPUT_POST, "number");
    $registry->registry_category_id  = filter_input(INPUT_POST, "registry_category_id");

    $items = "'name', 'company', 'number', 'registry_category_id'";

    filter_input(INPUT_POST, "address") ?? $items .= ", 'address'";
    filter_input(INPUT_POST, "email") ?? $items .= ", 'email'";
    filter_input(INPUT_POST, "notes") ?? $items .= ", 'notes'";

    if ($registry->update([$items],$id)) {
        header("Location: ../index.php?p=allRegistryCat&msg=registryCatEditSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistryCat&err=registryCatEditFail");
        exit;
    }

} else if ($operation == "add") {

    $registry->name  = filter_input(INPUT_POST, "name");
    $registry->company  = filter_input(INPUT_POST, "company");
    $registry->number  = filter_input(INPUT_POST, "number");
    $registry->registry_category_id  = filter_input(INPUT_POST, "registry_category_id");

    $items = "'name', 'company', 'number', 'registry_category_id'";

    filter_input(INPUT_POST, "address") ?? $items .= ", 'address'";
    filter_input(INPUT_POST, "email") ?? $items .= ", 'email'";
    filter_input(INPUT_POST, "notes") ?? $items .= ", 'notes'";

    if ($registry->insert([$items])) {
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
