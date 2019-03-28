<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leverancier_soort extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('leverancier_soort_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Leverancier soorten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_leveranciersoort_value'] = getSessionZoeknaamvalue('leverancier_soort'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect,"leverancier/beheren","leverancier_soort/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_leverancier_soort_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $leverancierSoort = new stdClass();
        $leverancierSoort->naam = checkString(strtolower($this->input->post('leverancier_soort_naam')));
        $leverancierSoort->toegevoegdDoor = $userId;
        $leverancierSoort->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->leverancier_soort_model->insertLeverancierSoort($leverancierSoort);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $leverancierSoort->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('leverancier_soort/beheren/' . true);
        }
        else {
            redirect('leverancier_soort/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $leverancierSoort = new stdClass();
        $leverancierSoort->id = checkInt(intval($this->input->post('leverancier_soort_id_update')));
        $leverancierSoort->naam = checkString(strtolower($this->input->post('leverancier_soort_naam_update')));
        $leverancierSoort->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->leverancier_soort_model->updateLeverancierSoort($leverancierSoort);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $leverancierSoort->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('leverancier_soort/beheren/' . true);
        }
        else {
            redirect('leverancier_soort/beheren');
        }
    }

    public function delete() {
        $this->load->model('leverancier_model');

        $leverancierSoort = new stdClass();
        $leverancierSoort->id = checkInt(intval($this->input->post('leverancier_soort_id_delete')));
        $leverancierSoort->naam = checkString(strtolower($this->input->post('leverancier_soort_naam_delete')));

        // leveranciers met deze leverancierSoortId op "N/A" zetten
        $this->leverancier_model->updateLeverancier_setNA_leverancierSoortId($leverancierSoort->id);

        // leverancierSoort verwijderen
        $databaseFunctionWasSuccess = $this->leverancier_soort_model->deleteLeverancierSoort($leverancierSoort);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $leverancierSoort->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('leverancier_soort/beheren/' . true);
        }
        else {
            redirect('leverancier_soort/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_leverancier_soort', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $leverancierSoorten = $this->leverancier_soort_model->getByZoekfunctie($zoeknaam);
        $data['leverancierSoorten'] = null;
        if ($leverancierSoorten != null) {
            foreach ($leverancierSoorten as $leverancierSoort) {
                $leverancierSoort->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($leverancierSoort->gewijzigdDoor);
                $leverancierSoort->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($leverancierSoort->toegevoegdDoor);
                $leverancierSoort = getReadableDateFormats($leverancierSoort);
            }
            $data['leverancierSoorten'] = $leverancierSoorten;
        }
        $this->load->view('ajaxcontent_leverancier_soort_by_zoekfunctie', $data);
    }

}
