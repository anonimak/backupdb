<?php

	class Conn
	{

        private $user	= "root";
        private $pass 	= "";

        private $dsn 	= "mysql:host=localhost;dbname=indonesia;port=3307";
        public $db;

        public function __construct()
		{
			$this->db = new PDO($this->dsn, $this->user, $this->pass);
    		return $this->db;
		}
	}


?>
