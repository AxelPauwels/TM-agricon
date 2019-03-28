<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Folie_ruw extends CI_Controller {

    var $leveranciers_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('folie_ruw_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->getDropdownOptions();

    }

    private function getDropdownOptions() {
        //leveranciers ophalen
        $this->load->model('leverancier_model');
        $leveranciers = $this->leverancier_model->getAll_metNA();
        $this->leveranciers_dropdownOptions = array('' => 'Selecteer...');
        foreach ($leveranciers as $leverancier) {
            $this->leveranciers_dropdownOptions[$leverancier->id] = ucwords($leverancier->naam);
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Ruwe folies beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_folie_ruw_value'] = getSessionZoeknaamvalue('folieruw'); // READ INFO IN THIS FUNCTION !!
        $data['leveranciers_dropdownOptions'] = $this->leveranciers_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('folie_ruw', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

//        // controleren of men van een "level2" navigatie komt, hier terug komt van stadgemeente, dus de "redirect_twice" unsetten van session (meer info: zie helperfunctie)
//        if ($this->session->has_userdata('redirect') && $this->session->userdata('redirect_url') == 'stadgemeente/beheren') {
//            setNavigationBackbuttonTwice(false, "");
//        }

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "folie_gesneden/beheren", "folie_ruw/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_folie_ruw_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $folieRuw = new stdClass();
        $folieRuw->naam = checkString(strtolower($this->input->post('folie_ruw_naam')));
        $leverancierId = checkInt(intval($this->input->post('folie_ruw_leverancierid')));
        if ($leverancierId == null) {
            $folieRuw->leverancierId = -1;
        }
        else {
            $folieRuw->leverancierId = $leverancierId;
        }

        $folieRuw->lopendeMeterEenheid = checkFloat(floatval($this->input->post('folie_ruw_lmeenheid')));
        $folieRuw->lopendeMeterPrijs = checkFloat(floatval($this->input->post('folie_ruw_lmprijs')));
        $folieRuw->micronDikte = checkInt(intval($this->input->post('folie_ruw_micron')));

        $folieRuw->toegevoegdDoor = $userId;
        $folieRuw->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->folie_ruw_model->insertFolieRuw($folieRuw);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $folieRuw->naam);

        setOrUnset_sessionFormData('folie_ruw', false); // true=set, false=unset

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('folie_ruw/beheren/' . true);
        }
        else {
            redirect('folie_ruw/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $folieRuw = new stdClass();
        $folieRuw->id = checkInt(intval($this->input->post('folie_ruw_id_update')));
        $folieRuw->naam = checkString(strtolower($this->input->post('folie_ruw_naam_update')));
        $leverancierId = checkInt(intval($this->input->post('folie_ruw_leverancierid_update')));
        if ($leverancierId == null) {
            $folieRuw->leverancierId = -1;
        }
        else {
            $folieRuw->leverancierId = $leverancierId;
        }
        $folieRuw->lopendeMeterEenheid = checkFloat(floatval($this->input->post('folie_ruw_lmeenheid_update')));
        $folieRuw->lopendeMeterPrijs = checkFloat(floatval($this->input->post('folie_ruw_lmprijs_update')));
        $folieRuw->micronDikte = checkInt(intval($this->input->post('folie_ruw_micron_update')));
        $folieRuw->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->folie_ruw_model->updateFolieRuw($folieRuw);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $folieRuw->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('folie_ruw/beheren/' . true);
        }
        else {
            redirect('folie_ruw/beheren');
        }
    }

    public function delete() {
        $this->load->model('folie_gesneden_model');
        $this->load->model('product_model');

        $folieRuw = new stdClass();
        $folieRuw->id = checkInt(intval($this->input->post('folie_ruw_id_delete')));
        $folieRuw->naam = checkString(strtolower($this->input->post('folie_ruw_naam_delete')));

        $productIds = array(); // key=>value , productid=>productiekostid

        // gesneden folies ophalen met deze folieRuwId
        $gesnedenFolies = $this->folie_gesneden_model->getByFolieRuwId($folieRuw->id);

        foreach ($gesnedenFolies as $folie) {

            // productIds bijhouden om straks de prijzen te updaten
            $producten = $this->product_model->get_byFolieId($folie->id);
            foreach ($producten as $product) {
                $productIds[$product->id] = $product->productieKostId;
            }

            // producten met deze folieId op "N/A" zetten
            $this->product_model->updateProduct_setNA_folieId($folie->id);

            // gesneden folie verwijderen
            $this->folie_gesneden_model->deleteFolieGesneden($folie);
        }

        // ruwe folie verwijderen
        $databaseFunctionWasSuccess = $this->folie_ruw_model->deleteFolieRuw($folieRuw);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $folieRuw->naam);

        // prijs updaten
        foreach ($productIds as $productId => $productieKostId) {
            calculate_and_update_productPrijs($productId, $productieKostId);
        }

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('folie_ruw/beheren/' . true);
        }
        else {
            redirect('folie_ruw/beheren');
        }
    }

    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            strtolower($this->input->post('naam')),
            intval($this->input->post('leverancierid')),
            floatval($this->input->post('lmeenheid')),
            floatval($this->input->post('lmprijs')),
            intval($this->input->post('micron'))
        );
        ajax_setSessionFormData("folie_ruw", $waardes);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_folieruw', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $foliesRuw = $this->folie_ruw_model->getByZoekfunctie($zoeknaam);
        $data['foliesRuw'] = null;
        if ($foliesRuw != null) {
            foreach ($foliesRuw as $folie) {
                $folie->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($folie->gewijzigdDoor);
                $folie->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($folie->toegevoegdDoor);
                $folie = getReadableDateFormats($folie);
            }
            $data['foliesRuw'] = $foliesRuw;
        }

        $data['leveranciers_dropdownOptions'] = $this->leveranciers_dropdownOptions;

        $this->load->view('ajaxcontent_folie_ruw_by_zoekfunctie', $data);
    }

}
