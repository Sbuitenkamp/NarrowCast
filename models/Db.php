<?php
class Db
{
   private $host;
   private $databaseName;
   private $user;
   private $password;
   private $charset;


   public function __construct($host = null, $databaseName = null, $user = null, $password = null, $charset = null)
   {
        $this->host = $host;
        $this->databaseName = $databaseName;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;
   }

   public function connect()
   {

       $dsn = "mysql:host=$this->host;dbname=$this->databaseName;charset=$this->charset";
       $options = [
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           PDO::ATTR_EMULATE_PREPARES => false,
       ];
       try {
           $pdo = new PDO($dsn, $this->user, $this->password, $options);
       } catch (\PDOException $e) {
           throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
   }
}