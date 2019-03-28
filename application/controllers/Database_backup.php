<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Database_backup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('database_backup_model');
        $this->load->helper('file');
        $this->load->library('upload');
        date_default_timezone_set('Europe/Brussels');
    }

    public function index() {
        $data['dbmessage'] = null;
        $data['dbimportmessage'] = null;
        $data['uploadmessage'] = null;
        if ($this->session->flashdata('dbmessage') != null) {
            $data['dbmessage'] = $this->session->flashdata('dbmessage');
        }
        if ($this->session->flashdata('dbimportmessage') != null) {
            $data['dbimportmessage'] = $this->session->flashdata('dbimportmessage');
        }
        if ($this->session->flashdata('uploadmessage') != null) {
            $data['uploadmessage'] = $this->session->flashdata('uploadmessage');
        }

        $sqlBackups = get_filenames(APPPATH . '../sql_exports/');
        arsort($sqlBackups);

        $sqlbackups_dropdownOptions = array('' => 'Bestand kiezen');
        foreach ($sqlBackups as $sqlBackup) {
            $sqlbackups_dropdownOptions[$sqlBackup] = $sqlBackup;
        }
        $data['sqlbackups_dropdownOptions'] = $sqlbackups_dropdownOptions;


        $this->session->unset_userdata('referred_from');
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Database backups beheren';
        $data['header'] = 'HeaderText';
        $data['footer'] = 'FooterText';

        // ALERT
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION
        // deze navigatie dient voor als je bv van "grondstof_ruw/beheren" naar "eenheden/heheren" gaat ipv gewoon op "eenheden/beheren" te klikken
        // wanneer je van grondstoffen/beheren komt moet er een terug-knop getoont worden.
        // De redirect boolean wordt meegegeven als parameter wanneer er een terug-knop getoont moet worden.
        // vervolgens wordt deze in session userdata opgeslaan omdat deze nofig is bij de insert, update en delete (anders verdwijnt deze weer)
        // de grondstof_ruw/beheren pagina zal dus ook met sessiondata werken, anders wordt dit formulier leeg bij het teruggaan?
        $this->session->set_userdata('redirect', false);
        $this->session->set_userdata('redirect_url', 'database_backup/index');

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_database_backups', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function export_db_backup($destination, $description = "") {
        $message = $this->database_backup_model->export_db($destination, $description);
        $this->session->set_flashdata('dbmessage', $message);
        redirect('database_backup/index');
    }

    public function import_db_backup($destination) {
        if ($destination == "pc" || $destination == "server") {
            $uploadIsSuccess = true; // deze is true indien er (bij 'pc') geen upload nodig is omdat deze al bestaat op de server
            if ($destination == "pc") {

                // upload file to server

                // NOTE:  add " 'sql'	=>	'text/plain' " to the application/config/mimes.php file !!!
                $_FILES['userfile']['type'] = 'text/plain'; // omzetten naar text/plain (gevonden op stackoverflow)
                $fileName = $_FILES['userfile']['name'];
                $existingSqlBackups = get_filenames(APPPATH . '../sql_exports/');

                // enkel uploaden indien deze nog niet bestaat(dus niets overschrijven)
                if (!in_array($fileName, $existingSqlBackups)) {
                    $this->upload->initialize($this->get_upload_options());

                    if (!$this->upload->do_upload('userfile')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('uploadmessage', $error['error']);
                        $uploadIsSuccess = false;
                    }
                    else {
                        $file_data = $this->upload->data();
                        print_r($file_data);
                        $this->session->set_flashdata('uploadmessage', 'success');
                    }
                }
            }
            else {
                $fileName = $this->input->post('gekozen_sqlnaam');
            }

            // file uitlezen en db import doen (indien het 'pc' was, eerst kijken of er geen error is (bv verkeerde file gekozen)
            if ($uploadIsSuccess || $destination == "server") {

//                //TODO drop db <-> met database_backup_model export db -> prefs 'foreign_key_checks' => TRUE'
//                $this->load->dbforge();
//                $this->dbforge->drop_database('agricon');
//                $this->dbforge->create_database('agricon');

                $filecontents = file_get_contents(base_url('/sql_exports/' . $fileName));
                $importIsSuccess = $this->database_backup_model->import_db($filecontents);

                //message maken indien de insert goed was.
                if ($importIsSuccess) {
                    $this->session->set_flashdata('dbimportmessage', 'success');

                    //TODO (alter tables fk's totdat ik het probleem van de fk's van hierboven heb gevonden)
                    $filecontents = file_get_contents(base_url('/sql_exports/keys'));
                    $this->database_backup_model->import_db($filecontents);

                }
                else {
                    $this->session->set_flashdata('dbimportmessage', 'error');
                }
            }
            redirect('database_backup/index');
        }
    }

    private function get_upload_options() {
        $config = array();
        $config['upload_path'] = './sql_exports/';
        $config['allowed_types'] = 'sql';
        $config['max_size'] = 0;
//        $config['max_width'] = 0;
//        $config['max_height'] = 0;
        return $config;
    }

//    private function changePermissions($fotoNaam, $fotoNaamThumb = "")
//    {
//        $config['source_image'] = './assets/images/autos/' . $fotoNaam;
//        chmod($config['source_image'], 0777);
//        if ($fotoNaamThumb != "") {
//            $config2['source_image'] = './assets/images/autos/' . $fotoNaamThumb;
//            chmod($config2['source_image'], 0777);
//        }
//    }
}
