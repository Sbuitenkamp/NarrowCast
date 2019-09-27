<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}

class Db
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $databaseName = 'narrow_cast';
    private $charset = 'utf8mb4';

    public function connect()
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
    public function insert($options = [])
    {
        try {
            [
                $columns, // array
                $values, // array
                $table, // string
            ] = $options;
            $con = $this->connect();
            $query = "INSERT INTO " . $table . "(" . join(",", $columns) . ")" . " VALUES (" . join(",", $values) . ");";
            echo $query . "\n";
            $prepared = $con->prepare($query);
            $prepared->execute();
            return $prepared->rowCount();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function select($options = [])
    {
        try {
            [
                $values, // array
                $table, // string
                $conditions, // assoc array
                $limit // int
            ] = $options;
            $con = $this->connect();
            $query = "SELECT " . join(",", $values) . " FROM " . $table;
            $query .= $this->where($conditions);
            if (isset($limit)) $query .= " LIMIT " . $limit;
            $query .= ";";
            echo $query . "\n";
            $prepared = $con->prepare($query);
            $prepared->execute();
            return $prepared->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function update($options = [])
    {
        try {
            [
                $values, // assoc array
                $table, // string
                $conditions // assoc array
            ] = $options;
            $con = $this->connect();
            $query = "UPDATE " . $table . " SET ";
            foreach ($values as $col => $value) $query .= $col . " = " . $value . ", ";
            $query = trim(substr_replace($query, "", -2));
            $query .= $this->where($conditions);
            $query .= ";";
            echo $query . "\n";
            $prepared = $con->prepare($query);
            $prepared->execute();
            return $prepared->rowCount();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function delete($options = [])
    {
        try {
            [
                $table, // string
                $conditions // assoc array
            ] = $options;
            $con = $this->connect();
            $query = "DELETE FROM " . $table;
            $query .= $this->where($conditions);
            $query .= ";";
            echo $query . "\n";
            $prepared = $con->prepare($query);
            $prepared->execute();
            return $prepared->rowCount();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}