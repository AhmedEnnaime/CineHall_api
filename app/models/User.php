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
    public $reservation_key;

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
            $this->db->query("SELECT * FROM " . $this->table . " WHERE email = :email WHERE role = 0");
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
            $this->db->query("SELECT * FROM " . $this->table . " WHERE reservation_key = :reservation_key");
            $this->db->bind(':reservation_key', $this->reservation_key);
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
}
