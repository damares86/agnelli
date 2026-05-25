<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

if (!isset($_GET['token']) || $_GET['token'] !== 'Agnelli312!') {
    http_response_code(403);
    exit('Accesso negato');
}

spl_autoload_register('autoloader');

function autoloader($class){
	include("../admin/class/$class.php");
}

require "../admin/core/prefix.php";

$database = new Database();
$db = $database->getConnection();

include "../admin/inc/class_initialize.php";

$error = 0;

// calcolo differenza date
$day = date("Y-m-d", strtotime("+10 days"));

$start = $day . " 00:00:00";
$end   = $day . " 23:59:59";

$calendar->end = date("Y-m-d", strtotime("+10 days"));
$calendar->table = "calendar_events";
$stmt = $calendar->showAllWhereBetween('id', 'end', $start, $end);

$from = "economo@agnelli.it";


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    
    if($row['cat_id']==1){
        $to = ['economo@agnelli.it'];
    }else{
        $to = ['economo@agnelli.it', 'amministrazione@istitutoagnelli.it'];
    }
    //$to=['economo@agnelli.it','amministrazione@istitutoagnelli.it'];

    $end_date = date("d-m-Y", strtotime($row['end'])) ;

    $subject = 'AGNELLI MANAGER: Scadenza: ' . $row['title'] . ' - ' . $end_date ;
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Create email headers
    $headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $output = '<html><body>';
    $output .= '<p><b>Titolo: </b>' . $row['title'] . '</p>';
    $output .= '<p><b>Data di scadenza: </b>' . $end_date . '</p>';
    $output .= '<p><b>Note: </b>' . $row['note'] . '</p>';
    $output .= '</body></html>';
    
    foreach ($to as $email) {
       if (!mail($email, $subject, $output, $headers)) {
            $error++;
        }
    }
}

if ($error > 0) {
    $from = "economo@agnelli.it";
    $to = "economo@agnelli.it";
    $subject = "Errore nell'invio delle email delle scadenze";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Create email headers
    $headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $output = '<html><body>';
    $output .= '<p>C\'è stato un errore nell\'invio di una mail di scadenze dall\'app Gestione Agnelli</p>';
    $output .= '<br>';
    $output .= '</body></html>';
}
exit;
