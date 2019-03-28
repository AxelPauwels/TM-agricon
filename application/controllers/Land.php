<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Land extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('land_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Landen beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_land_value'] = getSessionZoeknaamvalue('land'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "stadgemeente/beheren", "land/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_land_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $land = new stdClass();
        $land->naam = checkString(strtolower($this->input->post('land_naam')));
        $land->toegevoegdDoor = $userId;
        $land->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->land_model->insertLand($land);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $land->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('land/beheren/' . true);
        }
        else {
            redirect('land/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $land = new stdClass();
        $land->id = checkInt(intval($this->input->post('land_id_update')));
        $land->naam = checkString(strtolower($this->input->post('land_naam_update')));
        $land->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->land_model->updateLand($land);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $land->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('land/beheren/' . true);
        }
        else {
            redirect('land/beheren');
        }
    }

    public function delete() {
        $this->load->model('stadgemeente_model');
        $this->load->model('leverancier_model');

        $land = new stdClass();
        $land->id = checkInt(intval($this->input->post('land_id_delete')));
        $land->naam = checkString(strtolower($this->input->post('land_naam_delete')));

        // steden ophalen met deze landId
        $steden = $this->stadgemeente_model->getByLandid($land->id);

        foreach ($steden as $stad) {
            // leveranciers met deze stadGemeenteId op "N/A" zetten
            $this->leverancier_model->updateLeverancier_setNA_stadGemeenteId($stad->id);

            // stad verwijderen
            $this->stadgemeente_model->deleteStadGemeente_byId($stad->id);
        }
        // land verwijderen
        $databaseFunctionWasSuccess = $this->land_model->deleteLand($land);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $land->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('land/beheren/' . true);
        }
        else {
            redirect('land/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_land', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $landen = $this->land_model->getByZoekfunctie($zoeknaam);
        $data['landen'] = null;
        if ($landen != null) {
            foreach ($landen as $land) {
                $land->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($land->gewijzigdDoor);
                $land->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($land->toegevoegdDoor);
                $land = getReadableDateFormats($land);
            }
            $data['landen'] = $landen;
        }
        $this->load->view('ajaxcontent_land_by_zoekfunctie', $data);
    }

}
