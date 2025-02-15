<?php

namespace App\Controllers\Core;

class DBQueryController{
    private $db;
    private $configfile;
    private $config;
    private $query;
    private $insertData;
    private $currentQuery;
    private $params;

    /**
     * Create a database connection given the credentials in the config.json file
     * This will be used trough the whole class
     */

    public function __construct(){
        $this->configfile = file_get_contents(dirname(__DIR__, 2) . "/config.json");
        $this->config = json_decode($this->configfile);
        $this->db = new \PDO('mysql:dbname=' . $this->config->db_name . ';host=' . $this->config->db_host . ';charset=utf8mb4', $this->config->db_user, $this->config->db_pass);
    }

    /**
     * Handle the select query
     */

    public function select(array $columns){
        $columns = implode(',', $columns);
        $this->query = "SELECT " . $columns;
        
        return $this;
    }

    public function from(string $tablename){
        $this->query .= " FROM " .$tablename;

        return $this;
    }

    public function where(array $where = []){
        $whereQuery = '';

        if(!empty($where)){
            $whereParts = [];
            foreach ($where as $key => $value) {
                if($key == "YEAR(readed)"){
                    $param = ":year";
                }else{
                    $param = ":" . $key;
                }
                
                $whereParts[] = $key . " = " . $param;
                $this->params[$param] = $value;
            }
            $whereQuery = " WHERE " . implode(' AND ', $whereParts);
        }

        $this->query .= $whereQuery;
        
        return $this;
    }

    public function orderby(array $order = []){
        $orderQuery = '';

        if(!empty($order)){
            foreach ($order as $key => $value) {
                $direction = strtoupper($value) == 'DESC' ? 'DESC' : 'ASC';
            }

            $orderQuery = " ORDER BY $key $direction";
        }

        $this->query .= $orderQuery;

        return $this;
    }

    public function groupby(string $groupby = ''){
        if(!empty($groupby)){
            $this->query .= ' GROUP BY ' . $groupby;
        }

        return $this;
    }

    public function fetchAll(){
        $this->currentQuery = $this->db->prepare($this->query);
        $this->currentQuery->execute($this->params);
        return $this->currentQuery->fetchAll();
    }

    public function fetchOne(){
        $this->currentQuery = $this->db->prepare($this->query);
        $this->currentQuery->execute($this->params);
        return $this->currentQuery->fetch();
    }

    /**
     * Handle the insert query
     */

    public function insertInto(string $tablename){
        $this->query = "INSERT INTO $tablename ";
        return $this;
    }

    public function data(array $data){
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $this->query .= "($columns) VALUES ($placeholders)";
        $this->insertData = array_combine(explode(', ', $placeholders), array_values($data));
        return $this;
    }

    /**
     * Handle the update query
     */

    public function update(string $tablename){
        $this->query = "UPDATE $tablename";
        return $this;
    }

    public function set(array $data){
        $updateParts = [];

        foreach($data as $key => $value){
            $param = ":" . $key;
            $updateParts[] = "$key = $param";
            $this->params[$param] = $value;
        }

        $updateQuery = implode(', ', $updateParts);
        $this->query .= " SET $updateQuery";

        return $this;
    }

    public function execute(){
        $book = $this->db->prepare($this->query);
        $result = $book->execute($this->insertData ? $this->insertData : $this->params);
        return $result;
    }

    /**
     * Handle the delete query
     */

    public function delete(){
        $this->query = "DELETE ";
        return $this;
    }
}