<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function json_output($statusHeader, $response) {
    $CI =& get_instance();
    $CI->output->set_content_type('application/json');
    $CI->output->set_status_header($statusHeader);
    $CI->output->set_output(json_encode($response));
}