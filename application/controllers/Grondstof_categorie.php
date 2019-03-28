<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grondstof_categorie extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('grondstof_categorie_model');
        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Grondstof categorieën beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_grondstofcategorie_value'] = getSessionZoeknaamvalue('grondstofcategorie'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, $this->session->userdata('redirect_url'), "grondstof_categorie/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_grondstof_categorie_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $newCategorie = new stdClass();
        $newCategorie->naam = checkString(strtolower($this->input->post('categorie_naam')));
        $newCategorie->isFractieCategorie = intval($this->input->post('categorie_isfractiecategorie'));
        $newCategorie->toegevoegdDoor = $userId;
        $newCategorie->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->grondstof_categorie_model->insertCategorie($newCategorie);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $newCategorie->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('grondstof_categorie/beheren/' . true);
        }
        else {
            redirect('grondstof_categorie/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $updateCategorie = new stdClass();
        $updateCategorie->id = checkInt(intval($this->input->post('categorie_id')));
        $updateCategorie->naam = checkString(strtolower($this->input->post('categorie_naam')));
        $updateCategorie->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->grondstof_categorie_model->updateCategorie($updateCategorie);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $updateCategorie->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('grondstof_categorie/beheren/' . true);
        }
        else {
            redirect('grondstof_categorie/beheren');
        }
    }

    public function delete() {
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('grondstof_afgewerkt_model');

        $deleteCategorie = new stdClass();
        $deleteCategorie->id = checkInt(intval($this->input->post('categorie_id')));
        $deleteCategorie->naam = checkString(strtolower($this->input->post('categorie_naam')));

        $grondstoffenRuw = $this->grondstof_ruw_model->getAll_byCategorieId($deleteCategorie->id);
        $productIds = array(); // key=>value, productId=>productieKostId

        foreach ($grondstoffenRuw as $grondstofRuw) {
            $_grondstoffenAfgewerkt = $this->grondstof_afgewerkt_model->getAll_byGrondstofRuwId($grondstofRuw->id);

            foreach ($_grondstoffenAfgewerkt as $_grondstofAfgewerkt) {
                $_productSamenstellingen = $this->product_samenstelling_model->get_byGrondstofAfgewerktId($_grondstofAfgewerkt->id);

                foreach ($_productSamenstellingen as $_productSamenstelling) {
                    // indien dit een percentage heeft, is dit totaal niet meer 100% en moet het product verwijderd worden.
                    if ($_productSamenstelling->percentage != NULL) {
                        // verwijder product
                        deleteVolledigProduct($_productSamenstelling->productId);
                    }
                    else {
                        // verwijder samenstelling en houd productId bij om prijzen te updaten
                        $_product = $this->product_model->get($_productSamenstelling->productId);
                        $productIds[$_product->id] = $_product->productieKostId;
                        $this->product_samenstelling_model->deleteProductSamenstelling($_productSamenstelling);
                    }
                }
                // grondstoffen verwijderen
                $this->grondstof_afgewerkt_model->deleteGrondstofAfgewerkt($_grondstofAfgewerkt);
            }
            // ruwe grondstoffen verwijderen
            $this->grondstof_ruw_model->deleteGrondstofRuw($grondstofRuw);
        }

        // categorie verwijderen
        $databaseFunctionWasSuccess = $this->grondstof_categorie_model->deleteCategorie($deleteCategorie);

        //prijzen updaten
        foreach ($productIds as $productId => $productieKostId) {
            calculate_and_update_productPrijs($productId, $productieKostId);
        }

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $deleteCategorie->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('grondstof_categorie/beheren/' . true);
        }
        else {
            redirect('grondstof_categorie/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_grondstofcategorie', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();

        $grondstofCategorieen = $this->grondstof_categorie_model->getByZoekfunctie($zoeknaam);
        foreach ($grondstofCategorieen as $categorie) {
            $categorie->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($categorie->gewijzigdDoor);
            $categorie->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($categorie->toegevoegdDoor);
            $categorie = getReadableDateFormats($categorie);
        }
        $data['grondstofCategorieen'] = $grondstofCategorieen;

        $this->load->view('ajaxcontent_grondstof_categorie_by_zoekfunctie', $data);
    }

}
