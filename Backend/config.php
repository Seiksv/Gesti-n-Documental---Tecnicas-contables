<?php
    class db extends mysqli {

        private static $instance = null;

        private $user = "root";
        private $pass = "mysql";
        private $dbName = "contabilidaddb";
        private $dbHost = "localhost";

        public static function getInstance() {
        if (!self::$instance instanceof self) {
                self::$instance = new self;
        }
            return self::$instance;
        }

        public function __clone() {
       trigger_error('Clone is not allowed.', E_USER_ERROR);
        }
        public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
        }

        private function __construct() {
            try {
            parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
                if (mysqli_connect_error()) {
                    die('Connect error check db server status (' . mysqli_connect_errno() . ') ');
                }
            parent::set_charset('utf-8');
            } catch (\Throwable $th) {
                return "Error";
            }
       }
       public function dbquery($query)
        {
            if($this->query($query))
            {
                return true;
            }
            else{
                return false;
            }

        }
        public function get_result($query) 
        {
            try {
                $result = $this->query($query);
                if (false !== strpos($query,'INSERT') || false !== strpos($query,'update') || false !== strpos($query,'UPDATE') || false !== strpos($query,'update')) {
                    if ($result== true){
                        return true; 
                    } else
                         return null;
                    
                }else{
                    if ($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        return $row;
                    } else
                         return null;
                }
               
            } catch (\Throwable $th) {
                return "Error";
            }
        }

        public function get_results($query) 
        {
            try {
                $result = $this->query($query);
                if (false !== strpos($query,'INSERT') || false !== strpos($query,'update') || false !== strpos($query,'UPDATE') || false !== strpos($query,'update')) {
                    if ($result== true){
                        return true; 
                    } else
                         return null;
                    
                }else{
                    if ($result->num_rows > 0){
                        $row = $result->fetch_all(MYSQLI_ASSOC);
                        return $row;
                    } else
                         return null;
                }
               
            } catch (\Throwable $th) {
                return "Error";
            }
        }
    }

    ?>
