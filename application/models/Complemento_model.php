<?php
class Complemento_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_complementos_by_user_and_date($user_id, $start_date, $end_date) {
        $this->db->select('COMPLEMENTO_ID , FOLIO , MONEDA , FECHA , PATH_PDF ,MONTO');
        $this->db->from('COMPLEMENTOS');
        $this->db->where('USER_ID', $user_id);
        $this->db->where('FECHA >=', $start_date);
        $this->db->where('FECHA <=', $end_date);
        $this->db->order_by('FECHA','ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
?>
