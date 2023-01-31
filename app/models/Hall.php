<?php

class Hall extends Model
{

    protected $table = "halls";

    public $id;
    public $name;
    public $capacity;

    public function __construct()
    {
        parent::__construct();
    }

    public function getHalls()
    {
        return $this->getTable();
    }

    public function createHall()
    {

        try {
            $query = "INSERT INTO " . $this->table . " (name,capacity) VALUES (:name,:capacity)";
            $this->db->query($query);
            $this->db->bind(":name", $this->name);
            $this->db->bind(":capacity", $this->capacity);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteHall($id)
    {
        return $this->delete($id);
    }
}
