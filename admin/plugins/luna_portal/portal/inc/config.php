<?php

spl_autoload_register('autoloader');

function autoloader($class){
    include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files=glob("../admin/class/*.php", GLOB_BRACE);
rsort($files); 

// creation of the file with all the initialization of the classes
if(!is_file('../admin/inc/class_initialize.php')){
    $file_handle = fopen('../admin/inc/class_initialize.php', 'w');
    fwrite($file_handle, '<?php');
    fwrite($file_handle, "\n");
    foreach ($files as $filename) {
        $nomefile = pathinfo($filename);
        $file=$nomefile['filename'];
        if($file!="PhpXlsxGenerator")
        {
            $file_var = strtolower($file);
            fwrite($file_handle, '$'.$file_var.' = new '.$file.'($db);');
            fwrite($file_handle, "\n");
        }
    }
    if($prefix){
        fwrite($file_handle,'$common->prx = "'.$prefix.'_";') ;
        fwrite($file_handle, "\n");
    }
    fwrite($file_handle,"?>");
    chmod('../admin/inc/class_initialize.php',0777);
}

include "../admin/inc/class_initialize.php";

$setting->name = "debug" ;
$dbg = $setting->showAllWhere('id',['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if($row_debug['value']==1){
	require '../admin/vendor/autoload.php';		// If installed via composer
	$debug = new \bdk\Debug(array(
		'collect' => true,
		'output' => true,
	));
}


require __DIR__."/luna_version.php";
require "../admin/inc/damares_version.php";

$luna->table = 'luna_settings' ;
$luna->name = "luna_lang";
$stmt = $luna->showAllWhere('id',['name']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);
  $luna_lang = $row['value'] ;

foreach (glob("../admin/locale/$luna_lang/*.php") as $row) {
  require "$row";
}

// variable for require script for chart
$apex='';