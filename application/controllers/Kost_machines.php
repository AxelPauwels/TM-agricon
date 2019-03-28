<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kost_machines extends CI_Controller {
    var $machineSoorten_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('kost_machines_model');
        $this->load->model('machine_soort_model');

        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
        $this->getDropdownOptions();

    }

    private function getDropdownOptions() {
        //machine soorten ophalen
        $this->load->model('machine_soort_model');
        $machineSoorten = $this->machine_soort_model->getAll();
        $this->machineSoorten_dropdownOptions = array('' => 'Selecteer...');
        foreach ($machineSoorten as $machineSoort) {
            $this->machineSoorten_dropdownOptions[$machineSoort->id] = ucwords($machineSoort->naam);
        }
    }

    public function beheren($redirect = false) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Machinekosten beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_kost_machines_value'] = getSessionZoeknaamvalue('kostmachines'); // READ INFO IN THIS FUNCTION !!
        $data['machineSoorten_dropdownOptions'] = $this->machineSoorten_dropdownOptions;

        // formData uit sessie halen, anders standaard waarden instellen
        $data['formData'] = setOrUnset_sessionFormData('kost_machines', true); // true=set, false=unset

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);


        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton($redirect, "kost_machines/beheren", "kost_machines/beheren");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_kost_machines_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();

        $kost_machines = new stdClass();

        $kost_machines->machineSoortId = checkInt(intval($this->input->post('kost_machines_machinesoortid')));
        $kost_machines->naam = $this->machine_soort_model->get($kost_machines->machineSoortId)->naam; //naam wordt automatisch gelijkgesteld als de machinesoortnaam
        $kost_machines->aankoopPrijs = checkFloat(floatval($this->input->post('kost_machines_aankoopPrijs')));
        $kost_machines->aantal = checkInt(intval($this->input->post('kost_machines_aantal')));
        $kost_machines->afschrijfperiodePerJaar = checkInt(intval($this->input->post('kost_machines_afschrijfperiodePerJaar')));

        $kost_machines->onderhoudFrequentiePerJaar = checkInt(intval($this->input->post('kost_machines_onderhoudFrequentiePerJaar')));
        $kost_machines->onderhoudKost = checkFloat(floatval($this->input->post('kost_machines_onderhoudKost')));
        $kost_machines->onderhoudUren = checkFloat(floatval($this->input->post('kost_machines_onderhoudUren')));
        $kost_machines->onderhoudUurloon = checkFloat(floatval($this->input->post('kost_machines_onderhoudUurloon')));

        $kost_machines->toegevoegdDoor = $userId;
        $kost_machines->gewijzigdDoor = $userId;

        $insertedMachinesId = $this->kost_machines_model->insertKostMachines($kost_machines);

        // reparaties ophalen
        $aantalReparaties = checkInt(intval($this->input->post('aantal_reparaties')));
        $reparaties = array();
        // aantalReparaties zijn het aantal toegevoegde. Dit kan 6 zijn. Indien er 2 niet werden ingevuld, werden deze verwijderd van de DOM
        // dit wil zeggen dat het getal 6 kan zijn, maar er maar 4 reparaties zijn. Dit kan nummer 1,2,4,6 hebben, dus niet mooi oplopend
        for($i=1;$i<=$aantalReparaties+1;$i++){
            if($this->input->post('kost_machines_reparatieKost'.$i)){
                $reparatie = new stdClass();
                $reparatie->reparatieKost = checkFloat(floatval($this->input->post('kost_machines_reparatieKost'.$i)));
                $reparatie->reparatieUren = checkFloat(floatval($this->input->post('kost_machines_reparatieUren'.$i)));
                $reparatie->reparatieUurloon = checkFloat(floatval($this->input->post('kost_machines_reparatieUurloon'.$i)));
                $reparatie->kostMachinesId= $insertedMachinesId;
                $reparatie->gewijzigdDoor = $userId;
                $reparatie->toegevoegdDoor = $userId;
                array_push($reparaties,$reparatie);
            }
        }

        // reparaties inserten in de database en alertMessages opbouwen.
        $databaseFunctionWasSuccess_reparaties = array(); //een array maken om alle successen en fails in op te slaan. indien deze array één "FALSE" bevat, is de message in error-stijl
        $databaseItems = ""; //zelf message opbouwen omdat de custom helper functie maar 1 titel verwacht -> "create_alert()"
        $this->load->model('kost_machines_reparaties_model');
        foreach ($reparaties as $reparatie) {
            //messages opbouwen
            array_push($databaseFunctionWasSuccess_reparaties, $this->kost_machines_reparaties_model->insertKostMachinesReparatie($reparatie));
            $databaseItems .= 'Reparatie € ' . $reparatie->reparatieKost . ' kost, ' . $reparatie->reparatieKost . ' uren, € '.$reparatie->reparatieUurloon . " uurloon <br>";
        }
        $databaseItems .= 'Machinekost "' . ucfirst($kost_machines->naam) . '" ';

        $databaseFunctionWasSuccess = TRUE;
        if (in_array(false, $databaseFunctionWasSuccess_reparaties) || $insertedMachinesId <= 0) {
            //indien deze array één value "FALSE" bevat, message weergeven in error-stijl
            $databaseFunctionWasSuccess = FALSE;
        }
        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $databaseItems);
        setOrUnset_sessionFormData('kost_machines', false); // true=set, false=unset

        // de totaalKosten (dat niet door de database kan gedaan worden) zelf berekenen en updaten
        calculate_and_update_reparatieEnMachineTotaalKostenPerJaar($insertedMachinesId,$userId);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_machines/beheren/' . true);
        }
        else {
            redirect('kost_machines/beheren');
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();

        $kost_machines = new stdClass();
        $kost_machines->id = checkInt(intval($this->input->post('kost_machines_id_update')));
        $kost_machines->machineSoortId = checkInt(intval($this->input->post('kost_machines_machinesoortid_update')));
        $kost_machines->naam = $this->machine_soort_model->get($kost_machines->machineSoortId)->naam; //naam wordt automatisch gelijkgesteld als de machinesoortnaam
        $kost_machines->aankoopPrijs = checkFloat(floatval($this->input->post('kost_machines_aankoopPrijs_update')));
        $kost_machines->aantal = checkInt(intval($this->input->post('kost_machines_aantal_update')));
        $kost_machines->afschrijfperiodePerJaar = checkInt(intval($this->input->post('kost_machines_afschrijfperiodePerJaar_update')));

        $kost_machines->onderhoudFrequentiePerJaar = checkInt(intval($this->input->post('kost_machines_onderhoudFrequentiePerJaar_update')));
        $kost_machines->onderhoudKost = checkFloat(floatval($this->input->post('kost_machines_onderhoudKost_update')));
        $kost_machines->onderhoudUren = checkFloat(floatval($this->input->post('kost_machines_onderhoudUren_update')));
        $kost_machines->onderhoudUurloon = checkFloat(floatval($this->input->post('kost_machines_onderhoudUurloon_update')));

        $kost_machines->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_machines_model->updateKostMachines($kost_machines);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', ucfirst($kost_machines->naam));

        calculate_and_update_reparatieEnMachineTotaalKostenPerJaar($kost_machines->id,$userId);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_machines/beheren/' . true);
        }
        else {
            redirect('kost_machines/beheren');
        }
    }

    public function delete() {
        $kost_machines = new stdClass();
        $kost_machines->id = checkInt(intval($this->input->post('kost_machines_id_delete')));
        $kost_machines->naam = checkString(ucfirst($this->input->post('kost_machines_naam_delete')));

        // TODO
        // $databaseFunctionWasSuccess = $this->kost_machines_model->deleteKostMachines($kost_machines);
        $databaseFunctionWasSuccess = false;

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $kost_machines->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_machines/beheren/' . true);
        }
        else {
            redirect('kost_machines/beheren');
        }
    }

    // AJAX
    public function ajax_save_to_session() {
        $waardes = array(
            $this->input->post('naam'),
            intval($this->input->post('machinesoortid')),
            $this->input->post('aankoopPrijs'),
            $this->input->post('aantal'),
            $this->input->post('afschrijfperiodePerJaar'),
            $this->input->post('onderhoudFrequentiePerJaar'),
            $this->input->post('onderhoudKost'),
            $this->input->post('onderhoudUren'),
            $this->input->post('onderhoudUurloon'),
        );
        ajax_setSessionFormData("kost_machines", $waardes);
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_kostmachines', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $kost_machines = $this->kost_machines_model->getByZoekfunctie($zoeknaam);
        $data['kost_machines'] = null;

        if ($kost_machines != null) {
            $eersteRecord=true;
            foreach ($kost_machines as $kost_machine) {
                if($eersteRecord){
                    // enkel voor de eerste ook de reparaties ophalen voor de berekening te laten zien
                    $this->load->model('kost_machines_reparaties_model');
                    $kost_machine->reparaties = $this->kost_machines_reparaties_model->get_byKostMachineId($kost_machine->id);
                    $eersteRecord = false;
                }
                $kost_machine->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($kost_machine->gewijzigdDoor);
                $kost_machine->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($kost_machine->toegevoegdDoor);
                $kost_machine = getReadableDateFormats($kost_machine);
            }
            $data['kost_machines'] = $kost_machines;
        }
        $data['machineSoorten_dropdownOptions'] = $this->machineSoorten_dropdownOptions;

        $this->load->view('ajaxcontent_kost_machines_by_zoekfunctie', $data);
    }
}