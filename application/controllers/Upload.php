<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form', 'url'));
        date_default_timezone_set('Europe/Brussels');
    }

    public function index()
    {
//        $this->load->view('upload_form', array('error' => ' '));
    }

    public function do_upload()
    {
        // file uploaden naar server
        $files = $_FILES;
        for($i=0; $i< 1; $i++) {
            $_FILES['userfile']['name']= $files['userfile']['name'][$i];
            $_FILES['userfile']['type']= $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error']= $files['userfile']['error'][$i];
            $_FILES['userfile']['size']= $files['userfile']['size'][$i];
//            echo $_FILES['userfile']['name'];
//            echo base_url('/uploads/');
            $this->upload->initialize($this->get_upload_options());
            $this->upload->do_upload();

//
//            if ( ! $this->upload->do_upload())
//            {
//                $error = array('error' => $this->upload->display_errors());
//
//                $this->load->view('upload_form', $error);
//            }
//            else
//            {
//                $data = array('upload_data' => $this->upload->data());
//
//                $this->load->view('upload_success', $data);
//            }

        }

//        redirect('home/autoDetail/'.$autoId);
    }

//    private function get_upload_options()
//    {
//        $config = array();
//        $config['upload_path'] = base_url('/uploads/');
////        $config['upload_path'] = './uploads';
//
////        $config['upload_path'] = './assets/database_exports';
////        $config['allowed_types'] = 'sql';
////        $config['max_size'] = 0;
////        $config['max_width'] = 0;
////        $config['max_height'] = 0;
//        return $config;
//    }
//
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

?>
