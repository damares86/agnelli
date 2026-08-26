<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";

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
        $to = ['economo@agnelli.it', 'davidemasera@gmail.com'];
    }
    //$to=['economo@agnelli.it','amministrazione@istitutoagnelli.it'];

    $subject = 'Scadenza: ' . $row['title'] . ' - ' . $row['end'];
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Create email headers
    $headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $output = '<html><body>';
    $output .= '<p><b>Titolo: </b>' . $row['title'] . '</p>';
    $output .= '<p><b>Data di scadenza: </b>' . $row['end'] . '</p>';
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
