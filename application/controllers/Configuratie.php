<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuratie extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('configuratie_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    // EENHEDEN  ********************************************************************************************
    public function eenheden_beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Eenheden beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_eenheid_value'] = getSessionZoeknaamvalue('eenheid'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION (zie home/index voor info)
        if ($redirect) {
            $this->session->set_userdata('redirect', true);
            $data['show_back_button'] = true;
            $data['redirect_url'] = site_url($this->session->userdata('redirect_url'));
        }
        else {
            $this->session->set_userdata('redirect', false);
            $data['show_back_button'] = false;
            $this->session->set_userdata('redirect_url', "configuratie/eenheden_beheren");
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_config_eenheid_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function eenheden_insert() {
        $userId = $this->authex->getUserId();
        $newEenheid = new stdClass();
        $newEenheid->naam = checkString(strtolower($this->input->post('config_eenheid_naam')));
        $newEenheid->toegevoegdDoor = $userId;
        $newEenheid->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->configuratie_model->insertEenheid($newEenheid);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $newEenheid->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/eenheden_beheren/' . true);
        }
        else {
            redirect('configuratie/eenheden_beheren');
        }
    }

    public function eenheden_update() {
        $userId = $this->authex->getUserId();
        $updateEenheid = new stdClass();
        $updateEenheid->id = checkInt(intval($this->input->post('config_eenheid_id_update')));
        $updateEenheid->naam = checkString(strtolower($this->input->post('config_eenheid_naam_update')));
        $updateEenheid->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->configuratie_model->updateEenheid($updateEenheid);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $updateEenheid->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/eenheden_beheren/' . true);
        }
        else {
            redirect('configuratie/eenheden_beheren');
        }
    }

    public function eenheden_delete() {
        $deleteEenheid = new stdClass();
        $deleteEenheid->id = checkInt(intval($this->input->post('config_eenheid_id_delete')));
        $deleteEenheid->naam = checkString(strtolower($this->input->post('config_eenheid_naam_delete')));

        // TODO
        // $databaseFunctionWasSuccess = $this->configuratie_model->deleteEenheid($deleteEenheid);
        $databaseFunctionWasSuccess = false;

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $deleteEenheid->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/eenheden_beheren/' . true);
        }
        else {
            redirect('configuratie/eenheden_beheren');
        }
    }

    // AJAX
    function eenheden_ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_eenheid', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $eenheden = $this->configuratie_model->eenheid_getByZoekfunctie($zoeknaam);
        $data['eenheden'] = null;
        if ($eenheden != null) {
            foreach ($eenheden as $eenheid) {
                $eenheid->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($eenheid->gewijzigdDoor);
                $eenheid->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($eenheid->toegevoegdDoor);
                $eenheid = getReadableDateFormats($eenheid);
            }
            $data['eenheden'] = $eenheden;
        }
        $this->load->view('ajaxcontent_eenheid_by_zoekfunctie', $data);
    }

    // GESCHATTE OMZET ********************************************************************************************
    public function omzet_beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Geschatte omzet beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_omzet_value'] = getSessionZoeknaamvalue('omzet'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION (zie home/index voor info)
        if ($redirect) {
            $this->session->set_userdata('redirect', true);
            $data['show_back_button'] = true;
            $data['redirect_url'] = site_url('grondstof_ruw/beheren');
        }
        else {
            $this->session->set_userdata('redirect', false);
            $data['show_back_button'] = false;
            $this->session->set_userdata('redirect_url', "configuratie/omzet_beheren");
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_config_omzet_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function omzet_insert() {
        $userId = $this->authex->getUserId();
        $omzet = new stdClass();
        $omzet->naam = checkString(strtolower($this->input->post('config_omzet_naam')));
        $omzet->zakjesPerDag = checkInt(intval($this->input->post('config_omzet_zakjesperdag')));
        $omzet->dagenPerJaar = checkInt(intval($this->input->post('config_omzet_dagenperjaar')));
        $omzet->toegevoegdDoor = $userId;
        $omzet->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->configuratie_model->insertOmzet($omzet);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $omzet->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/omzet_beheren/' . true);
        }
        else {
            redirect('configuratie/omzet_beheren');
        }
    }

    public function omzet_update() {
        $userId = $this->authex->getUserId();
        $omzet = new stdClass();
        $omzet->id = checkInt(intval($this->input->post('config_omzet_id_update')));
        $omzet->naam = checkString(strtolower($this->input->post('config_omzet_naam_update')));
        $omzet->zakjesPerDag = checkInt(intval($this->input->post('config_omzet_zakjesperdag_update')));
        $omzet->dagenPerJaar = checkInt(intval($this->input->post('config_omzet_dagenperjaar_update')));
        $omzet->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->configuratie_model->updateOmzet($omzet);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $omzet->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/omzet_beheren/' . true);
        }
        else {
            redirect('configuratie/omzet_beheren');
        }
    }

    public function omzet_delete() {
        $omzet = new stdClass();
        $omzet->id = checkInt(intval($this->input->post('config_omzet_id_delete')));
        $omzet->naam = checkString(strtolower($this->input->post('config_omzet_naam_delete')));

        // TODO
        // $databaseFunctionWasSuccess = $this->configuratie_model->deleteOmzet($omzet);
        $databaseFunctionWasSuccess = false;

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $omzet->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/omzet_beheren/' . true);
        }
        else {
            redirect('configuratie/omzet_beheren');
        }
    }

    // AJAX
    function omzet_ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_omzet', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $omzetten = $this->configuratie_model->omzet_getByZoekfunctie($zoeknaam);
        $data['omzetten'] = null;
        if ($omzetten != null) {
            foreach ($omzetten as $omzet) {
                $omzet->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($omzet->gewijzigdDoor);
                $omzet->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($omzet->toegevoegdDoor);
                $omzet = getReadableDateFormats($omzet);
            }
            $data['omzetten'] = $omzetten;
        }
        $this->load->view('ajaxcontent_omzet_by_zoekfunctie', $data);
    }

    // VERPAKKINGSKOST  **************************************************************************************
    public function verpakkingskosten_beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Verpakkingskosten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_verpakkingskost_value'] = getSessionZoeknaamvalue('verpakkingskost'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION (zie home/index voor info)
        if ($redirect) {
            $this->session->set_userdata('redirect', true);
            $data['show_back_button'] = true;
            $data['redirect_url'] = site_url('grondstof_ruw/beheren');
        }
        else {
            $this->session->set_userdata('redirect', false);
            $data['show_back_button'] = false;
            $this->session->set_userdata('redirect_url', "configuratie/verpakkingskosten_beheren");
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_config_verpakkingskost_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function verpakkingskosten_insert() {
        $userId = $this->authex->getUserId();
        $newVerpakkingskost = new stdClass();
        $newVerpakkingskost->verpakkingskost = checkString(strtolower($this->input->post('config_verpakkingskost_naam')));
        $newVerpakkingskost->toegevoegdDoor = $userId;
        $newVerpakkingskost->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->configuratie_model->insertVerpakkingskost($newVerpakkingskost);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $newVerpakkingskost->verpakkingskost);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/verpakkingskosten_beheren/' . true);
        }
        else {
            redirect('configuratie/verpakkingskosten_beheren');
        }
    }

    public function verpakkingskosten_update() {
        $userId = $this->authex->getUserId();
        $updateVerpakkingskost = new stdClass();
        $updateVerpakkingskost->id = checkInt(intval($this->input->post('config_verpakkingskost_id_update')));
        $updateVerpakkingskost->verpakkingskost = checkString(strtolower($this->input->post('config_verpakkingskost_naam_update')));
        $updateVerpakkingskost->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->configuratie_model->updateVerpakkingskost($updateVerpakkingskost);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $updateVerpakkingskost->verpakkingskost);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/verpakkingskosten_beheren/' . true);
        }
        else {
            redirect('configuratie/verpakkingskosten_beheren');
        }
    }

    public function verpakkingskosten_delete() {
        $deleteVerpakkingskost = new stdClass();
        $deleteVerpakkingskost->id = checkInt(intval($this->input->post('config_verpakkingskost_id_delete')));
        $deleteVerpakkingskost->verpakkingskost = checkString(strtolower($this->input->post('config_verpakkingskost_naam_delete')));

        // TODO
        // $databaseFunctionWasSuccess = $this->configuratie_model->deleteVerpakkingskost($deleteVerpakkingskost);
        $databaseFunctionWasSuccess = false;

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $deleteVerpakkingskost->verpakkingskost);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('configuratie/verpakkingskosten_beheren/' . true);
        }
        else {
            redirect('configuratie/verpakkingskosten_beheren');
        }
    }

    // AJAX
    function verpakkingskosten_ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_verpakkingskost', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $verpakkingskosten = $this->configuratie_model->verpakkingskost_getByZoekfunctie($zoeknaam);
        $data['verpakkingskosten'] = null;
        if ($verpakkingskosten != null) {
            foreach ($verpakkingskosten as $verpakkingskost) {
                $verpakkingskost->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($verpakkingskost->gewijzigdDoor);
                $verpakkingskost->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($verpakkingskost->toegevoegdDoor);
                $verpakkingskost = getReadableDateFormats($verpakkingskost);
            }
            $data['verpakkingskosten'] = $verpakkingskosten;
        }
        $this->load->view('ajaxcontent_verpakkingskost_by_zoekfunctie', $data);
    }


}
