<?php
   ob_start();
   session_set_cookie_params(0);
   session_start();
   define('DB_HOST','localhost');
   define('DB_USER','root');
   define('DB_PASS','');
   define('DB_NAME','gb_pant_new');

   class database{
       public $host      = DB_HOST;
       public $user      = DB_USER;
       public $pass      = DB_PASS;
       public $db_name   = DB_NAME;

       public $link;
       public $error;

       public function __construct(){
           $this->connect();
       }

       private function connect(){
           $this->link = new mysqli($this->host,$this->user,$this->pass,$this->db_name);
           $this->link->set_charset("utf8");
            if (!$this->link) {
                $this->error = "Connection Not Established" . $this->link->connect_error;
            }
       }
   }
