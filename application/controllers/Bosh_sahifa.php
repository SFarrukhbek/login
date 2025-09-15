<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bosh_sahifa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session'); 
    }

    public function index()
    {
        $data['username'] = $this->session->userdata('username');

    // Menu
    $data['menu'] = [];
    $data['current_page'] = 'bosh_sahifa ';

    // Fayllarni DB-dan olish (aloqa va all uchun)
    $this->db->order_by('uploaded_at', 'DESC');
    $this->db->where_in('destination', ['bosh_sahifa','all']);
    $data['files'] = $this->db->get('uploaded_files')->result();

    $this->load->view('bosh_sahifa', $data);
    }

     public function upload_file() {
    $text = $this->input->post('textariya'); 
    $destination = $this->input->post('destination');
    $uploaded_from = $this->input->post('from_page'); // qaysi sahifadan kelgani
    $uploaded_by = $this->session->userdata('username');

    $upload_path = './uploads/' . ($destination==='all' ? 'all' : $destination) . '/';
    if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

    $file_uploaded = false;
    $upload_data = [];

    // Fayl tanlangan bo‘lsa, yuklaymiz
    if (!empty($_FILES['file']['name'])) {
        $this->load->library('upload', [
            'upload_path' => $upload_path,
            'allowed_types' => '*',
            'max_size' =>  40960, // KB, ya'ni 20 MB
            'detect_mime' => FALSE,
            'ignore_mime_detection' => TRUE
        ]);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('info', "❌ Xatolik: " . $this->upload->display_errors());
            redirect('bosh_sahifa');
        } else {
            $upload_data = $this->upload->data();
            $file_uploaded = true;
        }
    }

    // DB-ga yozish (fayl bo‘lsa file_name bilan, bo‘lmasa null bilan)
    $pages = ($destination === 'all') 
        ? ['rayosati_talim','aloqa','hisobot','sozlamalar','malumotlar','Dashboard'] 
        : [$destination];

    foreach ($pages as $page) {
        $this->db->set('file_name', $file_uploaded ? $upload_data['file_name'] : null);
        $this->db->set('text', $text);
        $this->db->set('destination', $page);
        $this->db->set('uploaded_by', $uploaded_by);
        $this->db->set('uploaded_from', $uploaded_from);
        $this->db->set('uploaded_at', 'NOW()', FALSE); // MySQL NOW()
        $this->db->insert('uploaded_files');
    }

    $this->session->set_flashdata('info', "✅ Ma'lumot muvaffaqiyatli saqlandi!");
    redirect('bosh_sahifa');
}


public function delete($id)
{
    // Model chaqiramiz
    $this->load->model('Files_model');

    // Faylni bazadan va diskdan o‘chiramiz
    if ($this->Files_model->delete_file($id)) {
        $this->session->set_flashdata('success', 'Файл муваффақиятнок хориҷ шуд ✅');
    } else {
        $this->session->set_flashdata('error', 'Файл хориҷ нашуд ❌');
    }

    // Orqaga qaytish
    redirect('bosh_sahifa');
}
}