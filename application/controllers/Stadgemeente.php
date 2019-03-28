<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stadgemeente extends CI_Controller {
    var $landen_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('stadgemeente_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->getDropdownOptions();
    }

    private function getDropdownOptions() {
        //landen ophalen
        $this->load->model('land_model');
        $landen = $this->land_model->getAll();
        $this->landen_dropdownOptions = array('' => 'Selecteer...');
        foreach ($landen as $land) {
            $this->landen_dropdownOptions[$land->id] = ucwords($land->naam);
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Steden/gemeenten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_stadgemeente_value'] = getSessionZoeknaamvalue('stadgemeente'); // READ INFO IN THIS FUNCTION !!
        $data['landen_dropdownOptions'] = $this->landen_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('stadgemeente', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect,"leverancier/beheren","stadgemeente/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        // controleren of men van een "level1" navigatie komt (hier leverancier, meer info: zie helperfunctie)
        if($this->session->has_userdata('redirect') && $this->session->userdata('redirect_url') =='leverancier/beheren'){
            setNavigationBackbuttonTwice(true,"leverancier/beheren");
        }
        if($this->session->has_userdata('redirect_url_twice')){
            $data['show_back_button_twice'] = true;
            $data['redirect_url_twice'] = site_url($this->session->userdata('redirect_url_twice'));
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_stadgemeente_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $stadGemeente = new stdClass();
        $stadGemeente->naam = checkString(strtolower($this->input->post('stadgemeente_naam')));
        $stadGemeente->postcode = checkString($this->input->post('stadgemeente_postcode'));
        $stadGemeente->landId = checkInt(intval($this->input->post('stadgemeente_landid')));
        $stadGemeente->toegevoegdDoor = $userId;
        $stadGemeente->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->stadgemeente_model->insertStadGemeente($stadGemeente);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $stadGemeente->naam);

        setOrUnset_sessionFormData('stadgemeente', false); // true=set, false=unset

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('stadgemeente/beheren/' . true);
        }
        else {
            redirect('stadgemeente/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $stadGemeente = new stdClass();
        $stadGemeente->id = checkInt(intval($this->input->post('stadgemeente_id_update')));
        $stadGemeente->naam = checkString(strtolower($this->input->post('stadgemeente_naam_update')));
        $stadGemeente->postcode = checkString($this->input->post('stadgemeente_postcode_update'));
        $stadGemeente->landId = checkInt(intval($this->input->post('stadgemeente_landid_update')));
        $stadGemeente->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->stadgemeente_model->updateStadGemeente($stadGemeente);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $stadGemeente->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('stadgemeente/beheren/' . true);
        }
        else {
            redirect('stadgemeente/beheren');
        }
    }

    public function delete() {
        $this->load->model('leverancier_model');

        $stadGemeente = new stdClass();
        $stadGemeente->id = checkInt(intval($this->input->post('stadgemeente_id_delete')));
        $stadGemeente->naam = checkString(strtolower($this->input->post('stadgemeente_naam_delete')));

        // leveranciers met deze stadGemeenteId op "N/A" zetten
        $this->leverancier_model->updateLeverancier_setNA_stadGemeenteId($stadGemeente->id);

        // stad verwijderen
        $databaseFunctionWasSuccess = $this->stadgemeente_model->deleteStadGemeente($stadGemeente);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $stadGemeente->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('stadgemeente/beheren/' . true);
        }
        else {
            redirect('stadgemeente/beheren');
        }
    }

    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            checkString(strtolower($this->input->post('naam'))),
            checkString($this->input->post('postcode')),
            checkInt(intval($this->input->post('landid')))
        );
        ajax_setSessionFormData("stadgemeente", $waardes);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_stadgemeente', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $steden = $this->stadgemeente_model->getByZoekfunctie($zoeknaam);
        foreach ($steden as $stadGemeente) {
            $this->load->model('land_model');
            $stadGemeente->land = $this->land_model->get($stadGemeente->landId);
            $stadGemeente->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($stadGemeente->gewijzigdDoor);
            $stadGemeente->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($stadGemeente->toegevoegdDoor);
            $stadGemeente = getReadableDateFormats($stadGemeente);
        }
        $data['steden'] = $steden;
        $data['landen_dropdownOptions'] = $this->landen_dropdownOptions;

        $this->load->view('ajaxcontent_stadgemeente_by_zoekfunctie', $data);
    }

}
