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

    public function getReservations()
    {
        try {
            $query = "SELECT r.id as reservation_id,r.user_key as user_key, r.film_id as film_id,
                        f.title as film_title,f.date as reservation_date,f.time as reservation_time,
                        h.id as hall_id,h.name as hall_name,s.num as seat_num,
                        u.fname as first_name, u.lname as last_name FROM reservations r
                        JOIN films f ON r.film_id = f.id
                        JOIN halls h ON f.hall_id = h.id
                        JOIN seats s ON s.reservation_id = r.id
                        JOIN users u ON u.key = r.user_key;";
            $this->db->query($query);
            $result = $this->db->resultSet();
            return $result;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function add($data, $film_id)
    {
        try {
            $reservations = $this->getReservations();

            $user = $this->findUserByEmail($data["email"]);
            foreach ($reservations as $reservation) {
                foreach ($this->num as $n) {
                    if ($reservation->film_id == $film_id && $reservation->seat_num == $n) {
                        return false;
                    }
                }
            }

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
                                foreach ($this->num as $n) {
                                    $this->db->query("INSERT INTO seats (num,reservation_id) VALUES (:num,:reservation_id)");
                                    $this->db->bind(":num", $n);
                                    $this->db->bind(":reservation_id", $record->id);
                                    $this->db->execute();
                                }
                                return true;
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
