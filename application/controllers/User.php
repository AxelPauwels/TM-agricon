<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends CI_Controller {
    var $userLevel_dropdownOptions;

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->getDropdownOptions();
    }

    private function getDropdownOptions() {
        // userlevel dropdown maken
        $this->userLevel_dropdownOptions = ['' => 'Selecteer',
            1 => 'Niveau 1 - Kan beheren (momenteel nog geen extra functies)',
            2 => 'Niveau 2 - Kan beheren (momenteel nog geen extra functies)',
            3 => 'Niveau 3 - Kan beheren (momenteel nog geen extra functies)',
            4 => 'Niveau 4 - Kan beheren (momenteel nog geen extra functies)',
            5 => 'Niveau 5 - Kan beheren + users beheren'];
    }


    public function login() {
        clearstatcache();
        $naam = strtolower($this->input->post('user_naam'));
        $wachtwoord = sha1($this->input->post('user_wachtwoord'));

        //set alertSettings
        $sessionAlertData = array(
            'show_alert' => FALSE,
            'database_is_success' => '',
            'database_function' => '',
            'database_item' => ''
        );
        $this->session->set_userdata($sessionAlertData);

        if ($this->authex->login($naam, $wachtwoord)) {
            // trigger database-backup
            $this->load->model('database_backup_model');
            $message = $this->database_backup_model->export_db("server", "AUTO_BACKUP_" . strtoupper($naam));

            redirect('home/index');
        }
        redirect('home/index');
    }

    public function logout() {
        clearstatcache();
        $this->authex->logout();
        $this->session->sess_destroy();

        redirect('home/index');
    }

    // NORMALE FUNCTIES
    public function gebruikers_beheren() {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Gebruikers beheren';
        $data['header'] = 'HeaderText';
        $data['footer'] = 'FooterText';

        //data ophalen
        $data['userLevel_dropdownOptions'] = $this->userLevel_dropdownOptions;
        $data['zoeknaam_user_value'] = getSessionZoeknaamvalue('user'); // READ INFO IN THIS FUNCTION !!

        // ALERT
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        $this->session->set_userdata('redirect', false);
        $this->session->set_userdata('redirect_url', 'user/gebruikers_beheren');

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_gebruikers_beheren', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function check_if_username_exists() {
        $naam = $this->input->post("naam");
        $exist = $this->user_model->checkIfUsernameExists($naam);
        echo json_encode($exist);
    }

    public function insert() {
        $wachtwoord1 = $this->input->post("user_password1");
        $wachtwoord2 = $this->input->post("user_password2");
        if ($wachtwoord1 !== $wachtwoord2) {
            return;
        }

        $user = new stdClass();
        $user->naam = checkString(strtolower($this->input->post("user_naam")));
        $user->wachtwoord = sha1($wachtwoord1);
        $user->level = checkInt(intval($this->input->post("user_level")));
        $insertedId = $this->user_model->insertUser($user);
        if ($insertedId > 0) {
            $databaseFunctionWasSuccess = true;
        }
        else {
            $databaseFunctionWasSuccess = false;
        }
        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'insert', $user->naam);

        redirect('user/gebruikers_beheren');
    }


    public function update() {
        $userId = $this->authex->getUserId();
        $user = new stdClass();
        $user->id = checkInt(intval($this->input->post("user_id_update")));
        $user->naam = checkString(strtolower($this->input->post("user_naam_update")));
        $user->level = checkInt(intval($this->input->post("user_level_update")));
        $nieuwWachtwoord = $this->input->post("user_password_update");
        // enkel het wachtwoord updaten indien het aangepast is
        $currentUser = $this->user_model->get($user->id);
        if ($currentUser->wachtwoord !== $nieuwWachtwoord) {
            $user->wachtwoord = sha1($nieuwWachtwoord);
        }

        //indien success, een alert message in session opslaan
        $databaseFunctionWasSuccess = $this->user_model->updateUser($user);
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'update', $user->naam);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('user/gebruikers_beheren/' . true);
        }
        else {
            redirect('user/gebruikers_beheren');
        }
    }

    public function delete() {
        $this->load->model('configuratie_model');
        $this->load->model('folie_gesneden_model');
        $this->load->model('folie_ruw_model');
        $this->load->model('grondstof_afgewerkt_model');
        $this->load->model('grondstof_categorie_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('kost_elektriciteit_model');
        $this->load->model('kost_gebouwen_model');
        $this->load->model('kost_machines_model');
        $this->load->model('kost_machines_reparaties_model');
        $this->load->model('kost_personeel_model');
        $this->load->model('kost_samenstelling_gebouwen_model');
        $this->load->model('kost_samenstelling_machines_model');
        $this->load->model('land_model');
        $this->load->model('leverancier_model');
        $this->load->model('leverancier_soort_model');
        $this->load->model('machine_soort_model');
        $this->load->model('product_model');
        $this->load->model('product_samenstelling_model');
        $this->load->model('productiekost_model');
        $this->load->model('stadgemeente_model');

        $user = new stdClass();
        $user->id = checkInt(intval($this->input->post('user_id_delete')));
        $user->naam = checkString(strtolower($this->input->post('user_naam_delete')));

        //alle gegevens die toegevoegd of gewijzigd zijn naar "geen" linken
        $user = $this->user_model->getUser_byId($user->id);
        if ($user->level < 5) {
            $this->configuratie_model->eenheid_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->configuratie_model->omzet_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->configuratie_model->verpakkingskost_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->folie_gesneden_model->folieGesneden_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->folie_ruw_model->folieRuw_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->grondstof_afgewerkt_model->grondstofAfgewerkt_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->grondstof_categorie_model->grondstofCategorie_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->grondstof_ruw_model->grondstofRuw_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_elektriciteit_model->kostElektriciteit_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_gebouwen_model->kostGebouwen_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_machines_model->kostMachines_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_machines_reparaties_model->kostMachinesReparatie_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_personeel_model->kostPersoneel_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_samenstelling_gebouwen_model->kostGebouwen_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->kost_samenstelling_machines_model->kostMachines_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->land_model->land_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->leverancier_model->leverancier_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->leverancier_soort_model->leverancierSoort_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->machine_soort_model->machineSoort_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->product_model->product_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->product_samenstelling_model->productSamenstelling_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->productiekost_model->productiekost_setAllNA_toegevoegd_of_gewijzigd($user->id);
            $this->stadgemeente_model->stadGemeente_setAllNA_toegevoegd_of_gewijzigd($user->id);

            $databaseFunctionWasSuccess = $this->user_model->deleteUser($user);
            $databaseMessage = ucfirst($user->naam);
        }
        else {
            $databaseFunctionWasSuccess = false;
            $databaseMessage = ucfirst($user->naam) . ' heeft level 5 en ';
        }

        //indien success, een alert message in session opslaan
        setSessionAlertData(true, $databaseFunctionWasSuccess, 'delete', $databaseMessage);

        // REDIRECT
        if ($this->session->userdata('redirect')) {
            redirect('user/gebruikers_beheren' . true);
        }
        else {
            redirect('user/gebruikers_beheren');
        }
    }

    function ajax_get_by_zoekfunctie() {
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $this->session->set_userdata('zoeknaam_user', $zoeknaam);
        $data['gezochte_zoeknaam'] = $zoeknaam;

        $data['user'] = $this->authex->getUserInfo();
        $users = $this->user_model->getByZoekfunctie($zoeknaam);

        $data['users'] = null;
        if ($users != null) {
            foreach ($users as $user) {
                $timestamp_actief = strtotime($user->actief);
                $user->actief_datum = date('d/m/Y', $timestamp_actief);
                $user->actief_tijd = date('H:i', $timestamp_actief);
            }
            $data['users'] = $users;
        }

        $data['userLevel_dropdownOptions'] = $this->userLevel_dropdownOptions;

        $this->load->view('ajaxcontent_users_by_zoekfunctie', $data);
    }

}
