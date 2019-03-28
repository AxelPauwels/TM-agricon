<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Folie_gesneden extends CI_Controller {

    var $folies_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('folie_gesneden_model');
        $this->load->model('folie_ruw_model');

        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->getDropdownOptions();

    }

    private function getDropdownOptions() {
        //leveranciers ophalen
        $this->load->model('folie_ruw_model');
        $folies = $this->folie_ruw_model->getAll();
        $this->folies_dropdownOptions = array('' => 'Selecteer...');
        foreach ($folies as $folie) {
            $this->folies_dropdownOptions[$folie->id] = ucwords($folie->naam) . " (micron " . $folie->micronDikte . " - €" . round($folie->lopendeMeterPrijs) . "/" . round($folie->lopendeMeterEenheid) . " LM)";
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Folies beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_folie_gesneden_value'] = getSessionZoeknaamvalue('foliegesneden'); // READ INFO IN THIS FUNCTION !!
        $data['folies_dropdownOptions'] = $this->folies_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('folie_gesneden', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

//        // controleren of men van een "level2" navigatie komt, hier terug komt van stadgemeente, dus de "redirect_twice" unsetten van session (meer info: zie helperfunctie)
//        if ($this->session->has_userdata('redirect') && $this->session->userdata('redirect_url') == 'stadgemeente/beheren') {
//            setNavigationBackbuttonTwice(false, "");
//        }

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "folie_gesneden/beheren", "folie_gesneden/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_folie_gesneden_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $folieGesneden = new stdClass();
        $folieGesneden->naam = strtolower($this->input->post('folie_gesneden_naam'));

        $folieGesneden->folieRuwId = checkInt(intval($this->input->post('folie_gesneden_folieruwid')));
        $folieGesneden->lengteAfslag = checkFloat(floatval($this->input->post('folie_gesneden_lengte')));
        $folieGesneden->breedte = checkFloat(floatval($this->input->post('folie_gesneden_breedte')));
        // $folieGesneden->aantalZakjesPerRol //IS EEN CALCULATED FIELD IN DE DATABASE
        $folieRuw = $this->folie_ruw_model->get($folieGesneden->folieRuwId);
        if ($folieRuw) {
            $folieGesneden->prijsPerZakje = calculate_folieGesneden_prijsPerZakje($folieRuw->lopendeMeterPrijs, $folieRuw->lopendeMeterEenheid, $folieGesneden->lengteAfslag);
        }
        $folieGesneden->toegevoegdDoor = $userId;
        $folieGesneden->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->folie_gesneden_model->insertFolieGesneden($folieGesneden);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $folieGesneden->naam);

        setOrUnset_sessionFormData('folie_gesneden', false); // true=set, false=unset

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('folie_gesneden/beheren/' . true);
        }
        else {
            redirect('folie_gesneden/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $folieGesneden = new stdClass();
        $folieGesneden->id = checkInt(intval($this->input->post('folie_gesneden_id_update')));
        $folieGesneden->naam = checkString(strtolower($this->input->post('folie_gesneden_naam_update')));
        $folieGesneden->lengteAfslag = checkFloat(floatval($this->input->post('folie_gesneden_lengte_update')));
        $folieGesneden->breedte = checkFloat(floatval($this->input->post('folie_gesneden_breedte_update')));
        $folieGesneden->folieRuwId = checkInt(intval($this->input->post('folie_gesneden_folieruwid_update')));
        $folieGesneden->gewijzigdDoor = $userId;
        $folieRuw = $this->folie_ruw_model->get($folieGesneden->folieRuwId);
        if ($folieRuw) {
            $folieGesneden->prijsPerZakje = calculate_folieGesneden_prijsPerZakje($folieRuw->lopendeMeterPrijs, $folieRuw->lopendeMeterEenheid, $folieGesneden->lengteAfslag);
        }

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->folie_gesneden_model->updateFolieGesneden($folieGesneden);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $folieGesneden->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('folie_gesneden/beheren/' . true);
        }
        else {
            redirect('folie_gesneden/beheren');
        }
    }

    public function delete() {
        $this->load->model('product_model');

        $folieGesneden = new stdClass();
        $folieGesneden->id = checkInt(intval($this->input->post('folie_gesneden_id_delete')));
        $folieGesneden->naam = checkString(strtolower($this->input->post('folie_gesneden_naam_delete')));

        $productIds = array(); // key=>value , productid=>productiekostid

        // productIds bijhouden om straks de prijzen te updaten
        $producten = $this->product_model->get_byFolieId($folieGesneden->id);
        foreach ($producten as $product) {
            $productIds[$product->id] = $product->productieKostId;
        }

        // producten met deze folieId op "N/A" zetten
        $this->product_model->updateProduct_setNA_folieId($folieGesneden->id);

        // gesneden folie verwijderen
        $databaseFunctionWasSuccess = $this->folie_gesneden_model->deleteFolieGesneden($folieGesneden);

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $folieGesneden->naam);

        // prijs updaten
        foreach ($productIds as $productId => $productieKostId) {
            calculate_and_update_productPrijs($productId, $productieKostId);
        }

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('folie_gesneden/beheren/' . true);
        }
        else {
            redirect('folie_gesneden/beheren');
        }
    }

    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            strtolower($this->input->post('naam')),
            intval($this->input->post('folieruwid')),
            floatval($this->input->post('lengte')),
            floatval($this->input->post('breedte'))
        );
        ajax_setSessionFormData("folie_gesneden", $waardes);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_foliegesneden', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $foliesGesneden = $this->folie_gesneden_model->getByZoekfunctie($zoeknaam);
        $data['foliesGesneden'] = null;
        if ($foliesGesneden != null) {
            foreach ($foliesGesneden as $folie) {
                $folie->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($folie->gewijzigdDoor);
                $folie->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($folie->toegevoegdDoor);
                $folie = getReadableDateFormats($folie);
            }
            $data['foliesGesneden'] = $foliesGesneden;
        }

        $data['folies_dropdownOptions'] = $this->folies_dropdownOptions;

        $this->load->view('ajaxcontent_folie_gesneden_by_zoekfunctie', $data);
    }

}
