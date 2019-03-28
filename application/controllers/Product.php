<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    var $folies_dropdownOptions;
    var $grondstof_categorieen_dropdownOptions;
    var $grondstoffen_dropdownOptions;
    var $kost_elektriciteit_dropdownOptions;
    var $kost_gebouwen_dropdownOptions;
    var $kost_machines_dropdownOptions;
    var $kost_personeel_dropdownOptions;
    var $kost_omzet_dropdownOptions;
    var $config_verpakkingskosten_dropdownOptions;

    public function __construct() {
        parent::__construct();
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->load->model('product_model');
        $this->load->model('productiekost_model');
        $this->getDropdownOptions();
    }

    private function getDropdownOptions() {
        // folies ophalen
        $this->load->model('folie_gesneden_model');
        $this->load->model('folie_ruw_model');
        $folies = $this->folie_gesneden_model->getAll_metNA();
        $this->folies_dropdownOptions = array('' => 'Selecteer...', '-1' => 'Geen folie');
        foreach ($folies as $folie) {
            $micron = $this->folie_ruw_model->get($folie->folieRuwId)->micronDikte;
            $this->folies_dropdownOptions[$folie->id] = ucwords($folie->naam) . ' - micron ' . $micron . ' (' . round($folie->lengteAfslag, 2) . ' &times; ' . round($folie->breedte) . ')';
        }

        // grondstoffen categorien ophalen
        $this->load->model('grondstof_categorie_model');
        $grondstofCategorieen = $this->grondstof_categorie_model->getAll();
        $this->grondstof_categorieen_dropdownOptions = array('' => 'Selecteer...');
        foreach ($grondstofCategorieen as $grondstofCategorie) {
            $this->grondstof_categorieen_dropdownOptions[$grondstofCategorie->id] = ucwords($grondstofCategorie->naam);
        }

        // kosten elektriciteit ophalen
        $this->load->model('kost_elektriciteit_model');
        $elektriciteiten = $this->kost_elektriciteit_model->getAll();
        $this->kost_elektriciteit_dropdownOptions = array('' => 'Selecteer...');
        foreach ($elektriciteiten as $elektriciteit) {
            $this->kost_elektriciteit_dropdownOptions[$elektriciteit->id] = ucwords($elektriciteit->naam) . ' - €' . $elektriciteit->elektriciteitKostPerJaar . "/jaar";
        }

        // kosten gebouwen ophalen
        $this->load->model('kost_gebouwen_model');
        $gebouwen = $this->kost_gebouwen_model->getAll();
        $this->kost_gebouwen_dropdownOptions = array('alles' => 'Alle gebouwen (dit selecteert alles)');
        $_kost_gebouwen_dropdownOptions_totaal = 0;

        foreach ($gebouwen as $gebouw) {
            $this->kost_gebouwen_dropdownOptions[$gebouw->id] = ucwords($gebouw->naam) . ' - € ' . $gebouw->gebouwKostPerJaar . "/jaar";
            $_kost_gebouwen_dropdownOptions_totaal += $gebouw->gebouwKostPerJaar;
        }
        $this->kost_gebouwen_dropdownOptions['alles'] = 'Alle gebouwen - €' . $_kost_gebouwen_dropdownOptions_totaal . "/jaar";


        // kosten machines ophalen
        $this->load->model('kost_machines_model');
        $machines = $this->kost_machines_model->getAll();
        $this->kost_machines_dropdownOptions = array('alles' => 'Alle machines (dit selecteert alles)');
        $_kost_machines_dropdownOptions_totaal = 0;
        foreach ($machines as $machine) {
            $this->kost_machines_dropdownOptions[$machine->id] = ucwords($machine->naam) . ' - € ' . $machine->totaalMachineKostPerJaar . "/jaar";
            $_kost_machines_dropdownOptions_totaal += $machine->totaalMachineKostPerJaar;
        }
        $this->kost_machines_dropdownOptions['alles'] = 'Alle machines - €' . $_kost_machines_dropdownOptions_totaal . "/jaar";

        // kosten personeel ophalen
        $this->load->model('kost_personeel_model');
        $personelen = $this->kost_personeel_model->getAll();
        $this->kost_personeel_dropdownOptions = array('' => 'Selecteer...');
        foreach ($personelen as $personeel) {
            $this->kost_personeel_dropdownOptions[$personeel->id] = ucwords($personeel->naam) . ' - € ' . $personeel->personeelKostPerJaar . "/jaar";
        }

        // geschatte omzet uit configuratie ophalen
        $this->load->model('configuratie_model');
        $omzetten = $this->configuratie_model->omzet_getAll();
        $this->kost_omzet_dropdownOptions = array('' => 'Selecteer...');
        foreach ($omzetten as $omzet) {
            $this->kost_omzet_dropdownOptions[$omzet->id] = ucwords($omzet->naam) . ' - ' . round($omzet->aantalZakjesPerJaar) . " zakjes/jaar (" . $omzet->zakjesPerDag . " zakjes/dag &times; " . $omzet->dagenPerJaar . " dagen/jaar)";
        }

        // verpakkingskosten uit configuratie ophalen
        $verpakkingskosten = $this->configuratie_model->verpakkingskost_getAll();
        $this->config_verpakkingskosten_dropdownOptions = array('' => 'Selecteer...');
        foreach ($verpakkingskosten as $verpakkingskost) {
            $this->config_verpakkingskosten_dropdownOptions[$verpakkingskost->id] = $verpakkingskost->verpakkingskost;
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Producten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_product_value'] = getSessionZoeknaamvalue('product'); // READ INFO IN THIS FUNCTION !!
        $data['folies_dropdownOptions'] = $this->folies_dropdownOptions;
        $data['grondstof_categorieen_dropdownOptions'] = $this->grondstof_categorieen_dropdownOptions;
        $data['grondstoffen_dropdownOptions'] = $this->grondstoffen_dropdownOptions;
        $data['kost_elektriciteit_dropdownOptions'] = $this->kost_elektriciteit_dropdownOptions;
        $data['kost_gebouwen_dropdownOptions'] = $this->kost_gebouwen_dropdownOptions;
        $data['kost_machines_dropdownOptions'] = $this->kost_machines_dropdownOptions;
        $data['kost_personeel_dropdownOptions'] = $this->kost_personeel_dropdownOptions;
        $data['kost_omzet_dropdownOptions'] = $this->kost_omzet_dropdownOptions;
        $data['config_verpakkingskost_dropdownOptions'] = $this->config_verpakkingskosten_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('product', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "product/beheren", "product/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_product_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    private function _insertProductiekost($userId) {
        $productieKost = new stdClass();
        $productieKost->electriciteitKostId = ($this->input->post('product_kost_elektriciteitid') == NULL) ? '-1' : $this->input->post('product_kost_elektriciteitid');
        $productieKost->personeelKostId = ($this->input->post('product_kost_personeelid') == NULL) ? '-1' : $this->input->post('product_kost_personeelid');
        $productieKost->omzetid = ($this->input->post('product_kost_omzetid') == NULL) ? '-1' : $this->input->post('product_kost_omzetid');
        $productieKost->toegevoegdDoor = $userId;
        $productieKost->gewijzigdDoor = $userId;

        $insertedProductieKostId = $this->productiekost_model->insertProductiekost($productieKost);
        return $insertedProductieKostId;
    }

    private function _insertProductiekost_samenstellingen($userId, $insertedProductieKostId) {
        $all_dbSuccess = array();

        // productiekost samenstellingen ophalen
        $gebouwenKostIds = ($this->input->post('product_kost_gebouwenid[]') == NULL) ? array("-1") : $this->input->post('product_kost_gebouwenid[]'); // indien "-1" alle kosten gebruiken
        if ($gebouwenKostIds[0] == "alles") {
            $this->load->model('kost_gebouwen_model');
            $gebouwenKostIds = $this->kost_gebouwen_model->getAllids();
        }

        $machineKostIds = ($this->input->post('product_kost_machinesid[]') == NULL) ? array("-1") : $this->input->post('product_kost_machinesid[]'); // indien "-1" alle kosten gebruiken
        if ($machineKostIds[0] == "alles") {
            $this->load->model('kost_machines_model');
            $machineKostIds = $this->kost_machines_model->getAllids();
        }

        // productiekost samenstellingen opslaan
        $this->load->model('kost_samenstelling_gebouwen_model');
        foreach ($gebouwenKostIds as $id) {
            $samenstelling_gebouwen = new stdClass();
            $samenstelling_gebouwen->productieKostId = $insertedProductieKostId;
            $samenstelling_gebouwen->kostGebouwenId = $id;
            $samenstelling_gebouwen->toegevoegdDoor = $userId;
            $samenstelling_gebouwen->gewijzigdDoor = $userId;
            $success = $this->kost_samenstelling_gebouwen_model->insertKostGebouwen($samenstelling_gebouwen);
            array_push($all_dbSuccess, $success);
        }

        $this->load->model('kost_samenstelling_machines_model');
        foreach ($machineKostIds as $id) {
            $samenstelling_machines = new stdClass();
            $samenstelling_machines->productieKostId = $insertedProductieKostId;
            $samenstelling_machines->kostMachinesId = $id;
            $samenstelling_machines->toegevoegdDoor = $userId;
            $samenstelling_machines->gewijzigdDoor = $userId;
            $success = $this->kost_samenstelling_machines_model->insertKostmachines($samenstelling_machines);
            array_push($all_dbSuccess, $success);
        }

        // indien allemaal success, treu returnen, anders false
        if (in_array(false, $all_dbSuccess)) {
            return false;
        }
        else {
            return true;
        }
    }

    private function _insertProduct($userId, $insertedProductieKostId) {
        $product = new stdClass();
        $product->artikelCode = checkString(strtoupper($this->input->post('product_artikelcode')));
        $product->beschrijving = checkString(ucwords($this->input->post('product_beschrijving')));
        $product->stuksPerPallet = checkInt(intval($this->input->post('product_stuksperpallet')));
        $product->inhoudPerZak = checkFloat(floatval($this->input->post('product_inhoudperzak')));
        $product->folieId = checkInt(intval($this->input->post('product_folieid')));
        $product->verpakkingsKostId = checkInt(intval($this->input->post('product_verpakkingskostid')));

        $product->productieKostId = $insertedProductieKostId;
        $product->toegevoegdDoor = $userId;
        $product->gewijzigdDoor = $userId;
        $insertedProductId = $this->product_model->insertProduct($product);
        return $insertedProductId;
    }

    private function _insertProduct_samenstellingen($userId, $insertedProductId) {
        $all_dbSuccess = array();
        $grondstofids = json_decode($this->input->post('product_samenstelling_grondstoffen'));
        $waardes = json_decode($this->input->post('product_samenstelling_waardes'));
        $waardesoorten = json_decode($this->input->post('product_samenstelling_waardesoorten'));

        $this->load->model('product_samenstelling_model');

        $i = 0;
        foreach ($grondstofids as $grondstof) {
            $product_samenstelling = new stdClass();
            $product_samenstelling->productId = $insertedProductId;
            $product_samenstelling->grondstofAfgewerktId = $grondstofids[$i];

            if ($waardesoorten[$i] == "%") {
                $product_samenstelling->percentage = $waardes[$i];
            }
            else {
                $product_samenstelling->gewicht = $waardes[$i];
            }
            $product_samenstelling->toegevoegdDoor = $userId;
            $product_samenstelling->gewijzigdDoor = $userId;
            $success = $this->product_samenstelling_model->insertProductSamenstelling($product_samenstelling);

            array_push($all_dbSuccess, $success);
            $i++;
        }

        // indien allemaal success, treu returnen, anders false
        if (in_array(false, $all_dbSuccess)) {
            return false;
        }
        else {
            return true;
        }
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $all_dbIsSuccess = array(); // success van database inserts bijhouden voor melding voor gebruiker

        // PRODUCTIEKOST
        $insertedProductieKostId = $this->_insertProductiekost($userId);
        if (is_nan($insertedProductieKostId) || !$insertedProductieKostId > 0) {
            $insertedProductieKostId = "-1";
            array_push($all_dbIsSuccess, false);
        }

        // PRODUCTIEKOST SAMENSTELLINGEN
        $dbIsSuccess_productieKostSamenstelling = $this->_insertProductiekost_samenstellingen($userId, $insertedProductieKostId);
        array_push($all_dbIsSuccess, $dbIsSuccess_productieKostSamenstelling);

        // PRODUCT
        $insertedProductId = $this->_insertProduct($userId, $insertedProductieKostId);
        if (is_nan($insertedProductId) || !$insertedProductId > 0) {
            $insertedProductId = "-1";
            array_push($all_dbIsSuccess, false);
        }

        // PRODUCT SAMENSTELLINGEN
        $dbIsSuccess_productSamenstelling = $this->_insertProduct_samenstellingen($userId, $insertedProductId);
        array_push($all_dbIsSuccess, $dbIsSuccess_productSamenstelling);

        calculate_and_update_productPrijs($insertedProductId, $insertedProductieKostId);

        // DB SUCCESS CONTROLEREN EN MESSAGE OPBOUWEN
        $artikelCode = $this->input->post('product_artikelcode');
        $beschrijving = $this->input->post('product_beschrijving');

        $databaseFunctionWasSuccess = true;
        if (in_array(false, $all_dbIsSuccess)) {
            $databaseFunctionWasSuccess = false;
        }
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $artikelCode . ' - ' . $beschrijving);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('product/beheren/' . true);
        }
        else {
            redirect('product/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();

        $product = new stdClass();
        $product->id = intval($this->input->post('product_id_update'));
        $naam = $this->input->post('product_naam_update'); // enkel voor messages voor gebruiker
        $product->artikelCode = checkString(strtoupper($this->input->post('product_artikelcode_update')));
        $product->beschrijving = checkString(ucwords(strtolower($this->input->post('product_beschrijving_update'))));
        $product->stuksPerPallet = checkInt(intval($this->input->post('product_stuksperpallet_update')));
        $product->inhoudPerZak = checkFloat(floatval($this->input->post('product_inhoudperzak_update')));
        $product->folieId = checkInt(intval($this->input->post('product_folieid_update')));
        $product->verpakkingsKostId = checkInt(intval($this->input->post('product_verpakkingskostid_update')));
        $product->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->product_model->updateProduct($product);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $naam);

        $productieKostId = $this->product_model->get($product->id)->productieKostId;
        calculate_and_update_productPrijs($product->id, $productieKostId);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('product/beheren/' . true);
        }
        else {
            redirect('product/beheren');
        }
    }

    public function delete() {
        $this->load->model('product_samenstelling_model');
        $product = new stdClass();
        $product->id = intval($this->input->post('product_id_delete'));
        $naam = $this->input->post('product_naam_delete'); // enkel voor messages voor gebruiker

        $databaseFunctionWasSuccess = deleteVolledigProduct($product->id);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('product/beheren/' . true);
        }
        else {
            redirect('product/beheren');
        }
    }

    // AJAX --------------------------------------------------------------------------------------------------------
    public function ajax_save_to_session() {
        $waardes = array(
            strtolower($this->input->post('naam')),
            strtolower($this->input->post('artikelcode')),
            strtolower($this->input->post('beschrijving')),
            intval($this->input->post('stuksperpallet')),
            floatval($this->input->post('inhoudperzak')),
            intval($this->input->post('folieid'))
        );
        ajax_setSessionFormData("product", $waardes);
    }

    function ajax_getCalulationMessage_product() {
        $productid = $this->input->post('productid');
        $productiekostid = $this->input->post('productiekostid');
        return getCalulationMessage_product($productid, $productiekostid);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_product', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $producten = $this->product_model->getByZoekfunctie($zoeknaam, "artikelCode");
        $data['producten'] = null;
        if ($producten != null) {
            foreach ($producten as $product) {
                $product->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($product->gewijzigdDoor);
                $product->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($product->toegevoegdDoor);
                $product = getReadableDateFormats($product);
            }
            $data['producten'] = $producten;
        }

        $data['folies_dropdownOptions'] = $this->folies_dropdownOptions;
        $data['config_verpakkingskost_dropdownOptions'] = $this->config_verpakkingskosten_dropdownOptions;

        $this->load->view('ajaxcontent_product_by_zoekfunctie', $data);
    }

    function ajaxGetGrondstofDropdownOptions_byCategorieId() {
        $grondstofCategorieId = $this->input->get('grondstofCategorieId');

        // alle grondstoffen_ruw ophalen die deze grondstofCategorieId hebben
        $this->load->model('grondstof_ruw_model');
        $grondstoffenRuw = $this->grondstof_ruw_model->getByGrondstofCategorieId($grondstofCategorieId);

        // grondstofRuwIds opslaan in array (om afgewerkte grondstoffen op te halen)
        if ($grondstoffenRuw != null) {
            $grondstoffenRuwIds = array();
            foreach ($grondstoffenRuw as $grondstofRuw) {
                array_push($grondstoffenRuwIds, $grondstofRuw->id);
            }

            // alle afgewerkte grondstoffen ophalen met deze grondstofRuwIds
            $this->load->model('grondstof_afgewerkt_model');
            $grondstoffen_afgewerkt = $this->grondstof_afgewerkt_model->getByGrondstofRuwIds($grondstoffenRuwIds);

            if ($grondstoffen_afgewerkt != null) {
                $this->load->model('grondstof_categorie_model');

                //grondstofRuw_naam en categorie_isFractieCategorie ophalen (om in "ajaxdropdownoptions_grondstoffen" de juiste dropdown-option-text te maken)
                foreach ($grondstoffen_afgewerkt as $grondstof_afgewerkt) {
                    // grondstofRuwNaam ophalen
                    $grondstof_afgewerkt->ruwNaam = $this->grondstof_ruw_model->get($grondstof_afgewerkt->grondstofRuwId)->naam;
                    // categorieIsFractie ophalen
                    $categorieId = $this->grondstof_ruw_model->get($grondstof_afgewerkt->grondstofRuwId)->grondstofCategorieId;
                    $grondstof_afgewerkt->isFractieCategorie = $this->grondstof_categorie_model->get($categorieId)->isFractieCategorie;
                }

                // sorteren op grondstof-ruwnaam, of op grondstof-naam voor isFractieCategorie
                if (intval($grondstoffen_afgewerkt[0]->isFractieCategorie) == false) {
                    usort($grondstoffen_afgewerkt, array($this, "custom_cmp"));
                }
                else {
                    usort($grondstoffen_afgewerkt, array($this, "custom_cmp2"));
                }
                $data['grondstoffen_voor_product'] = $grondstoffen_afgewerkt;
            }
        }
        $this->load->view('ajaxdropdownoptions_grondstoffen', $data);
    }

    private function custom_cmp($a, $b) {
        return strcmp(strtolower($a->naam), strtolower($b->naam));
    }

    private function custom_cmp2($a, $b) {
        // eerst kijken naar "naam"
        $aNaam = $a->ruwNaam;
        $bNaam = $b->ruwNaam;
        $returnData = strcmp(strtolower($aNaam), strtolower($bNaam));

        // dan kijken naar het 1ste "getal" dat voor het streepje staat
        $aArray = explode("-", $a->naam);
        $aFirst = $aArray[0];
        $bArray = explode("-", $b->naam);
        $bFirst = $bArray[0];
        $aGetal1 = intval($aFirst);
        $bGetal1 = intval($bFirst);
        $returnData2 = $this->intcmp($aGetal1, $bGetal1);

        // dan kijken naar het 2de "getal" dat voor het streepje staat
        $aStringLength = strlen(strtolower($a->naam));
        $bStringLength = strlen(strtolower($b->naam));

        $returnData3 = strcmp($aStringLength, $bStringLength);
        return $returnData + $returnData2 + $returnData3;
    }

    function intcmp($a, $b) {
        return ($a - $b) ? ($a - $b) / abs($a - $b) : 0;
    }

    function ajaxGetFoliePrijs() {
        $folieid = $this->input->get('folieid');

        $this->load->model('folie_gesneden_model');
        $folie = $this->folie_gesneden_model->get($folieid);

        if ($folieid > 0) {
            echo $folie->prijsPerZakje;
        }
        else {
            echo 0;
        }
    }

    function ajax_getGrondstoffen() {
        $productId = $this->input->post('productid');
        $productNaam = $this->input->post('productnaam');
        redirect('product/product_grondstoffenBeheren/' . $productId . '/' . $productNaam);
    }

    // PRODUCT_GRONDSTOFFEN ***************************************************************************************
    public function product_grondstoffenBeheren($productId, $productNaam) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Grondstoffen';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $product = $this->product_model->get($productId);
        $productieKost = $this->productiekost_model->get($product->productieKostId);

        $data['productNaam'] = ucwords($product->artikelCode) . ' - ' . ucwords($product->beschrijving);
        $data['productId'] = $product->id;
        $data['productieKostId'] = $product->productieKostId;
        $data['productieKostPrijs'] = $productieKost->productieKostPerJaar;

        $this->load->model('product_samenstelling_model');
        $this->load->model('grondstof_afgewerkt_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('grondstof_categorie_model');

        $productSamenstellingen = $this->product_samenstelling_model->getByProductId($productId);

        foreach ($productSamenstellingen as $samenstelling) {
            $samenstelling->grondstof = $this->grondstof_afgewerkt_model->get($samenstelling->grondstofAfgewerktId);

            $samenstelling->grondstofRuw = $this->grondstof_ruw_model->get($samenstelling->grondstof->grondstofRuwId);
            $samenstelling->grondstofCategorie = $this->grondstof_categorie_model->get($samenstelling->grondstofRuw->grondstofCategorieId);

            $samenstelling->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($samenstelling->gewijzigdDoor);
            $samenstelling->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($samenstelling->toegevoegdDoor);
            $samenstelling = getReadableDateFormats($samenstelling);
        }
        $data['samenstellingen'] = $productSamenstellingen;

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton(true, "product/beheren", "product/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_product_beheren_grondstoffen', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function update_grondstoffen() {
        $userId = $this->authex->getUserId();
        $this->load->model('product_samenstelling_model');
        $this->load->model('productiekost_model');

        $productId = $this->input->post('product_id_update[]');
        $samenstellingIds = $this->input->post('samenstelling_id_update[]');
        $percentages = $this->input->post('samenstelling_percentage_update[]');
        $gewichten = $this->input->post('samenstelling_gewicht_update[]');

        $dbsuccesses = array();

        $i = 0;
        foreach ($samenstellingIds as $item) {
            // vervang lege strings door "NULL" (kan beter met een array_map function)
            if ($gewichten[$i] == '') {
                $gewichten[$i] = NULL;
            }
            if ($percentages[$i] == '') {
                $percentages[$i] = NULL;
            }
            $samenstelling = new stdClass();
            $samenstelling->id = $samenstellingIds[$i];
            $samenstelling->percentage = $percentages[$i];
            $samenstelling->gewicht = $gewichten[$i];
            $samenstelling->gewijzigdDoor = $userId;
            $dbsuccess = $this->product_samenstelling_model->updateProductSamenstelling($samenstelling);
            array_push($dbsuccesses, $dbsuccess);
            $i++;
        }

        // prijzen updaten
        $product = $this->product_model->get($productId);
        calculate_and_update_productPrijs($productId, $product->productieKostId);
        $productNaam = ucwords($product->artikelCode) . ' - ' . ucwords($product->beschrijving);

        $databaseFunctionWasSuccess = false;
        if (in_array("true", $dbsuccesses)) {
            $databaseFunctionWasSuccess = true;
        }

        // indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', 'Samenstelling van ' . $productNaam);
        redirect('product/product_grondstoffenBeheren/' . $productId . '/' . $productNaam);
    }

    public function delete_grondstoffen() {
        $samenstelling = new stdClass();
        $samenstelling->id = intval($this->input->post('samenstelling_id_delete'));
        $percentageOfGewicht = $this->input->post('percentageOfGewicht_delete');
        $this->load->model('product_samenstelling_model');

        $productId = intval($this->input->post('product_id_delete'));
        $productNaam = $this->input->post('productnaam_delete');

        // indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->product_samenstelling_model->deleteProductSamenstelling($samenstelling);

        // prijzen updaten (hoeft niet bij percentages omdat dit reeds gedaan werdt bij het wijzigen)
        if ($percentageOfGewicht == "gewicht") {
            $product = $this->product_model->get($productId);
            calculate_and_update_productPrijs($productId, $product->productieKostId);
        }

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', 'Samenstelling van ' . $productNaam);
        redirect('product/product_grondstoffenBeheren/' . $productId . '/' . $productNaam);
    }


    // PRODUCT_PRODUCTIEKOSTEN ***************************************************************************************
    public function product_productiekostenBeheren($productId, $productNaam) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Productiekosten';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['kost_elektriciteit_dropdownOptions'] = $this->kost_elektriciteit_dropdownOptions;
        $data['kost_gebouwen_dropdownOptions'] = $this->kost_gebouwen_dropdownOptions;
        $data['kost_machines_dropdownOptions'] = $this->kost_machines_dropdownOptions;
        $data['kost_personeel_dropdownOptions'] = $this->kost_personeel_dropdownOptions;
        $data['kost_omzet_dropdownOptions'] = $this->kost_omzet_dropdownOptions;
        $data['config_verpakkingskost_dropdownOptions'] = $this->config_verpakkingskosten_dropdownOptions;

        $product = $this->product_model->get($productId);
        $productieKost = $this->productiekost_model->get($product->productieKostId);

        $data['productNaam'] = urldecode($productNaam);
        $data['productId'] = $product->id;
        $data['productieKostId'] = $product->productieKostId;
        $data['productieKostPrijs'] = $productieKost->productieKostPerJaar;

        $this->load->model('kost_elektriciteit_model');
        $this->load->model('kost_personeel_model');
        $this->load->model('kost_samenstelling_gebouwen_model');
        $this->load->model('kost_samenstelling_machines_model');
        $this->load->model('kost_gebouwen_model');
        $this->load->model('kost_machines_model');

        // properties opvullen
        $productieKost->elektriciteit = $this->kost_elektriciteit_model->get($productieKost->electriciteitKostId);
        $productieKost->personeel = $this->kost_personeel_model->get($productieKost->personeelKostId);
        $productieKost->gebouwenSamenstellingen = $this->kost_samenstelling_gebouwen_model->getByProductieKostId($productieKost->id);
        $productieKost->machinesSamenstellingen = $this->kost_samenstelling_machines_model->getByProductieKostId($productieKost->id);

        // datums opvullen met usernaam en readableformat
        $productieKost->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($productieKost->gewijzigdDoor);
        $productieKost->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($productieKost->toegevoegdDoor);
        $productieKost = getReadableDateFormats($productieKost);

        $selectedGebouwenValues = array();
        $selectedMachinesValues = array();

        // properties opvullen
        foreach ($productieKost->gebouwenSamenstellingen as $samenstelling) {
            $samenstelling->gebouw = $this->kost_gebouwen_model->get($samenstelling->kostGebouwenId);
            array_push($selectedGebouwenValues, $samenstelling->kostGebouwenId);
        }
        foreach ($productieKost->machinesSamenstellingen as $samenstelling) {
            $samenstelling->machine = $this->kost_machines_model->get($samenstelling->kostMachinesId);
            array_push($selectedMachinesValues, $samenstelling->kostMachinesId);
        }

        $data['productieKost'] = $productieKost;
        $data['selectedGebouwenValues'] = $selectedGebouwenValues;
        $data['selectedMachinesValues'] = $selectedMachinesValues;

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton(true, "product/beheren", "product/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_product_beheren_productiekosten', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function update_productiekosten() {
        $userId = $this->authex->getUserId();
        $productId = $this->input->post('productid');
        $productieKostId = $this->input->post('productiekostid');
        $naam = $this->input->post('productnaam'); // enkel voor messages voor gebruiker

        $productiekost = new stdClass();
        $productiekost->id = $productieKostId;
        $productiekost->omzetId = $this->input->post('product_kost_omzetid');
        $productiekost->electriciteitKostId = $this->input->post('product_kost_elektriciteitid');
        $productiekost->personeelKostId = $this->input->post('product_kost_personeelid');
        $this->productiekost_model->updateProductieKost($productiekost);

        $all_dbSuccess = array();

        // productiekost samenstellingen ophalen
        $gebouwenKostIds = ($this->input->post('product_kost_gebouwenid[]') == NULL) ? array("-1") : $this->input->post('product_kost_gebouwenid[]'); // indien "-1" alle kosten gebruiken
        if ($gebouwenKostIds[0] == "alles") {
            $this->load->model('kost_gebouwen_model');
            $gebouwenKostIds = $this->kost_gebouwen_model->getAllids();
        }

        $machineKostIds = ($this->input->post('product_kost_machinesid[]') == NULL) ? array("-1") : $this->input->post('product_kost_machinesid[]'); // indien "-1" alle kosten gebruiken
        if ($machineKostIds[0] == "alles") {
            $this->load->model('kost_machines_model');
            $machineKostIds = $this->kost_machines_model->getAllids();
        }

        $this->load->model('kost_samenstelling_gebouwen_model');
        $this->kost_samenstelling_gebouwen_model->deleteAll_byProductieKostId($productieKostId);  // alle vorige samenstellingen verwijderen
        foreach ($gebouwenKostIds as $id) {
            $samenstelling_gebouwen = new stdClass();
            $samenstelling_gebouwen->productieKostId = $productieKostId;
            $samenstelling_gebouwen->kostGebouwenId = $id;
            $samenstelling_gebouwen->toegevoegdDoor = $userId;
            $samenstelling_gebouwen->gewijzigdDoor = $userId;
            $success = $this->kost_samenstelling_gebouwen_model->insertKostGebouwen($samenstelling_gebouwen);
            array_push($all_dbSuccess, $success);
        }

        $this->load->model('kost_samenstelling_machines_model');
        $this->kost_samenstelling_machines_model->deleteAll_byProductieKostId($productieKostId); // alle vorige samenstellingen verwijderen
        foreach ($machineKostIds as $id) {
            $samenstelling_machines = new stdClass();
            $samenstelling_machines->productieKostId = $productieKostId;
            $samenstelling_machines->kostMachinesId = $id;
            $samenstelling_machines->toegevoegdDoor = $userId;
            $samenstelling_machines->gewijzigdDoor = $userId;
            $success = $this->kost_samenstelling_machines_model->insertKostmachines($samenstelling_machines);
            array_push($all_dbSuccess, $success);
        }

        // indien allemaal success, treu returnen, anders false
        if (in_array(false, $all_dbSuccess)) {
            $databaseFunctionWasSuccess = false;
        }
        else {
            $databaseFunctionWasSuccess = true;
        }
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $naam);

        calculate_and_update_productPrijs($productId, $productieKostId);

        redirect('product/product_productiekostenBeheren/' . $productieKostId . '/' . $naam);
    }

    // AJAX CALCULATION MESSAGES
    function ajaxGetCalculation_folie() {
        $stuksperpallet = $this->input->get('stuksperpallet');
        $folieid = $this->input->get('folieid');
        $message = getCalculationMessage_folie($stuksperpallet, $folieid);
        if ($folieid > 0) {
            echo $message;
        }
        else {
            echo "";
        }
    }

    function ajaxGetCalculation_grondstof_fractie() {
        $waarde = $this->input->post('waarde');
        $grondstofid = $this->input->post('grondstofid');
        $counter_grondstof = $this->input->post('counter_grondstof');

        $message = getCalculationMessage_grondstof_fractie($waarde, $grondstofid, $counter_grondstof);

        if ($grondstofid > 0) {
            echo $message;
        }
        else {
            echo "";
        }
    }

    function ajaxGetCalculation_grondstof_nietfractie() {
        $waarde = $this->input->post('waarde');
        $grondstofid = $this->input->post('grondstofid');
        $counter_grondstof = $this->input->post('counter_grondstof');

        $message = getCalculationMessage_grondstof_nietfractie($waarde, $grondstofid, $counter_grondstof);

        if ($grondstofid > 0) {
            echo $message;
        }
        else {
            echo "";
        }
    }


}
