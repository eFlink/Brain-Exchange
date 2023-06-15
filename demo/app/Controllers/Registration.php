<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Security\Password;

class Registration extends BaseController
{
    protected $helpers = ['form'];

    public function index() {
        $data['error'] = "";
        echo view("template/header");
        echo view("registration", $data);
        echo view("template/footer");
    }

    public function register() {
        $validation =  \Config\Services::validation();
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Registration Failed!! </div> ";
        
        // Set validation rules
        $rules = [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
        ];
        
        // Check validation rules
        if ($this->validate($rules)) {
            $user_data = array(
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            );
            
            $model = model("App\Models\User_model");
            $check = $model->register_user($user_data);
            
            if ($check) {
                return redirect()->to(base_url("login"));
            } else {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Username or email is already registered! </div> ";
                echo view("template/header");
                echo view('registration', $data);
                echo view("template/footer");
            }
        } else {
            // Display validation error messages
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Validation Error! </div> ";
            echo view("template/header");
            echo view('registration', $data);
            echo view("template/footer");
        }
    }

}
