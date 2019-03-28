<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kost_gebouwen extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('kost_gebouwen_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Gebouwenkosten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_kost_gebouwen_value'] = getSessionZoeknaamvalue('kost_gebouwen'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "kost_gebouwen/beheren", "kost_gebouwen/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_kost_gebouwen_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $kost_gebouwen = new stdClass();
        $kost_gebouwen->naam = checkString(strtolower($this->input->post('kost_gebouwen_naam')));
        $kost_gebouwen->aankoopPrijs = checkFloat(floatval($this->input->post('kost_gebouwen_aankoopPrijs')));
        $kost_gebouwen->afschrijfperiodePerJaar = checkFloat(floatval($this->input->post('kost_gebouwen_afschrijfperiodePerJaar')));
        $kost_gebouwen->toegevoegdDoor = $userId;
        $kost_gebouwen->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_gebouwen_model->insertKostGebouwen($kost_gebouwen);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $kost_gebouwen->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_gebouwen/beheren/' . true);
        }
        else {
            redirect('kost_gebouwen/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $kost_gebouwen = new stdClass();
        $kost_gebouwen->id = checkInt(intval($this->input->post('kost_gebouwen_id_update')));
        $kost_gebouwen->naam = checkString(strtolower($this->input->post('kost_gebouwen_naam_update')));
        $kost_gebouwen->aankoopPrijs = checkFloat(floatval($this->input->post('kost_gebouwen_aankoopPrijs_update')));
        $kost_gebouwen->afschrijfperiodePerJaar = checkFloat(floatval($this->input->post('kost_gebouwen_afschrijfperiodePerJaar_update')));
        $kost_gebouwen->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_gebouwen_model->updateKostGebouwen($kost_gebouwen);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $kost_gebouwen->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_gebouwen/beheren/' . true);
        }
        else {
            redirect('kost_gebouwen/beheren');
        }
    }

    public function delete() {
        $kost_gebouwen = new stdClass();
        $kost_gebouwen->id = checkInt(intval($this->input->post('kost_gebouwen_id_delete')));
        $kost_gebouwen->naam = checkString(strtolower($this->input->post('kost_gebouwen_naam_delete')));
        $kost_gebouwen->aankoopPrijs = checkFloat(floatval($this->input->post('kost_gebouwen_aankoopPrijs_delete')));
        $kost_gebouwen->afschrijfperiodePerJaar = checkFloat(floatval($this->input->post('kost_gebouwen_afschrijfperiodePerJaar_delete')));

        // TODO
        // $databaseFunctionWasSuccess = $this->kost_gebouwen_model->deleteKostGebouwen($kost_gebouwen);
        $databaseFunctionWasSuccess = false;

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $kost_gebouwen->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_gebouwen/beheren/' . true);
        }
        else {
            redirect('kost_gebouwen/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_kost_gebouwen', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();

        $kost_gebouwen = $this->kost_gebouwen_model->getByZoekfunctie($zoeknaam);
        $data['kost_gebouwen'] = null;
        if ($kost_gebouwen != null) {

            foreach ($kost_gebouwen as $kost_gebouw) {
                $kost_gebouw->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($kost_gebouw->gewijzigdDoor);
                $kost_gebouw->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($kost_gebouw->toegevoegdDoor);
                $kost_gebouw = getReadableDateFormats($kost_gebouw);
            }
            $data['kost_gebouwen'] = $kost_gebouwen;
        }
        $this->load->view('ajaxcontent_kost_gebouwen_by_zoekfunctie', $data);

    }

    public function ajax_save_to_session() {
        $waardes = array(
            floatval($this->input->post('aankoopPrijs')),
            floatval($this->input->post('afschrijfperiodePerJaar')),
        );
        ajax_setSessionFormData("kost_gebouwen", $waardes);
    }

}