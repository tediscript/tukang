<?php

class User_model extends Generic_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'user';
    }

}

?>
