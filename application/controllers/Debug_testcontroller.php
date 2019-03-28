<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_testcontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        require_once("PHPDebug.php");
    }


    public function index() {
        $this->session->unset_userdata('referred_from');
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Kostprijzen beheren';
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
        $this->session->set_userdata('redirect_url', 'home/index');

        $partials = array('myHeader' => 'main_header', 'myContent' => 'main_content', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function log() {
        $this->session->unset_userdata('referred_from');
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'TEST CONSOLE LOG';
        $data['header'] = 'HeaderText';
        $data['footer'] = 'FooterText';

        $fruits = array("banana", "apple", "strawberry", "pineaple");
        $data['consolelog'] = $fruits;

        $partials = array('myHeader' => 'main_header', 'myContent' => 'main_content', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

// TODO: onderstaande DEBUG functie werkt voor console.log(),
// TODO: maar print niet echt arrays en objecten, werk met "$data['consolelog'] en print het in de view met <script> tag (zie voorbeeld in home/log)
//    public function debug(){
//        $debug = new PHPDebug();
//
//        // simple message to console
//        $debug->debug("A very simple message");
//
//        // vaiable to console
//        $x = 3;
//        $y = 5;
//        $z = $x/$y;
//        $debug->debug("Variable Z: ", $z);
//
//        // a warnign
//        $debug->debug("A simple Warning", null, WARN);
//
//        // info
//        $debug->debug("A simple Info message", null, INFO);
//
//        // An error
//        $debug->debug("A simple error messsage", null, ERROR);
//
//        // Array in console
//        $fruits = array("banana", "apple", "strawberry", "pineaple");
//        $fruits = array_reverse($fruits);
//        $debug->debug("Fruits array", $fruits);
//
//
//        // object to console
//        $book               = new stdClass;
//        $book->title        = "Harry Potter and the Prisoner of Azkaban";
//        $book->author       = "J. K. Rowling";
//        $book->publisher    = "Arthur A. Levine Books";
//        $book->amazon_link  = "http://www.amazon.com/dp/0439136369/";
//        $debug->debug("Object", $book);
//
//      //require_once("PHPDebug.php"); // in de class constructor
//      //$debug = new PHPDebug(); // in de class function
//      //$debug->debug("A very simple message"); // in de class function
//


//    }


}
