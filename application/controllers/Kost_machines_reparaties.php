<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kost_machines_reparaties extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kost_machines_model');
        $this->load->model('kost_machines_reparaties_model');
        $this->load->model('machine_soort_model');

        if (!$this->authex->loggedIn()) {
            redirect('home/index');
        }
    }

    public function beheren($machineId = 0,$machineNaam="") {
        if($machineId < 1 || $machineId == null){
            $machineId =$this->input->post("kost_machines_reparaties_machineid");
            $machineNaam = ucfirst($this->input->post("kost_machines_reparaties_machinenaam"));
        }
        $data['machineId'] = $machineId;
        $data['machineNaam'] = $machineNaam;

        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Reparaties beheren';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        // reparaties ophalen


        $reparaties = $this->kost_machines_reparaties_model->get_byKostMachineId($data['machineId']);
        if(isset($reparaties) && $reparaties != null){
            foreach ($reparaties as $reparatie) {
                $reparatie->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($reparatie->gewijzigdDoor);
                $reparatie->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($reparatie->toegevoegdDoor);
                $reparatie = getReadableDateFormats($reparatie);
            }
            $data['reparaties'] = $reparaties;
        }

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_kost_machines_reparaties_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function insert() {
        $userId = $this->authex->getUserId();
        $machineId = checkInt(intval($this->input->post('reparatie_machineid')));
        $machineNaam = checkString(strtolower($this->input->post('reparatie_machinenaam')));


        // reparaties ophalen
        $aantalReparaties = checkInt(intval($this->input->post('aantal_reparaties')));
        $reparaties = array();
        // aantalReparaties zijn het aantal toegevoegde. Dit kan 6 zijn. Indien er 2 niet werden ingevuld, werden deze verwijderd van de DOM
        // dit wil zeggen dat het getal 6 kan zijn, maar er maar 4 reparaties zijn. Dit kan nummer 1,2,4,6 hebben, dus niet mooi oplopend
        for($i=1;$i<=$aantalReparaties+1;$i++){
            if($this->input->post('kost_machines_reparaties_reparatieKost'.$i)){
                $reparatie = new stdClass();
                $reparatie->reparatieKost = checkFloat(floatval($this->input->post('kost_machines_reparaties_reparatieKost'.$i)));
                $reparatie->reparatieUren = checkFloat(floatval($this->input->post('kost_machines_reparaties_reparatieUren'.$i)));
                $reparatie->reparatieUurloon = checkFloat(floatval($this->input->post('kost_machines_reparaties_reparatieUurloon'.$i)));
                $reparatie->kostMachinesId= $machineId;
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
        $databaseItems .= 'Machinekost "' . ucfirst($machineNaam) . '" ';

        //
        $databaseFunctionWasSuccess = TRUE;
        if (in_array(false, $databaseFunctionWasSuccess_reparaties)) {
            //indien deze array één value "FALSE" bevat, message weergeven in error-stijl
            $databaseFunctionWasSuccess = FALSE;
        }

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $databaseItems);
        setOrUnset_sessionFormData('kost_machines', false); // true=set, false=unset

        // de totaalKosten (dat niet door de database kan gedaan worden) zelf berekenen en updaten
        calculate_and_update_reparatieEnMachineTotaalKostenPerJaar($machineId,$userId);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_machines_reparaties/beheren/'.$machineId .'/'.$machineNaam);
        }
        else {
            redirect('kost_machines_reparaties/beheren/' .$machineId.'/'.$machineNaam);
        }
    }

    public function update() {
        $userId = $this->authex->getUserId();
        $reparatieId = checkInt(intval($this->input->post('reparatie_id_update')));
        $machineId = checkInt(intval($this->input->post('reparatie_machineid_update')));
        $machineNaam = checkString($this->input->post('reparatie_machinenaam_update'));

        $reparatie = new stdClass();
        $reparatie->id = $reparatieId;
        $reparatie->reparatieKost = checkFloat(floatval($this->input->post('reparatie_kost_update')));
        $reparatie->reparatieUren = checkFloat(floatval($this->input->post('reparatie_uren_update')));
        $reparatie->reparatieUurloon = checkFloat(floatval($this->input->post('reparatie_uurloon_update')));
        $reparatie->gewijzigdDoor = $userId;

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->kost_machines_reparaties_model->updateKostMachinesReparatie($reparatie);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', 'Reparatie van ' . ucfirst($machineNaam));

        // na reparatie-update ook reparatieKostPerJaar bij kost_machine updaten.
        calculate_and_update_reparatieEnMachineTotaalKostenPerJaar($machineId,$userId);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_machines_reparaties/beheren/'.$machineId .'/'.$machineNaam);
        }
        else {
            redirect('kost_machines_reparaties/beheren/' .$machineId.'/'.$machineNaam);
        }
    }

    public function delete() {
        $userId = $this->authex->getUserId();
        $reparatie = new stdClass();
        $reparatie->id = checkInt(intval($this->input->post('reparatie_id_delete')));
        $machineId = checkInt(intval($this->input->post('reparatie_machineid_delete')));
        $machineNaam = checkString(ucfirst($this->input->post('reparatie_machinenaam_delete')));

        // TODO
        // $databaseFunctionWasSuccess = $this->kost_machines_reparaties_model->deleteKostMachinesReparatie($reparatie);
        $databaseFunctionWasSuccess = false;

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', 'Reparatie van ' . ucfirst($machineNaam));

        calculate_and_update_reparatieEnMachineTotaalKostenPerJaar($machineId,$userId);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('kost_machines_reparaties/beheren/'.$machineId .'/'.$machineNaam);
        }
        else {
            redirect('kost_machines_reparaties/beheren/' .$machineId.'/'.$machineNaam);
        }
    }
}