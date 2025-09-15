<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class istori extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function view($page) {
    // faqat shu sahifa uchun fayllar
    $files = $this->db
        ->where('destination', $page)
        ->or_where('destination', 'all') // all bo‘lgan fayllar ham chiqadi
        ->order_by('uploaded_at', 'DESC')
        ->get('uploaded_files')
        ->result();

    $data['page'] = $page;
    $data['files'] = $files;
    $this->load->view('istori', $data);
}

}
