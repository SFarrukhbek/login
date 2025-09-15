<?php
class User_model extends CI_Model {

    public function check_user($username, $password) {
        // Parolni md5 qilib tekshiramiz
        $this->db->where('username', $username);
        $this->db->where('password', md5(sha1(md5(sha1(($password))))));
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row(); // foydalanuvchi topildi
        } else {
            return false; // topilmadi
        }
    }
    
}
