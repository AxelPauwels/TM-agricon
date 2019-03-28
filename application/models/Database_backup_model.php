<?php

class Database_backup_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    function get_sql_backups() {
        $eenheden = $this->eenheid_model->getAll();
        $this->eenheden_dropdownOptions = array('' => 'Selecteer...');
        foreach ($eenheden as $eenheid) {
            $this->eenheden_dropdownOptions[$eenheid->id] = ucwords($eenheid->naam);
        }
    }

    function export_db($destination, $description) {
        $backupDescription = "";
        if ($description != null && $description != "") {
            $backupDescription = "_" . str_replace('%20', '_', $description);
        }
        $fileName = date("Y-m-d") . "_" . date("H") . 'u' . date("i") . $backupDescription . '.sql';

        $serverPath = 'sql_exports/' . $fileName;

        // Load the DB utility class
        $this->load->dbutil();

        $prefs = array(
            /*'tables'        => array('table1', 'table2'),*/   // Array of tables to backup. (blank for all)
            /*'ignore'        => array(),*/                     // List of tables to omit from the backup
            'format' => 'txt',                                  // gzip, zip, txt
            /*'filename'      => $fileName,*/                   // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE,                                 // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE,                               // Whether to add INSERT data to backup file
            'newline' => "\n",                                  // Newline character used in backup file
            'foreign_key_checks' => FALSE                       // Whether output should keep foreign key checks enabled. TODO moet eigenlijk 'TRUE' zijn, zie de database_backup controller
        );

        // Backup your entire database and assign it to a variable
        $backupSql = $this->dbutil->backup($prefs);

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        if (write_file($serverPath, $backupSql, 'a+')) {    //more info about mode: http://php.net/manual/en/function.fopen.php
            $message = 'success';
        }
        else {
            $message = 'error';
        }

        if ($destination == "pc") {
            // Load the download helper and send the file to your desktop
            $this->load->helper('download');
            force_download($fileName, $backupSql);
            return $message;
        }
        return $message;
    }

    function import_db($file_contents) {
        $queryList = ['CREATE DATABASE IF NOT EXISTS `agricon` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;', 'USE `agricon`;'];
//        $queryList = ['DROP DATABASE IF EXISTS `agricon`; CREATE DATABASE IF NOT EXISTS `agricon` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;', 'USE `agricon`;'];

        // NOTE: explode-functie verwijderd het delimiter-teken
        // $queryList_comments = explode(";", $file_contents);

        // splitsen op het ";" karakter
        $queryList_containsComments = preg_split('@(?<=;)@', $file_contents);

        //comments eruit halen
        foreach ($queryList_containsComments as $query_may_contain_a_comment) {

            // indien er "#" aanwezig zijn...
            if (strpos($query_may_contain_a_comment, "#") !== false) {

                // splitsen op het "#" karakter
                $mixedList = preg_split('@(?<=#)@', $query_may_contain_a_comment);
                foreach ($mixedList as $item) {
                    if (strpos($item, "#") === false) {
                        // -> bevat echte queries
                        array_push($queryList, $item);
                        echo $item . '<br>';
                    }
                }
            }
            else {
                // is echte query
                array_push($queryList, $query_may_contain_a_comment);
            }
        }

        // als laatste leeg is of geen alpabetische karakter bevat, verwijderen uit array;
        if (empty($queryList[count($queryList) - 1]) || ctype_alpha($queryList[count($queryList) - 1]) == false) {
            unset($queryList[count($queryList) - 1]);
        }

        $oneQueryWasSuccesful = false;
        $isAlreadyChecked = false;
        foreach ($queryList as $query) {
            if ($query) {
                $this->db->query($query);
            }
            if (!$isAlreadyChecked) {
                $isAlreadyChecked = true;
                $oneQueryWasSuccesful = $this->db->affected_rows() > 0;
            }
        }
        return $oneQueryWasSuccesful;
    }







    // NOTE: werkt nog niet, moet eerst de autoload tegen gaan en dan database connectie pas maken
//    public function create_database_if_not_exist($db_name, $ifnotexists = false) {
//        if ($ifnotexists) {
//            $db_name = "IF NOT EXISTS " . $db_name;
//        }
//
////        $this->dbforge->create_database($db_name);
//        $sql = $this->dbforge->create_database($db_name);
//
//        if (is_bool($sql)) {
//            return $sql;
//        }
//
//        return $this->db->query($sql);
//    }

}

?>