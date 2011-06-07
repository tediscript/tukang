<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post extends CI_Controller {

    public function index() {
        $this->load->model('post_model');
        $params['status'] = 'new';
        $data['posts'] = $this->post_model->find($params);
        $this->load->view('post', $data);
    }

    public function add() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('source', 'Source', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('post_add');
        } else {
            $category = $this->input->post('category');
            $source = $this->input->post('source');
            $sources = explode("\n", $source);
            $this->load->model('post_model');
            foreach ($sources as $item) {
                $data['category'] = $category;
                $data['title'] = trim($item);
                $data['status'] = 'new';
                $this->post_model->save($data);
            }
            redirect('post');
        }
    }

    public function edit($post_id) {
        
    }

    public function delete($post_id) {
        $params['post_id'] = $post_id;
        $this->load->model('post_model');
        $this->post_model->delete($params);
        redirect('post');
    }

    public function do_post() {
        //select single title
        $this->load->model('post_model');
        $params['limit'][1] = 0;
        $params['status'] = 'new';
        $post = $this->post_model->find_one($params);

        if (!empty($post)) {

            //fetch google
            $pics = array();
            $keyword = $post['title'] . ' site:' . $this->config->item('site_target');
            $results = $this->getGoogleImg($keyword);

            // shuffle result
            if ($this->config->item('shuffle_result')) {
                shuffle($results);
            }

            //limit number of pics
            $max_pics = $this->config->item('max_pics');
            foreach ($results as $result) {
                $pics[] = $result;
                if (count($pics) == $max_pics) {
                    break;
                }
            }

            //create slug
            $slug = $this->create_slug($post['title']);

            //save image
            $i = 1;
            $raw_path = $this->config->item('raw_file_path');
            foreach ($pics as $pic) {
                $this->save_image($pic, $raw_path . $slug . '-' . $i);
                $i++;
            }

            //resize image
            //post to wp
            $params_post['title'] = $post['title'];
            $params_post['description'] = '';
            $params_post['categories'] = explode(',', $post['category']);
            $params_post['blogurl'] = $this->config->item('xmlrpc_url');
            $params_post['blogpass'] = $this->config->item('wp_password');
            $params_post['bloguser'] = $this->config->item('wp_username');
            $this->newpost($params_post);

            //update flag            
            $params = array();
            $params['post_id'] = $post['post_id'];
            $params_set['status'] = 'posted';
            $this->post_model->update($params, $params_set);
        }
    }

    /*     * **************helper********************************** */

    function getGoogleImg($k) {
        $url = "http://www.google.com/search?hl=en&as_st=y&biw=1280&bih=592&tbs=isz%3Al%2Citp%3Aphoto&tbm=isch&sa=1&q=##query##";
        $web_page = file_get_contents(str_replace("##query##", urlencode($k), $url));

        $tieni = stristr($web_page, "dyn.setResults(");
        $tieni = str_replace("dyn.setResults(", "", str_replace(stristr($tieni, ");"), "", $tieni));
        $tieni = str_replace("[]", "", $tieni);
        $m = preg_split("/[\[\]]/", $tieni);
        $x = array();
        for ($i = 0; $i < count($m); $i++) {
            $m[$i] = str_replace("/imgres?imgurl\\x3d", "", $m[$i]);
            $m[$i] = str_replace(stristr($m[$i], "\\x26imgrefurl"), "", $m[$i]);
            $m[$i] = preg_replace("/^\"/i", "", $m[$i]);
            $m[$i] = preg_replace("/^,/i", "", $m[$i]);
            if ($m[$i] != "")
                array_push($x, $m[$i]);
        }
        return $x;
    }

    function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return strtolower($slug);
    }

    function save_image($inPath, $outPath) {
        $in = fopen($inPath, "rb");
        $out = fopen($outPath, "wb");
        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    public function newpost($params = array()) {
        $this->load->library('xmlrpc');

        $blogurl = $params['blogurl'];
        $blogpass = $params['blogpass'];
        $bloguser = $params['bloguser'];

        $categories = $params['categories'];
        $blogid = 1;
        $publishImmediately = TRUE;

        $title = $params['title'];
        $description = $params['description'];

        $thePost = array(
            array(
                'title' => array($title, 'string'),
                'description' => array($description, 'string'),
                'categories' => array($categories, 'struct'),
                'post_type' => array('post', 'string'),
            ), 'struct');

        $this->xmlrpc->server($blogurl, 80);
        $this->xmlrpc->method('metaWeblog.newPost');
        $request = array($blogid, $bloguser, $blogpass, $thePost, $publishImmediately);
        $this->xmlrpc->request($request);
        $result = $this->xmlrpc->send_request();
    }

    public function jajal() {
        $this->load->model('post_model');
        $params['status'] = 'new';
        echo $this->post_model->count($params);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */