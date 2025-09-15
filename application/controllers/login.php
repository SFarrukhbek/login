<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','form'));
        $this->load->library('session');
    }

    // Login form
    public function index()
    {
        $this->load->view('login');
    }

    // Login tekshirish
    public function auth()
    {
        $username = $this->input->post('username');
        $password = md5(sha1(md5(sha1($this->input->post('password')))));

        // Foydalanuvchini DB dan tekshirish
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $user = $this->db->get('users')->row(); // 1 ta foydalanuvchi olish

        if($user){
            // Sessiyani saqlash
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('id', $user->id);

            // Rolga qarab redirect
            switch($user->id) {
            case 1:
             redirect('dashboard');
              break;
               case 2:
                redirect('rayosati_talim');
                 break;
                  case 3:
                   redirect('bosh_sahifa');
                    break;
                     case 4:
                      redirect('malumotlar');
                       break;
                        case 5:
                         redirect('hisobot');
                          break;
                           case 6:
                            redirect('sozlamalar');
                             case 7:
                             redirect('aloqa');
                             break;
                              default:
                               redirect('id'); // boshqa rollar
            }
        } else {
            $this->session->set_flashdata('error', '❌ Login yoki parol noto‘g‘ri!');
            redirect('login');
        }
    }

    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
