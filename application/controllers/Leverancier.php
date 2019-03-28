<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leverancier extends CI_Controller {

    var $steden_dropdownOptions;
    var $leveranciersoorten_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('leverancier_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->getDropdownOptions();
    }

    private function getDropdownOptions() {
        //steden ophalen
        $this->load->model('stadgemeente_model');
        $steden = $this->stadgemeente_model->getAll_metNA();
        $this->steden_dropdownOptions = array('' => 'Selecteer...');
        foreach ($steden as $stad) {
            $this->steden_dropdownOptions[$stad->id] = ucwords($stad->naam);
        }

        //leveranciersoorten ophalen
        $this->load->model('leverancier_soort_model');
        $leverancierSoorten = $this->leverancier_soort_model->getAll_metNA();
        $this->leveranciersoorten_dropdownOptions = array('' => 'Selecteer...');
        foreach ($leverancierSoorten as $leverancierSoort) {
            $this->leveranciersoorten_dropdownOptions[$leverancierSoort->id] = ucwords($leverancierSoort->naam);
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Leveranciers beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_leverancier_value'] = getSessionZoeknaamvalue('leverancier'); // READ INFO IN THIS FUNCTION !!
        $data['steden_dropdownOptions'] = $this->steden_dropdownOptions;
        $data['leveranciersoorten_dropdownOptions'] = $this->leveranciersoorten_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('leverancier', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // controleren of men van een "level2" navigatie komt, hier terug komt van stadgemeente, dus de "redirect_twice" unsetten van session (meer info: zie helperfunctie)
        if ($this->session->has_userdata('redirect') && $this->session->userdata('redirect_url') == 'stadgemeente/beheren') {
            setNavigationBackbuttonTwice(false, "");
        }

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "folie_ruw/beheren", "leverancier/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_leverancier_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $leverancier = new stdClass();
        $leverancier->naam = checkString(strtolower($this->input->post('leverancier_naam')));
        $leverancier->straat = checkString(strtolower($this->input->post('leverancier_straat')));
        $leverancier->huisnummer = checkString(strtolower($this->input->post('leverancier_huisnummer')));
        $leverancier->stadGemeenteId = checkInt(intval($this->input->post('leverancier_stadgemeenteid')));
        $leverancier->leverancierSoortId = checkInt(intval($this->input->post('leverancier_leveranciersoortid')));
        $leverancier->BTWnummer = checkString(strtolower($this->input->post('leverancier_btwnummer')));

        $leverancier->toegevoegdDoor = $userId;
        $leverancier->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->leverancier_model->insertLeverancier($leverancier);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $leverancier->naam);

        setOrUnset_sessionFormData('leverancier', false); // true=set, false=unset

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('leverancier/beheren/' . true);
        }
        else {
            redirect('leverancier/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $leverancier = new stdClass();
        $leverancier->id = checkInt(intval($this->input->post('leverancier_id_update')));
        $leverancier->naam = checkString(strtolower($this->input->post('leverancier_naam_update')));
        $leverancier->straat = checkString(strtolower($this->input->post('leverancier_straat_update')));
        $leverancier->huisnummer = checkString(strtolower($this->input->post('leverancier_huisnummer_update')));
        $leverancier->stadGemeenteId = checkInt(intval($this->input->post('leverancier_stadgemeenteid_update')));
        $leverancier->leverancierSoortId = checkInt(intval($this->input->post('leverancier_leveranciersoortid_update')));
        $leverancier->BTWnummer = checkString(strtolower($this->input->post('leverancier_btwnummer_update')));
        $leverancier->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->leverancier_model->updateLeverancier($leverancier);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $leverancier->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('leverancier/beheren/' . true);
        }
        else {
            redirect('leverancier/beheren');
        }
    }

    public function delete() {
        $this->load->model('folie_ruw_model');

        $leverancier = new stdClass();
        $leverancier->id = checkInt(intval($this->input->post('leverancier_id_delete')));
        $leverancier->naam = checkString(strtolower($this->input->post('leverancier_naam_delete')));

        // ruwe folies met deze leverancierId op "N/A" zetten
        $this->folie_ruw_model->updateFolieRuw_setNA_leverancierId($leverancier->id);

        // leverancier verwijderen
        $databaseFunctionWasSuccess = $this->leverancier_model->deleteLeverancier($leverancier);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $leverancier->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('leverancier/beheren/' . true);
        }
        else {
            redirect('leverancier/beheren');
        }
    }

    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            strtolower($this->input->post('naam')),
            strtolower($this->input->post('straat')),
            strtolower($this->input->post('huisnummer')),
            intval($this->input->post('stadgemeenteid')),
            intval($this->input->post('leveranciersoortid')),
            strtolower($this->input->post('btwnummer'))
        );
        ajax_setSessionFormData("leverancier", $waardes);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_leverancier', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $leveranciers = $this->leverancier_model->getByZoekfunctie($zoeknaam);
        $data['leveranciers'] = null;
        if ($leveranciers != null) {
            foreach ($leveranciers as $leverancier) {
                $leverancier->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($leverancier->gewijzigdDoor);
                $leverancier->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($leverancier->toegevoegdDoor);
                $leverancier = getReadableDateFormats($leverancier);
            }
            $data['leveranciers'] = $leveranciers;
        }

        $data['steden_dropdownOptions'] = $this->steden_dropdownOptions;
        $data['leveranciersoorten_dropdownOptions'] = $this->leveranciersoorten_dropdownOptions;

        $this->load->view('ajaxcontent_leverancier_by_zoekfunctie', $data);
    }

}
