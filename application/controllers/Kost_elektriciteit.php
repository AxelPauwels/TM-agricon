<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Kost_elektriciteit extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('kost_elektriciteit_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Elektriciteitskosten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_kost_elektriciteit_value'] = getSessionZoeknaamvalue('kost_elektriciteit'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "kost_elektriciteit/beheren", "kost_elektriciteit/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_kost_elektriciteit_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $kost_elektriciteit = new stdClass();
        $kost_elektriciteit->naam = checkString(strtolower($this->input->post('kost_elektriciteit_naam')));
        $kost_elektriciteit->verbruikPerJaarInKwh = checkFloat(floatval($this->input->post('kost_elektriciteit_verbruikPerJaarInKwh')));
        $kost_elektriciteit->kostprijsPerKwh = checkFloat(floatval($this->input->post('kost_elektriciteit_kostprijsPerKwh')));
        $kost_elektriciteit->toegevoegdDoor = $userId;
        $kost_elektriciteit->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_elektriciteit_model->insertKostElektriciteit($kost_elektriciteit);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $kost_elektriciteit->verbruikPerJaarInKwh);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_elektriciteit/beheren/' . true);
        }
        else {
            redirect('kost_elektriciteit/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $kost_elektriciteit = new stdClass();
        $kost_elektriciteit->id = checkInt(intval($this->input->post('kost_elektriciteit_id_update')));
        $kost_elektriciteit->naam = checkString(strtolower($this->input->post('kost_elektriciteit_naam_update')));
        $kost_elektriciteit->verbruikPerJaarInKwh = checkFloat(floatval($this->input->post('kost_elektriciteit_verbruikPerJaarInKwh_update')));
        $kost_elektriciteit->kostprijsPerKwh = checkFloat(floatval($this->input->post('kost_elektriciteit_kostprijsPerKwh_update')));
        $kost_elektriciteit->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_elektriciteit_model->updateKostElektriciteit($kost_elektriciteit);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $kost_elektriciteit->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_elektriciteit/beheren/' . true);
        }
        else {
            redirect('kost_elektriciteit/beheren');
        }
    }

    public function delete() {
        $this->load->model('kost_elektriciteit_model');
        $this->load->model('productiekost_model');
        $this->load->model('product_model');

        $kost_elektriciteit = new stdClass();
        $kost_elektriciteit->id = checkInt(intval($this->input->post('kost_elektriciteit_id_delete')));
        $kost_elektriciteit->naam = checkString(strtolower($this->input->post('kost_elektriciteit_naam_delete')));
        $kost_elektriciteit->verbruikPerJaarInKwh = checkFloat(floatval($this->input->post('kost_elektriciteit_verbruikPerJaarInKwh_delete')));
        $kost_elektriciteit->kostprijsPerKwh = checkFloat(floatval($this->input->post('kost_elektriciteit_kostprijsPerKwh_delete')));

        $productieKosten = $this->productiekost_model->getAll_byElektriciteitKostId($kost_elektriciteit->id);

        foreach ($productieKosten as $productieKost) {
            $this->productiekost_model->updateProductiekost_setNA_elektriciteitKostId($productieKost->id);
            //update prijzen
            $producten = $this->product_model->getAll_byProductieKostId($productieKost->id);
            foreach ($producten as $product) {
                calculate_and_update_productPrijs($product->id, $productieKost->id);
            }
        }

        $databaseFunctionWasSuccess = $this->kost_elektriciteit_model->deleteKostElektriciteit_byId($kost_elektriciteit->id);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $kost_elektriciteit->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
//            redirect('kost_elektriciteit/beheren/' . true);
        }
        else {
//            redirect('kost_elektriciteit/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_kost_elektriciteit', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();

        $kost_elektriciteit = $this->kost_elektriciteit_model->getByZoekfunctie($zoeknaam);
        $data['kost_elektriciteit'] = null;
        if ($kost_elektriciteit != null) {
            foreach ($kost_elektriciteit as $item_kost_elektriciteit) {
                $item_kost_elektriciteit->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($item_kost_elektriciteit->gewijzigdDoor);
                $item_kost_elektriciteit->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($item_kost_elektriciteit->toegevoegdDoor);
                $item_kost_elektriciteit = getReadableDateFormats($item_kost_elektriciteit);
            }
            $data['kost_elektriciteit'] = $kost_elektriciteit;
        }
        $this->load->view('ajaxcontent_kost_elektriciteit_by_zoekfunctie', $data);
    }

    public function ajax_save_to_session() {
        $waardes = array(
            floatval($this->input->post('naam')),
            floatval($this->input->post('verbruikPerJaarInKwh')),
            floatval($this->input->post('kostprijsPerKwh')),
        );
        ajax_setSessionFormData("kost_elektriciteit", $waardes);
    }

}