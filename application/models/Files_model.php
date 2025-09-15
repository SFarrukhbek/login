<?php
class Files_model extends CI_Model
{
    public function delete_file($id)
    {
        $file = $this->db->get_where('uploaded_files', ['id' => $id])->row();

        if ($file) {
            $path = FCPATH . 'uploads/' . $file->destination . '/' . $file->file_name;
            if (file_exists($path)) {
                unlink($path);
            }
            return $this->db->delete('uploaded_files', ['id' => $id]);
        }
        return false;
    }
}
