<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function index() {
        $this->load->view('form');
    }

    function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);

        $this->upload->do_upload();
        $upload_data = $this->upload->data();
        $data['upload_data'] = json_encode($upload_data);
        $this->load->view('inject', $data);
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */