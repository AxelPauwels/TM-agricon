<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grondstof_ruw extends CI_Controller {
    var $eenheden_dropdownOptions;
    var $grondstofCategorieen_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('grondstof_ruw_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
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

        //grondstof categorieën ophalen
        $this->load->model('grondstof_categorie_model');
        $grondstofCategorieen = $this->grondstof_categorie_model->getAll();
        $this->grondstofCategorieen_dropdownOptions = array('' => 'Selecteer...');
        foreach ($grondstofCategorieen as $grondstofCategorie) {
            $this->grondstofCategorieen_dropdownOptions[$grondstofCategorie->id] = ucwords($grondstofCategorie->naam);
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Ruwe grondstoffen beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_grondstofruw_value'] = getSessionZoeknaamvalue('grondstof_ruw'); // READ INFO IN THIS FUNCTION !!

        $data['eenheden_dropdownOptions'] = $this->eenheden_dropdownOptions;
        $data['grondstofCategorieen_dropdownOptions'] = $this->grondstofCategorieen_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('grondstof_ruw', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "grondstoffen/beheren", "grondstof_ruw/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_grondstof_ruw_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();

        $newGrondstofRuw = new stdClass();
        $newGrondstofRuw->naam = checkString(strtolower($this->input->post('grondstof_ruw_naam')));
        $newGrondstofRuw->aankoopprijs = checkFloat(floatval($this->input->post('grondstof_ruw_aankoopprijs')));
        $newGrondstofRuw->eenheidId = checkInt(intval($this->input->post('grondstof_ruw_aankoopprijs_eenheidid')));
        $newGrondstofRuw->grondstofCategorieId = checkInt(intval($this->input->post('grondstof_ruw_categorieid')));
        $newGrondstofRuw->toegevoegdDoor = $userId;
        $newGrondstofRuw->gewijzigdDoor = $userId;
        $insertedGrondstofRuwId = $this->grondstof_ruw_model->insertGrondstofRuw($newGrondstofRuw);

        if ($insertedGrondstofRuwId != 0 && $insertedGrondstofRuwId != null) {
            //vervolgens de afgewerkte grondstoffen (de fracties) toevoegen
            $aantalFracties = checkInt(intval($this->input->post('aantal_fracties'))); //aantal fractie-velden van de form
            $grondstoffen = array(); //een array maken met alle fracties
            $grondstoffenPrijzen = array(); //een array maken met alle fracties voor nadien up te daten (kan veel beter, maar last-minute toegevoegd, geen tijd om te refactor-en)
            for ($i = 1; $i <= $aantalFracties; $i++) {
                $fractieNaam = checkString(strtolower($this->input->post('grondstof_ruw_afgewerkt-fractie' . $i)));
                $fractiePercentage = checkInt(intval($this->input->post('grondstof_ruw_afgewerkt-percentage' . $i)));
                $prijs = $this->input->post('grondstof_ruw_afgewerkt-prijs' . $i);

                // enkel naar array pushen indien deze velden ingevuld zijn
                if (($fractieNaam != "" && $fractieNaam != null) && ($fractiePercentage != "" && $fractiePercentage != null) && ($prijs != "" && $prijs != null)) {
                    $grondstoffen[$fractieNaam] = $fractiePercentage; // key => value (naam => percentage)
                    array_push($grondstoffenPrijzen, $prijs); // key => value (naam => prijs)
                }
            }

            // inserten in de database en alertMessages opbouwen.
            $databaseFunctionWasSuccess_all = array(); //een array maken om alle successen en fails in op te slaan. indien deze array één "FALSE" bevat, is de message in error-stijl
            $databaseItems = ""; //zelf message opbouwen omdat de custom helper functie maar 1 titel verwacht -> "create_alert()"
            $this->load->model('grondstof_afgewerkt_model');
            $teller = 0;
            foreach ($grondstoffen as $grondstofKey_naam => $grondstofValue_percentage) {
                $newGrondstof = new stdClass();
                $newGrondstof->grondstofRuwId = $insertedGrondstofRuwId;
                $newGrondstof->naam = $grondstofKey_naam;
                $newGrondstof->fractiePercentage = $grondstofValue_percentage;
                $newGrondstof->aankoopPrijsPerFractie = $grondstoffenPrijzen[$teller]; // prijs uit array halen
                $newGrondstof->gewijzigdDoor = $userId;
                $newGrondstof->toegevoegdDoor = $userId;
                //messages opbouwen
//                e($newGrondstof);

                array_push($databaseFunctionWasSuccess_all, $this->grondstof_afgewerkt_model->insertGrondstofAfgewerkt($newGrondstof));
                $databaseItems .= 'Fractie ' . ucfirst($newGrondstof->naam) . ' met ' . $newGrondstof->fractiePercentage . "%<br>";
                $teller++;
            }
            $databaseItems .= '"' . ucfirst($newGrondstofRuw->naam) . '" ';

            $databaseFunctionWasSuccess = TRUE;
            if (in_array(false, $databaseFunctionWasSuccess_all)) {
                //indien deze array één value "FALSE" bevat, message weergeven in error-stijl
                $databaseFunctionWasSuccess = FALSE;
            }
            setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $databaseItems);
        }
        else {
            //echo error : insert ruwe grondstof
            redirect('errorIn/grondstofRuwInsert');
        }

        setOrUnset_sessionFormData('grondstof_ruw', false); // true=set, false=unset

        if (!$this->session->has_userdata('referred_from')) {
            redirect('grondstof_ruw/beheren');
        }
        else {
            redirect('grondstof/toevoegen');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();

        $updateGrondstofRuw = new stdClass();
        $updateGrondstofRuw->id = checkInt(intval($this->input->post('grondstof_ruw_id_update')));
        $updateGrondstofRuw->naam = checkString(strtolower($this->input->post('grondstof_ruw_naam_update')));
        $updateGrondstofRuw->aankoopprijs = checkFloat(floatval($this->input->post('grondstof_ruw_aankoopprijs_update')));
        $updateGrondstofRuw->eenheidId = checkInt(intval($this->input->post('grondstof_ruw_aankoopprijs_eenheid_update')));
        $updateGrondstofRuw->grondstofCategorieId = checkInt(intval($this->input->post('grondstof_ruw_categorieid_update')));
        $updateGrondstofRuw->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->grondstof_ruw_model->updateGrondstofRuw($updateGrondstofRuw);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $updateGrondstofRuw->naam);

        if (!$this->session->has_userdata('referred_from')) {
            redirect('grondstof_ruw/beheren');
        }
        else {
//            redirect('grondstof/toevoegen');
        }
    }

    public function delete() {
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('grondstof_afgewerkt_model');

        $deleteGrondstofRuw = new stdClass();
        $deleteGrondstofRuw->id = checkInt(intval($this->input->post('grondstof_ruw_id_delete')));
        $deleteGrondstofRuw->naam = checkString(strtolower($this->input->post('grondstof_ruw_naam_delete')));


        $productIds = array(); // key=>value, productId=>productieKostId

        $_grondstoffenAfgewerkt = $this->grondstof_afgewerkt_model->getAll_byGrondstofRuwId($deleteGrondstofRuw->id);

        foreach ($_grondstoffenAfgewerkt as $_grondstofAfgewerkt) {
            $_productSamenstellingen = $this->product_samenstelling_model->get_byGrondstofAfgewerktId($_grondstofAfgewerkt->id);

            foreach ($_productSamenstellingen as $_productSamenstelling) {
                // indien dit een percentage heeft, is dit totaal niet meer 100% en moet het product verwijderd worden.
                if ($_productSamenstelling->percentage != NULL) {
                    // verwijder product
                    deleteVolledigProduct($_productSamenstelling->productId);
                }
                else {
                    // verwijder samenstelling en houd productId bij om prijzen te updaten
                    $_product = $this->product_model->get($_productSamenstelling->productId);
                    $productIds[$_product->id] = $_product->productieKostId;
                    $this->product_samenstelling_model->deleteProductSamenstelling($_productSamenstelling);
                }
            }
            // grondstoffen verwijderen
            $this->grondstof_afgewerkt_model->deleteGrondstofAfgewerkt($_grondstofAfgewerkt);
        }

        // ruwe grondstoffen verwijderen
        $databaseFunctionWasSuccess = $this->grondstof_ruw_model->deleteGrondstofRuw($deleteGrondstofRuw);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $deleteGrondstofRuw->naam . " met grondstoffen ");

        //prijzen updaten
        foreach ($productIds as $productId => $productieKostId) {
            calculate_and_update_productPrijs($productId, $productieKostId);
        }

        if (!$this->session->has_userdata('referred_from')) {
            redirect('grondstof_ruw/beheren');
        }
        else {
//            redirect('grondstof/toevoegen');
        }
    }

    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            strtolower($this->input->post('naam')),
            floatval($this->input->post('aankoopprijs')),
            intval($this->input->post('aankoopprijs_eenheidid')),
            intval($this->input->post('categorieid'))
        );
        ajax_setSessionFormData("grondstof_ruw", $waardes);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_grondstof_ruw', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();

        $grondstoffenRuw = $this->grondstof_ruw_model->getByZoekfunctie($zoeknaam);
        foreach ($grondstoffenRuw as $grondstofRuw) {
            $this->load->model('configuratie_model');
            $grondstofRuw->eenheid = $this->configuratie_model->eenheid_get($grondstofRuw->eenheidId);
            $this->load->model('grondstof_categorie_model');
            $grondstofRuw->categorie = $this->grondstof_categorie_model->get($grondstofRuw->grondstofCategorieId);
            $grondstofRuw->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($grondstofRuw->gewijzigdDoor);
            $grondstofRuw->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($grondstofRuw->toegevoegdDoor);
            $grondstofRuw = getReadableDateFormats($grondstofRuw);
        }
        $data['grondstoffenRuw'] = $grondstoffenRuw;

        $data['eenheden_dropdownOptions'] = $this->eenheden_dropdownOptions;
        $data['grondstofCategorieen_dropdownOptions'] = $this->grondstofCategorieen_dropdownOptions;

        $this->load->view('ajaxcontent_grondstof_ruw_by_zoekfunctie', $data);
    }

}
