 <?php
class Menu_model extends CI_Model {

    public function get_menu()
    {
    
        $query = $this->db->get('menu');
        return $query->result();
    }
}
