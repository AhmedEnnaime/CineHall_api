<?php
ini_set('display_errors', 1);

class Reservation extends Model
{
    protected $table = "reservations";

    // object properties
    public $id;
    public $film_id;
    public $user_key;
    public $num;

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data, $film_id)
    {
        try {
            $user = $this->findUserByEmail($data["email"]);

            if (!$user) {

                $this->db->query("INSERT INTO users (fname,lname,email,role,key) VALUES (:fname,:lname,:email,:role,:key)");
                $this->db->bind(":fname", $data["fname"]);
                $this->db->bind(":lname", $data["lname"]);
                $this->db->bind(":email", $data["email"]);
                $this->db->bind(":key", $data["key"]);
                $this->db->bind(":role", $data["role"]);
                if ($this->db->execute()) {
                    $this->db->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
                    $row = $this->db->single();

                    if ($row) {

                        $query = "INSERT INTO " . $this->table . " (user_key,film_id) VALUES (:user_key,:film_id)";
                        $this->db->query($query);
                        // bind values

                        $this->db->bind(":user_key", $row->key);
                        $this->db->bind(":film_id", $film_id);
                        if ($this->db->execute()) {
                            $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT 1");
                            $record = $this->db->single();
                            if ($record) {
                                $this->db->query("INSERT INTO seats (num,reservation_id) VALUES (:num,:reservation_id)");
                                $this->db->bind(":num", $this->num);
                                $this->db->bind(":reservation_id", $record->id);
                                if ($this->db->execute()) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                $query = "INSERT INTO " . $this->table . " (user_key,film_id) VALUES (:user_key,:film_id)";
                $this->db->query($query);
                // bind values
                $this->db->bind(":film_id", $film_id);
                $this->db->bind(":user_key", $user->key);
                if ($this->db->execute()) {
                    $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT 1");
                    $record = $this->db->single();
                    if ($record) {
                        $this->db->query("INSERT INTO seats (num,reservation_id) VALUES (:num,:reservation_id)");
                        $this->db->bind(":num", $this->num);
                        $this->db->bind(":reservation_id", $record->id);
                        if ($this->db->execute()) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                } else {
                    return false;
                }
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getReservations()
    {
        return $this->getTable();
    }

    public function getReservationsCount()
    {
        return $this->getCount();
    }

    public function getReservationById($id)
    {
        return $this->getElementById($id);
    }

    public function getUserReservations($user_key)
    {
        try {
            $query = "";
            $this->db->query($query);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
