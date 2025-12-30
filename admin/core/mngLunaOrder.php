<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";

$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../locale/$lang/*.php") as $row) {
    require "$row";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['orderedItems'])) {


        $orderedItems = json_decode($_POST['orderedItems'], true);
        // $orderedItems = array(
        //     array('id' => 6, 'livello' => 1),
        //     array('id' => 51, 'livello' => 2),
        //     array('id' => 69, 'livello' => 2),
        //     array('id' => 85, 'livello' => 2),
        //     array('id' => 91, 'livello' => 3),
        //     array('id' => 88, 'livello' => 2),
        //     array('id' => 9, 'livello' => 1),
        //     array('id' => 52, 'livello' => 2),
        //     array('id' => 90, 'livello' => 3),
        //     array('id' => 70, 'livello' => 2),
        //     array('id' => 86, 'livello' => 2)
        // );

        $prod_arr = json_decode($_POST['additionalData'], true);
        $prod_id = $prod_arr['luna_product_id'];

        // Controllo se ci sono livelli superiori a 3
        foreach ($orderedItems as $item) {
            if ($item['livello'] > 3) {
                $response = [
                    'success' => false,
                    'message' => $allLunaPages_wrong_level
                ];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit; // Interrompe l'esecuzione del resto del codice
            }
        }

        // In questo punto, $orderedItems contiene l'array dei dati gerarchici delle pagine
        // Puoi procedere con la manipolazione e l'elaborazione dei dati come desideri
        // Ad esempio, puoi creare l'array gerarchico qui

        // Creazione di una struttura gerarchica degli ID delle pagine
        $hierarchicalStructure = createTree($orderedItems);

        // Converte la struttura gerarchica in formato JSON
        $jsonContent = json_encode($hierarchicalStructure);

        // Salva il contenuto JSON su un file
        $real_file = '../inc/luna_pages/pages_' . $prod_id . '.json';
        $bck_file = '../inc/luna_pages_bck/pages_' . $prod_id . '.json';

        if (file_put_contents($real_file, $jsonContent)) {

            chmod($real_file, 0777);
            unlink($bck_file);
            copy($real_file, $bck_file);
            chmod($bck_file, 0777);
            $response = [
                'success' => true, // o false se c'è stato un errore
                'message' => $allLunaPages_save_ok,
                // Altri dati, se necessario
            ];
            // Imposta l'intestazione JSON
            header('Content-Type: application/json');

            // Invia la risposta come JSON
            echo json_encode($response);
        } else {
            unlink($real_file);
            copy($bck_file, $real_file);
            $response = [
                'success' => false, // o false se c'è stato un errore
                'message' => $allLunaPages_save_fail,
                // Altri dati, se necessario
                // Imposta l'intestazione JSON
            ];
            header('Content-Type: application/json');

            // Invia la risposta come JSON
            echo json_encode($response);
        }
    } else {
        // Se il parametro 'orderedItems' non è presente nella richiesta POST, invia una risposta JSON con un messaggio di errore
        $response = [
            'success' => false,
            'message' => 'Parametro "orderedItems" non trovato nella richiesta POST.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Se il metodo HTTP non è consentito, invia una risposta JSON con un messaggio di errore
    $response = [
        'success' => false,
        'message' => 'Metodo HTTP non consentito. Si prega di utilizzare il metodo POST.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Funzione per creare una struttura gerarchica degli ID delle pagine
function createTree($orderedItems)
{
    $tree = [];
    $child_tot = [];
    $par_tot = [];
    $previous_id = '';
    $previous_parent = '';
    $previous_child = '';
    $previous_level = '';

    foreach ($orderedItems as $item) {
        $id = $item['id'];
        $level = $item['livello'];

        if (isset($previous_level)) {
            // non è il primo giro

            if ($level == 1) {

                // è una pagina parent, va al livello principale
                $parent[] = $id;
            } else if ($level == 2) {

                // è una pagina di livello child
                if (!in_array($id, $child_tot)) {
                    $child_label = 'child_' . $previous_parent;

                    if (!isset($$child_label)) {
                        $$child_label = [];
                    }

                    $$child_label[] = $id;
                    $child_tot[] = $id;
                }
            } else if ($level == 3) {

                if (!in_array($id, $par_tot)) {
                    $paragraph_label = 'paragraph_' . $previous_child;
                    if (!isset($$paragraph_label)) {
                        $$paragraph_label = [];
                    }

                    $$paragraph_label[] = $id;
                    $par_tot[] = $id;
                }
            }
        } else {

            // è il primo giro
            $tree['parent'][] = [];
            $tree['parent'][] = $id;
        }

        $previous_level = $level;
        if ($level == 1) {
            $previous_parent = $id;
        } else if ($level == 2) {
            $previous_child = $id;
        }
    }

    $child_tree = [];

    foreach ($parent as $item) {
        $child_arr = 'child_' . $item;
        $child_tree[] = array("parent_id" => $item, "id" => $$child_arr);
    }


    $paragraph_tree = [];

    foreach ($child_tot as $item1) {
        $par_arr = 'paragraph_' . $item1;
        $paragraph_tree[] = array("child_id" => $item1, "id" => $$par_arr);
    }

    $tree = ['parent' => $parent, 'child' => $child_tree, 'paragraph' => $paragraph_tree];

    return $tree;
}
