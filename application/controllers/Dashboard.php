<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url','form'));
        $this->load->database(); // DB bilan ishlash uchun
    }

    public function index() {
        $data = array();

        // Foydalanuvchi nomini sessiyadan olish
        $data['username'] = $this->session->userdata('username');

        // Menyu
        $data['menu'] = array(
            (object) ['title' => 'Rayosati Talim', 'link' => 'rayosati_talim'],
            (object) ['title' => 'Bosh sahifa', 'link' => 'bosh_sahifa'],
            (object) ['title' => 'Malumotlar', 'link' => 'malumotlar'],
            (object) ['title' => 'Hisobot', 'link' => 'hisobot'],
            (object) ['title' => 'Sozlamalar', 'link' => 'sozlamalar'],
            (object) ['title' => 'Aloqa', 'link' => 'aloqa'],
            (object) ['title' => 'Istoriya', 'link' => 'istori/view/Dashboard']
        );

        // DB dan fayllarni olish
        $data['files'] = $this->db->order_by('uploaded_at', 'DESC')->get('uploaded_files')->result();

        $this->load->view('dashboard', $data);
    }

   public function upload_file() {
    $destination = $this->input->post('destination');
    $uploaded_from = $this->input->post('from_page'); // qaysi sahifadan kelgani
    $uploaded_by = $this->session->userdata('username');

    $upload_path = './uploads/' . ($destination==='all' ? 'all' : $destination) . '/';
    if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

    $this->load->library('upload', [
             'upload_path' => $upload_path,
    'allowed_types' => '*',
    'max_size' => 40960, // KB, ya'ni 20 MB
    'detect_mime' => FALSE,
    'ignore_mime_detection' => TRUE
    ]);

    if (!$this->upload->do_upload('file')) {
        $this->session->set_flashdata('info', "❌ Xatoli: " . $this->upload->display_errors());
    } else {
        $upload_data = $this->upload->data();

       // Faylni DB-ga yozish
$pages = ($destination === 'all') 
    ? ['bosh_sahifa','malumotlar','hisobot','sozlamalar','aloqa','rayosati_talim'] 
    : [$destination];

foreach ($pages as $page) {
    $this->db->set('file_name', $upload_data['file_name']);
    $this->db->set('destination', $page);
    $this->db->set('uploaded_by', $uploaded_by);
    $this->db->set('uploaded_from', $uploaded_from);
    $this->db->set('uploaded_at', 'NOW()', FALSE); // MySQL NOW()
    $this->db->insert('uploaded_files');
}


        $this->session->set_flashdata('info', "✅ Fayl muvaffaqiyatli yuklandi!");
    }


    redirect('dashboard');
}

}
