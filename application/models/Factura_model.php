<?php
class Factura_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_facturas_by_user_and_date($user_id, $start_date, $end_date) {
        $this->db->select('id, user_id, nombre_pdf, path_pdf, fecha_pdf,monto,moneda');
        $this->db->from('facturas');
        $this->db->where('user_id', $user_id);
        $this->db->where('fecha_pdf >=', $start_date);
        $this->db->where('fecha_pdf <=', $end_date);
        $this->db->order_by('fecha_pdf','ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
?>
