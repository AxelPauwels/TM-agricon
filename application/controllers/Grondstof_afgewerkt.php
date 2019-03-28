<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grondstof_afgewerkt extends CI_Controller {
    var $eenheden_dropdownOptions;
    var $grondstof_categorieen_dropdownOptions;
    var $grondstofCategorieen_enkelVoorFracties_dropdownOptions;

    public function __construct() {
        parent::__construct();

        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->load->model('grondstof_afgewerkt_model');
        $this->load->model('grondstof_ruw_model');
        $this->getDropdownOptions();
    }

    private function getDropdownOptions() {
        //eenheden ophalen
        $this->load->model('configuratie_model');
        $eenheden = $this->configuratie_model->eenheid_getAll();
        $this->eenheden_dropdownOptions = array('' => 'Selecteer...');
        foreach ($eenheden as $eenheid) {
            $this->eenheden_dropdownOptions[$eenheid->id] = ucwords($eenheid->naam);
        }

        // grondstoffen categorien ophalen
        $this->load->model('grondstof_categorie_model');
        $grondstofCategorieen = $this->grondstof_categorie_model->getAll();
        $this->grondstof_categorieen_dropdownOptions = array('' => 'Selecteer...');
        foreach ($grondstofCategorieen as $grondstofCategorie) {
            $this->grondstof_categorieen_dropdownOptions[$grondstofCategorie->id] = ucwords($grondstofCategorie->naam);
        }

        // grondstoffen categorien ophalen (enkel voor fracties)
        // fracties-grondstoffen kunnen niet zomaar aangemaakt worden, maar wordt automatisch aangemaakt tijdens het inserten van een ruwe grondstof
        $grondstofCategorieen_zonderFracties = $this->grondstof_categorie_model->getAll_zonderFractieCategorie();
        $this->grondstofCategorieen_enkelVoorFracties_dropdownOptions = array('' => 'Selecteer...');
        foreach ($grondstofCategorieen_zonderFracties as $grondstofCategorie) {
            $this->grondstofCategorieen_enkelVoorFracties_dropdownOptions[$grondstofCategorie->id] = ucwords($grondstofCategorie->naam);
        }
    }

    // ******************************************************************************************************************************
    // !!! ONDERSTAANDE FUNCTIES WORDEN ALS "NORMAAL" GEBRUIKT, WANNEER DE AJAX VIEW "ajaxcontent_grondstof_afgewerkt_byGrondstofruwid" is geladen !!!
    // ******************************************************************************************************************************


    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Grondstoffen beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoekid_categorieid_value'] = getSessionZoekIdvalue('categorieid'); // READ INFO IN THIS FUNCTION !!
        $data['zoekid_grondstofruwid_value'] = getSessionZoekIdvalue('grondstofruwid'); // READ INFO IN THIS FUNCTION !!

        $data['eenheden_dropdownOptions'] = $this->eenheden_dropdownOptions;
        $data['grondstof_categorieen_dropdownOptions'] = $this->grondstof_categorieen_dropdownOptions;
        $data['grondstofCategorieen_enkelVoorFracties_dropdownOptions'] = $this->grondstofCategorieen_enkelVoorFracties_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('grondstof_afgewerkt', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "grondstof_afgewerkt/beheren", "grondstof_afgewerkt/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }
//        e($this->session->userdata());

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_grondstof_afgewerkt_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        // eerst ruwe grondstof opslaan
        $newGrondstofRuw = new stdClass();
        $newGrondstofRuw->naam = checkString(strtolower($this->input->post('grondstof_afgewerkt_naam')));
        $newGrondstofRuw->aankoopprijs = floatval($this->input->post('grondstof_afgewerkt_aankoopprijs'));
        $newGrondstofRuw->eenheidId = checkInt(intval($this->input->post('grondstof_afgewerkt_aankoopprijs_eenheidid')));
        $newGrondstofRuw->grondstofCategorieId = checkInt(intval($this->input->post('grondstof_afgewerkt_categorieid')));
        $newGrondstofRuw->toegevoegdDoor = $userId;
        $newGrondstofRuw->gewijzigdDoor = $userId;
        $this->load->model('grondstof_ruw_model');
        $insertedGrondstofRuwId = $this->grondstof_ruw_model->insertGrondstofRuw($newGrondstofRuw);


        // afgewerkte grondstof opslaan
        $newGrondstof = new stdClass();
        $newGrondstof->grondstofRuwId = $insertedGrondstofRuwId; // deze wordt bijgehouden omdat de ruwe grondstof gekoppeld is aan een categorie
        $newGrondstof->naam = checkString(strtolower($this->input->post('grondstof_afgewerkt_naam')));
        $newGrondstof->fractiePercentage = 0; // deze insert is altijd géén fractie, dus heeft ook géén percetage
        $newGrondstof->aankoopPrijsPerFractie = $this->input->post('grondstof_afgewerkt_aankoopprijs');// moet eigelijk "aankoopPrijsPerFractieOfPerGrondstof" noemen

        $newGrondstof->toegevoegdDoor = $userId;
        $newGrondstof->gewijzigdDoor = $userId;

        $this->load->model('grondstof_afgewerkt_model');

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->grondstof_afgewerkt_model->insertGrondstofAfgewerkt($newGrondstof);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $newGrondstof->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('grondstof_afgewerkt/beheren/' . true);
        }
        else {
            redirect('grondstof_afgewerkt/beheren');
        }
    }


    public function addNaamloosFractie() {
        $userId = $this->authex->getUserId();
        $grondstofRuwId = checkInt(intval($this->input->post('grondstofruwid')));

        $fractie = new stdClass();
        $fractie->grondstofRuwId = $grondstofRuwId;
        $fractie->naam = "*NIEUWE FRACTIE*";
        $fractie->fractiePercentage = 0.00;
        $fractie->aankoopPrijsPerFractie = 0.00;
        $fractie->toegevoegdDoor = $userId;
        $fractie->gewijzigdDoor = $userId;

        $this->load->model('grondstof_afgewerkt_model');
        $this->grondstof_afgewerkt_model->insertGrondstofAfgewerkt($fractie);

        echo "reload";
    }


    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            strtolower($this->input->post('naam')),
            floatval($this->input->post('aankoopprijs')),
            intval($this->input->post('aankoopprijs_eenheidid')),
            intval($this->input->post('categorieid'))
        );
        ajax_setSessionFormData("grondstof_afgewerkt", $waardes);
    }


    function ajaxGetGrondstofDropdownOptions_byCategorieId() {
        // in session opslaan welke dropdowns actief moeten zijn, indien er terug gekeerd wordt van een insert, update of delete
        // wordt in "content_grondstof_afgewerkt_beheren" in $(document).ready en ajax.complete gecheckt
        $soortId = strtolower($this->input->post('soortId'));
        $id = intval($this->input->post('id'));
        $opgebouwdeZoeknaam = $soortId . "id"; // dit is categorieid of grondstofruwid
        $this->session->set_userdata('zoekid_' . $opgebouwdeZoeknaam, $id);

        $grondstofCategorieId = $id;
        $this->load->model('grondstof_categorie_model');
        $grondstofCategorie = $this->grondstof_categorie_model->get($grondstofCategorieId);

        //kijken of deze categorie voor fracties bedoeld is of niet (om weergave van dropdowns aan te passen)
        if ($grondstofCategorie->isFractieCategorie) {
            // dropdown options -> enkel de ruwe grondstof naam tonen
            $this->load->model('grondstof_ruw_model');
            $grondstoffenRuw = $this->grondstof_ruw_model->getByGrondstofCategorieId($grondstofCategorieId);

            $data['grondstoffen'] = $grondstoffenRuw;
            $this->load->view('ajaxdropdownoptions_grondstoffen', $data);
        }
        else {
            // dropdown options -> alle afgewerkte grondstoffen namen tonen

            // alle grondstoffen_ruw ophalen die deze grondstofCategorieId hebben
            $this->load->model('grondstof_ruw_model');
            $grondstoffenRuw = $this->grondstof_ruw_model->getByGrondstofCategorieId($grondstofCategorieId);

            // grondstofRuwIds opslaan in array
            if ($grondstoffenRuw != null) {
                $grondstoffenRuwIds = array();

                foreach ($grondstoffenRuw as $grondstofRuw) {
                    array_push($grondstoffenRuwIds, $grondstofRuw->id);
                }

                // alle afgewerkte grondstoffen ophalen met deze grondstofRuwIds
                $this->load->model('grondstof_afgewerkt_model');

                $grondstoffen_afgewerkt = $this->grondstof_afgewerkt_model->getByGrondstofRuwIds($grondstoffenRuwIds);
                if ($grondstoffen_afgewerkt != null) {
                    asort($grondstoffen_afgewerkt);

                    //grondstofRuwNaam ophalen
                    foreach ($grondstoffen_afgewerkt as $grondstof_afgewerkt) {
                        $grondstof_afgewerkt->ruw = $this->grondstof_ruw_model->get($grondstof_afgewerkt->grondstofRuwId);
                    }
                    $data['grondstoffen'] = $grondstoffen_afgewerkt;
                }
                $this->load->view('ajaxdropdownoptions_grondstoffen', $data);
            }
        }
    }

    // wordt geladen in beheer/grondstoffen
    public function ajax_get_by_grondstofRuwId_of_grondstofCategorieId() {
        // "zoeknaam" instellen -  in session opslaan welke dropdowns actief moeten zijn, indien er terug gekeerd wordt van een insert, update of delete
        // wordt in "content_grondstof_afgewerkt_beheren" in document.ready en ajax.complete gecheckt
        $soortId = strtolower($this->input->post('soortId'));
        $id = intval($this->input->post('id'));
        $opgebouwdeZoeknaam = $soortId . "id"; // dit is "categorieid" of "grondstofruwid"
        $this->session->set_userdata('zoekid_' . $opgebouwdeZoeknaam, $id);

        $data['user'] = $this->authex->getUserInfo();

        if ($soortId == "categorie") {
            // id is hier "categorieId"

            $grondstoffen = [];
            // alle ruwe grondstoffen ophalen die deze categorieId hebben
            $grondstoffenRuw = $this->grondstof_ruw_model->getAll_byCategorieId($id);

            // array maken van grondstofRuwIds
            $grondstofRuwIds = [];
            if ($grondstoffenRuw) {
                foreach ($grondstoffenRuw as $item) {
                    array_push($grondstofRuwIds, $item->id);
                }

                // Alle afgewerkte grondstoffen ophalen die een grondstofRuwId heeft die voorkomt in de grondstofRuwIds-array
                $grondstoffen = $this->grondstof_afgewerkt_model->getByGrondstofRuwIds($grondstofRuwIds);
                if ($grondstoffen != null) {
                    asort($grondstoffen);
                    $this->load->model('grondstof_categorie_model');
                    foreach ($grondstoffen as $grondstof) {
                        $grondstof->ruw = $this->grondstof_ruw_model->get($grondstof->grondstofRuwId);
                        $grondstof->categorie = $this->grondstof_categorie_model->get($grondstof->ruw->grondstofCategorieId);
                        $grondstof->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($grondstof->gewijzigdDoor);
                        $grondstof->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($grondstof->toegevoegdDoor);
                        $grondstof = getReadableDateFormats($grondstof);
                    }
                }
            }

            $data['eenheden_dropdownOptions'] = $this->eenheden_dropdownOptions;
            $data['grondstof_categorieen_dropdownOptions'] = $this->grondstof_categorieen_dropdownOptions;
            $data['grondstoffenAfgewerkt'] = $grondstoffen;
            $this->load->view('ajaxcontent_grondstof_afgewerkt_nietfracties', $data);
        }
        else {
            if ($soortId == "grondstofruw") {
                // id is hier "grondstofRuwId
                $grondstoffen = $this->grondstof_afgewerkt_model->getAll_byGrondstofRuwId($id);
                if ($grondstoffen != null) {
                    asort($grondstoffen);
                    foreach ($grondstoffen as $grondstof) {
                        $grondstof->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($grondstof->gewijzigdDoor);
                        $grondstof->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($grondstof->toegevoegdDoor);
                        $grondstof = getReadableDateFormats($grondstof);
                    }
                }
                $data['totaalPrijs'] = $this->grondstof_ruw_model->get($id)->aankoopprijs;
                $data['grondstofruwid'] = $id;
                $data['grondstoffenAfgewerkt'] = $grondstoffen;
                $this->load->view('ajaxcontent_grondstof_afgewerkt_by_grondstofruwid', $data);
            }
        }
    }

    // ******************************************************************************************************************************
    // !!! ONDERSTAANDE FUNCTIES WORDEN GEBRUIKT WANNEER DE AJAX VIEW "ajaxcontent_grondstof_afgewerkt_nietfracties" is geladen !!!
    // ******************************************************************************************************************************
    public function nietfractiesupdate() {
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');
        $userId = $this->authex->getUserId();

        $grondstofAfgewerktId = checkInt(intval($this->input->post('grondstof_afgewerkt_id_update')));
        $grondstofRuwId = checkInt(intval($this->input->post('grondstof_afgewerkt_grondstofruwid_update')));
        $grondstofCategorieId = checkInt(intval($this->input->post('grondstof_afgewerkt_categorieid_update')));

        // ander gegevens ophalen
        $naam = checkString(strtolower($this->input->post('grondstof_afgewerkt_naam_update')));
        $aankoopprijs = checkFloat(floatval($this->input->post('grondstof_afgewerkt_aankoopprijs_update')));
        $eenheidId = checkInt(intval($this->input->post('grondstof_afgewerkt_aankoopprijs_eenheid_update')));

        $grondstofRuw = new stdClass();
        $grondstofAfgewerkt = new stdClass();

        $grondstofRuw->id = $grondstofRuwId;
        $grondstofRuw->naam = $naam;
        $grondstofRuw->aankoopprijs = $aankoopprijs;
        $grondstofRuw->eenheidId = $eenheidId;
        $grondstofRuw->grondstofCategorieId = $grondstofCategorieId;
        $grondstofRuw->gewijzigdDoor = $userId;

        $grondstofAfgewerkt->id = $grondstofAfgewerktId;
        $grondstofAfgewerkt->naam = $naam;
        $grondstofAfgewerkt->aankoopPrijsPerFractie = $aankoopprijs;// moet eigelijk "aankoopPrijsPerFractieOfPerGrondstof" noemen
        $grondstofAfgewerkt->gewijzigdDoor = $userId;

        $databaseFunctionWasSuccess1 = $this->grondstof_ruw_model->updateGrondstofRuw($grondstofRuw);
        $databaseFunctionWasSuccess2 = $this->grondstof_afgewerkt_model->updateGrondstofAfgewerkt($grondstofAfgewerkt);

        // prijzen updaten van producten
        $productSamenstellingen = $this->product_samenstelling_model->get_byGrondstofAfgewerktId($grondstofAfgewerkt->id);
        foreach ($productSamenstellingen as $productSamenstelling) {
            $product = $this->product_model->get($productSamenstelling->productId);
            calculate_and_update_productPrijs($product->id, $product->productieKostId);
        }

        //indien success, een alert message in session opslaan
        if ($databaseFunctionWasSuccess1 || $databaseFunctionWasSuccess2) {
            $databaseFunctionWasSuccess = true;
        }
        else {
            $databaseFunctionWasSuccess = false;
        }
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $naam);

        if (!$this->session->has_userdata('referred_from')) {
            redirect('grondstof_afgewerkt/beheren');
        }
        else {
            redirect('grondstof_afgewerkt/beheren');
        }
    }

    public function nietfractiesdelete() {
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('grondstof_afgewerkt_model');

        $userId = $this->authex->getUserId();

        $grondstofAfgewerktId = checkInt(intval($this->input->post('grondstof_afgewerkt_id_delete')));
        $grondstofRuwId = checkInt(intval($this->input->post('grondstof_afgewerkt_grondstofruwid_delete')));
        $grondstofAfgewerktNaam = checkString(strtolower($this->input->post('grondstof_afgewerkt_naam_delete')));

        $deleteGrondstofRuw = new stdClass();
        $deleteGrondstofRuw->id = $grondstofRuwId;

        $deleteGrondstofAfgewerkt = new stdClass();
        $deleteGrondstofAfgewerkt->id = $grondstofAfgewerktId;

        $_productSamenstellingen = $this->product_samenstelling_model->get_byGrondstofAfgewerktId($grondstofAfgewerktId);

        foreach ($_productSamenstellingen as $_productSamenstelling) {
            if ($_productSamenstelling->percentage != NULL) {
                // alle producten die deze grondstofAfgwerktId hebben die %-gebaseerd zijn naar "N/A" linken
                $this->product_samenstelling_model->updateProductSamenstelling_setNA_grondstofAfgewerktId($_productSamenstelling->id);
            }
            else {
                $this->product_samenstelling_model->deleteProductSamenstelling($_productSamenstelling);
            }
            // prijzen updaten
            $product = $this->product_model->get($_productSamenstelling->productId);
            calculate_and_update_productPrijs($product->id, $product->productieKostId);
        }

        $databaseFunctionWasSuccess2 = $this->grondstof_afgewerkt_model->deleteGrondstofAfgewerkt($deleteGrondstofAfgewerkt);
        $databaseFunctionWasSuccess1 = $this->grondstof_ruw_model->deleteGrondstofRuw($deleteGrondstofRuw);

        //indien success, een alert message in session opslaan
        if ($databaseFunctionWasSuccess1 && $databaseFunctionWasSuccess2) {
            $databaseFunctionWasSuccess = true;
        }
        else {
            $databaseFunctionWasSuccess = false;
        }
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', ucfirst($grondstofAfgewerktNaam));

        if (!$this->session->has_userdata('referred_from')) {
            redirect('grondstof_afgewerkt/beheren');
        }
        else {
            redirect('grondstof_afgewerkt/beheren');
        }
    }

    // ******************************************************************************************************************************
    // !!! ONDERSTAANDE FUNCTIES WORDEN GEBRUIKT VIA DE VIEW "content_grondstof_afgewerkt_by_grondstofruwid" !!!
    //     deze view word opghaald door te klikken op het eye-icon om fracties te bekijken (beheer/grondstofRuw/bestaande wijzigen)
    // ******************************************************************************************************************************

    // klik op eye-icon -> laad template "content_grondstof_afgewerkt_by_grondstofruwid"
    public function fractiesbeheren_byGrondstofRuwId($redirect = false, $grondstofRuwId = 0) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Fracties beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // indien je komt van een update of delete, krijg je de grondstofRuwId mee via parameter
        // indien je komt van een grondstof_ruw/beheren, wordt de grondstofRuwId meegegeven in een form.
        if ($grondstofRuwId == 0) {
            $grondstofRuwId = checkInt(intval($this->input->post('grondstof_ruw_id_fracties')));
        }

        $grondstoffenAfgewerkt = $this->grondstof_afgewerkt_model->getAll_byGrondstofRuwId($grondstofRuwId);
        if ($grondstoffenAfgewerkt != null) {
            asort($grondstoffenAfgewerkt);
            foreach ($grondstoffenAfgewerkt as $grondstof) {
                $grondstof->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($grondstof->gewijzigdDoor);
                $grondstof->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($grondstof->toegevoegdDoor);
                $grondstof = getReadableDateFormats($grondstof);
            }
        }

        $data['grondstoffenAfgewerkt'] = $grondstoffenAfgewerkt;
        $data['grondstofRuwNaam'] = $this->grondstof_ruw_model->get($grondstofRuwId)->naam;
        $data['totaalPrijs'] = $this->grondstof_ruw_model->get($grondstofRuwId)->aankoopprijs;
        $data['grondstofruwid'] = $grondstofRuwId;

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "grondstof_ruw/beheren", "grondstof_afgewerkt/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_grondstof_afgewerkt_by_grondstofruwid', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    // hier wordt getest van welke view je komt (dat via de form wordt meegegeven)
    // beheer/grondstofruw/bestaandewijzigen_klikEyeIconOmFractiesTeZien->view  of  beheer/grondstoffen/bestaandewijzigen_zoekViaDropdown->ajaxvieuw
    public function fractiesupdate() {
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');

        $userId = $this->authex->getUserId();
        $ids = $this->input->post('grondstof_afgewerkt_id_update[]');
        $namen = $this->input->post('grondstof_afgewerkt_naam_update[]');
        $percentages = $this->input->post('grondstof_afgewerkt_percentage_update[]');
        $prijzen = $this->input->post('grondstof_afgewerkt_prijs_update[]');
        $databaseFunctionWasSuccess = array();

        $updateGrondstofAfgewerkt = new stdClass();
        $i = 0;
        foreach ($ids as $id) {
            $updateGrondstofAfgewerkt->id = checkInt(intval($ids[$i]));
            $updateGrondstofAfgewerkt->naam = checkString(strtolower($namen[$i]));
            $updateGrondstofAfgewerkt->fractiePercentage = checkFloat(floatval($percentages[$i]));
            $updateGrondstofAfgewerkt->aankoopPrijsPerFractie = checkFloat(floatval($prijzen[$i])) == null ? 0 : checkFloat(floatval($prijzen[$i]));
            $updateGrondstofAfgewerkt->gewijzigdDoor = $userId;
            $i++;
            array_push($databaseFunctionWasSuccess, $this->grondstof_afgewerkt_model->updateGrondstofAfgewerkt($updateGrondstofAfgewerkt));

            // prijzen updaten van producten
            $productSamenstellingen = $this->product_samenstelling_model->get_byGrondstofAfgewerktId($updateGrondstofAfgewerkt->id);

            foreach ($productSamenstellingen as $productSamenstelling) {
                $product = $this->product_model->get($productSamenstelling->productId);
                calculate_and_update_productPrijs($product->id, $product->productieKostId);
            }
        }
        $grondstofruwid = $this->input->post('grondstof_afgewerkt_grondstofruwid_update');
        $data['grondstofRuwNaam'] = $this->grondstof_ruw_model->get($grondstofruwid)->naam;


        //indien alles success was, een alert message in session opslaan
        if (in_array(true, $databaseFunctionWasSuccess)) {
            setSessionAlertData(true, true, 'update', $data['grondstofRuwNaam']);
        }
        else {
            setSessionAlertData(true, false, 'update', $data['grondstofRuwNaam']);
        }

        $redirectNaarview = strtolower($this->input->post('grondstof_afgewerkt_redirectview_update'));
        if ($redirectNaarview == "content_grondstof_afgewerkt_by_grondstofruwid") {
            redirect('grondstof_afgewerkt/fractiesbeheren_byGrondstofRuwId/false/' . $grondstofruwid);
        }
        elseif ($redirectNaarview == "content_grondstof_afgewerkt_beheren") {
            redirect('grondstof_afgewerkt/beheren');
        }
    }

    // hier wordt getest van welke view je komt (dat via de form wordt meegegeven)
    // beheer/grondstofruw/bestaandewijzigen_klikEyeIconOmFractiesTeZien->view  of  beheer/grondstoffen/bestaandewijzigen_zoekViaDropdown->ajaxvieuw
    public function fractiesdelete() {
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('grondstof_afgewerkt_model');

        $grondstofAfgewerkt = new stdClass();
        $grondstofAfgewerkt->id = checkInt(intval($this->input->post('grondstof_afgewerkt_id_delete')));
        $grondstofAfgewerkt->naam = checkString(strtolower($this->input->post('grondstof_afgewerkt_naam_delete')));
        $grondstofruwid = $this->input->post('grondstof_afgewerkt_grondstofruwid_delete');
        $aantalGrondstoffen = $this->input->post('aantal_grondstoffen_delete');

        $data['grondstofRuwNaam'] = $this->grondstof_ruw_model->get($grondstofruwid)->naam;

        $_productSamenstellingen = $this->product_samenstelling_model->get_byGrondstofAfgewerktId($grondstofAfgewerkt->id);

        foreach ($_productSamenstellingen as $_productSamenstelling) {
            // alle producten die deze grondstofAfgwerktId hebben die %-gebaseerd zijn naar "N/A" linken
//            deleteVolledigProduct($_productSamenstelling->productId);
            $this->product_samenstelling_model->updateProductSamenstelling_setNA_grondstofAfgewerktId($_productSamenstelling->id);

            // prijzen updaten
            $product = $this->product_model->get($_productSamenstelling->productId);
            calculate_and_update_productPrijs($product->id, $product->productieKostId);
        }

        // ruwe grondstoffen verwijderen
        $databaseFunctionWasSuccess = $this->grondstof_afgewerkt_model->deleteGrondstofAfgewerkt($grondstofAfgewerkt);

        // indien dit de laatste afgewerkte grondstof is van een ruwe grondstof, de ruwe grondstof ook verwijderen.
        if ($aantalGrondstoffen == 1) {
            // verwijder product
            $this->grondstof_ruw_model->deleteGrondstofRuwById($grondstofruwid);
        }

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $grondstofAfgewerkt->naam);

        $redirectNaarview = strtolower($this->input->post('grondstof_afgewerkt_redirectview_delete'));

        if ($redirectNaarview == "content_grondstof_afgewerkt_by_grondstofruwid") {
            if ($aantalGrondstoffen == 1) {
                $this->session->set_userdata('zoekid_' . 'categorieid', 0);
                $this->session->set_userdata('zoekid_' . 'grondstofruwid', 0);
                redirect('grondstof_ruw/beheren');
            }
            redirect('grondstof_afgewerkt/fractiesbeheren_byGrondstofRuwId/false/' . $grondstofruwid);
        }
        elseif ($redirectNaarview == "content_grondstof_afgewerkt_beheren") {
            if ($aantalGrondstoffen == 1) {
                $this->session->set_userdata('zoekid_' . 'categorieid', 0);
                $this->session->set_userdata('zoekid_' . 'grondstofruwid', 0);
            }
            redirect('grondstof_afgewerkt/beheren');
        }
    }

}
