<?php

function p($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function d($array) {
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
}

function e($array) {
    highlight_string("<?php\n" . var_export($array, true) . ";\n?>");
}

function setNavigationBackbutton($redirectIsTrue, $redirectIsTrue_url, $default_url) {
    $CI = &get_instance();
    // return value standaard op de default url zetten (wordt niet gebruikt, omdat de knop toch niet getoont wordt)

    $data = [];
    // NAVIGATION (zie home/index voor info)
    if ($redirectIsTrue) {
        $CI->session->set_userdata('redirect', true);
        $data['show_back_button'] = true;
        $data['redirect_url'] = site_url($redirectIsTrue_url);

    }
    else {
        $CI->session->set_userdata('redirect', false);
        $data['show_back_button'] = false;
        $data['redirect_url'] = site_url($default_url);
        $CI->session->set_userdata('redirect_url', $default_url);
    }
    return $data;
}

function setNavigationBackbuttonTwice($set, $redirectTwice_url) {
    // een gewone terug-knop is eigelijk als stad->land en dus level 1->2
    // een gewone terugknop gaat dus van level 2 naar level 1. aangezien dit "normaal" is spreken we niet van levels.

    // wanneer men 2x moet kunnen teruggaan, wordt er bij level 1 data bijgehouden.
    // bij bv van leverancier->stad->land, level 1->2->3
    // in stad wordt gecontroleerd of je hierin komt via leverancier.
    // zoja, wordt er in stad data "level1" ingesteld met de url van leverancier, omdat er een mogelijkheid is NOG een level te zakken (naar land)
    // bij stad wordt dus gecontroleerd of er een "level1" is in de session, zoja wordt die terugknop getoont, ...
    // anders wordt er (zoals gewoonlijk in de applicatie) gecontroleerd of er een normale teru-knop moet worden getoont
    // wanneer men van stad terug naar leverancier gaat (ongeacht of er naar land is gegaan) wordt deze "level1" data verwijderd uit de session

    $CI = &get_instance();

    if ($set) {
        $CI->session->set_userdata('redirect_url_twice', $redirectTwice_url); //wordt niet gebruikt, false
    }
    else {
        $CI->session->unset_userdata('redirect_url_twice');
    }
}

function createBasicDeleteModal($title, $message, $extraInfo = "", $question, $verwijderknopText) {
    $returnHtml = '
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"> </i> ' . $title . '</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>' . $message . '<br><span style="font-size: 12px;font-style: italic">' . $extraInfo . '</span><br><br>' . $question . '</p>
                </div>
                <div class="modal-footer">
                    <button id="deleteAllData" type="button" class="btn btn-danger">' . $verwijderknopText . '</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Annuleer</button>
                </div>
            </div>
        </div>
    </div>';
    echo $returnHtml;
}

function create_alert($showAlert = false, $db_is_success = "", $db_function = "", $db_item = "") {
    $CI = &get_instance();

    $alert = new stdClass();
    $alert->show = $showAlert;

    if (!$showAlert) {
        $alert->message = "";
        $alert->class = "";

        $CI->session->set_userdata('show_alert', FALSE);
        return $alert;
    }
    else {
        // alert message opbouwen
        $alertClass = "danger";
        $succesOrNotMessage = "niet";
        if ($db_is_success) {
            $alertClass = "success";
            $succesOrNotMessage = "succesvol";
        }

        switch ($db_function) {
            case "insert":
                $functionMessage = "<b>opgeslagen</b>.";
                break;
            case "update":
                $functionMessage = "<b>gewijzigd</b>.";
                break;
            case "delete":
                $functionMessage = "<b>verwijderd</b>.";
                break;
            default:
                $functionMessage = "";
                break;
        }

        // return object maken
        $alert->message = ucfirst($db_item) . " is " . $succesOrNotMessage . " " . $functionMessage;
        $alert->class = " show alert-" . $alertClass;

        $CI->session->set_userdata('show_alert', FALSE);
        return $alert;
    }
}

function setSessionAlertData($show_alert, $database_is_success, $database_function, $database_item) {
    $CI = &get_instance();
    $sessionAlertData = array(
        'show_alert' => $show_alert,
        'database_is_success' => $database_is_success,
        'database_function' => $database_function,
        'database_item' => $database_item
    );
    $CI->session->set_userdata($sessionAlertData);
}

// SESSION - ZOEKNAAM | is de zoeknaam die ingegeven wordt om tabellen gefilterd op te halen, onthouden voor na een refresh door update of delete
function getSessionZoeknaamvalue($soortZoeknaam) {
    // alles wordt opgehaald door de eerste ajax trigger.
    // Via een refresh kom je altijd via beheren. dan wordt de input "zoeknaam" met zoeknaam_value geset.
    // De data die geset wordt komt uit de session. (indien er geen session is wordt deze aangemaakt)
    // In ajax wordt in documeny.ready() -aan de hand van de waarde van zoeknaam- de ajaxZoekFunctie opgeroepen.
    // Wanneer er een ajax caal wordt gedaan wordt de waarde van de input #zoeknaam opniew in de session gestoken (overschreven)
    $CI = &get_instance();

    $userdataNaam = "zoeknaam_" . $soortZoeknaam; // bv zoeknaam_land, zoeknaam_leverancier
    if (!$CI->session->has_userdata($userdataNaam)) {
        $CI->session->set_userdata($userdataNaam, '');
    }
    return $CI->session->userdata($userdataNaam);
}

function getSessionZoekIdvalue($soortZoekId) {
    // info zie hierboven "getSessionZoeknaamvalue"
    $CI = &get_instance();

    $userdataId = "zoekid_" . $soortZoekId; // bv zoeknaam_land, zoeknaam_leverancier
    if (!$CI->session->has_userdata($userdataId)) {
        $CI->session->set_userdata($userdataId, '');
    }
    return $CI->session->userdata($userdataId);
}

// SESSION - FORMDATA | bijhouden indien er een refresh wordt gedaan, blijft het formulier ingevuld
function setOrUnset_sessionFormData($soortForm, $set) {
    //$set => true=set, false=unset
    $CI = &get_instance();

    $userdataNaam = "form_data_" . $soortForm; //bv form_data_land, form_data_leverancier
    $formDataSession = array($userdataNaam => true); // array om te gebruiken om sessie in op te slaan indien deze nog niet bestaat
    $namenMetDefaultWaarden = []; //bv naam, postcode, landid
    //met key=>value || key wordt gebruikt als naam indien de sessie bestaat anders een sessie maken met default waarden (is de value)

    switch ($soortForm) {
        case "stadgemeente":
            $namenMetDefaultWaarden = ['naam' => "", 'postcode' => "", 'landid' => 0];
            break;
        case "grondstof_ruw":
            $namenMetDefaultWaarden = ['naam' => "", 'aankoopprijs' => "", 'aankoopprijs_eenheidid' => 0, 'categorieid' => 0];
            break;
        case "grondstof_afgewerkt":
            $namenMetDefaultWaarden = ['naam' => "", 'aankoopprijs' => "", 'aankoopprijs_eenheidid' => 0, 'categorieid' => 0];
            break;
        case "leverancier":
            $namenMetDefaultWaarden = ['naam' => "", 'straat' => "", 'huisnummer' => "", 'stadgemeenteid' => 0, 'leveranciersoortid' => 0, 'btwnummer' => ""];
            break;
        case "folie_ruw":
            $namenMetDefaultWaarden = ['naam' => "", 'leverancierid' => 0, 'lmeenheid' => 1000, 'lmprijs' => '', 'micron' => 80];
            break;
        case "folie_gesneden":
            $namenMetDefaultWaarden = ['naam' => "", 'folieruwid' => 0, 'lengte' => '', 'breedte' => ''];
            break;
        case "product":
            $namenMetDefaultWaarden = ['naam' => "", 'artikelcode' => "", 'beschrijving' => "", 'stuksperpallet' => '', 'inhoudperzak' => '', 'folieid' => 0];
            break;
        case "kost_machines":
            $namenMetDefaultWaarden = ['naam' => "", 'machinesoortid' => 0, 'aankoopprijs' => "", 'aantal' => "", 'afschrijfperiodeperjaar' => "",
                'onderhoudfrequentieperjaar' => "", 'onderhoudkost' => "", 'onderhouduren' => "", 'onderhouduurloon' => ""];
            break;


    }

    // SET DATA
    if ($set) {
        $formData = new stdClass();

        if ($CI->session->userdata($userdataNaam) != null) {
            // waarden ophalen uit de sessie
            foreach ($namenMetDefaultWaarden as $naam => $value) {
                $formItemNaam = $soortForm . '_' . $naam; // bv land_naam, land_herkomst
                $formData->$formItemNaam = $CI->session->userdata($formItemNaam);
            }
        }
        else {
            //anders standaarwaarden instellen in de sessie
            foreach ($namenMetDefaultWaarden as $naam => $defaultWaarde) {
                $formItemNaam = $soortForm . '_' . $naam; // bv land_naam, land_herkomst
                $formData->$formItemNaam = $defaultWaarde;
                // en opslaan in sessionArray
                $formDataSession[$formItemNaam] = $defaultWaarde; // bv 'land_naam' => $formData->land_naam,
            }
            $CI->session->set_userdata($formDataSession);
        }
        return $formData;
    }
    else {
        //UNSET DATA
        $dataToUnset = [$userdataNaam]; //array wordt opgevuld met de namen als: land_naam, land_herkomst
        foreach ($namenMetDefaultWaarden as $naam => $value) {
            $formItemNaam = $soortForm . '_' . $naam; // bv land_naam, land_herkomst
            array_push($dataToUnset, $formItemNaam);
        }
        $CI->session->unset_userdata($dataToUnset);
    }
}

// SESSION FORMDATA AJAX | wordt getriggerd wanneer de user naar een andere beheerpagina gaat door een plus-button
function ajax_setSessionFormData($soortForm, $arrayMetWaardes) {
    $CI = &get_instance();

    $userdataNaam = "form_data_" . $soortForm; //bv form_data_land, form_data_leverancier
    $formDataSession = array($userdataNaam => true); // array om te gebruiken om sessie in op te slaan indien deze nog niet bestaat
    $namen = [];

    switch ($soortForm) {
        case "stadgemeente":
            $namen = ['naam', 'postcode', 'landid'];
            break;
        case "grondstof_ruw":
            $namen = ['naam', 'aankoopprijs', 'aankoopprijs_eenheidid', 'categorieid'];
            break;
        case "grondstof_afgewerkt":
            $namen = ['naam', 'aankoopprijs', 'aankoopprijs_eenheidid', 'categorieid'];
            break;
        case "leverancier":
            $namen = ['naam', 'straat', 'huisnummer', 'stadgemeenteid', 'leveranciersoortid', 'btwnummer'];
            break;
        case "folie_ruw":
            $namen = ['naam', 'leverancierid', 'lmeenheid', 'lmprijs', 'micron'];
            break;
        case "folie_gesneden":
            $namen = ['naam', 'folieruwid', 'lengte', 'breedte'];
            break;
        case "product":
            $namen = ['naam', 'artikelcode', 'beschrijving', 'stuksperpallet', 'inhoudperzak', 'folieid'];
            break;
        case "kost_machines":
            $namen = ['naam', 'machinesoortid', 'aankoopprijs', 'aantal', 'afschrijfperiodeperjaar',
                'onderhoudfrequentieperjaar', 'onderhoudkost', 'onderhouduren', 'onderhouduurloon'];
            break;


    }

    $i = 0;
    foreach ($arrayMetWaardes as $waarde) {
        $formItemNaam = $soortForm . '_' . $namen[$i]; // bv land_naam, land_herkomst
        $formDataSession[$formItemNaam] = $waarde;
        $i++;
    }
    $CI->session->set_userdata($formDataSession);
}


function controleerPercentageProductSamenstelling($productId) {
    $CI = &get_instance();
    $CI->load->model('product_model');
    $CI->load->model('product_samenstelling_model');

    $product = $CI->product_model->get($productId);

    $samenstellingen = $CI->product_samenstelling_model->getByProductId($product->id);
    $totaal = 0;
    foreach ($samenstellingen as $samenstelling) {
        if ($samenstelling->percentage != NULL) {
            $totaal += $samenstelling->percentage;
        }
    }
    return $totaal == 100 ? true : false;
}

function deleteVolledigProduct($productId) {
    $CI = &get_instance();
    $CI->load->model('product_model');
    $CI->load->model('product_samenstelling_model');
    $CI->load->model('kost_samenstelling_gebouwen_model');
    $CI->load->model('kost_samenstelling_machines_model');

    $product = $CI->product_model->get($productId);

    $CI->product_samenstelling_model->deleteAll_byProductId($product->id);
    $CI->kost_samenstelling_gebouwen_model->deleteAll_byProductieKostId($product->productieKostId);
    $CI->kost_samenstelling_machines_model->deleteAll_byProductieKostId($product->productieKostId);
    $succes = $CI->product_model->deleteProduct($product);
    return $succes;
}

?>