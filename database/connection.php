<?php

namespace database;

use PDO;
use PDOException;

class Connection {
    private $host;
    private $username;
    private $password;
    private $db;

    public function __construct(array $config)
    {
        $this->host = $config['DB_HOST'];
        $this->username = $config['DB_USER'];
        $this->password = $config['DB_PASS'];
        $this->db = $config['DB_NAME'] ?? null;
    }

    public function accesoDB ()
    {
        try{
            if($this->db != null) {
                $con = new PDO("mysql:host=$this->host;dbname=$this->db", $this->username, $this->password);
            } else {
                $con = new PDO("mysql:host=$this->host", $this->username, $this->password);
            }
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->exec("set names utf8");
            return $con;

        } catch (PDOException $e) {
            $err = $e->getCode();
            $msj = $e->getMessage();
    
            //Muestra errores si los hay
            echo "ERROR: " . $err . " Código del error: " . $msj;
        }
        
    }
}

?>