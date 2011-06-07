<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bot extends CI_Controller {

    public function index() {
        $this->load->view('welcome_message');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */