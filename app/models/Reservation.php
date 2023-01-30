<?php
ini_set('display_errors', 1);

class Reservation extends Model
{
    protected $table = "reservations";

    // object properties
    public $id;
    public $key;
    public $date;
    public $time;
    public $places_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (key, date, time, places_id) VALUES (:key, :date, :time, :places_id)";
            $this->db->query($query);

            // sanitize
            $this->key = htmlspecialchars(strip_tags($this->key));
            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->time = htmlspecialchars(strip_tags($this->time));
            $this->places_id = htmlspecialchars(strip_tags($this->places_id));

            // bind values
            $this->db->bind(":key", $this->key);
            $this->db->bind(":date", $this->date);
            $this->db->bind(":time", $this->time);
            $this->db->bind(":places_id", $this->places_id);

            if ($this->db->execute()) {
                $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT 1");
                $row = $this->db->single();

                if ($row) {
                    $this->db->query("INSERT INTO users (fname,lname,email,role,reservation_key) VALUES (:fname,:lname,:email,:role,:reservation_key)");
                    $this->db->bind(":fname", $data["fname"]);
                    $this->db->bind(":lname", $data["lname"]);
                    $this->db->bind(":email", $data["email"]);
                    $this->db->bind(":role", $data["role"]);
                    $this->db->bind(":reservation_key", $row->key);

                    if ($this->db->execute()) {
                        return true;
                    } else {
                        return false;
                    }
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
}
