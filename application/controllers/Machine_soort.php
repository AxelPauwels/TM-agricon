<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machine_soort extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('machine_soort_model');
        if (!$this->authex->loggedIn()) {
          redirect('home/index');
         }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Machinesoorten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_machine_soort_value'] = getSessionZoeknaamvalue('machine_soort'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, $this->session->userdata('redirect_url'), "machine_soort/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_machine_soort_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $machine_soort = new stdClass();
        $machine_soort->naam = checkString(strtolower($this->input->post('machine_soort_naam')));
        $machine_soort->toegevoegdDoor = $userId;
        $machine_soort->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->machine_soort_model->insertMachineSoort($machine_soort);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $machine_soort->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('machine_soort/beheren/' . true);
        }
        else {
            redirect('machine_soort/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $machine_soort = new stdClass();
        $machine_soort->id = checkInt(intval($this->input->post('machine_soort_id_update')));
        $machine_soort->naam = checkString(strtolower($this->input->post('machine_soort_naam_update')));
        $machine_soort->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->machine_soort_model->updateMachineSoort($machine_soort);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $machine_soort->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('machine_soort/beheren/' . true);
        }
        else {
            redirect('machine_soort/beheren');
        }
    }

    public function delete() {
        $machine_soort = new stdClass();
        $machine_soort->id = checkInt(intval($this->input->post('machine_soort_id_delete')));
        $machine_soort->naam = checkString(strtolower($this->input->post('machine_soort_naam_delete')));

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->machine_soort_model->deleteMachineSoort($machine_soort);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $machine_soort->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('machine_soort/beheren/' . true);
        }
        else {
            redirect('machine_soort/beheren');
        }
    }

    // AJAX
    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_machine_soort', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();

        $machine_soorten = $this->machine_soort_model->getByZoekfunctie($zoeknaam);
        $data['machine_soorten'] = null;
        if ($machine_soorten != null) {
            foreach ($machine_soorten as $machine_soort) {
                $machine_soort->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($machine_soort->gewijzigdDoor);
                $machine_soort->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($machine_soort->toegevoegdDoor);
                $machine_soort = getReadableDateFormats($machine_soort);
            }
            $data['machine_soorten'] = $machine_soorten;
        }
        $this->load->view('ajaxcontent_machine_soort_by_zoekfunctie', $data);
    }

}