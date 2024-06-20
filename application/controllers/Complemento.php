<?php
class Complemento extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Complemento_model');
        $this->load->helper('url');
        // Agregar encabezados CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function get_complementos() {
        $user_id = $this->input->get('user_id');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (empty($user_id) || empty($start_date) || empty($end_date)) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(array('status' => 'error', 'message' => 'All parameters are required')));
            return;
        }

        $complementos = $this->Complemento_model->get_complementos_by_user_and_date($user_id, $start_date, $end_date);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status' => 'success', 'complementos' => $complementos)));
    }
}
?>
