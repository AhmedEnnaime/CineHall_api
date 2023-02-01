<?php
ini_set('display_errors', 1);

class Reservation extends Model
{
    protected $table = "reservations";

    // object properties
    public $id;
    public $date;
    public $time;
    public $user_key;

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
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

                        $query = "INSERT INTO " . $this->table . " (date, time,user_key) VALUES (:date, :time,:user_key)";
                        $this->db->query($query);

                        // sanitize
                        $this->date = htmlspecialchars(strip_tags($this->date));
                        $this->time = htmlspecialchars(strip_tags($this->time));

                        // bind values
                        $this->db->bind(":date", $this->date);
                        $this->db->bind(":time", $this->time);
                        $this->db->bind(":user_key", $row->key);
                        if ($this->db->execute()) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                $query = "INSERT INTO " . $this->table . " (date, time,user_key) VALUES (:date, :time,:user_key)";
                $this->db->query($query);

                // sanitize
                $this->date = htmlspecialchars(strip_tags($this->date));
                $this->time = htmlspecialchars(strip_tags($this->time));

                // bind values
                $this->db->bind(":date", $this->date);
                $this->db->bind(":time", $this->time);
                $this->db->bind(":user_key", $user->key);
                if ($this->db->execute()) {
                    return true;
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
}
