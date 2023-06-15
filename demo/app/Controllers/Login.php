<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $data['error'] = "";
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            return redirect()->to(base_url('home'));
        }
        else {
            $session = session();
            $username = $session->get('username');
            $password = $session->get('password');
            if ($username && $password) {
                return redirect()->to(base_url('home'));
            } else {
                echo view('template/header');
                echo view('login', $data);
                echo view('template/footer');
            }
        }
    }

    public function check_login()
    {
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $model = model('App\Models\User_model');
        $user = $model->login($username, $password);
        $if_remember = $this->request->getPost('remember');
        if ($user) {
            # Create a session 
            $session = session();
            $session->set('user_id', $user['user_id']);
            $session->set('logged_in', true);
            $session->set('username', $username);
            $session->set('password', $password);
            if ($if_remember) {
                # Create a cookie
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            }
            return redirect()->to(base_url('home'));
        } else {
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    public function logout()
    {
        helper('cookie');
        $session = session();
        $session->destroy();
        //destroy the cookie
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
        return redirect()->to(base_url('login'));
    }
}
