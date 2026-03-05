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

$registry->table = "registry_entry";

if (filter_input(INPUT_GET, "idToDel")) {

    $idToDel = filter_input(INPUT_GET, "idToDel");

    $registry->id = filter_input(INPUT_GET, "idToDel");

    if ($registry->delete('id')) {
        header("Location: ../index.php?p=allRegistry&msg=registryDel");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistry&err=registryNoDel");
        exit;
    }
}

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

///////// SISTEMA TUTTO CON IL SOLITO SISTEMA $registry->address = filter_input(ecc) ? filter_input(ecc) : '' ;

if (filter_input(INPUT_POST, "idToMod")) {

    $id = filter_input(INPUT_POST, "idToMod");
    $registry->id = $id ;
    $registry->name  = filter_input(INPUT_POST, "name");
    $registry->company  = filter_input(INPUT_POST, "company");
    $registry->number  = filter_input(INPUT_POST, "number");
    $registry->registry_category_id  = filter_input(INPUT_POST, "registry_category_id");
    
    $registry->address = filter_input(INPUT_POST, "address") ? filter_input(INPUT_POST, "address") : '' ;
    $registry->email = filter_input(INPUT_POST, "email") ? filter_input(INPUT_POST, "email") : '' ;
    $registry->notes = filter_input(INPUT_POST, "notes") ? filter_input(INPUT_POST, "notes") : '' ;
    

    if ($registry->update(['name', 'company','address','number','email','registry_category_id','notes'],'id')) {
        header("Location: ../index.php?p=allRegistry&msg=registryCatEditSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistry&err=registryCatEditFail");
        exit;
    }

} else if ($operation == "add") {

    $registry->name  = filter_input(INPUT_POST, "name");
    $registry->company  = filter_input(INPUT_POST, "company");
    $registry->number  = filter_input(INPUT_POST, "number");
    $registry->registry_category_id  = filter_input(INPUT_POST, "registry_category_id");

    $registry->address = filter_input(INPUT_POST, "address") ? filter_input(INPUT_POST, "address") : '' ;
    $registry->email = filter_input(INPUT_POST, "email") ? filter_input(INPUT_POST, "email") : '' ;
    $registry->notes = filter_input(INPUT_POST, "notes") ? filter_input(INPUT_POST, "notes") : '' ;
    
    if ($registry->insert(['name', 'company','address','number','email','registry_category_id','notes'])) {
        header("Location: ../index.php?p=allRegistry&msg=registrySucc");
        exit;
    } else {
        header("Location: ../index.php?p=allRegistry&err=registryFail");
        exit;
    }

} else {
    header("Location: ../index.php?p=allRegistry&err=noPost");
    exit;
}
