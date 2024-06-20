<?php
class User_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_user($username) {
        $query = $this->db->get_where('users', array('username' => $username));
        return $query->row_array();
    }

    public function create_user($username, $password) {
        $data = array(
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT)
        );
        return $this->db->insert('users', $data);
    }
    public function get_user_by_username($username) {
        $this->db->select('id, username, email, name, password_hash'); // Asegúrate de incluir la columna 'password'
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function update_password($username, $newPassword) {
        $data = array(
            'password_hash' => password_hash($newPassword, PASSWORD_BCRYPT)
        );
        $this->db->where('username', $username);
        return $this->db->update('users', $data);
    }
}
