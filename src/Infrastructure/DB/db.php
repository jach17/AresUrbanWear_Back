<?php

use PhpParser\Node\Stmt\Return_;

class db {
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPassword ='';
    private $dbName = 'aresurbanweardb';

    
    public function connectionDB(){
        $mySqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $dbConnection = new PDO($mySqlConnect, $this->dbUser, $this->dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConnection;

    }


}