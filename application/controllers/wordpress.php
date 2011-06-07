<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wordpress extends CI_Controller {

    public function index() {
        $this->load->model('wordpress_model');
        $wordpresses = $this->wordpress_model->find();
        $this->load->view('wordpress');
    }

    public function create() {
        
    }

    public function edit() {
        
    }

    public function delete() {
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */