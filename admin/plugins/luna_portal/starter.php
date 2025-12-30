<?php

$portal_dir = '../../portal/';
$json_dir = '../inc/luna_pages/';
$json_bck = '../inc/luna_pages_bck/';

if ($op == 'add') {

	if (!is_dir($portal_dir)) {
		$oldmask = umask(0);
		mkdir($portal_dir, 0777, true);
		umask($oldmask);
	}


	if (!is_dir($json_dir)) {
		$oldmask = umask(0);
		mkdir($json_dir, 0777, true);
		umask($oldmask);
	}


	if (!is_dir($json_bck)) {
		$oldmask = umask(0);
		mkdir($json_bck, 0777, true);
		umask($oldmask);
	}


	// copy portal files
	if ($common->copyDirectory('../plugins/luna_portal/portal/', $portal_dir)) {
		$common->chmod_R($portal_dir, 0777);
	} else {
		$error++;
	}
}else if($op == 'rm'){

	$luna->rmdir_recursive($portal_dir) ;
	$luna->rmdir_recursive($json_dir) ;
	$luna->rmdir_recursive($json_bck) ;
	

}
require "config.php";
