<?php

class User extends Model
{
    protected $table = "users";

    public $id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $role;
    public $key;

    public function __construct()
    {
        parent::__construct();
    }

    public function findUserByEmail($email)
    {
        return $this->findUserByEmail($email);
    }

    public function login()
    {
        try {
            $this->db->query("SELECT * FROM " . $this->table . " WHERE email = :email AND role = 0");
            $this->db->bind(':email', $this->email);
            $row = $this->db->single();
            if ($this->password == $row->password) {
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function userLogin()
    {
        try {
            $this->db->query("SELECT * FROM " . $this->table . " WHERE key = :key");
            $this->db->bind(':key', $this->key);
            $row = $this->db->single();
            if ($row) {
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getClients()
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE role = 1";
            $this->db->query($query);
            $result = $this->db->resultSet();
            return $result;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
