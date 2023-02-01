<?php
ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";

class Reservations extends Controller
{

    public $response;
    public $reservationModel;
    public $userModel;

    public function __construct()
    {
        $this->reservationModel = $this->model("Reservation");
        $this->userModel = $this->model("User");
    }

    public function index()
    {
    }

    public function takeReservation()
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->date) && !empty($data->time)) {
            $uniqueKey = strtoupper(substr(sha1(microtime()), rand(0, 5), 20));
            $uniqueKey  = implode("-", str_split($uniqueKey, 5));
            $this->reservationModel->date = $data->date;
            $this->reservationModel->time = $data->time;
            $info = [
                "fname" => $data->fname,
                "lname" => $data->lname,
                "email" => $data->email,
                "key" => $uniqueKey,
                "role" => 1,
            ];
            $result = $this->reservationModel->add($info);

            if ($result) {
                $to = $data->email;
                $subject = "Authentication key";
                $headers = "From: CineHall@gmail.com";
                mail($to, $subject, $uniqueKey, $headers);
                $this->response += ["message" => "Reservation taken successfully"];
                http_response_code(200);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to take reservation"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
    }

    public function getReservations()
    {
        $this->response = [];
        $result = $this->reservationModel->getReservations();

        if ($result) {
            $this->response += ["Reservations" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Reservations not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getReservationsCount()
    {
        $this->response = [];
        $result = $this->reservationModel->geReservationsCount();

        if ($result) {
            $this->response += ["Reservations" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed to get reservations count"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }
}
