<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function getProduct($artikelcode) {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request: Only GET allowed'));
        }
        else {
            $response = $this->product_model->api_getByArtikelcode(strtolower($artikelcode));
            json_output(200, $response);
        }
    }

    public function getProducten() {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request: Only GET allowed'));
        }
        else {
            $response = $this->product_model->api_getAll();
            json_output(200, $response);
        }
    }


}
