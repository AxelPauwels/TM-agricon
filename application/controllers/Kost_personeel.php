<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kost_personeel extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('kost_personeel_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Personeelskosten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_kost_personeel_value'] = getSessionZoeknaamvalue('kost_personeel'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "kost_personeel/beheren", "kost_personeel/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_kost_personeel_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $kost_personeel = new stdClass();
        $kost_personeel->naam = checkString(strtolower($this->input->post('kost_personeel_naam')));
        $kost_personeel->aantalWerknemers = checkInt(intval($this->input->post('kost_personeel_aantalWerknemers')));
        $kost_personeel->aantalUren = checkFloat(floatval($this->input->post('kost_personeel_aantalUren')));
        $kost_personeel->uurloon = checkFloat(floatval($this->input->post('kost_personeel_uurloon')));
        $kost_personeel->toegevoegdDoor = $userId;
        $kost_personeel->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_personeel_model->insertKostPersoneel($kost_personeel);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $kost_personeel->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_personeel/beheren/' . true);
        }
        else {
            redirect('kost_personeel/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $kost_personeel = new stdClass();
        $kost_personeel->id = checkInt(intval($this->input->post('kost_personeel_id_update')));
        $kost_personeel->naam = checkString(strtolower($this->input->post('kost_personeel_naam_update')));
        $kost_personeel->aantalWerknemers = checkInt(intval($this->input->post('kost_personeel_aantalWerknemers_update')));
        $kost_personeel->aantalUren = checkFloat(floatval($this->input->post('kost_personeel_aantalUren_update')));
        $kost_personeel->uurloon = checkFloat(floatval($this->input->post('kost_personeel_uurloon_update')));
        $kost_personeel->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_personeel_model->updateKostPersoneel($kost_personeel);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $kost_personeel->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_personeel/beheren/' . true);
        }
        else {
            redirect('kost_personeel/beheren');
        }
    }

    public function delete() {
        $this->load->model('kost_personeel_model');
        $this->load->model('productiekost_model');
        $this->load->model('product_model');

        $kost_personeel = new stdClass();
        $kost_personeel->id = checkInt(intval($this->input->post('kost_personeel_id_delete')));
        $kost_personeel->naam = checkString(strtolower($this->input->post('kost_personeel_naam_delete')));

        $productieKosten = $this->productiekost_model->getAll_by_personeelKostId($kost_personeel->id);

        foreach ($productieKosten as $productieKost){
           $this->productiekost_model->updateProductiekost_setNA_personeelKostId($productieKost->id);

            //update prijzen
            $producten = $this->product_model->getAll_byProductieKostId($productieKost->id);
            foreach ($producten as $product) {
                calculate_and_update_productPrijs($product->id, $productieKost->id);
            }

        }
        $databaseFunctionWasSuccess = $this->kost_personeel_model->deleteKostPersoneel_byId($kost_personeel->id);


        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $kost_personeel->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_personeel/beheren/' . true);
        }
        else {
            redirect('kost_personeel/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_kost_personeel', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();

        $kost_personeel = $this->kost_personeel_model->getByZoekfunctie($zoeknaam);
        $data['kost_personeel'] = null;
        if ($kost_personeel != null) {
            foreach ($kost_personeel as $kost_persoon) {
                $kost_persoon->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($kost_persoon->gewijzigdDoor);
                $kost_persoon->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($kost_persoon->toegevoegdDoor);
                $kost_persoon = getReadableDateFormats($kost_persoon);
            }
            $data['kost_personeel'] = $kost_personeel;
        }
        $this->load->view('ajaxcontent_kost_personeel_by_zoekfunctie', $data);
    }

    public function ajax_save_to_session() {
//        checkInt(intval($this->input->post('aantalWerknemers')));
//        checkFloat(floatval($this->input->post('aantalUren')));
//        checkFloat(floatval($this->input->post('uurloon')));
        $waardes = array(
            $this->input->post('naam')
        );
        ajax_setSessionFormData("kost_personeel", $waardes);
    }
}
