<?php
class Db
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $databaseName = 'narrow_cast';
    private $charset = 'utf8mb4';


    private function connect()
    {
       $dsn = "mysql:host=$this->host;dbname=$this->databaseName;charset=$this->charset";
       $options = [
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           PDO::ATTR_EMULATE_PREPARES => false,
       ];
       
       try {
           return new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
           throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    private function where($conditions)
    {
        $queryPart = "";
        if (!empty($conditions)) {
            foreach ($conditions as $key => $condition) {
                if (strpos($queryPart, "WHERE") == false) $queryPart .= " WHERE ";
                $queryPart .= $key . " = " . $condition . " AND ";
            }
            $queryPart = " " . trim(substr_replace($queryPart ,"", -4));
        }
        return $queryPart;

    }

    // put all your options in one array with the same order
    public function select($options = [])
    {
        [$values, $table, $conditions, $limit] = $options;
        $con = $this->connect();
        $query = "SELECT " . join(",", $values) . " FROM " . $table;
        $query .= $this->where($conditions);
        if (isset($limit)) $query .= " LIMIT " . $limit;
        $query .= ";";
        $prepared = $con->prepare($query);
        $prepared->execute();
        return $prepared->fetchAll();
    }
}