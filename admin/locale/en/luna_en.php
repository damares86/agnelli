<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

// BACKEND

// allLunaPages

$allLunaPages_title = "Pages Management" ;
$allLunaPages_save_ok = "Page order changed succesfully" ;
$allLunaPages_save_fail = "Page order change failed" ;
$allLunaPages_add_page = "Add a new parent page" ;
$allLunaPages_no_page = "No pages found" ;
$allLunaPages_operations = "Operations" ;
$allLunaPages_modal_body = "!!! ATTENTION !!!<br>If you delete this page you will delete also <b>the nested pages</b>!";
$allLunaPages_wrong_level = "It's not allowed to add pages over the third level";

// addLunaPages

$addLunaPages_product = "Product" ;
$addLunaPages_add = "Add" ;
$addLunaPages_add_title = "Add a new" ;
$addLunaPages_title = "Title" ;
$addLunaPages_parent = "parent page" ;
$addLunaPages_child = "child page" ;
$addLunaPages_paragraph = "paragraph" ;

// editLunaPages

$editLunaPages_product = "Product" ;
$editLunaPages_edit = "Edit page" ;
$editLunaPages_edit_title = "Edit" ;
$editLunaPages_title = "Title" ;


// allLunaProducts

$allLunaProducts_title = "All Luna Products" ;
$allLunaProducts_add = "Add a new product" ;
$allLunaProducts_name = "Product name" ;
$allLunaProducts_version = "Version" ;
$allLunaProducts_manage_pages = "Manage pages" ;
$allLunaProducts_edit = "Edit" ;
$allLunaProducts_clone = "Clone" ;
$allLunaProducts_delete = "Delete" ;
$allLunaProducts_clone_title = "Create a new version of the product documentation" ;
$allLunaProducts_clone_new_name = "New name" ;
$allLunaProducts_clone_desc = "Attention: if you want to create a new version of the same product, don't change the name" ;
$allLunaProducts_clone_new_version = "New version" ;
$allLunaProducts_modal_body = "If you confirm, you will completely delete this product and all its pages." ;

// addLunaProduct

$addLunaProduct_title = "Add a new Luna product" ;
$addLunaProduct_name = "Product name" ;
$addLunaProduct_version = "Version" ;

// editLunaProduct

$editLunaProduct_header = "Edit Luna product" ;
$editLunaProduct_title = "Edit product" ;
$editLunaProduct_name = "Product name" ;
$editLunaProduct_version = "Version" ;

// allLunaUsers

$allLunaUsers_header = "Luna users" ;
$allLunaUsers_title = "All Luna users" ;
$allLunaUsers_add = "Add a new users" ;
$allLunaUsers_perm = "Permissions" ;
$allLunaUsers_no_perm = "No permissions" ;
$allLunaUsers_modal_body = "If you confirm, you will completely delete this user." ;

// addLunaUser

$addLunaUser_header = "Add Luna user" ;
$addLunaUser_title = "Add a new Luna user" ;
$addLunaUser_auth = "Authorize product" ;

// editLunaUser

$editLunaUser_header = "Edit Luna user" ;
$editLunaUser_title = "Edit user" ;
$editLunaUser_auth = "Authorize product" ;
$editLunaUser_psw_title = "Edit password for this user" ;

// allLunaSettings

$allLunaSettings_header = "Luna settings" ;
$allLunaSettings_auth = "Allow manual access only to registered users" ;

//////////////////////////////////////////////

// FRONTEND

$luna_home_welcome = "Welcome" ;
$luna_home_choose = "Choose the manual";
$luna_home_no_manual = "No manual available" ;
$luna_login_remember = "Remember me on this device" ;
$luna_manual_title = "Manual:" ;
$luna_manual_version = "Choose version" ;
$luna_manual_editor = "Last modified by" ;
$luna_manual_on = "on" ;

//////////////////////////////////////////////

// ALERT

// msg

$msg_lunaProdDelSucc = "Product successfully deleted" ;
$msg_lunaDeletePageSucc = "Page successfully deleted" ;
$msg_lunaProdEditSucc = "Product successfully modified" ;
$msg_lunaProdSucc = "Product successfully created" ;
$msg_lunaProdCloneSucc = "Product cloned successfully" ;
$msg_lunaContentSucc = "Page created" ;
$msg_lunaContentEditSucc = "Page modified" ;
$msg_lunaUserSucc = "User successfully created" ;
$msg_lunaUserEditSucc = "User modified" ;
$msg_lunaUserEditPswSucc = "User password modified" ;
$msg_settingsEdit = "Settings modified" ;
$msg_lunaUserDelSucc = "User successfully deleted" ;


// err

$err_lunaProdDelTableErr = "Product table not deleted" ;
$err_lunaProdDelErr = "Product not deleted" ;
$err_lunaDeletePageTreeFail = "Page deleted, but there were problems on updating page tree." ;
$err_lunaDeletePageFail = "Page not deleted" ;
$err_lunaProdEditFail = "Product not modified" ;
$err_lunaProdFailDb = "Product not created: problems on creating db table" ;
$err_lunaProdFail = "Product not created" ;
$err_lunaProdCloneFail = "Product data not cloned" ;
$err_lunaProdCloneTableFail = "Product not cloned, problems with the db tables, please check" ;
$err_lunaProdCloneTreeFail = "Error while cloning the page tree. Product not cloned" ;
$err_lunaProdCloneFail = "Product clone not created" ;
$err_lunaContentTreeFail = "Page created, but there were problems on updating page tree." ;
$err_lunaContentEditFail = "Page not modified" ;
$err_lunaUserExist = "User already exists" ;
$err_lunaUserFail = "User not created" ;
$err_lunaUserEditFail = "User not modified" ;
$err_lunaUserEditPswFail = "User password not modified" ;
$err_settingsFail = "Settings not modified" ;
$err_lunaUserDelErr = "User not deleted" ;



?>
