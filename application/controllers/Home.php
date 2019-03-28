<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        require_once("PHPDebug.php");
        $this->load->model('product_model');
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

    public function producten() {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Producten';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $data['zoeknaam_product_bekijken_value'] = getSessionZoeknaamvalue('product_bekijken'); // READ INFO IN THIS FUNCTION !!
        $data['zoeknaam_product_bekijkenviacode_value'] = getSessionZoeknaamvalue('product_bekijkenviacode'); // READ INFO IN THIS FUNCTION !!

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_product_bekijken', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function product_grondstoffenBekijken($productId) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Grondstoffen';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $this->load->model('productiekost_model');
        $this->load->model('product_samenstelling_model');
        $this->load->model('grondstof_afgewerkt_model');
        $this->load->model('grondstof_ruw_model');
        $this->load->model('grondstof_categorie_model');

        $product = $this->product_model->get($productId);
        $productieKost = $this->productiekost_model->get($product->productieKostId);

        $data['productNaam'] = $product->artikelCode . ' - ' . $product->beschrijving;
        $data['productId'] = $product->id;
        $data['productieKostId'] = $product->productieKostId;
        $data['productieKostPrijs'] = $productieKost->productieKostPerJaar;

        $productSamenstellingen = $this->product_samenstelling_model->getByProductId($productId);
        foreach ($productSamenstellingen as $samenstelling) {
            $samenstelling->grondstof = $this->grondstof_afgewerkt_model->get($samenstelling->grondstofAfgewerktId);

            $samenstelling->grondstofRuw = $this->grondstof_ruw_model->get($samenstelling->grondstof->grondstofRuwId);
            $samenstelling->grondstofCategorie = $this->grondstof_categorie_model->get($samenstelling->grondstofRuw->grondstofCategorieId);

            $samenstelling->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($samenstelling->gewijzigdDoor);
            $samenstelling->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($samenstelling->toegevoegdDoor);
            $samenstelling = getReadableDateFormats($samenstelling);
        }
        $data['samenstellingen'] = $productSamenstellingen;

        // ALERT - een alert maken, tonen, en terug op false zetten (wordt voor het eerst geset tijdens het inloggen)
        $data['alert'] = create_alert($this->session->show_alert, $this->session->database_is_success, $this->session->database_function, $this->session->database_item);

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton(true, "home/producten", "home/producten");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_product_bekijken_grondstoffen', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function product_productiekostenBekijken($productId) {
        $data['user'] = $this->authex->getUserInfo();
        $data['title'] = 'Productiekosten';
        $data['header'] = 'textHeader';
        $data['footer'] = 'Agricon &copy; 2018';

        $this->load->model('productiekost_model');
        $this->load->model('kost_elektriciteit_model');
        $this->load->model('kost_personeel_model');
        $this->load->model('kost_samenstelling_gebouwen_model');
        $this->load->model('kost_samenstelling_machines_model');
        $this->load->model('kost_gebouwen_model');
        $this->load->model('kost_machines_model');
        $this->load->model('kost_machines_reparaties_model');
        $this->load->model('configuratie_model');

        $product = $this->product_model->get($productId);
        $productieKost = $this->productiekost_model->get($product->productieKostId);

        $data['productNaam'] = $product->artikelCode . ' - ' . $product->beschrijving;
        $data['productId'] = $product->id;
        $data['productieKostId'] = $product->productieKostId;
        $data['productieKostPrijs'] = $productieKost->productieKostPerJaar;

        // properties opvullen
        $geschatteOmzet = $this->configuratie_model->omzet_get($productieKost->omzetId);
        $productieKost->geschatteOmzet = $geschatteOmzet->naam . ' - ' . number_format($geschatteOmzet->aantalZakjesPerJaar, 0, ",", ".") . ' zakjes/jaar (' . $geschatteOmzet->zakjesPerDag . ' zakjes/dag &times; ' . $geschatteOmzet->dagenPerJaar . ' werkdagen/jaar)';

        $elektriciteit = $this->kost_elektriciteit_model->get($productieKost->electriciteitKostId);
        $productieKost->elektriciteit = $elektriciteit->naam . ' - € ' . number_format($elektriciteit->elektriciteitKostPerJaar, 0, ",", ".") . '/jaar (' . number_format($elektriciteit->verbruikPerJaarInKwh, 0, ",", ".") . ' verbruik/jaar aan € ' . number_format($elektriciteit->kostprijsPerKwh, 2) . '/kwh' . ')';

        $personeel = $this->kost_personeel_model->get($productieKost->personeelKostId);
        $productieKost->personeel = $personeel->naam . ' - € ' . number_format($personeel->personeelKostPerJaar, 0, ",", ".") . '/jaar (' . round($personeel->aantalWerknemers) . ' werknemers, ' . round($personeel->aantalUren) . ' uur/dag aan € ' . round($personeel->uurloon) . '/uur)';

        $gebouwenSamenstellingen = $this->kost_samenstelling_gebouwen_model->getByProductieKostId($productieKost->id);
        $gebouwen = array();

        foreach ($gebouwenSamenstellingen as $samenstelling) {
            $gebouw = $this->kost_gebouwen_model->get($samenstelling->kostGebouwenId);
            $text = new stdClass();
            $text->gebouwNaam = ucwords($gebouw->naam);
            $text->gebouwText = '€ ' . number_format($gebouw->gebouwKostPerJaar, 0, ",", ".") . '/jaar (gekocht voor € ' . number_format($gebouw->aankoopPrijs, 0, ",", ".") . ' op ' . round($gebouw->afschrijfperiodePerJaar) . ' jaar)';
            array_push($gebouwen, $text);
        }
        $productieKost->gebouwen_titel = '';
        $productieKost->gebouwen = $gebouwen;

        $machinesSamenstellingen = $this->kost_samenstelling_machines_model->getByProductieKostId($productieKost->id);
        $machines = array();

        foreach ($machinesSamenstellingen as $samenstelling) {
            $text = new stdClass();

            $machine = $this->kost_machines_model->get($samenstelling->kostMachinesId);
            $text->machineNaam = ucwords($machine->naam);
            $text->machineText = '€ ' . number_format($machine->totaalMachineKostPerJaar, 0, ",", ".") . '/jaar (' . round($machine->aantal) . ' machines gekocht voor € ' . number_format($machine->aankoopPrijs, 0, ",", ".") . ' op ' . number_format($gebouw->afschrijfperiodePerJaar, 0, ",", ".") . ' jaar)';
            $text->onderhoudText = '€ ' . number_format($machine->onderhoudKostPerJaar, 0, ",", ".") . '/jaar (' . round($machine->onderhoudFrequentiePerJaar) . ' keer/jaar met een kost van € ' . number_format($machine->onderhoudKost, 0, ",", ".") . '/onderhoud en ' . round($machine->onderhoudUren) . ' werkuren/onderhoud aan € ' . round($machine->onderhoudUurloon) . '/uur)';

            //reparaties
            $reparatiesRuw = $this->kost_machines_reparaties_model->get_byKostMachineId($samenstelling->kostMachinesId);
            $reparaties = array();
            $teller = 0; // om naam te maken 'reparatie 1', 'reparatie 2' ...
            foreach ($reparatiesRuw as $item) {
                $teller++;
                $reparatietext = new stdClass();
                $reparatietext->reparatieNaam = 'Reparatie ' . $teller;
                $reparatietext->reparatieText = '€ ' . number_format($item->reparatieKostPerReparatie, 0, ",", ".") . '/reparatie (met een kost van € ' . number_format($item->reparatieKost, 0, ",", ".") . '/reparatie en ' . round($item->reparatieUren) . ' werkuren/reparatie aan € ' . round($item->reparatieUurloon) . '/uur)';
                array_push($reparaties, $reparatietext);
            }
            $text->reparaties = $reparaties;
            array_push($machines, $text);
        }
        $productieKost->machines = $machines;
        $productieKost->machines_titel = '';

        $data['productieKost'] = $productieKost;

        // NAVIGATION BUTTON - show backbuttons or not
        $backButtonData = setNavigationBackbutton(true, "home/producten", "home/producten");
        foreach ($backButtonData as $key => $value) {
            $data[$key] = $value;
        }

        $partials = array('myHeader' => 'main_header', 'myContent' => 'content_product_bekijken_productiekosten', 'myFooter' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    function ajax_get_by_zoekfunctie() {
        $this->load->model('user_model');
        $this->load->model('folie_gesneden_model');
        $this->load->model('folie_ruw_model');
        $this->load->model('configuratie_model');

        $data['user'] = $this->authex->getUserInfo();
        $zoeknaam = strtolower($this->input->post('zoeknaam'));
        $codeOfNaam = strtolower($this->input->post('codeofnaam'));

        switch ($codeOfNaam) {
            case "alles":
                $this->session->set_userdata('zoeknaam_product_bekijkenviacode', '');
                $this->session->set_userdata('zoeknaam_product_bekijken', '');
                $producten = $this->product_model->getByZoekfunctie('', "alles");
                break;
            case "code":
                $this->session->set_userdata('zoeknaam_product_bekijkenviacode', $zoeknaam);
                $this->session->set_userdata('zoeknaam_product_bekijken', ''); // andere leeg maken
                $producten = $this->product_model->getByZoekfunctie($zoeknaam, "artikelCode");
                break;
            case "naam":
                $this->session->set_userdata('zoeknaam_product_bekijken', $zoeknaam);
                $this->session->set_userdata('zoeknaam_product_bekijkenviacode', ''); // andere leeg maken
                $producten = $this->product_model->getByZoekfunctie($zoeknaam, "beschrijving");
                break;
        }

        $data['producten'] = null;
        if ($producten != null) {
            foreach ($producten as $product) {
                $folie = $this->folie_gesneden_model->get($product->folieId);
                $folieRuw = $this->folie_ruw_model->get($folie->folieRuwId);
                $product->folie = ucwords($folie->naam) . ' €' . $folie->prijsPerZakje . '/st - micron ' . $folieRuw->micronDikte . " (" . number_format($folie->lengteAfslag, 2) . " &times; " . number_format($folie->breedte, 0) . ")";
                $product->verpakkingskost = $this->configuratie_model->verpakkingskost_get($product->verpakkingsKostId)->verpakkingskost;
                $product->gewijzigdDoorUser = $this->user_model->getUserNaam_byId($product->gewijzigdDoor);
                $product->toegevoegdDoorUser = $this->user_model->getUserNaam_byId($product->toegevoegdDoor);
                $product = getReadableDateFormats($product);
            }
            $data['producten'] = $producten;
        }
        $this->load->view('ajaxcontent_product_bekijken_by_zoekfunctie', $data);
    }

    function ajax_getCalulationMessage_product() {
        $productid = $this->input->post('productid');
        $productiekostid = $this->input->post('productiekostid');
        return getCalulationMessage_product($productid, $productiekostid);
    }

}
