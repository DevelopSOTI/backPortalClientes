<?php
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        // Agregar encabezados CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function login() {
        $username = $this->input->get('username');
        $password = $this->input->get('password');

        if (empty($username) || empty($password)) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'error',
                'message' => 'Username and password required'
            ]));
            return;
        }

        $user = $this->User_model->get_user_by_username($username);

        if ($user && password_verify($password, $user->password_hash)) {
            unset($user->password_hash); // Remove password from the user object
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'user' => $user
            ]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ]));
        }
    }
    

    public function register() {
        // Leer datos JSON desde el cuerpo de la solicitud
        $input = json_decode(trim(file_get_contents('php://input')), true);

        $username = isset($input['username']) ? $input['username'] : null;
        $password = isset($input['password']) ? $input['password'] : null;

        if (!$username || !$password) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(array('status' => 'error', 'message' => 'Username and password required')));
            return;
        }

        if ($this->User_model->create_user($username, $password)) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(array('status' => 'success', 'message' => 'User registered successfully')));
        } else {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(array('status' => 'error', 'message' => 'User registration failed')));
        }
    }

    public function change_password() {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        $username = isset($input['username']) ? $input['username'] : null;
        $currentPassword = isset($input['currentPassword']) ? $input['currentPassword'] : null;
        $newPassword = isset($input['newPassword']) ? $input['newPassword'] : null;

        if (!$username || !$currentPassword || !$newPassword) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'All fields are required')));
            return;
        }

        $user = $this->User_model->get_user_by_username($username);

        if ($user && password_verify($currentPassword, $user->password_hash)) {
            $this->User_model->update_password($username, $newPassword);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success', 'message' => 'Password changed successfully')));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Current password is incorrect')));
        }
    }
}
