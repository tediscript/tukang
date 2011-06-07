<?php

class Post_model extends Generic_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'wp_poster';
    }

}

?>
