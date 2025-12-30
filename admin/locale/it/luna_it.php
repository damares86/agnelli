<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

// BACKEND
$label_luna_portal ="Luna Portal";
$label_manage_products = "Gestione prodotti" ;
$label_manage_users = "Gestione utenti" ;

// allLunaPages

$allLunaPages_title = "Gestione pagine" ;
$allLunaPages_save_ok = "Ordine delle pagine modificato" ;
$allLunaPages_save_fail = "Errore nella modifica dell'ordine delle pagine" ;
$allLunaPages_add_page = "Aggiungi una nuova pagina di primo livello" ;
$allLunaPages_no_page = "Nessuna pagina presente" ;
$allLunaPages_operations = "Operazioni" ;
$allLunaPages_modal_body = "!!! ATTENZIONE !!!<br>Se cancelli questa pagina verranno cancellate anche <b>tutte le pagine dei sotto livelli</b>!";
$allLunaPages_wrong_level = "Non è possibile aggiungere pagine oltre il terzo livello";

// addLunaPages

$addLunaPages_product = "Prodotto" ;
$addLunaPages_add = "Aggiungi" ;
$addLunaPages_add_title = "Aggiungi" ;
$addLunaPages_title = "Titolo" ;
$addLunaPages_parent = "pagina di primo livello" ;
$addLunaPages_child = "pagina di secondo livello" ;
$addLunaPages_paragraph = "paragrafo" ;

// editLunaPages

$editLunaPages_product = "Prodotto" ;
$editLunaPages_edit = "Modifica pagina" ;
$editLunaPages_edit_title = "Modifica" ;
$editLunaPages_title = "Titolo" ;


// allLunaProducts

$allLunaProducts_title = "Tutti i prodotti di Luna" ;
$allLunaProducts_name = "Nome prodotto" ;
$allLunaProducts_add = "Aggiungi nuovo prodotto" ;
$allLunaProducts_version = "Versione" ;
$allLunaProducts_manage_pages = "Gestisci pagine" ;
$allLunaProducts_edit = "Modifica" ;
$allLunaProducts_clone = "Duplica" ;
$allLunaProducts_delete = "Elimina" ;
$allLunaProducts_clone_title = "Crea una nuova versione della documentazione di prodotto" ;
$allLunaProducts_clone_new_name = "Nuovo nome" ;
$allLunaProducts_clone_desc = "Attenzione: se vuoi creare una nuova versione dello stesso prodotto, non cambiare il nome" ;
$allLunaProducts_clone_new_version = "Nuova versione" ;
$allLunaProducts_modal_body = "Se confermi, questo prodotto e tutte le relative pagine saranno eliminati definitivamente" ;

// addLunaProduct

$addLunaProduct_title = "Aggiungi un nuovo prodotto a Luna" ;
$addLunaProduct_name = "Nome prodotto" ;
$addLunaProduct_version = "Versione" ;

// editLunaProduct

$editLunaProduct_header = "Modifica prodotto di Luna" ;
$editLunaProduct_title = "Modifica prodotto" ;
$editLunaProduct_name = "Nome prodotto" ;
$editLunaProduct_version = "Versione" ;

// allLunaUsers

$allLunaUsers_header = "Utente di Luna" ;
$allLunaUsers_title = "Tutti gli utenti di Luna" ;
$allLunaUsers_add = "Aggiungi un nuovo utente" ;
$allLunaUsers_perm = "Permessi" ;
$allLunaUsers_no_perm = "Nessun prodotto" ;
$allLunaUsers_modal_body = "Se confermi, questo utente verrà eliminato definitivamente." ;

// addLunaUser

$addLunaUser_header = "Aggiungi un utente di Luna" ;
$addLunaUser_title = "Aggiungi un nuovo utente di Luna" ;
$addLunaUser_auth = "Autorizza prodotti" ;

// editLunaUser

$editLunaUser_header = "Modifica utente di Luna" ;
$editLunaUser_title = "Modifica utente" ;
$editLunaUser_auth = "Autorizza prodotti" ;
$editLunaUser_psw_title = "Modifica password per questo utente" ;

// allLunaSettings

$allLunaSettings_header = "Impostazioni di Luna" ;
$allLunaSettings_auth = "Restringi l'accesso ai manuali solo agli utenti registrati" ;

//////////////////////////////////////////////

// FRONTEND

$luna_home_welcome = "Benvenuto" ;
$luna_home_choose = "Scegli il manuale";
$luna_home_no_manual = "Nessun manuale disponibile" ;
$luna_login_remember = "Ricordami su questo dispositivo" ;
$luna_manual_title = "Manuale:" ;
$luna_manual_version = "Scegli versione" ;
$luna_manual_editor = "Ultima modifica di" ;
$luna_manual_on = "il" ;

//////////////////////////////////////////////

// ALERT

// msg

$msg_lunaProdDelSucc = "Prodotto eliminato" ;
$msg_lunaDeletePageSucc = "Pagina eliminata" ;
$msg_lunaProdEditSucc = "Prodotto modificato" ;
$msg_lunaProdSucc = "Prodotto creato" ;
$msg_lunaProdCloneSucc = "Prodotto duplicato" ;
$msg_lunaContentSucc = "Pagina creata" ;
$msg_lunaContentEditSucc = "Pagina modificata" ;
$msg_lunaUserSucc = "Utente creato" ;
$msg_lunaUserEditSucc = "Utente modificato" ;
$msg_lunaUserEditPswSucc = "Password utente modificata" ;
$msg_settingsEdit = "Impostazioni modificate" ;
$msg_lunaUserDelSucc = "Utente eliminato" ;


// err

$err_lunaProdDelTableErr = "Tabella db del prodotto non eliminata" ;
$err_lunaProdDelErr = "Prodotto non eliminato" ;
$err_lunaDeletePageTreeFail = "Pagina eliminata, ma ci sono stati problemi nell'aggiornamento della gerarchia delle pagine." ;
$err_lunaDeletePageFail = "Pagina non eliminata" ;
$err_lunaProdEditFail = "Prodotto non modificato" ;
$err_lunaProdFailDb = "Prodotto non creato: problemi durante la creazione della tabella del db" ;
$err_lunaProdFail = "Prodotto non creato" ;
$err_lunaProdCloneFail = "Dati del prodotto non duplicati" ;
$err_lunaProdCloneTableFail = "Prodotto non duplicato, ci sono stati dei problemi con le tabelle del db" ;
$err_lunaProdCloneTreeFail = "Errore durante la duplicazione della struttura delle pagine. Prodotto non duplicato" ;
$err_lunaProdCloneFail = "Duplicato del prodotto non creato" ;
$err_lunaContentTreeFail = "Pagina creata, ma ci sono stati problemi nell'aggiornamento della gerarchia delle pagine." ;
$err_lunaContentEditFail = "Pagina non modificata" ;
$err_lunaUserExist = "L'utente esiste già" ;
$err_lunaUserFail = "Utente non creato" ;
$err_lunaUserEditFail = "Utente non modificato" ;
$err_lunaUserEditPswFail = "Password utente non modificata" ;
$err_settingsFail = "Impostazioni non modificate" ;
$err_lunaUserDelErr = "Utente non eliminato" ;


?>
