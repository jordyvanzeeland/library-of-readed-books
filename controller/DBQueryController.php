<?php

namespace App\Controller;

class DBQueryController{
    private $db;
    private $configfile;
    private $config;

    /**
     * Create a database connection given the credentials in the config.json file
     * This will be used trough the whole class
     */

    public function __construct(){
        $this->configfile = file_get_contents(dirname(__DIR__, 1) . "/config.json");
        $this->config = json_decode($this->configfile);
        $this->db = new \PDO('mysql:dbname=' . $this->config->db_name . ';host=' . $this->config->db_host . ';charset=utf8mb4', $this->config->db_user, $this->config->db_pass);
    }

    /**
     * Handle the select query
     */

    public function select(string $tablename, array $columns, array $where = []){
        $columns = implode(',', $columns);
        $whereQuery = '';
        $whereParams = [];

        if(!empty($where)){
            $whereParts = [];
            foreach ($where as $key => $value) {
                $param = ":" . $key;
                $whereParts[] = $key . " = " . $param;
                $whereParams[$param] = $value;
            }
            $whereQuery = " WHERE " . implode(' AND ', $whereParts);
        }
        
        $query = "SELECT " . $columns . " FROM " . $tablename . $whereQuery;

        $books = $this->db->prepare($query);
        $books->execute($whereParams);
        return $books->fetchAll();
    }

    /**
     * Handle the insert query
     */

    public function insert(string $tablename, array $data){
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $tablename ($columns) VALUES ($placeholders)";

        $book = $this->db->prepare($query);
        $result = $book->execute(array_combine(explode(', ', $placeholders), array_values($data)));
        return $result;
    }

    /**
     * Handle the update query
     */

    public function update(string $tablename, array $data, array $where){
        $updateParts = [];
        $updateParams = [];

        foreach($data as $key => $value){
            $param = ":" . $key;
            $updateParts[] = "$key = $param";
            $updateParams[$param] = $value;
        }

        $whereParts = [];
        foreach ($where as $key => $value) {
            $param = ":" . $key;
            $whereParts[] = $key . " = " . $param;
            $whereParams[$param] = $value;
        }

        $updateQuery = implode(', ', $updateParts);
        $whereQuery = implode(' AND ', $whereParts);

        $query = "UPDATE $tablename SET $updateQuery WHERE $whereQuery";

        $book = $this->db->prepare($query);
        $result = $book->execute($updateParams);
        return $result;
    }

    /**
     * Handle the delete query
     */

    public function delete($tablename, $where){
        $whereParts = [];
        $whereParams = [];
        foreach ($where as $key => $value) {
            $param = ":" . $key;
            $whereParts[] = $key . " = " . $param;
            $whereParams[$param] = $value;
        }
        $whereQuery = implode(' AND ', $whereParts);
        $query = "DELETE FROM $tablename WHERE $whereQuery";
        $book = $this->db->prepare($query);
        $result = $book->execute($whereParams);
        return $result;
    }
}