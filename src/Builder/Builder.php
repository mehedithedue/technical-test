<?php


namespace Builder;

use PDO;
use Repository\Repository;

class Builder
{
    private $repository;
    private $sql;
    private $table;
    private $where = '';

    public function __construct()
    {
        $this->repository = Repository::createPDOInstance();
    }

    public function table($tableName){
        $this->table = $tableName;
        return $this;
    }

    public function where($where){
        if(!empty($this->where) && !empty($where)){
            $where = ' AND ' . $where;
        }
        $this->where .=  $where;
        return $this;
    }

    public function create(array $formData)
    {
        if( empty($this->table)) throw new \Exception("Table no selected");

        $fields = array_keys($formData);

        $sql = "INSERT INTO " . $this->table . " (`" . implode('`,`', $fields) . "`) VALUES('" . implode("','", $formData) . "')";

        $q = $this->repository->prepare($sql);

        if(!$q->execute()){
            throw new \Exception(implode(",", $q->errorInfo()));
        }
        return $this->repository->lastInsertId();
    }

    public function update(array $formData)
    {
        if( empty($this->table)) throw new \Exception("Table no selected");
        if( empty($this->where)) throw new \Exception("No condition found for update");

        $sql = "UPDATE " . $this->table . " SET ";

        $sets = array();
        foreach ($formData as $column => $value) {
            $sets[] = "`" . $column . "` = '" . $value . "'";
        }
        $sql .= implode(', ', $sets);

        $sql .= " WHERE $this->where";
        $q = $this->repository->prepare($sql);

        if(!$q->execute()){
            throw new \Exception(implode(",", $q->errorInfo()));
        }
        return $q;
    }
    public function delete()
    {
        if( empty($this->table)) throw new \Exception("Table no selected");
        if( empty($this->where)) throw new \Exception("No condition found for update");

        $sql = "DELETE FROM " . $this->table. " WHERE ".$this->where;

        $q = $this->repository->prepare($sql);

        if(!$q->execute()){
            throw new \Exception(implode(",", $q->errorInfo()));
        }
        return $q;
    }


    private function generateQuery(){

        $this->sql = "SELECT * FROM $this->table";

        if(!empty($this->where)){
            $this->sql .= " WHERE $this->where";
        }

        return $this;
    }

    private function executeQuery(){

        $this->generateQuery();
        $q = $this->repository->prepare($this->sql);

        if(!$q->execute()){
            throw new \Exception(implode(",", $q->errorInfo()));
        }
        return $q;
    }

    public function get(){

        $data = [];

        $q = $this->executeQuery();

        while ($row = $q->fetch(PDO::FETCH_OBJ)) {
            $data[] = $row;
        }

        return $data;
    }


    public function first(){

        $q = $this->executeQuery();

        return $q->fetch(PDO::FETCH_OBJ);
    }


    public function find($id){

        $this->where('`id` = '.$id);

        $q = $this->executeQuery();

        return $q->fetch(PDO::FETCH_OBJ);
    }
}