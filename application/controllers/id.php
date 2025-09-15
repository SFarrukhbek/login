<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class id extends CI_Controller {

    public function index()
    {
        // oddiygina bitta view chaqiramiz
        $this->load->view('id_vews');
    }
}
