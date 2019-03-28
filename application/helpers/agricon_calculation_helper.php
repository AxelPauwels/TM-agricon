<?php
// PRIVATE FUNCTIONS
function _berekenGrondstoffenTotaal($product) {
    // grondstoffenkost - BEREKENING '%' = FractiePercentage * aankoopprijs/fractie
    // grondstoffenkost - BEREKENING 'kg' = aankoopprijs * eenheid
    // grondstoffenkost - BEREKENING = som van '%' en 'kg'

    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('product_samenstelling_model');
    $CI->load->model('grondstof_afgewerkt_model');

    $totaal = 0;
    $samenstellingen = $CI->product_samenstelling_model->getByProductId($product->id);

    foreach ($samenstellingen as $samenstelling) {
        $grondstof = $CI->grondstof_afgewerkt_model->get($samenstelling->grondstofAfgewerktId);

        //controleren of het '%' of 'kg' is
        if ($samenstelling->percentage != NULL) {
            $totaal += ($samenstelling->percentage / 100) * $grondstof->aankoopPrijsPerFractie;
        }
        else {
            $totaal += $samenstelling->gewicht * $grondstof->aankoopPrijsPerFractie;
        }
    }
    return $totaal;
}

function _berekenVerpakkingsKost($product, $grondstoffentotaal) {
    // grondstoffenkost - BEREKENING 'grondstoffenEindTotaal' = grondstoffentotaal + (verpakkingskost * 2)
    // grondstoffenkost - BEREKENING 'productieKost' = (Inhoud * grondstoffenEindTotaal) / 1000
    // grondstoffenkost - BEREKENING 'verpakkingsKost' = productieKost + foliePrijs/zak

    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('configuratie_model');
    $CI->load->model('folie_gesneden_model');

    $verpakkingsKost = $CI->configuratie_model->verpakkingskost_get($product->verpakkingsKostId)->verpakkingskost;
    $grondstoffenEindtotaal = $grondstoffentotaal + ($verpakkingsKost * 2);
    $productieKost = ($product->inhoudPerZak * $grondstoffenEindtotaal) / 1000;

    $folie = $CI->folie_gesneden_model->get($product->folieId);
    $verpakkingsKost = $productieKost + $folie->prijsPerZakje;

    return $verpakkingsKost;
}

function _berekenProductieKost($productieKost) {
    // grondstoffenkost - BEREKENING = som van alle kostenPerJaar / geschatteOmzet

    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('configuratie_model');
    $CI->load->model('kost_elektriciteit_model');
    $CI->load->model('kost_personeel_model');
    $CI->load->model('kost_gebouwen_model');
    $CI->load->model('kost_machines_model');
    $CI->load->model('kost_samenstelling_gebouwen_model');
    $CI->load->model('kost_samenstelling_machines_model');
    $geschatteOmzet = $CI->configuratie_model->omzet_get($productieKost->omzetId);

    $kost_elektriciteit = $CI->kost_elektriciteit_model->get($productieKost->electriciteitKostId)->elektriciteitKostPerJaar;
    $kost_personeel = $CI->kost_personeel_model->get($productieKost->personeelKostId)->personeelKostPerJaar;
    $kost_gebouwen = 0;
    $kost_machines = 0;

    $gebouwSamenstellingen = $CI->kost_samenstelling_gebouwen_model->getByProductieKostId($productieKost->id);
    $machineSamenstellingen = $CI->kost_samenstelling_machines_model->getByProductieKostId($productieKost->id);
    $kost_personeel = ($kost_personeel / 365) * $geschatteOmzet->dagenPerJaar; // fix kost naargelang de aantal dagen

    foreach ($gebouwSamenstellingen as $gebouwSamenstelling) {
        $kost_gebouwen += $CI->kost_gebouwen_model->get($gebouwSamenstelling->kostGebouwenId)->gebouwKostPerJaar;
    }
    foreach ($machineSamenstellingen as $machineSamenstelling) {
        $kost_machines += $CI->kost_machines_model->get($machineSamenstelling->kostMachinesId)->totaalMachineKostPerJaar;
    }

    $totaalPerJaar = $kost_elektriciteit + $kost_personeel + $kost_gebouwen + $kost_machines;
    // deze ook opslaan in "productieKost"
    $updateObject = new stdClass();
    $updateObject->id = $productieKost->id;
    $updateObject->productieKostPerJaar = $totaalPerJaar;
    $CI->productiekost_model->updateProductieKost($updateObject);

    $totaal = $totaalPerJaar / $geschatteOmzet->aantalZakjesPerJaar;
    return $totaal;
}

function _messageGrondstoffenTotaal($product) {
    // grondstoffenkost - BEREKENING '%' = FractiePercentage * aankoopprijs/fractie
    // grondstoffenkost - BEREKENING 'kg' = aankoopprijs * eenheid
    // grondstoffenkost - BEREKENING = som van '%' en 'kg'

    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('product_samenstelling_model');
    $CI->load->model('grondstof_afgewerkt_model');
    $CI->load->model('grondstof_ruw_model');
    $CI->load->model('grondstof_categorie_model');

    $totaal = 0;
    $messageBodyLeftContent = '<span class="text-muted">Formule - Percentage</span><br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Gewicht</span><br>';
    $messageBodyRightContent = '(percentage &divide; 100) &times; aankoopprijs<br>';
    $messageBodyRightContent .= 'gewicht &times; aankoopprijs<br>';

    $samenstellingen = $CI->product_samenstelling_model->getByProductId($product->id);

    foreach ($samenstellingen as $samenstelling) {
        $grondstof = $CI->grondstof_afgewerkt_model->get($samenstelling->grondstofAfgewerktId);
        $grondstofRuw = $CI->grondstof_ruw_model->get($grondstof->grondstofRuwId);
        $grondstofCategorie = $CI->grondstof_categorie_model->get($grondstofRuw->grondstofCategorieId);

        //controleren of het '%' of 'kg' is
        if ($samenstelling->percentage != NULL) {
            $subtotaal = ($samenstelling->percentage / 100) * $grondstof->aankoopPrijsPerFractie;
            $totaal += $subtotaal;

            // messages
            if ($grondstofCategorie->isFractieCategorie == 1) {
                $messageBodyLeftContent .= $samenstelling->percentage . '% ' . ucwords($grondstofRuw->naam) . ' ' . ucfirst($grondstof->naam) . ' <span class="bolder float-right">€ ' . number_format($subtotaal, 2) . '</span><br/>';
                $messageBodyRightContent .= '(' . $samenstelling->percentage . ' ' . '&divide; 100) &times; ' . $grondstof->aankoopPrijsPerFractie . ' = ' . number_format($subtotaal, 2) . '<br/>';
            }
            else {
                $messageBodyLeftContent .= $samenstelling->percentage . '% ' . ucfirst($grondstof->naam) . ' <span class="bolder float-right">€ ' . number_format($subtotaal, 2) . '</span><br/>';
                $messageBodyRightContent .= '(' . $samenstelling->percentage . ' ' . '&divide; 100) &times; ' . $grondstof->aankoopPrijsPerFractie . ' = ' . number_format($subtotaal, 2) . '<br/>';
            }
        }
        else {
            $subtotaal = $samenstelling->gewicht * $grondstof->aankoopPrijsPerFractie;
            $totaal += $subtotaal;

            //messages
            $messageBodyLeftContent .= $samenstelling->gewicht . 'kg ' . ucfirst($grondstof->naam) . ' <span class="bolder float-right">€ ' . number_format($subtotaal, 2) . '</span><br/>';
            $messageBodyRightContent .= $samenstelling->gewicht . ' ' . ' &times; ' . $grondstof->aankoopPrijsPerFractie . ' = ' . number_format($subtotaal, 2) . '<br/>';
        }
    }
    $messageBodyLeft = '<div class="col-6">';
    $messageBodyLeft .= '<h6 class="withBorder">Grondstoffen' . '<span class="bolder float-right">€ ' . number_format($totaal, 2) . '</span></h6>';

    $messageBodyRight = '<div class="col-6 text-muted">';
    $messageBodyRight .= '<h6 style="color: white">padding</h6>';

    $messageBodyLeft .= $messageBodyLeftContent;
    $messageBodyRight .= $messageBodyRightContent;

    $messageBodyLeft .= '</div>';
    $messageBodyRight .= '</div>';

    $message = '<div class="row">' . $messageBodyLeft . $messageBodyRight . '</div><div class="clearfix"></div>';
    return $message;
}

function _messageVerpakkingsKost($product, $grondstoffentotaal) {
    // grondstoffenkost - BEREKENING 'grondstoffenEindTotaal' = grondstoffentotaal + (verpakkingskost * 2)
    // grondstoffenkost - BEREKENING 'productieKost' = (Inhoud * grondstoffenEindTotaal) / 1000
    // grondstoffenkost - BEREKENING 'verpakkingsKost' = productieKost + foliePrijs/zak

    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('configuratie_model');
    $CI->load->model('folie_gesneden_model');

    $totaal = 0;
    $messageBodyLeftContent = '<span class="text-muted">Formule - Grondstoffen met verpakking</span><br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Verpakkings productiekost</span><br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Verpakkings totaalkost</span><br>';
    $messageBodyRightContent = 'grondstoffen + (verpakkingkost &times; 2)<br>';
    $messageBodyRightContent .= '(inhoud &times; grondstoffenMetVerpakking) &divide; 1000<br>';
    $messageBodyRightContent .= 'verpakkingsProductiekost + foliePrijs/zakje<br>';

    // berekening
    $verpakkingsKost = $CI->configuratie_model->verpakkingskost_get($product->verpakkingsKostId)->verpakkingskost;
    $grondstoffenEindtotaal = $grondstoffentotaal + ($verpakkingsKost * 2);

    $productieKost = ($product->inhoudPerZak * $grondstoffenEindtotaal) / 1000;
    $folie = $CI->folie_gesneden_model->get($product->folieId);
    $verpakkingsKost = $productieKost + $folie->prijsPerZakje;

    // messages
    $messageBodyLeftContent .= 'Grondstoffen met verpakking<span class="bolder float-right">€ ' . number_format($grondstoffenEindtotaal, 2) . '</span><br/>';
    $messageBodyRightContent .= $grondstoffentotaal . ' + (' . number_format($verpakkingsKost, 2) . ' &times; 2) = ' . number_format($grondstoffenEindtotaal, 2) . '<br/>';

    $messageBodyLeftContent .= 'Verpakkings productiekost <span class="bolder float-right">€ ' . number_format($productieKost, 2) . '</span><br/>';
    $messageBodyRightContent .= '(' . $product->inhoudPerZak . ' &times; ' . number_format($grondstoffenEindtotaal, 2) . ') &divide; 1000 = ' . number_format($productieKost, 2) . '<br/>';

    $messageBodyLeftContent .= 'Verpakkings totaalkost <span class="bolder float-right">€ ' . number_format($verpakkingsKost, 2) . '</span><br/>';
    $messageBodyRightContent .= $productieKost . ' + ' . $folie->prijsPerZakje . ' = ' . number_format($verpakkingsKost, 2) . '<br/>';

    $messageBodyLeft = '<div class="col-6">';
    $messageBodyLeft .= '<h6 class="withBorder">Verpakkingskost' . '<span class="bolder float-right">€ ' . number_format($verpakkingsKost, 2) . '</span></h6>';

    $messageBodyRight = '<div class="col-6 text-muted">';
    $messageBodyRight .= '<h6 style="color: white">padding</h6>';

    $messageBodyLeft .= $messageBodyLeftContent;
    $messageBodyRight .= $messageBodyRightContent;

    $messageBodyLeft .= '</div>';
    $messageBodyRight .= '</div>';

    $message = '<div class="row">' . $messageBodyLeft . $messageBodyRight . '</div><div class="clearfix"></div>';
    return $message;
}

function _messageProductieKost($productieKost) {
    // grondstoffenkost - BEREKENING = som van alle kostenPerJaar / geschatteOmzet

    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('configuratie_model');
    $CI->load->model('kost_elektriciteit_model');
    $CI->load->model('kost_personeel_model');
    $CI->load->model('kost_gebouwen_model');
    $CI->load->model('kost_machines_model');
    $CI->load->model('kost_samenstelling_gebouwen_model');
    $CI->load->model('kost_samenstelling_machines_model');

    $messageBodyLeftContent = "";
    $messageBodyRightContent = "";
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Elekriciteitkost/jaar</span><br>';
    $messageBodyRightContent .= 'verbuik/jaar &divide; prijs/Kwh<br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Personeelkost/jaar</span><br>';
    $messageBodyRightContent .= '((aantalWerknemers &times; uren ) &times uurloon) &times; werkdagen<br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Gebouwenkost/jaar</span><br>';
    $messageBodyRightContent .= 'aankoopprijs &divide; afschrijfperiode<br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Machinekost/jaar</span><br>';
    $messageBodyRightContent .= 'afschrijving + onderhoud + reparatie<br>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - Geschatte zakjes/jaar' . '</span><br/>';
    $messageBodyRightContent .= 'zakjesPerDag &times; dagen/jaar<br/>';
    $messageBodyLeftContent .= '<span class="text-muted">Formule - ProductieKost' . '</span><br/>';
    $messageBodyRightContent .= 'som van kosten &divide; geschatteZakjes/jaar<br/>';

    $kost_elektriciteit = $CI->kost_elektriciteit_model->get($productieKost->electriciteitKostId);
    $kost_personeel = $CI->kost_personeel_model->get($productieKost->personeelKostId);
    $geschatteOmzet = $CI->configuratie_model->omzet_get($productieKost->omzetId);

    $kost_personeelVolgensAantalWerkdagen = ($kost_personeel->personeelKostPerJaar / 365) * $geschatteOmzet->dagenPerJaar;
    $messageBodyLeftContent .= 'Elekriciteitkost<span class="bolder float-right">€ ' . number_format($kost_elektriciteit->elektriciteitKostPerJaar, 2) . '</span><br>';
    $messageBodyRightContent .= $kost_elektriciteit->verbruikPerJaarInKwh . ' &divide; ' . $kost_elektriciteit->kostprijsPerKwh . ' = ' . number_format($kost_elektriciteit->elektriciteitKostPerJaar, 2) . '<br>';
    $messageBodyLeftContent .= 'Personeelkost<span class="bolder float-right">€ ' . number_format($kost_personeelVolgensAantalWerkdagen, 2) . '</span><br>';
    $messageBodyRightContent .= '((' . $kost_personeel->aantalWerknemers . ' &times; ' . $kost_personeel->aantalUren . ') &times; ' . $kost_personeel->uurloon . ') &times; ' . $geschatteOmzet->dagenPerJaar . ' = ' . number_format($kost_personeelVolgensAantalWerkdagen, 2) . '<br>';

    $kost_gebouwen = 0;
    $kost_machines = 0;

    $gebouwSamenstellingen = $CI->kost_samenstelling_gebouwen_model->getByProductieKostId($productieKost->id);
    $machineSamenstellingen = $CI->kost_samenstelling_machines_model->getByProductieKostId($productieKost->id);

    $temp_left = "";
    $temp_right = "";
    foreach ($gebouwSamenstellingen as $gebouwSamenstelling) {
        $gebouw = $CI->kost_gebouwen_model->get($gebouwSamenstelling->kostGebouwenId);
        $kost_gebouwen_subtotaal = $gebouw->gebouwKostPerJaar;
        $kost_gebouwen += $gebouw->gebouwKostPerJaar;

        //messages
        $temp_left .= '<span style="padding-left: 10px">' . ucfirst($gebouw->naam) . '</span><span class="bolder float-right">€ ' . number_format($kost_gebouwen_subtotaal, 2) . '</span><br/>';
        $temp_right .= $gebouw->aankoopPrijs . ' &divide; ' . $gebouw->afschrijfperiodePerJaar . ' = ' . number_format($kost_gebouwen_subtotaal, 2) . '<br/>';
    }
    $messageBodyLeftContent .= 'Gebouwenkost<span class="bolder float-right">€ ' . number_format($kost_gebouwen, 2) . '</span><br>';
    $messageBodyRightContent .= '<span style="color: white">padding</span> <br>';
    $messageBodyLeftContent .= $temp_left;
    $messageBodyRightContent .= $temp_right;

    $temp_left = "";
    $temp_right = "";
    foreach ($machineSamenstellingen as $machineSamenstelling) {
        $machine = $CI->kost_machines_model->get($machineSamenstelling->kostMachinesId);
        $kost_machines_subtotaal = $machine->totaalMachineKostPerJaar;
        $kost_machines += $machine->totaalMachineKostPerJaar;
        //messages
        $temp_left .= '<span style="padding-left: 10px">' . ucfirst($machine->naam) . '</span><span class="bolder float-right">€ ' . number_format($kost_machines_subtotaal, 2) . '</span><br/>';
        $temp_right .= '(' . $machine->aankoopPrijs . ' &times; ' . $machine->aantal . ') &times; ' . $machine->afschrijfperiodePerJaar . ' + ' . number_format($machine->onderhoudKostPerJaar, 2) . ' + ' . number_format($machine->reparatieKostPerJaar, 2) . ' = ' . number_format($kost_machines_subtotaal, 2) . '<br/>';
    }
    $messageBodyLeftContent .= 'Machinekost<span class="bolder float-right">€ ' . number_format($kost_machines, 2) . '</span><br>';
    $messageBodyRightContent .= '<span style="color: white">padding</span> <br>';
    $messageBodyLeftContent .= $temp_left;
    $messageBodyRightContent .= $temp_right;

    $geschatteOmzet = $CI->configuratie_model->omzet_get($productieKost->omzetId);
    $totaal = ($kost_elektriciteit->elektriciteitKostPerJaar + $kost_personeel->personeelKostPerJaar + $kost_gebouwen + $kost_machines) / $geschatteOmzet->aantalZakjesPerJaar;

    $messageBodyLeftContent .= 'Geschatte zakjes/jaar' . ' <span class="bolder float-right">' . round($geschatteOmzet->aantalZakjesPerJaar, 0) . '</span><br/>';
    $messageBodyRightContent .= $geschatteOmzet->zakjesPerDag . ' &times; ' . $geschatteOmzet->dagenPerJaar . ' = ' . round($geschatteOmzet->aantalZakjesPerJaar, 0) . '<br/>';
    $messageBodyLeftContent .= 'Productiekost' . ' <span class="bolder float-right">' . number_format($totaal, 2) . '</span><br/>';
    $messageBodyRightContent .= $totaal * $geschatteOmzet->aantalZakjesPerJaar . ' &divide; ' . round($geschatteOmzet->aantalZakjesPerJaar) . ' = ' . number_format($totaal, 2) . '<br/>';

    $messageBodyLeft = '<div class="col-6">';
    $messageBodyLeft .= '<h6 class="withBorder">Productiekost' . '<span class="bolder float-right">€ ' . number_format($totaal, 2) . '</span></h6>';
    $messageBodyRight = '<div class="col-6 text-muted">';
    $messageBodyRight .= '<h6 style="color: white">padding</h6>';
    $messageBodyLeft .= $messageBodyLeftContent;
    $messageBodyRight .= $messageBodyRightContent;
    $messageBodyLeft .= '</div>';
    $messageBodyRight .= '</div>';

    $message = '<div class="row">' . $messageBodyLeft . $messageBodyRight . '</div><div class="clearfix"></div>';
    return $message;
}

function _messageTotaalKost($prijs_grondstoffentotaal, $prijs_verpakkingskost, $prijs_productiekost, $enkeleVerpakkingsKost, $prijs_totaal) {
    $messageBodyLeft = '<div class="col-6">';
    $messageBodyLeft .= '<h6 class="withBorder">Totaal' . '<span class="bolder float-right">€ ' . number_format($prijs_totaal, 2) . '</span></h6>';
    $messageBodyRight = '<div class="col-6 text-muted">';
    $messageBodyRight .= '<h6 style="color: white">padding</h6>';
    $messageBodyLeft .= '<span class="text-muted">Formule</span><br>';
    $messageBodyRight .= '(som van bovenstaande) + verpakkingskost <br>';

    $messageBodyLeft .= 'Totaal<span class="bolder float-right">€ ' . number_format($prijs_totaal, 2) . '</span><br>';
    $messageBodyRight .= '(' . number_format($prijs_grondstoffentotaal, 2) . ' + ' . number_format($prijs_verpakkingskost, 2) . ' + ' . number_format($prijs_productiekost, 2) . ') + ' . number_format($enkeleVerpakkingsKost, 2) . ' = ' . number_format($prijs_totaal, 2) . '<br>';

    $messageBodyLeft .= '</div>';
    $messageBodyRight .= '</div>';

    $message = '<div class="row">' . $messageBodyLeft . $messageBodyRight . '</div><div class="clearfix"></div>';
    return $message;
}

// CALCULATIONS ----------------------------------------------------------------------------------------------
function calculate_folieGesneden_prijsPerZakje($LMprijs, $LMeenheid = 1000, $afslag) {
    // berekening = folierol-prijs(per1000LM) / ( 1000(LM) / afslag )
    // berekening = € / (1000 / afslag)
    return $LMprijs / ($LMeenheid / $afslag);
}

function calculate_and_update_reparatieEnMachineTotaalKostenPerJaar($machinesId, $userId) {
    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('kost_machines_reparaties_model');
    $CI->load->model('kost_machines_model');

    // totaalkost van reparatieKosten van deze machineKost ophalen, en machineKost updaten
    $totaalReparaties = $CI->kost_machines_reparaties_model->getTotaalKost_byKostMachineId($machinesId);
    $kost_machines = new stdClass();
    $kost_machines->id = $machinesId;
    $kost_machines->reparatieKostPerJaar = $totaalReparaties;
    $CI->kost_machines_model->updateKostMachines($kost_machines);

    // machineKost terug ophalen omdat de Calculated Colums in de database nu pas werden berekend (dus ook met een anders object werken)
    $kost_machines = $CI->kost_machines_model->get($machinesId);
    $totaal = $kost_machines->afschrijfperiodeKostPerJaar + $kost_machines->onderhoudKostPerJaar + $kost_machines->reparatieKostPerJaar;
    $kost_machines->totaalMachineKostPerJaar = $totaal;
    $kost_machines->gewijzigdDoor = $userId;
    $CI->kost_machines_model->updateKostMachines($kost_machines);
}

function calculate_and_update_productPrijs($productId, $productieKostId) {
    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('product_model');
    $CI->load->model('productiekost_model');
    $CI->load->model('configuratie_model');

    $product = $CI->product_model->get($productId);
    $productieKost = $CI->productiekost_model->get($productieKostId);

    $grondstoffentotaal = _berekenGrondstoffenTotaal($product);
    $verpakkingskost = _berekenVerpakkingsKost($product, $grondstoffentotaal);
    $productiekost = _berekenProductieKost($productieKost);

    $enkeleVerpakkingsKost = $CI->configuratie_model->verpakkingskost_get($product->verpakkingsKostId)->verpakkingskost;

    // BEREKENING = som van kosten + enkeleVerpakkingsKost
    $prijs = $grondstoffentotaal + $verpakkingskost + $productiekost + $enkeleVerpakkingsKost;

    $productupdate = new stdClass();
    $productupdate->id = $productId;
    $productupdate->aankoopPrijs = $prijs;
    $CI->product_model->updateProduct($productupdate);
}

// CALCULATION MESSAGES ----------------------------------------------------------------------------------------------
function getCalculationMessage_kost_personeel($kost_personeel) {
    $html = '<p style="padding-bottom: 0;margin-bottom: 0">';
    $html .= '<span style="font-size: 1.2em">BEREKENING VAN "' . $kost_personeel->naam . '"</span>' .
        '<span id="closeThis" ><i class="far fa-window-close"></i></span>' .
        '<span id="bekijkGrootOfKlein" ><i class="far fa-window-maximize"></i></span>' .
        '<hr>';
    $html .= '<span style="font-weight: bold">Kost/Jaar = </span> ((Aantal werknemers &times; Uren/dag) &times; Uurloon ) &times; 365 dagen<br>';

    //rekenen
    $aantalWerknemers = $kost_personeel->aantalWerknemers;
    $aantalUren = $kost_personeel->aantalUren;
    $uurloon = $kost_personeel->uurloon;
    $subtotaal1 = $aantalWerknemers * $aantalUren;
    $subtotaal2 = $subtotaal1 * $uurloon;
    $subtotaal3 = $subtotaal2 * 365;

    //html toevoegen
    $berekening = '';
    $berekening .= $aantalWerknemers . " x " . $aantalUren . " = " . $subtotaal1 . "<br>";
    $berekening .= $subtotaal1 . " x " . $uurloon . " = " . $subtotaal2 . "<br>";
    $berekening .= $subtotaal2 . " x " . "365" . " = <span style='font-weight:500;color:darkgreen'>" . round($subtotaal3, 2) . "</span><br>";

    $html .= $berekening;

    $html .= '</p>';
    $html .= '<br>';
    echo $html;
}

function getCalculationMessage_kost_elektriciteit($kost_elektriciteit) {
    $html = '<p style="padding-bottom: 0;margin-bottom: 0">';
    $html .= '<span style="font-size: 1.2em">BEREKENING VAN "' . $kost_elektriciteit->naam . '"</span>' .
        '<span id="closeThis" ><i class="far fa-window-close"></i></span>' .
        '<span id="bekijkGrootOfKlein" ><i class="far fa-window-maximize"></i></span>' .
        '<hr>';
    $html .= '<span style="font-weight: bold">Kost/Jaar = </span> Verbruik/Jaar &divide Kostprijs/Kwh<br>';

    //rekenen
    $verbruikPerJaarInKwh = $kost_elektriciteit->verbruikPerJaarInKwh;
    $kostprijsPerKwh = $kost_elektriciteit->kostprijsPerKwh;
    $subtotaal1 = $verbruikPerJaarInKwh / $kostprijsPerKwh;

    //html toevoegen
    $berekening = '';
    $berekening .= $verbruikPerJaarInKwh . " &divide " . $kostprijsPerKwh . " = <span style='font-weight:500;color:darkgreen'>" . round($subtotaal1, 2) . "</span><br>";

    $html .= $berekening;

    $html .= '</p>';
    $html .= '<br>';
    echo $html;
}

function getCalculationMessage_kost_gebouwen($kost_gebouwen) {
    $html = '<p style="padding-bottom: 0;margin-bottom: 0">';
    $html .= '<span style="font-size: 1.2em">BEREKENING VAN "' . $kost_gebouwen->naam . '"</span>' .
        '<span id="closeThis" ><i class="far fa-window-close"></i></span>' .
        '<span id="bekijkGrootOfKlein" ><i class="far fa-window-maximize"></i></span>' .
        '<hr>';
    $html .= '<span style="font-weight: bold">Kost/Jaar = </span> Aankoopprijs &divide Afschrijfperiode<br>';

    //rekenen
    $aankoopPrijs = $kost_gebouwen->aankoopPrijs;
    $afschrijfperiodePerJaar = $kost_gebouwen->afschrijfperiodePerJaar;
    $subtotaal1 = $aankoopPrijs / $afschrijfperiodePerJaar;

    //html toevoegen
    $berekening = '';
    $berekening .= $aankoopPrijs . " &divide " . $afschrijfperiodePerJaar . " = <span style='font-weight:500;color:darkgreen'>" . round($subtotaal1, 2) . "</span><br>";

    $html .= $berekening;

    $html .= '</p>';
    $html .= '<br>';
    echo $html;
}

function getCalculationMessage_kost_machines($kost_machines) {
    $html = '<p style="padding-bottom: 0;margin-bottom: 0">';
    $html .= '<span style="font-size: 1.2em">BEREKENING VAN "' . $kost_machines->naam . '"</span>' .
        '<span id="closeThis" ><i class="far fa-window-close"></i></span>' .
        '<span id="bekijkGrootOfKlein" ><i class="far fa-window-maximize"></i></span>' .
        '<hr>';
    $html .= '<span style="font-weight: bold">AfschrijfKost/Jaar = </span> (Aankoopprijs &divide Afschrijfperiode) &times Aantal<br>';

    //rekenen 1 (AfschrijfKost/Jaar) *******************************************************************************************************
    $aankoopPrijs = $kost_machines->aankoopPrijs;
    $aantal = $kost_machines->aantal;
    $afschrijfPeriode = $kost_machines->afschrijfperiodePerJaar;

    $subtotaal1 = $aankoopPrijs / $afschrijfPeriode;
    $subtotaal2_totaalKost1 = $subtotaal1 * $aantal;

    //html toevoegen 1
    $berekening = '';
    $berekening .= $aankoopPrijs . " &divide " . $afschrijfPeriode . " = " . round($subtotaal1, 2) . "<br>";
    $berekening .= round($subtotaal1, 2) . " &times " . $aantal . " = <span style='font-weight:500;color:darkgreen'>" . round($subtotaal2_totaalKost1, 2) . "</span><br>";
    $html .= $berekening;

    //rekenen 2 (OnderhoudKost/Jaar) *******************************************************************************************************
    $html .= '<br><span style="font-weight: bold">OnderhoudKost/Jaar = </span> ((Uren &times Uurloon) + kost) &times Frequentie<br>';

    $oUren = $kost_machines->onderhoudUren;
    $oUurloon = $kost_machines->onderhoudUurloon;
    $oKost = $kost_machines->onderhoudKost;
    $oFrequentie = $kost_machines->onderhoudFrequentiePerJaar;

    $oSubtotaal1 = $oUren * $oUurloon;
    $oSubtotaal2 = $oSubtotaal1 + $oKost;
    $oSubtotaal3_totaalKost2 = $oSubtotaal2 * $oFrequentie;

    //html toevoegen 2
    $oBerekening = '';
    $oBerekening .= $oUren . " &times " . $oUurloon . " = " . round($oSubtotaal1, 2) . "<br>";
    $oBerekening .= round($oSubtotaal1, 2) . " + " . $oKost . " = " . round($oSubtotaal2, 2) . "<br>";
    $oBerekening .= round($oSubtotaal2, 2) . " &times " . $oFrequentie . " = <span style='font-weight:500;color:darkgreen'>" . round($oSubtotaal3_totaalKost2, 2) . "</span><br>";
    $html .= $oBerekening;

    //rekenen 3 (ReparatieKost/Jaar) *******************************************************************************************************
    $html .= '<br><span style="font-weight: bold">ReparatieKost/Jaar = </span> De som van alle reparaties. <span style="font-weight: bold">Elke reparatieKost = </span> (Uren &times Uurloon) + kost <br>';

    $rBerekening = '';
    $rBerekeningNaReparaties = "";
    $rTotaalAlleReparaties_totaalKost3 = 0; // moet hetzelfde zijn als $machine_kost->reparatieKostPerJaar
    $i = 0;
    foreach ($kost_machines->reparaties as $reparatie) {
        $i++;
        // (rekenen)
        $rBerekening .= '<span style="text-decoration: underline">Reparatie' . $i . '</span><br>';
        $rUren = $reparatie->reparatieUren;
        $rUurloon = $reparatie->reparatieUurloon;
        $rKost = $reparatie->reparatieKost;

        $rSubtotaal1 = $rUren * $rUurloon;
        $rSubtotaal2 = $rSubtotaal1 + $rKost;
        $rTotaalAlleReparaties_totaalKost3 += $rSubtotaal2;

        // (toevoegen)
        $rBerekening .= $rUren . " &times " . $rUurloon . " = " . round($rSubtotaal1, 2) . "<br>";
        $rBerekening .= round($rSubtotaal1, 2) . " + " . $rKost . " = " . round($rSubtotaal2, 2) . "<br>";

        $rBerekeningNaReparaties .= round($rSubtotaal2, 2) . " + ";

    }
    $html .= $rBerekening;

    $html .= '<span style="text-decoration: underline">Reparatie Totaal</span><br>';
    // het laatste plus-teken eruithalen
    $rBerekeningNaReparatiesCorrected = substr($rBerekeningNaReparaties, 0, -3);
    $html .= $rBerekeningNaReparatiesCorrected . " = <span style='font-weight:500;color:darkgreen'>" . round($rTotaalAlleReparaties_totaalKost3, 2) . "</span><br>";


    //rekenen 4 (TotaalKost/Jaar) *******************************************************************************************************
    $html .= '<br><span style="font-weight: bold">TotaalKost/Jaar = </span> De som van alle bovenstaande totalen<br>';

    $eindTotaal = $subtotaal2_totaalKost1 + $oSubtotaal3_totaalKost2 + $rTotaalAlleReparaties_totaalKost3;
    $html .= round($subtotaal2_totaalKost1, 2) . " + " . round($oSubtotaal3_totaalKost2, 2) . " + " . round($rTotaalAlleReparaties_totaalKost3, 2) . " = <span style='font-weight:500;color:darkgreen'>" . round($eindTotaal, 2) . "</span><br>";

    $html .= '</p>';
    $html .= '<br>';
    echo $html;
}

function getCalculationMessage_kost_machines_reparaties($reparatie, $machineNaam) {
    $html = '<p style="padding-bottom: 0;margin-bottom: 0">';
    $html .= '<span style="font-size: 1.2em">BEREKENING VAN DE EERSTE REPARATIE VAN "' . $machineNaam . '"</span>' .
        '<span id="closeThis" ><i class="far fa-window-close"></i></span>' .
        '<span id="bekijkGrootOfKlein" ><i class="far fa-window-maximize"></i></span>' .
        '<hr>';
    $html .= '<span style="font-weight: bold">Reparatie TotaalKost = </span> (Uren &times Uurloon) + Kost<br>';

    //rekenen **********************************************************************************************************
    $uren = $reparatie->reparatieUren;
    $uurloon = $reparatie->reparatieUurloon;
    $kost = $reparatie->reparatieKost;

    $subtotaal1 = $uren * $uurloon;
    $subtotaal2_totaalKost = $subtotaal1 + $kost;

    //html toevoegen
    $berekening = '';
    $berekening .= $uren . " &times " . $uurloon . " = " . round($subtotaal1, 2) . "<br>";
    $berekening .= round($subtotaal1, 2) . " + " . $kost . " = <span style='font-weight:500;color:darkgreen'>" . round($subtotaal2_totaalKost, 2) . "</span><br>";
    $html .= $berekening;

    $html .= '</p>';
    $html .= '<br>';
    echo $html;
}

// CALCULATION MESSAGES FOR VIEWS -------------------------------------------------------------------------------------

function getCalculationMessage_folie($stuksperpallet, $folieid) {
    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('folie_gesneden_model');
    $message = "";

    $prijsPerZakje = $CI->folie_gesneden_model->get($folieid)->prijsPerZakje;

    // berekening
    $subtotaal1 = $stuksperpallet * $prijsPerZakje;

    // message opbouwen
    $message .= '<p class="text-muted" style="margin-bottom: 10px">Berekening = Stuks/pallet &times Prijs/zak</p>';
    $message .= $stuksperpallet . " &times " . $prijsPerZakje . " = €<span class='totaal' style='font-weight: 500'>" . round($subtotaal1, 2) . "</span>";

    return $message;

}

function getCalculationMessage_grondstof_fractie($waarde, $grondstofid, $counter_grondstof) {
    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('grondstof_afgewerkt_model');
    $message = "";

    $aankoopPrijsPerFractie = $CI->grondstof_afgewerkt_model->get($grondstofid)->aankoopPrijsPerFractie;

    // berekening
    $subtotaal1 = ($waarde / 100) * $aankoopPrijsPerFractie;

    // message opbouwen
    $message .= '<span id="grondstofitem_span' . $counter_grondstof . '" class="grondstofitem_span fractieitem_span">' . $waarde . "% &times " . $aankoopPrijsPerFractie . " = €<span class='totaal' style='font-weight: 500'>" . round($subtotaal1, 2) . "</span></span>";

    return $message;
}

function getCalculationMessage_grondstof_nietfractie($waarde, $grondstofid, $counter_grondstof) {
    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('grondstof_afgewerkt_model');
    $CI->load->model('grondstof_ruw_model');
    $CI->load->model('configuratie_model');
    $message = "";


    $grondstofAfgewerkt = $CI->grondstof_afgewerkt_model->get($grondstofid);
    $grondstofRuw = $CI->grondstof_ruw_model->get($grondstofAfgewerkt->grondstofRuwId);
    $eenheid = $CI->configuratie_model->eenheid_get($grondstofRuw->eenheidId);

    $prijs = $grondstofAfgewerkt->aankoopPrijsPerFractie;

    switch (strtolower($eenheid->naam)) {
        case "ton":
            //prijs omzetten van ton naar kg
            $prijs = $prijs / 1000;
            break;
        case "kg":
            //prijs blijft hetzelfde
            break;
        default:
            break;
    }

    // berekening
    $subtotaal1 = $waarde * $prijs;

    // message opbouwen
    $message .= '<span id="grondstofitem_span' . $counter_grondstof . '" class="grondstofitem_span nietfractieitem_span">' . $waarde . " &times " . $prijs . " = €<span class='totaal' style='font-weight: 500'>" . round($subtotaal1, 2) . "</span></span>";

    return $message;
}

function getCalulationMessage_product($productId, $productieKostId) {
    // Get a reference to the controller object
    $CI = get_instance();
    $CI->load->model('product_model');
    $CI->load->model('productiekost_model');
    $CI->load->model('configuratie_model');

    $product = $CI->product_model->get($productId);
    $productieKost = $CI->productiekost_model->get($productieKostId);
    $enkeleVerpakkingsKost = $CI->configuratie_model->verpakkingskost_get($product->verpakkingsKostId)->verpakkingskost;

    // berekeningen (eindprijzen)
    $prijs_grondstoffentotaal = _berekenGrondstoffenTotaal($product);
    $prijs_verpakkingskost = _berekenVerpakkingsKost($product, $prijs_grondstoffentotaal);
    $prijs_productiekost = _berekenProductieKost($productieKost);
    $prijs_totaal = $prijs_grondstoffentotaal + $prijs_verpakkingskost + $prijs_productiekost + $enkeleVerpakkingsKost;

    // html messages
    $grondstoffentotaal = _messageGrondstoffenTotaal($product);
    $verpakkingskost = _messageVerpakkingsKost($product, $prijs_grondstoffentotaal);
    $productiekost = _messageProductieKost($productieKost);
    $totaalkost = _messageTotaalKost($prijs_grondstoffentotaal, $prijs_verpakkingskost, $prijs_productiekost, $enkeleVerpakkingsKost, $prijs_totaal);

    $message = $grondstoffentotaal . '<br/><br/>' . $verpakkingskost . '<br/><br/>' . $productiekost . '<br/><br/>' . $totaalkost;

    echo $message;
}

?>