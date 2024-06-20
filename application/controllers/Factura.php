<?php
class Factura extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Factura_model');
        $this->load->helper('url');
        // Agregar encabezados CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function get_facturas() {
        $user_id = $this->input->get('user_id');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (empty($user_id) || empty($start_date) || empty($end_date)) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(array('status' => 'error', 'message' => 'All parameters are required')));
            return;
        }

        $facturas = $this->Factura_model->get_facturas_by_user_and_date($user_id, $start_date, $end_date);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status' => 'success', 'facturas' => $facturas)));
    }
}
?>
