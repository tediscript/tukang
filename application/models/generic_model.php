<?php

class Generic_model extends CI_Model {

    var $table_name;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function find_one($params = array()) {
        $reval = array();
        if ($params) {
            foreach ($params as $key => $value) {
                if (is_array($value) && $key == 'order_by') {
                    foreach ($value as $ko => $vo) {
                        $this->db->order_by($ko, $vo);
                    }
                } else if (is_array($value) && $key == 'limit') {
                    foreach ($value as $kl => $vl) {
                        $this->db->limit($kl, $vl);
                    }
                } else if (is_array($value) && $key == 'like') {
                    foreach ($value as $kl => $vl) {
                        $this->db->limit($kl, $vl);
                    }
                } else {
                    $this->db->where($key, $value);
                }
            }
            $query = $this->db->get($this->table_name);
            foreach ($query->result_array() as $row) {
                $reval = $row;
            }
        }
        return $reval;
    }

    function find($params = array()) {
        $reval = array();
        if ($params) {
            foreach ($params as $key => $value) {
                if (is_array($value) && $key == 'order_by') {
                    foreach ($value as $ko => $vo) {
                        $this->db->order_by($ko, $vo);
                    }
                } else if (is_array($value) && $key == 'limit') {
                    foreach ($value as $kl => $vl) {
                        $this->db->limit($kl, $vl);
                    }
                } else if (is_array($value) && $key == 'like') {
                    foreach ($value as $kl => $vl) {
                        $this->db->limit($kl, $vl);
                    }
                } else {
                    $this->db->where($key, $value);
                }
            }
            $query = $this->db->get($this->table_name);
            foreach ($query->result_array() as $row) {
                $reval[] = $row;
            }
        }
        return $reval;
    }

    function save($data) {
        return $this->db->insert($this->table_name, $data);
    }

    function update($params, $data) {
        $reval = array();
        foreach ($params as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->update($this->table_name, $data);
    }

    function delete($params) {
        $reval = array();
        foreach ($params as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->table_name);
    }

    function count($params = array()) {
        $reval = 0;
        if ($params) {
            foreach ($params as $key => $value) {
                if (is_array($value) && $key == 'limit') {
                    foreach ($value as $kl => $vl) {
                        $this->db->limit($kl, $vl);
                    }
                } else if (is_array($value) && $key == 'like') {
                    foreach ($value as $kl => $vl) {
                        $this->db->limit($kl, $vl);
                    }
                } else {
                    $this->db->where($key, $value);
                }
            }
            $reval = $this->db->count_all_results($this->table_name);
        }
        return $reval;
    }

}

?>
